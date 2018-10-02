<?php

namespace model;

use model\dominio\Funcionario;
use core\SessionVO;

/**
 * Description of ModelPessoa
 *
 * @author Wictor
 */
class FuncionarioModel extends Model {

    function __construct() {
        parent::__construct(new Funcionario());
    }

    public function getFuncionariosEmpresa() {
        $query = "SELECT funcionario.*, emprego.data_admissao, emprego.data_saida, emprego.data_dispensa FROM funcionario,emprego,empresa WHERE empresa.id = emprego.id_empresa AND funcionario.id = emprego.id_funcionario AND emprego.data_admissao IS NOT NULL AND empresa.id = " . $_SESSION[SessionVO::$ID] . " GROUP BY funcionario.id";
        return $this->getCustomQuery($query);
    }

}
