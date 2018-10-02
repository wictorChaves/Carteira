<?php

namespace core;

use App;
use core\UrlHelper;

/**
 * Description of FileHelper
 *
 * @author Wictor
 */
class FileHelper{

    /**
     * Caminho com barra no final
     * @param type $caminho
     * @param string $img
     * @return string
     */
    public static function getExtensaImg($img) {

        $app = new App();
        $caminhoReal = $app->getPastaRaiz() . "/images/upload/" . $img;

        $tipos = array('jpg', 'jpeg', 'png', 'gif');
        foreach ($tipos as $tipo) {
            if (file_exists($caminhoReal . "." . $tipo)) {
                return FileHelper::getUrlImg() . "images/upload/" . $img;
            }
        }
        return "";
    }

    public static function getUrlImg() {
        
        $urlHelper = new UrlHelper();
        $tamanho = $urlHelper->getUrlSemRaiz();
        $qtd = count($tamanho);

        $url = "";
        for ($i = 1; $i <= $qtd; $i++) {
            $url .= "../";
        }

        return $url;
    }

    public static function limpaUrl($url) {
        $caracter = "/";
        $array = explode($caracter, $url);
        array_pop($array);
        $array = array_diff($array, array(""));
        return implode($caracter, $array);
    }

    public static function getExtensao($arquivo) {
        $temp = array();
        $temp = \explode(".", $arquivo);
        return \end($temp);
    }

    /**
     * Pega somente o arquivo da url
     */
    public static function getSomenteArquivo($url) {
        $temp = array();
        $temp = \explode(DIRECTORY_SEPARATOR, $url);
        return \end($temp);
    }

}
