<?php

namespace model;

use model\dominio\Emprego;

/**
 * Description of ModelPessoa
 *
 * @author Wictor
 */
class EmpregoModel extends Model {

    function __construct() {
        parent::__construct(new Emprego());
    }
    
    public function getDadosByIdFuncionario($id) {
        return $this->getCustomQuery("SELECT emprego.*,empresa.nome_fantasia FROM emprego,empresa WHERE emprego.id_empresa = empresa.id and emprego.id_funcionario = " . $id);
    }
    
    public function getDadoByIdFuncionario($id) {
        return $this->getCustomQuery("SELECT emprego.*,empresa.nome_fantasia FROM emprego,empresa WHERE emprego.id_empresa = empresa.id and emprego.id = " . $id)[0];
    }
    
    public function getPropostasByIdFuncionario($id) {
        return $this->getCustomQuery("SELECT emprego.*,empresa.nome_fantasia FROM emprego,empresa WHERE emprego.id_empresa = empresa.id and emprego.data_saida IS NULL and emprego.data_admissao IS NULL and emprego.data_dispensa IS NULL and emprego.id_funcionario = " . $id);
    }
}
