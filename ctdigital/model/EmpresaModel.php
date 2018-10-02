<?php

namespace model;

use model\dominio\Empresa;

/**
 * Description of EmpresaModel
 *
 * @author Wictor
 */
class EmpresaModel extends Model {

    function __construct() {
        parent::__construct(new Empresa());
    }

}
