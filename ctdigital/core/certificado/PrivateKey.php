<?php
namespace core\certificado;
/**
 * Description of PrivateKey
 *
 * @author Wictor
 */
class PrivateKey {

    private $arquivo;
    private $senha;

    function __construct($arquivo, $senha = null) {
        $this->arquivo = $arquivo;
        $this->senha = $senha;
    }

    public function getKey() {
        openssl_pkey_export($this->getResource(), $privkey);
        return $privkey;
    }
    
    public function validarSenha() {
        return is_null($this->senha);
    }

    public function getResource() {
        if ($this->validarSenha()) {
            $res = ((openssl_pkey_get_private(file_get_contents($this->arquivo))));
        } else {
            $res = ((openssl_pkey_get_private(file_get_contents($this->arquivo), $this->senha)));
        }
        return $res;
    }

    public function getPublicKey() {
        return openssl_pkey_get_details($this->getResource())['key'];
    }

    public function encrypt($dado) {
        openssl_private_encrypt($dado, $dadoEncrypt, $this->getKey());
        return $dadoEncrypt;
    }

    public function decrypt($dadoEncrypt) {
        openssl_private_decrypt($dadoEncrypt, $dado, $this->getKey());
        return $dado;
    }
    function getArquivo() {
        return $this->arquivo;
    }

    function getSenha() {
        return $this->senha;
    }

}
