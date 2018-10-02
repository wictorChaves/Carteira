<?php

namespace core\certificado;

/**
 * Is one pem encoded certificate the signer of another?
 *
 * The PHP openssl functionality is severely limited by the lack of a stable
 * api and documentation that might as well have been encrypted itself.
 * In particular the documention on openssl_verify() never explains where
 * to get the actual signature to verify.  The isCertSigner() function below
 * will accept two PEM encoded certs as arguments and will return true if
 * one certificate was used to sign the other.  It only relies on the
 * openssl_pkey_get_public() and openssl_public_decrypt() openssl functions,
 * which should stay fairly stable.  The ASN parsing code snippets were mostly
 * borrowed from the horde project's smime.php.
 *
 * @author Mike Green <mikey at badpenguins dot com>
 * @copyright Copyright (c) 2010, Mike Green
 * @license http://opensource.org/licenses/gpl-2.0.php GPLv2
 */

/**
 * 
 * Description of VerificaAssinatura
 *
 * Modificado por:
 * 
 * @author Wictor
 */
class Assinatura {

    /**
     *  Mensagem de erro ao verifica a assinatura
     * @var type string 
     */
    Private $erro = null;
    
    function getErro() {
        return $this->erro;
    }

    function setErro($erro) {
        $this->erro = $erro;
    }

    public function assinar($csr, PrivateKey $key, Certificado $crt, $days, $out) {
        $csrdata = file_get_contents($csr);
        $cacert = "file://" . getcwd() . "/" . $crt->getArquivo();
        $privkey = array("file://" . getcwd() . "/" . $key->getArquivo(), $key->getSenha());
        $usercert = openssl_csr_sign($csrdata, $cacert, $privkey, $days);
        openssl_x509_export_to_file($usercert, getcwd() . '//' . $out);
    }

    /**
     * Extrai a assinatura
     * @param type $der
     * @return boolean
     */
    public function extractSignature($der = false) {
        if (strlen($der) < 5) {
            return false;
        }
        // skip container sequence
        $der = substr($der, 4);
        // now burn through two sequences and the return the final bitstream
        while (strlen($der) > 1) {
            $class = ord($der[0]);
            $classHex = dechex($class);
            switch ($class) {
                // BITSTREAM
                case 0x03:
                    $len = ord($der[1]);
                    $bytes = 0;
                    if ($len & 0x80) {
                        $bytes = $len & 0x0f;
                        $len = 0;
                        for ($i = 0; $i < $bytes; $i++) {
                            $len = ($len << 8) | ord($der[$i + 2]);
                        }
                    }
                    return substr($der, 3 + $bytes, $len);
                    break;
                // SEQUENCE
                case 0x30:
                    $len = ord($der[1]);
                    $bytes = 0;
                    if ($len & 0x80) {
                        $bytes = $len & 0x0f;
                        $len = 0;
                        for ($i = 0; $i < $bytes; $i++) {
                            $len = ($len << 8) | ord($der[$i + 2]);
                        }
                    }
                    $contents = substr($der, 2 + $bytes, $len);
                    $der = substr($der, 2 + $bytes + $len);
                    break;
                default:
                    return false;
                    break;
            }
        }
        return false;
    }

