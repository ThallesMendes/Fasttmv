<?php
namespace Fasttmv\Classes;

/**
 * Class Config
 * @package Fasttmv\Classes
 */
class Config extends Objeto
{
     private $config;
	 private $dev_mode;
     private $path_config;
    /**
     * @var Objeto
     */
    public static $instance;

    /**
     * @var object
     */
    public static $objeto;

    private function __construct(){

        if($this->getPathConfig() == '')
            $this->setPathConfig(dirname(dirname(__FILE__)));

		if($this->isDevMode()){
			$this->config = $this->getPathConfig() . '/config-dev.json';
		}
		else {
			$this->config = $this->getPathConfig() . '/config.json';
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

    /**
     * @return boolean
     */
    public function isDevMode()
    {
        return $this->dev_mode;
    }

    /**
     * @param boolean $dev_mode
     */
    public function setDevMode($dev_mode)
    {
        $this->dev_mode = $dev_mode;
    }

    /**
     * @return mixed
     */
    public function getPathConfig()
    {
        return $this->path_config;
    }

    /**
     * @param mixed $path_config
     */
    public function setPathConfig($path_config)
    {
        $this->path_config = $path_config;
    }

}