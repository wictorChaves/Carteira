<?php

namespace controller;

/**
 * Description of SempermissaoController
 *
 * @author wictor
 */
class SempermissaoController extends MainController {
    
    function __construct() {
        $this->setLayout(null);
    }

    public function index() {
        return $this->view();
    }

}
