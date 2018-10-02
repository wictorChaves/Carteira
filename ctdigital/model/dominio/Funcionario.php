<?php

namespace model\dominio;

use core\StringHelper;

/**
 * Description of Funcionario
 *
 * @author Wictor
 */
class Funcionario extends Dominio {

    use traitDominio;

    private $id;
    private $pis;
    private $numeroCarteira;
    private $nome;
    private $mae;
    private $pai;
    private $dataNascimento;
    private $sexo;
    private $estadoCivil;
    private $naturalidade;
    private $rg;
    private $cpf;
    private $cnh;
    private $tituloEleitoral;
    private $secao;
    private $zona;
    private $localEmissao;
    private $nacionalidade;
    private $nChegada;
    private $nExpedido;
    private $nEstado;
    private $observacao;
    private $email;
    private $imagem;
    private $senha;
    private $grupo;
    private $dataEmissao;

    public function isValida() {
        if (!$this->campoRequerido($this->pis, 11)) {
            return "Preencha o campo PIS!";
        }
        if ($this->campoCompletoOuVazio($this->numeroCarteira, 9)) {
            return "Preencha o campo Número da carteira por completo!";
        }
        if (!$this->campoRequerido($this->nome)) {
            return "Preencha o campo Nome!";
        }
        if (!$this->campoRequerido($this->mae)) {
            return "Preencha o campo Mãe!";
        }
        if (!$this->campoRequerido($this->pai)) {
            return "Preencha o campo Pai!";
        }
        if (!$this->campoData($this->dataNascimento)) {
            return "Data de nascimento invalida!";
        }
        if (!$this->campoIdade($this->dataNascimento, 14)) {
            return "A idade deve ser maior que 14 anos!";
        }
        if (!in_array($this->sexo, array(0, 1))) {
            return "Sexo invalido!";
        }
        if (!is_numeric($this->estadoCivil)) {
            return "Favor informa o seu estado civil!";
        }
        if (!is_numeric($this->naturalidade)) {
            return "Favor informa o sua naturalidade!";
        }
        if (!is_numeric($this->nacionalidade)) {
            return "Favor informa sua Nacionalidade!";
        }
        if (!$this->campoRequerido($this->rg, 4)) {
            return "Favor informa seu RG!";
        }
        if (!$this->campoRequerido($this->cpf, 11) && !is_numeric($this->cpf)) {
            return "Favor informa seu CPF!";
        }
        if ($this->campoCompletoOuVazio($this->cnh, 11) && $this->cnh != 'NULL') {
            return "Preencha o campo CNH por completo!";
        }
        if ($this->nacionalidade == 7) {

            $this->nChegada = NULL;
            $this->nChegada = NULL;
            $this->nExpedido = NULL;
            $this->nEstado = NULL;

            if ($this->campoIdade($this->dataNascimento, 18)) {
                if (!$this->campoRequerido($this->tituloEleitoral, 12) && !is_numeric($this->tituloEleitoral)) {
                    return "Favor informa seu Titulo Eleitoral!";
                }
                if (!$this->campoRequerido($this->tituloEleitoral, 12) && !is_numeric($this->tituloEleitoral)) {
                    return "Favor informa seu Titulo Eleitoral!";
                }
                if (!$this->campoRequerido($this->secao, 4) && !is_numeric($this->secao)) {
                    return "Favor informa sua Seção!";
                }
                if (!$this->campoRequerido($this->zona, 3) && !is_numeric($this->zona)) {
                    return "Favor informa sua Zona!";
                }
                if (!is_numeric($this->localEmissao)) {
                    return "Favor informa o Local de emissão!";
                }
            }
        } else {

            $this->tituloEleitoral = NULL;
            $this->secao = NULL;
            $this->zona = NULL;

            if (strtotime($this->nChegada) < strtotime($this->dataNascimento)) {
                return "Data de chegada deve ser maior que a data de nascimento!";
            }

            if (!$this->campoData($this->nChegada)) {
                return "Data de chegada invalida!";
            }
            if (!$this->campoData($this->nChegada)) {
                return "Data de chegada invalida!";
            }
            if (!$this->campoRequerido($this->nExpedido, 4)) {
                return "Favor informa seu Expedido!";
            }
            if (!$this->campoRequerido($this->nEstado, 2)) {
                return "Favor informa seu Estado!";
            }
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return "E-mail invalido";
        }
        return true;
    }

