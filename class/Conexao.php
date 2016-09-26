<?php
namespace Fasttmv\Classes;

# Thalles Mendes 27/06/2015
# Classe Conexao BD singleton

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Conexao {

	private static $isDevMode = true;
	private static $dbParams;
	
	public static $entityManager;
	
	# get instance singleton
	public static function getInstance(){
		self::$dbParams = array(
			'driver'   => Config::getInstance()->getConfig('db','driver'),
			'user'     => Config::getInstance()->getConfig('db','user'),
			'host'	   => Config::getInstance()->getConfig('db','host'),
			'password' => Config::getInstance()->getConfig('db','password'),
			'dbname'   => Config::getInstance()->getConfig('db','database'),
			'charset'  => 'utf8',
			'driversOptions'=> array(
				1002=>'SET NAMES utf8'
			)
		);

        if (!isset(self::$entityManager)) {
			Log::getInstance()->addDebug('iniciando conexao com banco de dados');
            $config = Setup::createConfiguration(self::$isDevMode);
            $driver = new AnnotationDriver(new AnnotationReader(), array(dirname(__FILE__) . "/entity/"));
            AnnotationRegistry::registerLoader('class_exists');
            $config->setMetadataDriverImpl($driver);
            self::$entityManager = EntityManager::create(self::$dbParams, $config);
			Log::getInstance()->addDebug('conectado com sucesso');
        }

		return self::$entityManager;
		
	}
	
	# call static
	final public static function __callStatic( $chrMethod, $arrArguments ) { 
            
        $objInstance = self::getInstance(); 
        
        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments); 
        
    }
	
}