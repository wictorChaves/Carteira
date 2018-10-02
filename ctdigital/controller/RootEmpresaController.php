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
class RootEmpresaController extends MainController {

    public $model = null;
    public $tokenModel = null;

    function __construct() {
        $this->model = new EmpresaModel();
        $this->tokenModel = new TokenModel();
    }

    /**
     * @login true
     * @grupo root
     */
    public function index() {
        return $this->view($this->model->getDados());
    }

    public function manipulaImg() {
        if ($this->getPostValue("foto", "") == '') {
            return null;
        }
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

    public function cnpjExist($cnpj) {
        $empresas = $this->model->getDadosByFiltro('cnpj', '=', $cnpj);
        if ($empresas != null || count($empresas) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @login true
     * @grupo root
     */
    public function detalhes() {
        if ($this->getIssetGet("id")) {
            $id = $this->getGetValue("id", "");
            $dados['empresa'] = $this->model->getDadosByFiltro('cnpj', '=', $id)[0];
        } else {
            return $this->view();
        }
        if ($this->isPost()) {
            if ($this->token()) {
                $dominio = $this->postFactory(new Empresa());
                if ($dados['empresa']->getCnpj() != $dominio->getCnpj()) {
                    if ($this->cnpjExist($dominio->getCnpj())) {
                        $response = array(
                            'fail' => 'Este cnpj já está sendo usado no sistema'
                        );
                        return $this->viewJson($response);
                    }
                }
                if ($dominio->getGrupo() != '') {
                    $dominio->setGrupo('empresa');
                }
                $imagem = $this->manipulaImg();
                if (is_null($imagem)) {
                    $dominio->setImagem($dados['empresa']->getImagem());
                } else {
                    $dominio->setImagem($imagem);
                }
                if ($this->model->setDado($dominio)) {

                    $old = $dados['empresa']->getCnpj();
                    $new = $dominio->getCnpj();

                    $caminho = $this->parseDiretorio($this->getPastaRaiz() . '/../ctdigital/Certificados/');

                    rename($caminho . $old . ".zip", $caminho . $new . ".zip");
                    rename($caminho . $old . ".crt", $caminho . $new . ".crt");
                    rename($caminho . $old . ".key", $caminho . $new . ".key");

                    $enviarPara = $this->parseDiretorio('../../rootempresa/detalhes/?id=' . $new);

                    $response = array(
                        'setasync' => 'true',
                        'redirecionar' => $enviarPara . "&save=ok"
                    );
                } else {
                    $response = array('fail' => 'Erro ao tentar enviar!');
                }
                return $this->viewJson($response);
            }
        } else {
            return $this->view($dados);
        }
    }

    public function criaArquivoZip($new, $caminho, $caminhoChave) {
        $files_to_zip = array(
            array($caminho . $new . '.crt', $caminhoChave . 'certificado.crt'),
            array($caminho . $new . '.key', $caminhoChave . 'key/chave.key'),
            array($caminhoChave . 'Chave.jar', $caminhoChave . 'Chave.jar'),
            array($caminhoChave . 'icon/key-xxl.png', $caminhoChave . 'icon/key-xxl.png'),
            array($caminhoChave . 'icon/Lock-icon.png', $caminhoChave . 'icon/Lock-icon.png'),
            array($caminhoChave . 'icon/Unlock-icon.png', $caminhoChave . 'icon/Unlock-icon.png')
        );
        $this->create_zip($files_to_zip, $caminho . $new . '.zip');
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
