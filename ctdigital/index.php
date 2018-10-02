<?php

session_start();
/**
 * AutoLoader
 */
include_once 'AutoLoader.php';
new AutoLoader();

/**
 * Rotas
 */
use core\Config;
use core\RouteConfig;

/**
 * Carrega o arquivo de configuração
 */
Config::setConfig(parse_ini_file("config.ini", true));


header('Content-Type: text/html; charset=utf-8', true);



/**
 * Rotas
 */
$rotas = new RouteConfig();
$rotas->callView();
