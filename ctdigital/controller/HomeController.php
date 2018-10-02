<?php

namespace controller;

use controller\MainController;
use model\EmpregoModel;
use model\FuncionarioModel;
use controller\PerfilController;
use core\SessionVO;
use model\EmpresaModel;

/**
 * Description of HomeController
 *
 * @author Wictor
 */
class HomeController extends MainController {

    /**
     * @login true
     * @grupo trabalhador,empresa
     */
    public function index() {
        $perfil = new PerfilController();
        return $perfil->index();
    }

    public function propostas() {
        if ($_SESSION[SessionVO::$TIPO] == 'cpf') {
            $model = new EmpregoModel();
            $resultado = $model->getPropostasByIdFuncionario($_SESSION[SessionVO::$ID]);
            if(count($resultado) > 0){
                return $resultado;
            }
            return null;
        }
        return null;
    }

    public function getInformacoes() {
        if ($_SESSION[SessionVO::$TIPO] == 'cnpj') {
            $empresa = new EmpresaModel();
            return $empresa->getDadoById($_SESSION[SessionVO::$ID]);
        } else {
            $funcionarioModel = new FuncionarioModel();
            return $funcionarioModel->getDadoById($_SESSION[SessionVO::$ID]);
        }
    }

}