    function __construct(...$args) {

        /**
         * Verifica se há parametros
         */
        if (isset($args)) {
            /**
             * Conta quanto atributos existem
             */
            $c = 0;
            foreach (get_class_methods($this) as $metodo) {
                if (preg_match('/set/', $metodo)) {
                    $c++;
                }
            }

            //Zera todos os valores se a pessoa instanciar desta forma new Classe('')
            if (count($args) == 1 && $args[0] == '') {
                foreach (array_slice(get_class_methods($this), 1) as $i => $metodo) {
                    if (preg_match('/set/', $metodo)) {
                        if (array_key_exists($c, $args)) {
                            $this->$metodo('');
                        }
                        $c++;
                    }
                }
            } else if (count($args) == ($c - 1)) {//Se não entrar com o id
                $this->id = null;
                $c = 0;
                foreach (array_slice(get_class_methods($this), 1) as $i => $metodo) {
                    if (preg_match('/set/', $metodo)) {
                        if (array_key_exists($c, $args)) {
                            $this->$metodo($args[$c]);
                        }
                        $c++;
                    }
                }
            } else {
                $c = 0;
                foreach (get_class_methods($this) as $i => $metodo) {
                    if (preg_match('/set/', $metodo)) {
                        if (array_key_exists($c, $args)) {
                            $this->$metodo($args[$c]);
                        }
                        $c++;
                    }
                }
            }
        } else {
            $this->id = null;
        }
    }

    function getId() {
        return $this->id;
    }

    function getPis() {
        return $this->pis;
    }

    function getNumeroCarteira() {
        return $this->numeroCarteira;
    }

    function getNome() {
        return $this->nome;
    }

    function getMae() {
        return $this->mae;
    }

    function getPai() {
        return $this->pai;
    }

    function getDataNascimento() {
        return $this->dataNascimento;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getEstadoCivil() {
        return $this->estadoCivil;
    }

    function getNaturalidade() {
        return $this->naturalidade;
    }

    function getRg() {
        return $this->rg;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getCnh() {
        return $this->cnh;
    }

    function getTituloEleitoral() {
        return $this->tituloEleitoral;
    }

    function getSecao() {
        return $this->secao;
    }

    function getZona() {
        return $this->zona;
    }

    function getLocalEmissao() {
        return $this->localEmissao;
    }

    function getNacionalidade() {
        return $this->nacionalidade;
    }

    function getNChegada() {
        return $this->nChegada;
    }

    function getNExpedido() {
        return $this->nExpedido;
    }

    function getNEstado() {
        return $this->nEstado;
    }

    function getObservacao() {
        return $this->observacao;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPis($pis) {
        $this->pis = StringHelper::somenteNumeros($pis);
    }

    function setNumeroCarteira($numeroCarteira) {
        $this->numeroCarteira = StringHelper::somenteNumeros($numeroCarteira);
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setMae($mae) {
        $this->mae = $mae;
    }

    function setPai($pai) {
        $this->pai = $pai;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $this->converteData($dataNascimento);
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setEstadoCivil($estadoCivil) {
        $this->estadoCivil = $estadoCivil;
    }

    function setNaturalidade($naturalidade) {
        $this->naturalidade = $naturalidade;
    }

    function setRg($rg) {
        $this->rg = $rg;
    }

    function setCpf($cpf) {
        $this->cpf = StringHelper::somenteNumeros($cpf);
    }

    function setCnh($cnh) {
        $this->cnh = $this->valorNullBanco($cnh);
    }

    function setTituloEleitoral($tituloEleitoral) {
        $this->tituloEleitoral = StringHelper::somenteNumeros($tituloEleitoral);
    }

    function setSecao($secao) {
        $this->secao = StringHelper::somenteNumeros($secao);
    }

    function setZona($zona) {
        $this->zona = StringHelper::somenteNumeros($zona);
    }

    function setLocalEmissao($localEmissao) {
        $this->localEmissao = $localEmissao;
    }

    function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
    }

    function setNChegada($nChegada) {
        $this->nChegada = $this->converteData($nChegada);
    }

    function setNExpedido($nExpedido) {
        $this->nExpedido = $nExpedido;
    }

    function setNEstado($nEstado) {
        $this->nEstado = $nEstado;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function getGrupo() {
        return $this->grupo;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    function getDataEmissao() {
        return $this->dataEmissao;
    }

    function setDataEmissao($dataEmissao) {
        $this->dataEmissao = $this->converteData($dataEmissao);
    }

    function getImagem() {
        return $this->imagem;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

}
