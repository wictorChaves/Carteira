<?php

namespace model;

use model\dominio\Pessoa;

/**
 * Description of ModelPessoa
 *
 * @author Wictor
 */
class PessoaModel extends Model {

    function __construct() {
        parent::__construct(new Pessoa());
    }

}
