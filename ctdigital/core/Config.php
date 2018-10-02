<?php

namespace core;

/**
 * Description of Config
 *
 * @author Wictor
 */
class Config {

    public static $config;

    static function getConfig() {
        return self::$config;
    }

    static function getPath($path) {
        $barras = array("\\", "/");
        return str_replace($barras, DIRECTORY_SEPARATOR, Config::getConfig()['path'][$path]);
    }

    static function setConfig($config) {
        self::$config = $config;
    }

}
