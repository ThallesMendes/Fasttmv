<?php
namespace Fasttmv\Classes;

use Fasttmv\Interfaces\IObjeto;

/**
 * Class Objeto
 * @package Atualizador\Classes
 */
class Objeto implements IObjeto {

    /**
     * @var Objeto
     */
    public static $instance;

    /**
     * @var object
     */
    public static $objeto;

	private function __construct(){
			
	}

	public static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance = new Objeto();
		}
		return self::$instance;
	}

    # call static
    final public static function __callStatic( $chrMethod, $arrArguments ) {

        $objInstance = self::getInstance();

        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments);

    }

}
