<?php

namespace conexao;

use PDO;
use PDOException;
use core\Config;

class Conexao {

    /**
     * Informações para a conexao
     */
    private $servername;
    private $username;
    private $password;
    private $banco;

    /**
     * Deixando a conexão 'static' evita que outra conexão se abra desnecessariamente
     */
    private static $conn = null;
    private $status = null;

    /**
     * Conecta ao criar o objeto
     */
    public function __construct() {

        /**
         * Pega as configurações do arquivo ini
         */
        $this->servername = Config::getConfig()['banco']['servername'];
        $this->username = Config::getConfig()['banco']['username'];
        $this->password = Config::getConfig()['banco']['password'];
        $this->banco = Config::getConfig()['banco']['banco'];

        /**
         * Faz a conexão com o banco
         */
        $this->openConection();
    }

    /**
     * Conexao
     */
    public function openConection() {
        try {

            //Verifica se uma instancia já existe
            if (!isset(self::$conn)) {
                //String de conexão
                self::$conn = new PDO("mysql:host=$this->servername;dbname=$this->banco", $this->username, $this->password);

                // set the PDO error mode to exception
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

            //Mensagem de status
            $this->status = "Conectado no host $this->servername, no banco dbname=$this->banco com o usuário $this->username";
        } catch (PDOException $e) {
            //Mensagem de status
            $this->status = "Falha ao tentar conectar: \n" . $e->getMessage();
        }
    }

    private function limpaQuery($query) {
        $itens = array("'NULL'", '"NULL"');
        return str_replace($itens, "NULL", $query);
    }

    /**
     * Pega as informações do banco
     * @param type $query
     * @return type
     */
    public function getQuery($query) {
        try {
            return self::$conn->query($this->limpaQuery($query));
        } catch (PDOException $Exception) {
            var_export($query);
            die();
        }
    }

    /**
     * Envia as informações para o banco
     * @param type $query
     */
    public function setQuery($query) {
        try {
            $stmt = self::$conn->prepare($this->limpaQuery($query));
            return $stmt->execute();
        } catch (PDOException $Exception) {
            var_export($query);
            die();
        }
    }

    public function log($valor) {
        $remover = array("'");
        $valor = str_replace($remover, "#", $valor);
        $query = "INSERT INTO `log` (`id`, `informacao`) VALUES (NULL, '" . $valor . "')";
        $stmt = self::$conn->prepare($this->limpaQuery($query));
        return $stmt->execute();
    }

    /**
     * Fecha a conexão com o banco
     */
    public function closeConection() {
        self::$conn = null;
    }

    /**
     * Pega o status da conexão
     * @return type
     */
    function getStatus() {
        return $this->status;
    }

}
