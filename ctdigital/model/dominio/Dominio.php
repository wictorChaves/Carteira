<?php

namespace model\dominio;

use core\StringHelper;

/**
 * Description of Dominio
 *
 * @author Wictor
 */
class Dominio {

    public function campoCompletoOuVazio($valor, $tamanho = 3) {
        if (!is_null($valor)) {
            if (!(strlen($valor) == $tamanho) && !(strlen($valor) == 0)) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    public function campoRequerido($valor, $tamanho = 3) {
        if (!is_null($valor)) {
            if (strlen($valor) >= $tamanho) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function campoData($valor) {
        $data = explode("-", $this->converteData($valor));
        if (is_array($data) && count($data) == 3) {
            return checkdate($data[1], $data[2], $data[0]);
        } else {
            return false;
        }
    }

    public function campoIdade($data, $idade = 18) {
        $data = $this->converteData($data);
        $nova_data = strtotime('-' . $idade . ' year', strtotime(date("Y-m-d")));
        if ($nova_data >= strtotime($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna o nome da classe
     * @return string Nome da classe
     */
    public static function getClassName() {
        $namespace = explode("\\", get_called_class());
        return end($namespace);
    }

    public function converteData($data) {
        if (strpos($data, "/")) {
            return StringHelper::dataBR2EN($data);
        } else if (strpos($data, "-")) {
            return $data;
        } else {
            return NULL;
        }
    }

    /**
     * Valor null para o banco
     * @param type $valor
     */
    function valorNullBanco($valor) {
        if ($valor == '') {
            return 'NULL';
        } else {
            return $valor;
        }
    }

}
