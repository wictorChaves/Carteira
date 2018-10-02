<?php

namespace core;

use core\StringHelper;

/**
 * Description of StatusVO
 *
 * @author Wictor
 */
class StatusPeriodoTrabalho {

    public static $ATIVO = 'ativo';
    public static $PENDENTE = 'pendente';
    public static $INATIVO = 'inativo';
    public static $PEDIUDEMISSAO = 'pediudemissao';
    
    public static function getPeriodo($item) {
        if(is_array($item)){
            $data_admissao = $item['data_admissao'];
            $data_saida = $item['data_saida'];
            $data_dispensa = $item['data_dispensa'];
        }else{
            $data_admissao = $item->getDataAdmissao();
            $data_saida = $item->getDataSaida() ;
            $data_dispensa = $item->getDataDispensa();
        }
        if(is_null($data_admissao) && !is_null($data_dispensa)){
            return "Recusou o emprego";
        }
        if(!is_null($data_admissao) && !is_null($data_saida)){
            return StringHelper::dataEN2BR($data_admissao) . " - " . StringHelper::dataEN2BR($data_saida);
        }
        if(!is_null($data_admissao) && is_null($data_dispensa)){
            return StringHelper::dataEN2BR($data_admissao) . " - Atual";
        }
        
        return StringHelper::dataEN2BR($data_admissao) . " - " . StringHelper::dataEN2BR($data_dispensa);
    }

}
