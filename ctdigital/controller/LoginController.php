<?php

namespace controller;

use core\Authorize;
use core\UrlHelper;
use core\SessionVO;

/**
 * Description of LoginController
 *
 * @author Wictor
 */
class LoginController extends MainController {

    function __construct() {
        $this->setLayout(null);
    }

    private function limpaMascara($valorCampo) {
        $valores = array(".", "-", "/");
        return str_replace($valores, "", $valorCampo);
    }

    public function index() {

        if ($_POST != null) {

            //Cria as sessions
            $_SESSION[SessionVO::$LOGIN] = $this->limpaMascara($this->getPostValue("login", ""));
            $_SESSION[SessionVO::$SENHA] = $this->getPostValue("senha", "");
            $_SESSION[SessionVO::$TIPO] = $this->getPostValue("tipo", "");
            $_SESSION[SessionVO::$GRUPO] = '';
            

            /**
             * Envia o usuário para a mesma tela onde ele estava antes do login
             */
            $urlHelper = new UrlHelper();
            $url = implode("/", $urlHelper->getUrlSemRaiz());
            header("Location: ../../$url/");
        }

        /**
         * Se o usuário estiver logado e tentar entrar na tela de login
         */
        if (isset($_SESSION[SessionVO::$LOGIN]) && !isset($_SESSION[SessionVO::$ERROLOGIN])) {
            $authorize = new Authorize();
            if ($authorize->verificaUsuario()) {
                header("Location: ../../home/index/");
            }
        }

        return $this->view();
    }

}
