<?php

namespace controller;

use model\EmpresaModel;
use model\dominio\Empresa;
use core\StringHelper;
use core\FileHelper;
use core\certificado\Certificado;
use core\certificado\CriarChaves;
use core\certificado\DistinguishedName;
use model\TokenModel;
use core\SessionVO;

/**
 * Description of EmpresaController
 *
 * @author Wictor
 */
class CadEmpresaController extends MainController {

    public $model = null;
    public $tokenModel = null;

    function __construct() {
        $this->model = new EmpresaModel();
        $this->tokenModel = new TokenModel();
    }

    /**
     * @login true
     * @grupo cad_empresa
     */
    public function index() {
        return $this->view($this->model->getDados());
    }
    
    /**
     * @login true
     * @grupo cad_empresa
     */
    public function detalhes() {
        if ($this->getIssetGet("id")) {
            $id = $this->getGetValue("id", "");
            $dados['empresa'] = $this->model->getDadosByFiltro('cnpj', '=', $id)[0];
            return $this->view($dados);
        }
        return $this->view();
    }
    
    /**
     * @login true
     * @grupo cad_empresa
     */
    public function adicionar() {
        if ($this->isPost()) {
            if ($this->cnpjExist()) {
                $response = array(
                    'fail' => 'Este cnpj já está sendo usado no sistema'
                );
                return $this->viewJson($response);
            }
            if ($this->token()) {
                $dominio = $this->postFactory(new Empresa());
                $dominio->setGrupo(null);
                $dominio->setImagem($this->manipulaImg());
                if ($this->model->setDado($dominio)) {
                    $distinguishedName = $this->criaDistinguishedName($dominio);
                    $caminho = $this->parseDiretorio($this->getPastaRaiz() . '/Certificados/');
                    $caminhoChave = $this->parseDiretorio($this->getPastaRaiz() . '/chave/');
                    new CriarChaves($distinguishedName, $caminho, 365, 4096);
                    $this->criaArquivoZip($distinguishedName, $caminho, $caminhoChave);
                    $enviarPara = '../../cadempresa/detalhes/?id=' . $distinguishedName->getNome();
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
        $distinguishedName->setOrganizacao($dominio->getRazaoSocial());
        $distinguishedName->setSetor($dominio->getNomeFantasia());
        $distinguishedName->setNome($dominio->getCnpj());
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

    public function cnpjExist() {
        $cnpj = StringHelper::somenteNumeros($this->getPostValue("cnpj", ""));
        $empresas = $this->model->getDadosByFiltro('cnpj', '=', $cnpj);
        if ($empresas != null || count($empresas) > 0) {
            return true;
        }
        return false;
    }

    private function token() {
        $caminhoDoCertificado = $this->parseDiretorio('../ctdigital/Certificados' . DIRECTORY_SEPARATOR . $_SESSION[SessionVO::$LOGIN] . '.crt');
        if ($this->getPostValue('chave', '') == '') {
            $token = $this->tokenModel->geraToken($_SESSION[SessionVO::$LOGIN]);
            $certificado = new Certificado($caminhoDoCertificado);
            $tokenEncrypt = $certificado->encrypt($token);
            $response = array(
                'success' => 'Favor liberar a chave para contratar',
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
                $certificado = new Certificado($caminhoDoCertificado);
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

}
