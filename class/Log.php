<?php
namespace Fasttmv\Classes;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * Class Log
 * @package Atualizador\Classes
 */
class Log extends Objeto
{

    /**
     * @var
     */
    public static $instance;

    /**
     * Log constructor.
     */
    private function __construct(){

    }

    /**
     * @return Logger
     */
    public static function getInstance(){
        if(!isset(self::$instance)){
            // Criar Logger
            $logger = new Logger('log_sistema');
            // Adiciona Handlers
            $logger->pushHandler(new StreamHandler(dirname(__DIR__) .'/logs/debug.log', Logger::DEBUG));
            $logger->pushHandler(new StreamHandler(dirname(__DIR__) .'/logs/alert.log', Logger::ALERT));
            $logger->pushHandler(new StreamHandler(dirname(__DIR__) .'/logs/critical.log', Logger::CRITICAL));
            $logger->pushHandler(new StreamHandler(dirname(__DIR__) .'/logs/error.log', Logger::ERROR));
            $logger->pushHandler(new StreamHandler(dirname(__DIR__) .'/logs/emergency.log', Logger::EMERGENCY));
            $logger->pushHandler(new StreamHandler(dirname(__DIR__) .'/logs/notice.log', Logger::NOTICE));
            $logger->pushHandler(new StreamHandler(dirname(__DIR__) .'/logs/warning.log', Logger::WARNING));
            $logger->pushHandler(new StreamHandler(dirname(__DIR__) .'/logs/info.log', Logger::INFO));
            $logger->pushHandler(new FirePHPHandler());

            self::$instance = $logger;
        }
        return self::$instance;
    }

}