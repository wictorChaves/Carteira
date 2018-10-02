<?php

namespace model\dominio;

use model\dominio\Dominio;

/**
 * Description of Emprego
 *
 * @author Wictor
 */
class Emprego extends Dominio {

    use traitDominio;

    private $id;
    private $idFuncionario;
    private $idEmpresa;
    private $cargo;
    private $remuneracao;
    private $dataAdmissao;
    private $dataSaida;
    private $dataDispensa;
    private $dataProposta;

    function __construct(...$args) {

        /**
         * Verifica se há parametros
         */
        if (isset($args)) {
            /**
             * Conta quanto atributos existem
             */
            $c = 0;
            foreach (get_class_methods($this) as $metodo) {
                if (preg_match('/set/', $metodo)) {
                    $c++;
                }
            }

            //Zera todos os valores se a pessoa instanciar desta forma new Classe('')
            if (count($args) == 1 && $args[0] == '') {
                foreach (array_slice(get_class_methods($this), 1) as $i => $metodo) {
                    if (preg_match('/set/', $metodo)) {
                        if (array_key_exists($c, $args)) {
                            $this->$metodo('');
                        }
                        $c++;
                    }
                }
            } else if (count($args) == ($c - 1)) {//Se não entrar com o id
                $this->id = null;
                $c = 0;
                foreach (array_slice(get_class_methods($this), 1) as $i => $metodo) {
                    if (preg_match('/set/', $metodo)) {
                        if (array_key_exists($c, $args)) {
                            $this->$metodo($args[$c]);
                        }
                        $c++;
                    }
                }
            } else {
                $c = 0;
                foreach (get_class_methods($this) as $i => $metodo) {
                    if (preg_match('/set/', $metodo)) {
                        if (array_key_exists($c, $args)) {
                            $this->$metodo($args[$c]);
                        }
                        $c++;
                    }
                }
            }
        } else {
            $this->id = null;
        }
    }

    function getId() {
        return $this->id;
    }

    function getIdFuncionario() {
        return $this->idFuncionario;
    }

    function getIdEmpresa() {
        return $this->idEmpresa;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getRemuneracao() {
        return $this->remuneracao;
    }

    function getDataAdmissao() {
        return $this->dataAdmissao;
    }

    function getDataSaida() {
        return $this->dataSaida;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function setRemuneracao($remuneracao) {
        $this->remuneracao = $remuneracao;
    }

    function setDataAdmissao($dataAdmissao) {
        $this->dataAdmissao = $this->converteData($dataAdmissao);
    }

    function setDataSaida($dataSaida) {
        $this->dataSaida = $this->converteData($dataSaida);
    }

    function getDataDispensa() {
        return $this->dataDispensa;
    }

    function setDataDispensa($dataDispensa) {
        $this->dataDispensa = $dataDispensa;
    }

    function getDataProposta() {
        return $this->dataProposta;
    }

    function setDataProposta($dataProposta) {
        $this->dataProposta = $dataProposta;
    }

}
