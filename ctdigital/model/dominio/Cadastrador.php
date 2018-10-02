<?php

namespace model\dominio;

/**
 * Description of Cadastrador
 *
 * @author Wictor
 */
class Cadastrador extends Dominio {
    
    use traitDominio;

    private $id;
    private $idFuncionario;
    private $usuario;
    private $senha;
    private $grupo;

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

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function getGrupo() {
        return $this->grupo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

}
