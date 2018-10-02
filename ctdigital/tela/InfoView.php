<?php

namespace tela;

use DOMDocument;

/**
 * Description of infoView
 *
 * @author Wictor
 */
class InfoView {

    //local onde se encontra o arquivo
    private $caminho = '';

    function setCaminho($caminho) {
        $this->caminho = $caminho;
    }

    function __construct($caminho) {
        $this->caminho = $caminho;
    }

    public function getTituloHead() {
        return $this->getElemento('_tituloHead');
    }

    public function getTituloMenuPrincipal() {
        return $this->getElemento('_tituloMenuPrincipal');
    }

    public function getIconMenuPrincipal() {
        return $this->getElemento('_icon');
    }

    public function getMenuOff() {
        return $this->getElemento('_menuOff');
    }

    public function getTituloView() {
        return $this->getElemento('_tituloView');
    }

    /**
     * Pega o elemento dom pelo id
     * @param string $elemento 
     * @return DOM
     */
    private function getElemento($elemento) {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);

        if (!$doc->loadHTMLFile($this->caminho)) {
            libxml_clear_errors();
            return null;
        }

        if (!$doc->getElementById($elemento)) {
            libxml_clear_errors();
            return null;
        }

        return utf8_decode($doc->getElementById($elemento)->nodeValue);
    }

}
