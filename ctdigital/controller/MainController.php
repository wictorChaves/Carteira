<?php

namespace controller;

use model\Model;
use App;

/**
 * Description of MainController
 *
 * @author Wictor
 * 
 * __FUNCTION__
 * __METHOD__
 * __FILE__
 * __LINE__
 * __CLASS__
 * __NAMESPACE__
 * 
 */
class MainController extends App{

    //Seta o '_layout' como padrão
    private static $layout = '_layout';

    /**
     * Informação de qual view chamar e
     * dados que serão enviados para a view 
     * @var type 
     */
    private $_viewreturn = [];

    static function getLayout() {
        return self::$layout;
    }

    static function setLayout($layout) {
        self::$layout = $layout;
    }

    /**
     * Converte o atributo para atributo do banco exemplo
     * dataNascimento para data_nascimento
     * @param type $string
     * @return type
     */
    public function atributoToDb($string) {
        $string = preg_replace('/([A-Z])/', '_$1', $string);
        return strtolower($string);
    }

    public function postFactory($class) {
        if ($_POST != null) {

            //Pega os atributos da classe
            $model = new Model($class);
            $class->getAtributos();

            //Instancia a classe
            $classe = 'model\dominio\\' . ucfirst($model->getTabela());
            $class = new $classe();

            //Se não tiver o id pula ele no foreach
            $i = 1;
            if ($this->getPostValue('id', '') != '') {
                $i = 0;
            }

            //Atribui todos os valores no objeto
            foreach (array_slice($class->getAtributos(), $i) as $atributo) {
                $metodo = 'set' . ucfirst($atributo);
                $class->$metodo($this->getPostValue($this->atributoToDb($atributo), ''));
            }
            return $class;
        } else {
            return null;
        }
    }

    /**
     * Carrega a pagina
     * SobreCarga view() e view($model)
     */
    public function view() {

        $_viewreturn['view'] = 'view\\' . $this->getFolderView() . '\\' . $this->getNomeMetodoFilho() . '.php';

        //Para realizar sobrecarga
        $count = func_num_args();
        if ($count == 1) {
            $_viewreturn['model'] = func_get_arg(0);
        }
        return $_viewreturn;
    }

    /**
     * Pega o quão profundo foi chamado o metodo
     */
    private function getProfundidade() {
        return count(debug_backtrace()) - 3;
    }

    /**
     * Pega o nome do metodo filho
     */
    private function getNomeMetodoFilho() {
        return debug_backtrace()[$this->getProfundidade()]['function'];
    }

    /**
     * Pega a pasta onde esta a view
     */
    private function getFolderView() {

        /**
         * Pega o namespace e o nome da classe
         */
        $classeFilha = debug_backtrace()[$this->getProfundidade()]['class'];

        /**
         * Pega somente o nome da classe em minusculo
         */
        $array = explode('\\', strtolower($classeFilha));
        $classeFilha = end($array);

        /**
         * Remove a palavra controller do nome
         */
        $classeFilha = str_replace("controller", "", $classeFilha);

        return $classeFilha;
    }

    public function viewJson($response) {
        header("content-type: application/json; charset=utf-8");
        echo json_encode($response);
        return null;
    }

}
