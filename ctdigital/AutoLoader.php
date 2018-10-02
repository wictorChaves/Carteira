<?php

/**
 * Description of AutoLoader
 *
 * @author Wictor
 */
include './App.php';

class AutoLoader extends App {

    public function __construct() {
        spl_autoload_register(array($this, 'loader'), true);
    }

    private function loader($className) {
        $caminho = __DIR__ . __NAMESPACE__ . DIRECTORY_SEPARATOR . $className . ".php";
        $this->carregaPagina($caminho);
    }

    private function carregaPagina($caminho) {
        if(file_exists($this->parseDiretorio($caminho))){
            include($this->parseDiretorio($caminho));
        }        
    }

}
