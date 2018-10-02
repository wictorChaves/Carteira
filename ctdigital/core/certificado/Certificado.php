<?php
namespace core\certificado;
/**
 * Description of PrivateKey
 *
 * @author Wictor
 */
class Certificado {

    private $arquivo;

    function __construct($arquivo) {
        $this->arquivo = $arquivo;
    }

    public function getResource() {
        return openssl_pkey_get_public(file_get_contents($this->arquivo));
    }

    public function getKey() {
        return (openssl_pkey_get_details($this->getResource())['key']);
    }
    
    public function getFileKey() {
        $myfile = fopen($this->arquivo, "r");
        return fread($myfile,filesize($this->arquivo));
    }

    public function encrypt($dado) {
        openssl_public_encrypt($dado, $dadoEncrypt, $this->getKey());
        return $dadoEncrypt;
    }

    public function decrypt($dadoEncrypt) {
        openssl_public_decrypt($dadoEncrypt, $dado, $this->getKey());
        return $dado;
    }
    
    public function getInformacoes(){
        return openssl_x509_parse(file_get_contents($this->arquivo));
    }

    public function getDataCriacao() {
        $validFrom = date('Y-m-d H:i:s', $this->getInformacoes()['validFrom_time_t']);
        return $validFrom;
    }

    public function getDataValidade() {
        $validTo = date('Y-m-d H:i:s', $this->getInformacoes()['validTo_time_t']);
        return $validTo;
    }

    function getArquivo() {
        return $this->arquivo;
    }
}
