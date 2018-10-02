<?php

namespace model;

use model\dominio\Token;
use model\TokenModel;

/**
 * Description of TokenModel
 *
 * @author Wictor
 */
class TokenModel extends Model {

    private $token = null;

    function __construct() {
        parent::__construct(new Token());
        $this->token = new Token();
    }

    public function geraToken($idToken) {
        $guid = $this->guidv4();
        $this->token->setId(null);
        $this->token->setIdToken($idToken);
        $this->token->setValor($guid);
        $this->token->setDataHora(NULL);
        $this->setDado($this->token);
        return $guid;
    }

    public function getToken($idToken) {
        /**
         * Tempo valido do token (Minutos)
         */
        $tempo = 30;
        $temp = $this->getCustomQuery('SELECT * FROM token WHERE data_hora BETWEEN (now() - INTERVAL ' .
                $tempo . ' MINUTE) AND now() AND id_token = ' .
                $idToken . ' ORDER BY id DESC');
        if (count($temp) > 0) {
            $token = $temp[0]['valor'];
        } else {
            $token = 0;
        }
        $this->setDeleteWhere("id_token", "=", $idToken);
        return $token;
    }

}