    /**
     * Get signature algorithm oid from der encoded signature data.
     * Expects decrypted signature data from a certificate in der format.
     * This ASN1 data should contain the following structure:
     * SEQUENCE
     *    SEQUENCE
     *       OID    (signature algorithm)
     *       NULL
     * OCTET STRING (signature hash)
     * @return bool false on failures
     * @return string oid
     */
    public function getSignatureAlgorithmOid($der = null) {

        // Validate this is the der we need...
        if (!is_string($der) or strlen($der) < 5) {
            return false;
        }
        $bit_seq1 = 0;
        $bit_seq2 = 2;
        $bit_oid = 4;
        if (ord($der[$bit_seq1]) !== 0x30) {
            die('Invalid DER passed to getSignatureAlgorithmOid()');
        }
        if (ord($der[$bit_seq2]) !== 0x30) {
            die('Invalid DER passed to getSignatureAlgorithmOid()');
        }
        if (ord($der[$bit_oid]) !== 0x06) {
            die('Invalid DER passed to getSignatureAlgorithmOid');
        }

        // strip out what we don't need and get the oid
        $der = substr($der, $bit_oid);

        // Get the oid
        $len = ord($der[1]);
        $bytes = 0;
        if ($len & 0x80) {
            $bytes = $len & 0x0f;
            $len = 0;
            for ($i = 0; $i < $bytes; $i++) {
                $len = ($len << 8) | ord($der[$i + 2]);
            }
        }
        $oid_data = substr($der, 2 + $bytes, $len);

        // Unpack the OID
        $oid = floor(ord($oid_data[0]) / 40);
        $oid .= '.' . ord($oid_data[0]) % 40;
        $value = 0;
        $i = 1;
        while ($i < strlen($oid_data)) {
            $value = $value << 7;
            $value = $value | (ord($oid_data[$i]) & 0x7f);
            if (!(ord($oid_data[$i]) & 0x80)) {
                $oid .= '.' . $value;
                $value = 0;
            }
            $i++;
        }
        return $oid;
    }

    /**
     * Get signature hash from der encoded signature data.
     * Expects decrypted signature data from a certificate in der format.
     * This ASN1 data should contain the following structure:
     * SEQUENCE
     *    SEQUENCE
     *       OID    (signature algorithm)
     *       NULL
     * OCTET STRING (signature hash)
     * @return bool false on failures
     * @return string hash
     */
    public function getSignatureHash($der = null) {

        // Validate this is the der we need...
        if (!is_string($der) or strlen($der) < 5) {
            return false;
        }
        if (ord($der[0]) !== 0x30) {
            die('Invalid DER passed to getSignatureHash()');
        }

        // strip out the container sequence
        $der = substr($der, 2);
        if (ord($der[0]) !== 0x30) {
            die('Invalid DER passed to getSignatureHash()');
        }

        // Get the length of the first sequence so we can strip it out.
        $len = ord($der[1]);
        $bytes = 0;
        if ($len & 0x80) {
            $bytes = $len & 0x0f;
            $len = 0;
            for ($i = 0; $i < $bytes; $i++) {
                $len = ($len << 8) | ord($der[$i + 2]);
            }
        }
        $der = substr($der, 2 + $bytes + $len);

        // Now we should have an octet string
        if (ord($der[0]) !== 0x04) {
            die('Invalid DER passed to getSignatureHash()');
        }
        $len = ord($der[1]);
        $bytes = 0;
        if ($len & 0x80) {
            $bytes = $len & 0x0f;
            $len = 0;
            for ($i = 0; $i < $bytes; $i++) {
                $len = ($len << 8) | ord($der[$i + 2]);
            }
        }
        return bin2hex(substr($der, 2 + $bytes, $len));
    }

