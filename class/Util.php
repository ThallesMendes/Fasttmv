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

    /**
     * @param $dateString
     * @param string $separator
     * @param bool $inverse
     * @return mixed|string
     */
    public static function formatStringDate( $dateString , $separator='/', $inverse=true){
        if( count(explode($separator,$dateString)) == 3){
            if($inverse)
                $dateString = implode('-', array_reverse(explode($separator, $dateString)));
            else
                $dateString = str_replace($separator,'-',$dateString);
        }
        return $dateString;
    }

}