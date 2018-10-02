<?php

namespace core\certificado;

use App;
use core\certificado\DistinguishedName;


/**
 * Description of CriarChaves
 *
 * @author Wictor
 */
class CriarChaves extends App{

    private $distinguishedName;

    /**
     * Destino com barra no final
     */
    function __construct(DistinguishedName $distinguishedName, $destino, $validade, $tamanho) {
        $this->distinguishedName = new DistinguishedName();
        $this->distinguishedName = $distinguishedName;

        /**
         * Configuração para criar pacote pkcs8
         */
        $sslConfig = array(
            "digest_alg" => "sha512",
            "private_key_bits" => $tamanho,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        $diretorio = $this->parseDiretorioFile($this->getPastaRaiz() . "/Certificados/");
        
        $cacertCA = $diretorio . "ca.crt";
        $privkeyCA = array($diretorio . "ca.key", "grafite");
        
        /**
         * Cria os certificados
         */
        $privkey = openssl_pkey_new($sslConfig);
        $csr = openssl_csr_new($distinguishedName->getDistinguishedName(), $privkey);
        $sscert = openssl_csr_sign($csr, $cacertCA, $privkeyCA, $validade);
        openssl_x509_export_to_file($sscert, $destino . $this->distinguishedName->getNome() . '.crt');
        openssl_pkey_export_to_file($privkey, $destino . $this->distinguishedName->getNome() . '.key');
    }

    function getDistinguishedName() {
        return $this->distinguishedName;
    }

}
