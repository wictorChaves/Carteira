<?php

namespace model;

use model\dominio\Cadastrador;

/**
 * Description of CadastradorModel
 *
 * @author Wictor
 */
class CadastradorModel extends Model {

    function __construct() {
        parent::__construct(new Cadastrador());
    }

}
