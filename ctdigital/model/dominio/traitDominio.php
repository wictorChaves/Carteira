<?php

namespace model\dominio;

/**
 * Description of traitDominio
 *
 * @author wictor
 */
trait traitDominio {

    public function getAtributos() {
        return array_keys(get_object_vars($this));
    }

}
