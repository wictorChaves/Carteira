<?php

namespace controller;

use controller\MainController;
use model\EmpregoModel;
use core\RouteConfig;
use core\certificado\Certificado;
use model\TokenModel;
use core\SessionVO;

/**
 * Description of EmpregoController
 *
 * @author Wictor
 */
class EmpEmpregoController extends MainController {

    private $tokenModel = null;

    function __construct() {
        $this->tokenModel = new TokenModel();
    }

    /**
     * @login true
     * @grupo empresa
     */
    public function index() {
        $model = new EmpregoModel();
        $campos = array('data_admissao', 'id_empresa');
        $operadores = array('IS NOT', '=');
        $valores = array(null, $_SESSION[SessionVO::$ID]);
        $dados = $model->getDadosByFiltro($campos, $operadores, $valores);
        return $this->view($dados);
    }

    /**
     * @login true
     * @grupo empresa
     */
    public function propostas() {
        $model = new EmpregoModel();
        $campos = array('data_admissao', 'data_saida', 'id_empresa');
        $operadores = array('IS', 'IS', '=');
        $valores = array(null, null, $_SESSION[SessionVO::$ID]);
        $dados = $model->getDadosByFiltro($campos, $operadores, $valores);
        return $this->view($dados);
    }

    /**
     * @login true
     * @grupo empresa
     */
    public function pedidosDemissao() {
        $model = new EmpregoModel();
        $campos = array('data_saida', 'data_admissao', 'data_dispensa', 'id_empresa');
        $operadores = array('IS', 'IS NOT', 'IS NOT', '=');
        $valores = array(null, null, null, $_SESSION[SessionVO::$ID]);
        $dados = $model->getDadosByFiltro($campos, $operadores, $valores);
        return $this->view($dados);
    }

    /**
     * @login true
     * @grupo empresa
     */
    public function detalhes() {
        if ($_POST != null) {
            if ($this->getPostValue("chave", "") != "") {
                if ($this->tokenModel->getToken($_SESSION[SessionVO::$LOGIN]) == $this->getPostValue("chave", "")) {

                    $model = new EmpregoModel();
                    $emprego = $model->getDadoById($this->getGetValue("id", ""));
                    $emprego->setDataSaida(date('Y-m-d'));

                    $model->setDado($emprego);

                    $response = array(
                        'success' => 'ok',
                        'message' => 'Dados enviados com sucesso!',
                        'enviado' => 'ok',
                        'alert' => 'Funcionario demitido!'
                    );

                    return $this->viewJson($response);
                } else {
                    $response = array(
                        'success' => 'fail',
                        'message' => 'Token inválido!'
                    );
                    return $this->viewJson($response);
                }
            } else {
                $token = $this->tokenModel->geraToken($_SESSION[SessionVO::$LOGIN]);
                $dirCertificado = $this->parseDiretorio('../ctdigital/Certificados' . DIRECTORY_SEPARATOR . $_SESSION[SessionVO::$LOGIN] . '.crt');
                $certificado = new Certificado($dirCertificado);
                $tokenEncrypt = $certificado->encrypt($token);
                $response = array(
                    'success' => 'ok',
                    'message' => 'Dados enviados com sucesso!',
                    'tokenEncrypt' => '' . base64_encode($tokenEncrypt),
                    'token' => $token
                );
                return $this->viewJson($response);
            }
        } else {
            $id = $this->getGetValue("id", "");
            if ($id == "") {
                $rota = new RouteConfig();
                $rota->get404();
            }
            $model = new EmpregoModel();
            $dados = $model->getDadoByIdFuncionario($id);
            if ($dados == null) {
                $rota = new RouteConfig();
                $rota->get404();
            }
            return $this->view($dados);
        }
    }

}
