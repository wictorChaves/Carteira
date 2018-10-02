<?php

namespace model;

use conexao\Conexao;
use PDO;
use App;

/**
 * Description of Model
 *
 * @author Wictor
 */
class Model extends App {

    private $class = null;
    private $conexao = null;
    private $arrayObj = null;
    private $tabela = '';

    function getTabela() {
        return $this->tabela;
    }

    function __construct($class) {
        $this->class = $class;
        $this->tabela = $class::getClassName();
        $this->conexao = new Conexao();
    }

    /**
     * Converte o atributo para atributo do banco exemplo
     * dataNascimento para data_nascimento
     * @param type $string
     * @return type
     */
    public function atributoToDb($string) {
        $string = preg_replace('/([A-Z])/', '_$1', $string);
        return strtolower($string);
    }

    /**
     * Retorna uma string com os valores do banco de acordo com a classe
     * ex: 'fulano', '22', ...
     * @return type
     */
    public function getPreparaInsert() {
        $arrayAtributos = $this->class->getAtributos();
        foreach ($arrayAtributos as $index => $atributo) {
            $metodo = 'get' . ucfirst($atributo);
            if (!is_null($this->class->$metodo())) {
                $valores[$index] = $this->limpaValorer($this->class->$metodo());
                $arrayAtributos[$index] = '`' . $this->atributoToDb($atributo) . '`';
            } else {
                unset($arrayAtributos[$index]);
            }
        }
        $resultado['campos'] = implode(',', $arrayAtributos);
        $resultado['valores'] = implode(',', $valores);
        return $resultado;
    }

    public function getPreparaUpdate() {
        $arrayAtributos = $this->class->getAtributos();
        foreach ($arrayAtributos as $index => $atributo) {
            $metodo = 'get' . ucfirst($atributo);
            if (!is_null($this->class->$metodo())) {
                $valores[$index] = "`" . $this->atributoToDb($atributo) . "` = " . $this->limpaValorer($this->class->$metodo()) . "";
            }
        }
        return implode(',', $valores);
        ;
    }

    /**
     * Cria a string para o updade
     * @return type
     */
    public function getUrlUpdate() {
        $query = "UPDATE `" .
                $this->getTabela() .
                "` SET " . $this->getPreparaUpdate() . " WHERE `id` = " .
                $this->class->getId();
        return $query;
    }

    /**
     * Cria a string para o insert
     * @return type
     */
    public function getQueryInsert() {
        $resultado = $this->getPreparaInsert();
        $query = "INSERT INTO `" .
                $this->getTabela() . "` (" .
                $resultado['campos'] . ") VALUES (" .
                $resultado['valores'] . ");";
        return $query;
    }

    /**
     * Cria a string para o delete
     * @return type
     */
    public function getQueryDelete($id) {
        $this->conexao->setQuery("DELETE FROM `" . $this->getTabela() . "` WHERE `id` = " . $id);
    }

    /**
     * Cria a string para o delete de acordo com o where
     * @return type
     */
    public function setDeleteWhere($campos, $operadores, $valores) {
        //Caso entre com um array
        if (is_array($campos)) {
            $query = "DELETE FROM " .
                    $this->getTabela() . " WHERE `" .
                    $campos[0] . "` " .
                    $operadores[0] . " '" .
                    $valores[0] . "'";
            foreach (array_slice($campos, 1) as $i => $campo) {
                $query = $query . " AND `" .
                        $campo . "` " .
                        $operadores[$i + 1] . " '" .
                        $valores[$i + 1] . "'";
            }
        } else { //Caso entre só com string
            $query = "DELETE FROM " .
                    $this->getTabela() . " WHERE `" .
                    $campos . "` " .
                    $operadores . " '" .
                    $valores . "'";
        }
        $this->conexao->setQuery($query);
    }

    /**
     * Insere ou atualida dados
     * @return type
     */
    public function setDado($class) {
        $this->class = $class;
        if ($class->getId() != null) {
            return $this->conexao->setQuery($this->getUrlUpdate());
        } else {
            return $this->conexao->setQuery($this->getQueryInsert());
        }
    }

    /**
     * Cria a string para o select
     * @return type
     */
    public function getDados() {
        return $this->queryToArrayObj("select * from " . $this->getTabela());
    }

    private function verificaEntrada($campos, $operadores, $valores) {
        if (is_array($campos) && is_array($operadores) && is_array($valores)) {
            if (count($campos) === count($operadores)) {
                if (count($campos) === count($valores)) {
                    return TRUE;
                }
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function limpaValorer($valor) {
        if (is_null($valor)) {
            return 'NULL';
        }
        if (is_numeric($valor) && substr($valor, 0, 1) != 0) {
            return $valor;
        }
        $valor = str_replace("'", "&apos;", $valor);
        return "'" . $valor . "'";
    }

    /**
     * Pesquisa no banco de acordo com o filtro
     * ex: SELECT * FROM `tabela` WHERE `nome` REGEXP '3'
     * ex: SELECT * FROM `tabela` WHERE `nome` LIKE '321' AND `idade` = 123
     * @return type
     */
    public function getDadosByFiltro($campos, $operadores, $valores) {
        if (!$this->verificaEntrada($campos, $operadores, $valores)) {
            return NULL;
        }
        $query = 'SELECT * FROM ' . $this->getTabela() . ' WHERE ';
        if (is_array($campos)) {
            $array = array();
            foreach ($campos as $i => $campo) {
                $array[$i] = "`" . $campo . "` " . $operadores[$i] . " " . $this->limpaValorer($valores[$i]);
            }
            $where = implode(" AND ", $array);
        } else {
            $where = "`" . $campos . "` " . $operadores . " " . $this->limpaValorer($valores);
        }
        $query = $query . $where;
        return $this->queryToArrayObj($query);
    }

    /**
     * Pega o resultado da query e coloca em um array de objetos
     * @param type $query
     * @return type
     */
    protected function queryToArrayObj($query) {
        $this->arrayObj = null;
        $stmt = $this->conexao->getQuery($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $atributos = $this->class->getAtributos();
        foreach ($results as $i => $row) {
            $classe = 'model\dominio\\' . ucfirst($this->getTabela());
            $cla = new $classe();
            foreach ($atributos as $atributo) {
                $metodo = 'set' . ucfirst($atributo);
                $cla->$metodo($row[$this->atributoToDb($atributo)]);
            }
            $this->arrayObj[] = $cla;
        }
        return $this->arrayObj;
    }

    /**
     * Retorna um registro de acordo com o id
     * @return type
     */
    public function getDadoById($id) {
        $stmt = $this->conexao->getQuery("select * from " . $this->getTabela() . " WHERE `id` = " . $id);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cla = null;
        if (count($results) > 0) {
            $atributos = $this->class->getAtributos();
            $classe = 'model\dominio\\' . ucfirst($this->getTabela());
            $cla = new $classe();
            foreach ($atributos as $atributo) {
                $metodo = 'set' . ucfirst($atributo);
                $cla->$metodo($results[0][$this->atributoToDb($atributo)]);
            }
        }
        return $cla;
    }

    /**
     * Cria a string para o delete
     * @return type
     */
    public function getCustomQuery($query) {
        $stmt = $this->conexao->getQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
