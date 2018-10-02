<?php

namespace controller;

use model\FuncionarioModel;
use model\EmpregoModel;
use core\certificado\Certificado;
use model\dominio\Emprego;
use model\TokenModel;
use core\StringHelper;
use core\SessionVO;

/**
 * Description of ContratarController
 *
 * @author Wictor
 */
class ContratarController extends MainController {

    private $tokenModel = null;

    function __construct() {
        $this->tokenModel = new TokenModel();
    }

    /**
     * @login true
     * @grupo empresa
     */
    public function index() {

        /**
         * Carrega formulario para busca do funcionario
         */
        if ($this->getGetValue('cpf', '') == '') {
            return $this->view(null);
        }

        /**
         * Carrega funcionario
         */
        if ($_POST == null) {
            $funcionario = new FuncionarioModel();
            $resultado = $funcionario->getDadosByFiltro("cpf", "=", StringHelper::somenteNumeros($this->getGetValue("cpf", "")));
            if (count($resultado) > 0) {
                $dados['funcionario'] = $resultado[0];
                $modelEmprego = new EmpregoModel();
                $dados['empregos'] = $modelEmprego->getDadosByIdFuncionario($resultado[0]->getId());
                return $this->view($dados);
            }
            return $this->view(null);
        }

        /**
         * Contrata o funcionario
         */
        if ($this->getPostValue("chave", "") != "") {
            if ($this->tokenModel->getToken($_SESSION[SessionVO::$LOGIN]) == $this->getPostValue("chave", "")) {

                $empregoModel = new EmpregoModel();
                $emprego = new Emprego();

                $emprego->setIdFuncionario($this->getPostValue("idfuncionario", ""));
                $emprego->setIdEmpresa($this->getPostValue("idempresa", ""));
                $emprego->setCargo($this->getPostValue("cargo", ""));
                $emprego->setRemuneracao(StringHelper::dinheiroBR2EN($this->getPostValue("salario", "")));
                $emprego->setDataAdmissao(null);
                $emprego->setDataSaida(null);
                $emprego->setDataDispensa(null);

                $empregoModel->setDado($emprego);

                $response = array(
                    'success' => 'ok',
                    'message' => 'Dados enviados com sucesso!',
                    'enviado' => 'ok',
                    'alert' => 'Agora é só esperar o retorno do funcionário!'
                );
                return $this->viewJson($response);
            } else {
                $response = array(
                    'success' => 'fail',
                    'message' => 'Token inválido!'
                );
                return $this->viewJson($response);
            }
        }

        /**
         * Gera a chave para o
         */
        $token = $this->tokenModel->geraToken($_SESSION[SessionVO::$LOGIN]);
        $dirCertificado = $this->parseDiretorio('../ctdigital/Certificados' . DIRECTORY_SEPARATOR . $_SESSION[SessionVO::$LOGIN] . '.crt');
        $certificado = new Certificado($dirCertificado);
        $tokenEncrypt = $certificado->encrypt($token);
        $response = array(
            'success' => 'ok',
            'message' => 'Favor liberar a chave para contratar',
            'tokenEncrypt' => '' . base64_encode($tokenEncrypt)
        );
        return $this->viewJson($response);
    }

}
