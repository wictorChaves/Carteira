<?php

namespace tela;

use DOMDocument;
use tela\InfoView;
use core\UrlHelper;
use ReflectionClass;
use core\SessionVO;

/**
 * Cria um array para o menu
 *
 * @author Wictor
 */
class Menu extends UrlHelper {

    private $menu = null;
    private $dir = 'controller';

    function __construct() {

        /**
         * Verifica se o diretorio existe
         */
        if (!file_exists($this->dir)) {
            return;
        }

        /**
         * Pega todos os arquivos do diretorio
         */
        $files = scandir($this->dir);

        /**
         * Pecorre todos os arquivos
         */
        foreach (array_slice($files, 2) as $i => $file) {

            /**
             * Remove o "Controller.php" do nome do arquivo
             */
            $nome = strtolower(str_replace("Controller.php", "", $file));

            /**
             * Verifica se a classe tem view
             */
            if (!file_exists('view/' . $nome)) {
                continue;
            }

            /**
             * Pega o todos os metodos da classe
             */
            foreach (get_class_methods('controller\\' . str_replace(".php", "", $file)) as $metodo) {

                /**
                 * Pega a listagem de views
                 */
                $views = scandir('view/' . $nome);

                /**
                 * Pecorre todas as views
                 */
                foreach (array_slice($views, 2) as $view) {

                    /**
                     * Verifica se o metodo tem uma view
                     */
                    if (!(str_replace(".php", "", $view) == $metodo)) {
                        continue;
                    }

                    /**
                     * Cria link
                     */
                    $link = $nome . "/$metodo/";

                    /**
                     * Busca no arquivo o titulo do menu
                     */
                    $inforView = new InfoView('view/' . $nome . '/' . $metodo . '.php');

                    /**
                     * Se não tiver coloca o nome do arquivo
                     */
                    if ($inforView->getTituloView() == null) {
                        $tituloMenu = $metodo;
                    } else {
                        $tituloMenu = $inforView->getTituloView();
                    }

                    /**
                     * Verifica se o grupo tem permissao
                     */
                    $grupos = explode(",", $_SESSION[SessionVO::$GRUPO]);
                    $grupo_permissao = $this->getAuthorize($nome, $metodo)['grupo'];

                    /**
                     * Não aparece no menu caso tenha a tag div com a classe _menuOff
                     */
                    if ($inforView->getMenuOff() == null && ($grupo_permissao == null || in_array($grupo_permissao, $grupos))) {
                        /**
                         * Nome e href
                         */
                        $submenu[] = array($tituloMenu, $link);
                    }
                }
            }

            /**
             * Busca no arquivo o titulo do menu principal
             */
            $inforView = new InfoView('view/' . $nome . '/index.php');
            if ($inforView->getTituloMenuPrincipal() != null) {
                $nome = $inforView->getTituloMenuPrincipal();
            }

            /**
             * Busca no arquivo o icone do menu principal
             */
            $icon = 'fa-circle-thin';
            if ($inforView->getIconMenuPrincipal() != null) {
                $icon = $inforView->getIconMenuPrincipal();
            }

            /**
             * Não aparece no menu caso tenha a tag div com a classe _menuOff
             */
            if ($inforView->getMenuOff() == null && isset($submenu) && $submenu != null) {
                $menu[] = array($nome, $submenu, $icon);
            }
            $submenu = array();
        }

        /**
         * Cria o array do menu
         */
        $this->menu = $menu;
    }

    /**
     * Retorna com o comentario do metodo da view para saber
     * se a pagina precisa de login ou não e o grupo de
     * permissão
     * @return array com o grupo de permissao e se precisa de login
     */
    public function getAuthorize($controller, $view) {
        $controller = "\controller\\" . ucfirst($controller) . "Controller";
        $rc = new ReflectionClass($controller);
        if ($view == null) {
            if ($rc->getDocComment() == null) {
                return null;
            }
            $retorno = $rc->getDocComment();
        } else {
            if ($rc->getMethod($view)->getDocComment() == null) {
                return null;
            }
            $retorno = $rc->getMethod($view)->getDocComment();
        }
        preg_match_all("#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#", $retorno, $saida, PREG_PATTERN_ORDER);
        foreach ($saida[0] as $item) {
            $temp = explode(" ", $item);
            $return[str_replace('@', '', $temp[0])] = trim($temp[1]);
        }
        return $return;
    }

    /**
     * Gera o menu de acordo com os controllers e as views
     */
    public function getMenu() {
        return $this->menu;
    }

    public function ativo($valor) {
        if (implode("/", $this->getUrlSemRaiz()) . "/" == $valor) {
            return "active";
        }
    }

    public function ativoMainMenu($valor) {
        $pgAtual = $this->getUrlSemRaiz();
        $pgAtual = reset($pgAtual);
        if ($pgAtual == explode("/", $valor)[0]) {
            return "active";
        }
    }

}
