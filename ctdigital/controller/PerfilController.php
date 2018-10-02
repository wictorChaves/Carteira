<?php

namespace controller;

use model\FuncionarioModel;
use model\EmpregoModel;
use core\SessionVO;
use model\EmpresaModel;

/**
 * Description of PerfilController
 *
 * @author Wictor
 */
class PerfilController extends MainController {

    /**
     * @login true
     * @grupo cad_funcionario,empresa
     */
    public function index() {
        if ($_SESSION[SessionVO::$TIPO] == 'cnpj') {
            $model = new EmpresaModel();
            $dados = $model->getDadoById($_SESSION[SessionVO::$ID]);
            return $this->view($dados);
        } else {
            $funcionarioModel = new FuncionarioModel();
            $funcionario = $funcionarioModel->getDadoById($_SESSION[SessionVO::$ID]);
            $modelEmprego = new EmpregoModel();
            $dados['empregos'] = $modelEmprego->getDadosByIdFuncionario($funcionario->getId());
            $dados['funcionario'] = $funcionario;
            return $this->view($dados);
        }
    }

}
