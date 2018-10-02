<?php

namespace controller;

use controller\MainController;
use model\EmpregoModel;
use core\RouteConfig;
use core\certificado\Certificado;
use core\SessionVO;

/**
 * Description of EmpregoController
 *
 * @author Wictor
 */
class EmpregoController extends MainController {

    /**
     * @login true
     * @grupo trabalhador
     */
    public function index() {
        $model = new EmpregoModel();
        return $this->view($model->getDadosByIdFuncionario($_SESSION[SessionVO::$ID]));
    }

    /**
     * @login true
     * @grupo trabalhador
     */
    public function propostas() {
        $model = new EmpregoModel();
        return $this->view($model->getDadosByIdFuncionario($_SESSION[SessionVO::$ID]));
    }

    /**
     * @login true
     * @grupo trabalhador
     */
    public function detalhes() {
        if ($_POST != null) {
            if (isset($_SESSION['trabalhadortoken']) && $this->getPostValue("chave", "") != "") {
                if ($_SESSION['trabalhadortoken'] == $this->getPostValue("chave", "")) {

                    $model = new EmpregoModel();
                    $emprego = $model->getDadoById($this->getGetValue("id", ""));

                    if ($this->getPostValue("id", "") == "geraToken") {
                        $emprego->setDataAdmissao(date('Y-m-d'));
                    }

                    if ($this->getPostValue("id", "") == "sairEmprego") {
                        $emprego->setDataDispensa(date('Y-m-d'));
                    }

                    if ($this->getPostValue("id", "") == "recusarProposta") {
                        $emprego->setDataDispensa(date('Y-m-d'));
                    }

                    $model->setDado($emprego);

                    $response = array(
                        'success' => 'ok',
                        'message' => 'Dados enviados com sucesso!',
                        'enviado' => 'ok'
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
                $token = $this->guidv4();
                $dirCertificado = $this->parseDiretorio('../ctdigital/Certificados' . DIRECTORY_SEPARATOR . $_SESSION[SessionVO::$LOGIN] . '.crt');
                $certificado = new Certificado($dirCertificado);
                $tokenEncrypt = $certificado->encrypt($token);
                $_SESSION['trabalhadortoken'] = $token;
                $response = array(
                    'success' => 'ok',
                    'message' => 'Utilize sua chave para liberar o token',
                    'tokenEncrypt' => '' . base64_encode($tokenEncrypt)
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
