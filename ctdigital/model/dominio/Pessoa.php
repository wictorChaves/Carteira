<?php

namespace model\dominio;

class Pessoa extends Dominio {

    use traitDominio;

    private $id;
    private $nome;
    private $idade;
    private $sexo;
    protected $values = array();

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
            /**
             * Se não entrar com o id
             */
            if (count($args) == ($c - 1)) {
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

    function getNome() {
        return $this->nome;
    }

    function getIdade() {
        return $this->idade;
    }

    function getSexo() {
        return $this->sexo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setIdade($idade) {
        $this->idade = $idade;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

}
