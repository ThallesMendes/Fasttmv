<?php
namespace Fasttmv\Classes;

/**
 * Class Config
 * @package Fasttmv\Classes
 */
class Config extends Objeto
{
     private $config;
	 private $dev_mode = true;
    /**
     * @var Objeto
     */
    public static $instance;

    /**
     * @var object
     */
    public static $objeto;

    private function __construct(){
		if($this->dev_mode){
			$this->config = dirname(dirname(__FILE__)) . '/config-dev.json';
		}
		else {
			$this->config = dirname(dirname(__FILE__)) . '/config.json';
		}
    }

    /**
     * @return Config|Objeto
     */
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new Config();
        }
        return self::$instance;
    }

    /**
     * @param $type
     * @param $config
     * @param null $default
     * @return null
     */
    public function getConfig( $type, $config , $default = null){
        $json = file_get_contents($this->config);
        $json = json_decode($json);

        return isset($json->{$type}->{$config}) ? $json->{$type}->{$config} : $default;
    }


}