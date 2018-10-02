<?php

namespace model\dominio;

/**
 * Description of Token
 *
 * @author Wictor
 */
class Token extends Dominio {

    use traitDominio;

    private $id;
    private $idToken;
    private $valor;
    private $dataHora;

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

    function getIdToken() {
        return $this->idToken;
    }

    function getValor() {
        return $this->valor;
    }

    function getDataHora() {
        return $this->dataHora;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdToken($idToken) {
        $this->idToken = $idToken;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }

}
