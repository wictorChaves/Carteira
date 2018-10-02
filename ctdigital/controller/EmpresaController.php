<?php

namespace controller;

use model\EmpresaModel;

/**
 * Description of EmpresaController
 *
 * @author Wictor
 */
class EmpresaController extends MainController {

    public function index() {
        if ($this->getIssetGet("id")) {
            if ($this->getGetValue("id", "") != "") {
                $model = new EmpresaModel();
                $dados = $model->getDadoById($this->getGetValue("id", ""));
                return $this->view($dados);
            }
        }
        header("Location: ../../page404/index/");
    }

}
