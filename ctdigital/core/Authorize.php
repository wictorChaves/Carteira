<?php

namespace core;

use ReflectionClass;
use core\SessionVO;

/**
 * Description of Authorize
 *
 * @author Wictor
 */
class Authorize extends UrlHelper {

    public function autorizado() {

        /**
         * Logout
         */
        if ($this->getGetValue("acao", false) == "logout") {
            $this->logout();
        }

        /**
         * Verifica se a pagina precisa de credencial
         */
        if (!$this->getLogin()) {
            return true;
        }

        /**
         * Verifica se existe sessão ativa se tiver retorna elas
         */
        if (($sessions = $this->getSessions()) == null) {
            return false;
        }

        /**
         * Verifica o usuário no banco
         */
        if (!$this->verificaUsuario()) {
            return false;
        }

        /**
         * Verifica o usuário no banco
         */
        if (!$this->verificaGrupo()) {
            header("Location: /" . implode("/", $this->getUrlFile()) . "/sempermissao/index/");
            $this->apagaCookies();
            return false;
        }

        return true;
    }

    /**
     * Retorna com o comentario do metodo da view para saber
     * se a pagina precisa de login ou não e o grupo de
     * permissão
     * @return array com o grupo de permissao e se precisa de login
     */
    public function getAuthorize() {
        $rc = new ReflectionClass($this->getUrlUse());
        if ($this->getView() == null) {
            if ($rc->getDocComment() == null) {
                return null;
            }
            $retorno = $rc->getDocComment();
        } else {
            if ($rc->getMethod($this->getView())->getDocComment() == null) {
                return null;
            }
            $retorno = $rc->getMethod($this->getView())->getDocComment();
        }
        preg_match_all("#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#", $retorno, $saida, PREG_PATTERN_ORDER);
        foreach ($saida[0] as $item) {
            $temp = explode(" ", $item);
            $return[str_replace('@', '', $temp[0])] = trim($temp[1]);
        }
        return $return;
    }

    /**
     * Verifica se a pagina precisa de autorização para acesso
     */
    public function getLogin() {
        if ($this->getAuthorize()['login'] == 'true') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna o grupo de permissão para acessar aquela pagina
     */
    public function getGrupo() {
        return explode(",", $this->getAuthorize()['grupo']);
    }

    /**
     * Verica se todas as sessions para o login estão ativas
     * Se sim retorna elas
     */
    public function getSessions() {
        if (!isset($_SESSION[SessionVO::$LOGIN]) || !isset($_SESSION[SessionVO::$SENHA]) || !isset($_SESSION[SessionVO::$GRUPO])) {
            return null;
        }
        $sessions['login'] = $_SESSION[SessionVO::$LOGIN];
        $sessions['senha'] = $_SESSION[SessionVO::$SENHA];
        $sessions['grupo'] = $_SESSION[SessionVO::$GRUPO];
        return $sessions;
    }

    public function logout() {
        $this->apagaCookies();
        header("Location: /" . implode("/", $this->getUrlFile()) . "/home/index/");
    }

    public function apagaCookies() {
        unset($_SESSION[SessionVO::$ID]);
        unset($_SESSION[SessionVO::$LOGIN]);
        unset($_SESSION[SessionVO::$SENHA]);
        unset($_SESSION[SessionVO::$GRUPO]);
        unset($_SESSION[SessionVO::$GRUPO]);
    }

    public function verificaUsuario() {
        $strClasse = '\model\\' . SessionVO::getMODEL();
        $model = new $strClasse();
        $sessions = $this->getSessions();

        $campos = array(SessionVO::getLOGINDB(), SessionVO::$SENHADB);
        $operadores = array('=', '=');
        $valores = array($sessions['login'], $sessions['senha']);

        /**
         * Consulta usuário no banco
         */
        $buscaUser = $model->getDadosByFiltro($campos, $operadores, $valores);

        /**
         * Verifica se o usuário existe
         */
        if (is_null($buscaUser)) {
            $_SESSION[SessionVO::$ERROLOGIN] = "Usuário ou senha estão incorretos";
            return false;
        }

        $_SESSION[SessionVO::$GRUPO] = $buscaUser[0]->getGrupo();
        $_SESSION[SessionVO::$ID] = $buscaUser[0]->getId();
        unset($_SESSION[SessionVO::$ERROLOGIN]);

        return true;
    }

    public function verificaGrupo() {
        $grupos = explode(",", $this->getSessions()['grupo']);
        foreach ($grupos as $grupo) {
            foreach ($grupos as $item) {
                if (in_array($item, $this->getGrupo())) {
                    return true;
                }
            }
        }
        return false;
    }

}
