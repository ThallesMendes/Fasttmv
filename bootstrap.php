<?php

@session_start();

require_once "vendor/autoload.php";

use Fasttmv\Classes\Config;

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

/**
 * CONFIGURAÇÕES DE URL E PATHS
 */
define('URL_PRINCIPAL', Config::getInstance()->getConfig('url','url_principal'));
define('URL_RAIZ',Config::getInstance()->getConfig('url','url_raiz'));
define('URL_API',Config::getInstance()->getConfig('url','url_api'));
define('URL_RESOURCE',Config::getInstance()->getConfig('url','url_resource'));
define('BASE_VIEWS', Config::getInstance()->getConfig('url','url_views'));
define('BASE_PUBLIC', Config::getInstance()->getConfig('url','url_public'));
/**
 * CONFIGURACOES GLOBAIS
 */
define('PAGE_SIZE', Config::getInstance()->getConfig('global','page_size'));
define('DEV_MODE', Config::getInstance()->getConfig('global','dev_mode'));
