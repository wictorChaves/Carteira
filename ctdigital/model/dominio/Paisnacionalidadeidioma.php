<?php

namespace model\dominio;

/**
 * Description of Paisnacionalidadeidioma
 *
 * @author Wictor
 */
class Paisnacionalidadeidioma extends Dominio {

    use traitDominio;

    private $id;
    private $pais;
    private $nacionalidade;
    private $idioma;

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

    function getPais() {
        return $this->pais;
    }

    function getNacionalidade() {
        return $this->nacionalidade;
    }

    function getIdioma() {
        return $this->idioma;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

    function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
    }

    function setIdioma($idioma) {
        $this->idioma = $idioma;
    }

}
