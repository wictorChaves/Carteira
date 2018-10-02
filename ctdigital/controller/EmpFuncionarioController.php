<?php

namespace controller;

use controller\MainController;
use model\FuncionarioModel;
use model\EmpregoModel;

/**
 * Description of FuncionarioController
 *
 * @author Wictor
 */
class EmpFuncionarioController extends MainController {

    public $model = null;

    function __construct() {
        $this->model = new FuncionarioModel();
    }

    /**
     * @login true
     * @grupo empresa
     */
    public function index() {
        return $this->view($this->model->getFuncionariosEmpresa());
    }

    /**
     * @login true
     * @grupo empresa
     */
    public function detalhes() {
        if ($this->getIssetGet("id")) {
            $id = $this->getGetValue("id", "");
            
            $model = new FuncionarioModel();
            $modelEmprego = new EmpregoModel();
            $dados['funcionario'] = $model->getDadoById($id);
            $dados['empregos'] = $modelEmprego->getDadosByIdFuncionario($id);
            
            return $this->view($dados);
        }
        return $this->view();
    }

}
