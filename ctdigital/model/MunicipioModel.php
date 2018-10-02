<?php

namespace model;

use model\dominio\Municipio;

/**
 * Description of MunicipioModel
 *
 * @author wictor
 */
class MunicipioModel extends Model {

    function __construct() {
        parent::__construct(new Municipio());
    }

}
