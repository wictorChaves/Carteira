<?php

namespace controller;

use model\dominio\Funcionario;

/**
 * Description of TesteController
 *
 * @author wictor
 */
class TesteController extends MainController {

    public function index() {
        $funcionarios = new Funcionario();
        return $this->view($funcionarios->getAtributos());
    }

}
