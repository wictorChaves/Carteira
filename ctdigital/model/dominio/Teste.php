<?php

namespace model\dominio;

use model\dominio\Dominio;

/**
 * Description of Teste
 *
 * @author Wictor
 */
class Teste extends Dominio {

    use traitDominio;

    //put your code here
    private $id;
    private $nome;
    private $idade;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getIdade() {
        return $this->idade;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setIdade($idade) {
        $this->idade = $idade;
    }

}
