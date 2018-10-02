<?php

namespace core;

/**
 * Description of StringHelper
 * 
 * Formata Strings
 *
 * @author Wictor
 */
class StringHelper {

    public static function somenteNumeros($string) {
        return preg_replace("/[^0-9]/", "", $string);
    }

    public static function getCodeFormate($texto) {
        return "<code>" . $texto . "</code>";
    }

    public static function getPreFormate($texto) {
        return "<pre>" . $texto . "</pre>";
    }

    public static function getMostraNome($nome) {
        $arrayNome = explode(" ", $nome);
        if (count($arrayNome) >= 2) {
            return $arrayNome[0] . " " . $arrayNome[1];
        } else {
            return $nome;
        }
    }

    public static function getCep($numero) {
        return StringHelper::mascara($numero, '#####-###');
    }

    public static function getNumeroCarteira($numero) {
        return StringHelper::mascara($numero, '###.###.##-##');
    }

    public static function getCpf($numero) {
        return StringHelper::mascara($numero, '###.###.###-##');
    }

    public static function getCnpj($numero) {
        return StringHelper::mascara($numero, '##.###.###/####-##');
    }

    public static function getInscricaoEstadual($numero) {
        return StringHelper::mascara($numero, '###.###.###.###');
    }

    public static function getSexo($valor) {
        if ($valor == 1) {
            return "Masculino";
        } else {
            return "Feminino";
        }
    }

    public static function dataEN2BR($valor) {
        $valor = str_replace("-", "", $valor);
        $ano = substr($valor, 0, 4);
        $mes = substr($valor, 4, 2);
        $dia = substr($valor, 6, 2);
        return $dia . "/" . $mes . "/" . $ano;
    }

    public static function dataBR2EN($valor) {
        $valor = str_replace("/", "", $valor);
        $dia = substr($valor, 0, 2);
        $mes = substr($valor, 2, 2);
        $ano = substr($valor, 4, 4);
        return $ano . "-" . $mes . "-" . $dia;
    }

    public static function mascara($val, $mask) {

        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    public static function isEmpty($valor) {
        if ($valor == '') {
            return true;
        }
        if (is_null($valor)) {
            return true;
        }
    }
    
    public static function dinheiroBR2EN($valor){
        $valor = str_replace(".", "", $valor);
        return str_replace(",", ".", $valor);
    }
    
    public static function dinheiroEN2BR($valor){
        $valor = str_replace(",", "", $valor);
        return str_replace(".", ",", $valor);
    }

}
