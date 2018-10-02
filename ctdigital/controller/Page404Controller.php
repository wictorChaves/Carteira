<?php

namespace controller;

use controller\MainController;

/**
 * Description of page404
 *
 * @author Wictor
 */
class Page404Controller extends MainController {
    
    public function index() {
        return $this->view();
    }

}
