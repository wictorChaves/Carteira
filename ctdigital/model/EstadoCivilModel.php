<?php

namespace model;

use model\dominio\EstadoCivil;

/**
 * Description of EstadosModel
 *
 * @author Wictor
 */
class EstadoCivilModel extends Model {

    function __construct() {
        parent::__construct(new EstadoCivil());
    }

}
