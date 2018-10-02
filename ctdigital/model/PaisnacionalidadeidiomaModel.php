<?php

namespace model;

use model\dominio\Paisnacionalidadeidioma;

/**
 * Description of PaisnacionalidadeidiomaModel
 *
 * @author Wictor
 */
class PaisnacionalidadeidiomaModel extends Model {

    function __construct() {
        parent::__construct(new Paisnacionalidadeidioma());
    }

    public function getDados() {
        return $this->queryToArrayObj("select * from " . $this->getTabela() . " ORDER BY `nacionalidade` ASC");
    }

}
