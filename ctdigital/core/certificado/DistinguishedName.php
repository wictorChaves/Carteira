<?php
namespace core\certificado;
/*
  [ req_distinguished_name ]
  countryName                     = Country Name (2 letter code)
  countryName_default             = US
  countryName_min                 = 2
  countryName_max                 = 2

  stateOrProvinceName             = State or Province Name (full name)
  stateOrProvinceName_default     = Wisconsin

  localityName                    = Locality Name (eg, city)
  localityName_default            = Madison

  0.organizationName              = Organization Name (eg, company)
  0.organizationName_default      = University of Wisconsin -- Madison

  1.organizationName              = Second Organization Name (eg, company)
  1.organizationName_default      = Computer Sciences Department

  organizationalUnitName          = Organizational Unit Name (eg, section)
  organizationalUnitName_default  = Condor Project

  commonName                      = Common Name (eg, YOUR name)
  commonName_max                  = 64

  emailAddress                    = Email Address
  emailAddress_max                = 40
 */

/**
 * Description of DistinguishedName
 *
 * @author Wictor
 */
class DistinguishedName {

    private $pais;
    private $estado;
    private $cidade;
    private $organizacao;
    private $setor;
    private $nome;
    private $email;

    public function __construct(...$args) {
        if (isset($args)) {
            $count = count($args);
            if ($count == 7) {
                $this->setPais($args[0]);
                $this->setEstado($args[1]);
                $this->setCidade($args[2]);
                $this->setOrganizacao($args[3]);
                $this->setSetor($args[4]);
                $this->setNome($args[5]);
                $this->setEmail($args[6]);
            }
        }
    }

    public function getDistinguishedName() {
        return array(
            "countryName" => $this->getPais(),
            "stateOrProvinceName" => $this->getEstado(),
            "localityName" => $this->getCidade(),
            "organizationName" => $this->getOrganizacao(),
            "organizationalUnitName" => $this->getSetor(),
            "commonName" => $this->getNome(),
            "emailAddress" => $this->getEmail()
        );
    }

    public function getPais() {
        return $this->pais;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getOrganizacao() {
        return $this->organizacao;
    }

    public function getSetor() {
        return $this->setor;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setOrganizacao($organizacao) {
        $this->organizacao = $organizacao;
    }

    public function setSetor($setor) {
        $this->setor = $setor;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

}