    /**
     * Determine if one cert was used to sign another
     * Note that more than one CA cert can give a positive result, some certs
     * re-issue signing certs after having only changed the expiration dates.
     * @param string $cert - PEM encoded cert
     * @param string $caCert - PEM encoded cert that possibly signed $cert
     * @return bool
     */
    public function verificar($certificado, $ca) {
        $certPem = $certificado->getFileKey();
        $caCertPem = $ca->getKey();
        if (!function_exists('openssl_pkey_get_public')) {
            $this->setErro('Need the openssl_pkey_get_public() public function.');
            return 0;
        }
        if (!function_exists('openssl_public_decrypt')) {
            $this->setErro('Need the openssl_public_decrypt() public function.');
            return 0;
        }
        if (!function_exists('hash')) {
            $this->setErro('Need the php hash() public function.');
            return 0;
        }
        if (empty($certPem) or empty($caCertPem)) {
            return 0;
        }

        // Convert the cert to der for feeding to extractSignature.
        $certDer = $this->pemToDer($certPem);
        if (!is_string($certDer)) {
            $this->setErro('invalid certPem');
            return 0;
        }

        // Grab the encrypted signature from the der encoded cert.
        $encryptedSig = $this->extractSignature($certDer);
        if (!is_string($encryptedSig)) {
            $this->setErro('Failed to extract encrypted signature from certPem.');
            return 0;
        }

        // Extract the public key from the ca cert, which is what has
        // been used to encrypt the signature in the cert.
        $pubKey = openssl_pkey_get_public($caCertPem);
        if ($pubKey === false) {
            $this->setErro('Failed to extract the public key from the ca cert.');
            return 0;
        }

        // Attempt to decrypt the encrypted signature using the CA's public
        // key, returning the decrypted signature in $decryptedSig.  If
        // it can't be decrypted, this ca was not used to sign it for sure...
        $rc = openssl_public_decrypt($encryptedSig, $decryptedSig, $pubKey);
        if ($rc === false) {
            return 0;
        }

        // We now have the decrypted signature, which is der encoded
        // asn1 data containing the signature algorithm and signature hash.
        // Now we need what was originally hashed by the issuer, which is
        // the original DER encoded certificate without the issuer and
        // signature information.
        $origCert = $this->stripSignerAsn($certDer);
        if ($origCert === false) {
            $this->setErro('Failed to extract unsigned cert.');
            return 0;
        }

        // Get the oid of the signature hash algorithm, which is required
        // to generate our own hash of the original cert.  This hash is
        // what will be compared to the issuers hash.
        $oid = $this->getSignatureAlgorithmOid($decryptedSig);
        if ($oid === false) {
            $this->setErro('Failed to determine the signature algorithm.');
            return 0;
        }
        switch ($oid) {
            case '1.2.840.113549.2.2': $algo = 'md2';
                break;
            case '1.2.840.113549.2.4': $algo = 'md4';
                break;
            case '1.2.840.113549.2.5': $algo = 'md5';
                break;
            case '1.3.14.3.2.18': $algo = 'sha';
                break;
            case '1.3.14.3.2.26': $algo = 'sha1';
                break;
            case '2.16.840.1.101.3.4.2.1': $algo = 'sha256';
                break;
            case '2.16.840.1.101.3.4.2.2': $algo = 'sha384';
                break;
            case '2.16.840.1.101.3.4.2.3': $algo = 'sha512';
                break;
            default:
                die('Unknown signature hash algorithm oid: ' . $oid);
                break;
        }

        // Get the issuer generated hash from the decrypted signature.
        $decryptedHash = $this->getSignatureHash($decryptedSig);

        // Ok, hash the original unsigned cert with the same algorithm
        // and if it matches $decryptedHash we have a winner.
        $certHash = hash($algo, $origCert);
        return ($decryptedHash === $certHash);
    }

    /**
     * Convert pem encoded certificate to DER encoding
     * @return string $derEncoded on success
     * @return bool false on failures
     */
    public function pemToDer($pem = null) {
        if (!is_string($pem)) {
            return false;
        }
        $cert_split = preg_split('/(-----((BEGIN)|(END)) CERTIFICATE-----)/', $pem);
        if (!isset($cert_split[1])) {
            return false;
        }
        return base64_decode($cert_split[1]);
    }

    /**
     * Obtain der cert with issuer and signature sections stripped.
     * @param string $der - der encoded certificate
     * @return string $der on success
     * @return bool false on failures.
     */
    public function stripSignerAsn($der = null) {
        if (!is_string($der) or strlen($der) < 8) {
            return false;
        }
        $bit = 4;
        $len = ord($der[($bit + 1)]);
        $bytes = 0;
        if ($len & 0x80) {
            $bytes = $len & 0x0f;
            $len = 0;
            for ($i = 0; $i < $bytes; $i++) {
                $len = ($len << 8) | ord($der[$bit + $i + 2]);
            }
        }
        return substr($der, 4, $len + 4);
    }

}
