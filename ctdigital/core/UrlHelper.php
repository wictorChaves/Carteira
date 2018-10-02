<?php

namespace core;

use App;

/**
 * Description of UrlHelper
 *
 * @author Wictor
 */
class UrlHelper extends App {

    /**
     * Pega controller atual
     */
    public function getController() {
        $array = array_diff($this->getUrlSemRaiz(), array($this->getView()));
        return (count($this->getUrlSemRaiz()) == 2 ? end($array) : 'home');
    }

    /**
     * Pega view atual
     */
    public function getView() {
        $array = $this->getUrlSemRaiz();
        return (count($array) == 2 ? end($array) : 'index');
    }

    /**
     * Retorna o caminho da view para fazer include
     */
    public function getUrlFileInclude() {
        return $this->parseDiretorio('view/' . ucfirst($this->getController()) . '/' . $this->getView() . '.php');
    }

    /**
     * Retorna a url para utilizada no use ou instancia o metodo
     */
    public function getUrlUse() {
        return $this->parseDiretorio("controller/" . ucfirst($this->getController()) . "Controller");
    }

    /**
     * Pega a url sem a pasta onde os arquivos foram salvos
     */
    public function getUrlSemRaiz() {
        return array_diff($this->getUrlAlias(), $this->getUrlFile());
    }

    /**-----------------------------------------------------------------------
     * exemplo/index.php
     * @return type array
     */
    public function getUrlFile() {
        $strtolower = strtolower($_SERVER['PHP_SELF']);
        $array = $this->removeValorArray(explode("/", $strtolower), '');
        return $this->removeValorArray($array, end($array));
    }

    /**
     * controller/index/
     * @return type array
     */
    public function getUrlAlias() {    
        $strtolower = strtolower($_SERVER['REQUEST_URI']);
        $semQueryString = strtok($strtolower, '?');
        return $this->removeValorArray(explode("/", $semQueryString), '');
    }

    /**
     * 
     * @param type $array
     * @param type $valor
     * @return type array
     */
    public function removeValorArray($array, $valor) {
        $index = array_search($valor, $array);       
        while ($index !== FALSE) {
            unset($array[$index]);
            $index = array_search($valor, $array);
        }
        return $array;
    }

}
