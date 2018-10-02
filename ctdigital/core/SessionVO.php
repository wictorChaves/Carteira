<?php

namespace core;

/**
 * Description of StatusVO
 *
 * @author Wictor
 */
class SessionVO {

    public static $ID = 'id';
    public static $LOGIN = 'login';
    public static $SENHA = 'senha';
    public static $TIPO = 'tipo';
    public static $GRUPO = 'grupo';
    public static $ERROLOGIN = 'erroLogin';
    public static $SENHADB = 'senha';
    private static $LOGINDB = 'cpf';
    private static $MODEL = 'FuncionarioModel';

    static function getLOGINDB() {
        if (isset($_SESSION[SessionVO::$TIPO])) {
            if ($_SESSION[SessionVO::$TIPO] == 'cnpj') {
                return 'cnpj';
            } else {
                return 'cpf';
            }
        } else {
            return 'cpf';
        }
    }

    static function getMODEL() {
        if (isset($_SESSION[SessionVO::$TIPO])) {
            if ($_SESSION[SessionVO::$TIPO] == 'cnpj') {
                return 'EmpresaModel';
            } else {
                return 'FuncionarioModel';
            }
        } else {
            return 'FuncionarioModel';
        }
        return self::$MODEL;
    }

}
