<?php

namespace controller;

use controller\MainController;
use model\FuncionarioModel;
use model\dominio\Funcionario;
use model\TokenModel;
use core\certificado\Certificado;
use core\certificado\CriarChaves;
use core\certificado\DistinguishedName;
use core\StringHelper;
use core\FileHelper;
use core\SessionVO;
use model\EmpregoModel;

/**
 * Description of FuncionarioController
 *
 * @author Wictor
 */
class FuncionarioController extends MainController {

    public $model = null;
    public $tokenModel = null;

    function __construct() {
        $this->model = new FuncionarioModel();
        $this->tokenModel = new TokenModel();
    }

    /**
     * @login true
     * @grupo cad_funcionario
     */
    public function index() {
        return $this->view($this->model->getDados());
    }

    public function manipulaImg() {
        $nomeFoto = FileHelper::getSomenteArquivo($this->parseDiretorio($this->getPostValue("foto", "")));
        $pastaTemporaria = $this->getPastaRaiz() . "/../temp/";
        $base64 = $this->imgToBase64($this->parseDiretorio($pastaTemporaria . $nomeFoto));
        unlink($this->parseDiretorio($pastaTemporaria . $nomeFoto));
        return $base64;
    }

    public function criaDistinguishedName($dominio) {
        $distinguishedName = new DistinguishedName();
        $distinguishedName->setPais('BR');
        $distinguishedName->setEstado('Minas Gerais');
        $distinguishedName->setCidade('Ipatinga');
        $distinguishedName->setOrganizacao($dominio->getNome());
        $distinguishedName->setSetor($dominio->getNome());
        $distinguishedName->setNome($dominio->getCpf());
        $distinguishedName->setEmail($dominio->getEmail());
        return $distinguishedName;
    }

    public function criaArquivoZip($distinguishedName, $caminho, $caminhoChave) {
        $files_to_zip = array(
            array($caminho . $distinguishedName->getNome() . '.crt', $caminhoChave . 'certificado.crt'),
            array($caminho . $distinguishedName->getNome() . '.key', $caminhoChave . 'key/chave.key'),
            array($caminhoChave . 'Chave.jar', $caminhoChave . 'Chave.jar'),
            array($caminhoChave . 'icon/key-xxl.png', $caminhoChave . 'icon/key-xxl.png'),
            array($caminhoChave . 'icon/Lock-icon.png', $caminhoChave . 'icon/Lock-icon.png'),
            array($caminhoChave . 'icon/Unlock-icon.png', $caminhoChave . 'icon/Unlock-icon.png')
        );
        $this->create_zip($files_to_zip, $caminho . $distinguishedName->getNome() . '.zip');
    }

    /**
     * @login true
     * @grupo cad_funcionario
     */
    public function adicionar() {

        /**
         * Campo autocompletar do municipio
         */
        if ($this->getIssetGet('municipio')) {
            return $this->buscaMunicipio();
        }

        if ($this->isPost()) {
            if ($this->cpfExist()) {
                $response = array(
                    'fail' => 'Este cpf já está sendo usado no sistema'
                );
                return $this->viewJson($response);
            }
            $dominio = $this->postFactory(new Funcionario());
            $validaEntidade = $dominio->isValida();
            if (!is_bool($validaEntidade)) {
                $response = array(
                    'fail' => $validaEntidade
                );
                return $this->viewJson($response);
            }
            if ($this->token()) {
                $dominio->setImagem($this->manipulaImg());
                $dominio->setGrupo(NULL);
                if ($this->model->setDado($dominio)) {
                    $distinguishedName = $this->criaDistinguishedName($dominio);
                    $caminho = $this->parseDiretorio($this->getPastaRaiz() . '/Certificados/');
                    $caminhoChave = $this->parseDiretorio($this->getPastaRaiz() . '/chave/');
                    new CriarChaves($distinguishedName, $caminho, 365, 4096);
                    $this->criaArquivoZip($distinguishedName, $caminho, $caminhoChave);
                    $enviarPara = '../../funcionario/detalhes/?id=' . $distinguishedName->getNome();
                    $enviarPara = str_replace("/", DIRECTORY_SEPARATOR, $enviarPara);
                    $response = array(
                        'setasync' => 'true',
                        'redirecionar' => $enviarPara
                    );
                } else {
                    $response = array('fail' => 'Erro ao tentar enviar!');
                }
                return $this->viewJson($response);
            }
        }
        return $this->view();
    }

    public function cpfExist() {
        $cpf = StringHelper::somenteNumeros($this->getPostValue("cpf", ""));
        $funcionarios = $this->model->getDadosByFiltro('cpf', '=', $cpf);
        if ($funcionarios != null || count($funcionarios) > 0) {
            return true;
        }
        return false;
    }

    private function token() {
        if ($this->getPostValue('chave', '') == '') {
            $token = $this->tokenModel->geraToken($_SESSION[SessionVO::$LOGIN]);
            $certificado = new Certificado('Certificados' . DIRECTORY_SEPARATOR . $_SESSION[SessionVO::$LOGIN] . '.crt');
            $tokenEncrypt = $certificado->encrypt($token);
            $response = array(
                'success' => 'Favor liberar a chave para cadastrar',
                'mostracmp' => array('areatoken'),
                'settexto' => array(
                    array('botaoenviar', 'Confirmar'),
                    array('transfer', '' . base64_encode($tokenEncrypt)))
            );
            $this->viewJson($response);
            exit();
        } else {
            if ($this->tokenModel->getToken($_SESSION[SessionVO::$LOGIN]) == $this->getPostValue("chave", "")) {
                return true;
            } else {
                $token = $this->tokenModel->geraToken($_SESSION[SessionVO::$LOGIN]);
                $certificado = new Certificado('Certificados' . DIRECTORY_SEPARATOR . $_SESSION[SessionVO::$LOGIN] . '.crt');
                $tokenEncrypt = $certificado->encrypt($token);
                $response = array(
                    'fail' => 'Token invalido',
                    'settexto' => array(array('transfer', '' . base64_encode($tokenEncrypt)))
                );
                $this->viewJson($response);
                exit();
            }
        }
        return false;
    }

    private function buscaMunicipio() {
        $query = "SELECT * FROM municipio WHERE `municipio` LIKE '%" .
                $this->getPostValue('QueryFilter', '') . "%' LIMIT 3";
        $resultados = $this->model->getCustomQuery($query);
        $response = array();
        foreach ($resultados as $row) {
            $valor = utf8_encode($row['municipio']) . ", " . utf8_encode($row['estado']);
            $response[] = array(
                'valor' => $valor,
                'id' => $row['id']);
        }
        return $this->viewJson($response);
    }

    /**
     * @login true
     * @grupo cad_funcionario
     */
    public function detalhes() {
        if ($this->getIssetGet("id")) {
            $id = $this->getGetValue("id", "");

            $model = new FuncionarioModel();
            $funcionario = $model->getDadosByFiltro('cpf', '=', $id)[0];

            $modelEmprego = new EmpregoModel();
            $dados['empregos'] = $modelEmprego->getDadosByIdFuncionario($funcionario->getId());
            $dados['funcionario'] = $funcionario;
            return $this->view($dados);
        }
        return $this->view();
    }

}
