<?php

namespace Fasttmv\Classes;

/**
 * Class Util
 * @package Fasttmv\Classes
 */
class Util extends Objeto
{
    /**
     * @var
     */
    public static $instance;

    /**
     * Hash constructor.
     */
    private function __construct(){

    }

    /**
     * @return Hash
     */
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new Util();
        }
        return self::$instance;
    }

    /**
     * checa se atring é um UUID validoz
     *
     * @param   string  $uuid   The string to check
     * @return  boolean
     */
    public static function isValidUuid( $uuid ) {

        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }
        return true;
    }


}