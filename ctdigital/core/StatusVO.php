<?php

namespace core;

/**
 * Description of StatusVO
 *
 * @author Wictor
 */
class StatusVO {

    public static $ATIVO = 'ativo';
    public static $PENDENTE = 'pendente';
    public static $INATIVO = 'inativo';
    public static $PEDIUDEMISSAO = 'pediudemissao';
    
    public static function getStatus($item) {
        if(is_array($item)){
            $data_admissao = $item['data_admissao'];
            $data_saida = $item['data_saida'];
            $data_dispensa = $item['data_dispensa'];
        }else{
            $data_admissao = $item->getDataAdmissao();
            $data_saida = $item->getDataSaida() ;
            $data_dispensa = $item->getDataDispensa();
        }
        if(is_null($data_admissao) && is_null($data_saida) && is_null($data_dispensa)){
            return StatusVO::$PENDENTE;
        }
        if(!is_null($data_admissao) && is_null($data_saida) && is_null($data_dispensa)){
            return StatusVO::$ATIVO;
        }
        if(!is_null($data_admissao) && is_null($data_saida) && !is_null($data_dispensa)){
            return StatusVO::$PEDIUDEMISSAO;
        }
        if(!is_null($data_dispensa) || !is_null($data_saida)){
            return StatusVO::$INATIVO;
        }
    }
    
    public static function getLabel($valor) {
        switch ($valor) {
            case 'ativo':
                return "label-success";
                break;
            case 'pendente':
                return "label-info";
                break;
            case 'inativo':
                return "label-default";
                break;
            case 'pediudemissao':
                return "label-warning";
                break;
        }
    }

    public static function getValor($valor) {
        switch ($valor) {
            case 'ativo':
                return "Ativo";
                break;
            case 'pendente':
                return "Pendente";
                break;
            case 'inativo':
                return "Inativo";
                break;
            case 'pediudemissao':
                return "Pediu Demissão";
                break;
        }
    }

}
