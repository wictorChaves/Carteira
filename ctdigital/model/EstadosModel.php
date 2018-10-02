<?php

namespace model;

use model\dominio\Estados;

/**
 * Description of EstadosModel
 *
 * @author Wictor
 */
class EstadosModel extends Model {

    function __construct() {
        parent::__construct(new Estados());
    }

}
