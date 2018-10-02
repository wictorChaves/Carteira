<?php

/**
 * 
 * Arquivo de configuração de rotas
 * 
 * A rota é feita de forma automatica
 * 
 */

namespace core;

use tela\InfoView;
use controller\LoginController;

class RouteConfig extends Authorize {

    private $logado = false;

    function __construct() {
        $this->raizToHome();
        if (!$this->autorizado()) {
            $loginController = new LoginController();
            include_once $loginController->index()['view'];
        } else {
            $this->logado = true;
        }
    }

    /**
     * Verifica se o usuário esta na pasta raiz
     */
    private function raizToHome() {
        if (count($this->getUrlSemRaiz()) == 0) {
            header("Location: /" . implode("/", $this->getUrlAlias()) . "/home/index/");
            exit();
        }
    }

    public function callView() {

        if (!$this->logado) {
            return false;
        }

        /**
         * Instancia o controller
         */
        $controllerObj = $this->getControllerObj();
        $view = $this->getView();

        /**
         * Se o retorno da view for null não carrega a view
         */
        if (is_null($retornView = $controllerObj->$view())) {
            return;
        }

        /**
         * Verifica se há dados para enviar para view
         */
        if (count($retornView) > 1) {
            $_pagina['model'] = $retornView['model'];
        }

        /**
         * Acessa o arquivo utilizando DOM
         * E pega o titulo
         */
        $inforView = new InfoView($this->getUrlFileInclude());
        $_pagina['titulo'] = $inforView->getTituloHead();

        /**
         * Não carrega o Layout caso o valor de layout seja null
         */
        if ($controllerObj->getLayout() == null) {
            include_once $this->getUrlFileInclude();
            return;
        }

        /**
         * Carrega a view com layout
         */
        $_pagina['conteudo'] = $retornView['view'];
        include_once 'view\shared\\' . $controllerObj->getLayout() . '.php';
    }

    /**
     * Pega o objeto controller
     */
    public function getControllerObj() {
        $controller = $this->getUrlUse();
        return new $controller();
    }

    public function get404() {
        header("Location: /" . implode("/", $this->getUrlFile()) . "/page404/index/");
    }

}
