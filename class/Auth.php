<?php
namespace Fasttmv\Classes;

use Fasttmv\Interfaces\IAuth;
use Fasttmv\Classes\Hash;

/**
 * Class Auth
 * @package Atualizador\Classes
 */
class Auth implements IAuth
{
    /**
     * @var Auth
     */
    public static $instance;

    /**
     * @var object
     */
    public static $object;

    /**
     * @var string
     */
    private $secrect;

    private function __construct(){}

    /**
     * @return Auth
     */
    public static function getInstance()
    {
        // TODO: Implement getInstance() method.
        if(!isset(self::$instance)){
            self::$instance = new Auth();
        }
        return self::$instance;
    }

    /**
     * @return void
     */
    private function generateSecret($create = false){
        if($create){
            $part_id    = substr(self::$object->getId(),10,5);
            $part_user  = substr(self::$object->getUser(),0,5);
        }
        else {
            $part_id    = substr($_COOKIE['_ID'],10,5);
            $part_user  = substr($_COOKIE['_USER'],0,5);
        }
        $this->secrect = ($part_id . $part_user);
    }

    /**
     * Procura usuario de acordo com nome
     * @param string $user
     * @return object
     */
    public function findUser($user)
    {
        // TODO: Implement findUser() method.
        return self::$object;
    }

    /**
     * Valida senha do usuario utlizando classe Hash
     * @param string $password
     * @return bool
     */
    public function authenticate($password)
    {
        // TODO: Implement authenticate() method.
        return Hash::validate_password($password,self::$object->getSenha());
    }

    /**
     * Seta cookies
     * @param int $expire
     * @param string $path
     * @param null $domain
     * @param null $secure
     * @param null $httponly
     * @param array $others
     * @return void
     */
    public function setCookies($expire = 0, $path = "/", $domain = null, $secure = null, $httponly = null, $others = array())
    {
        // TODO: Implement setCookies() method.
        setcookie('_ID',self::$object->getId(),$expire,$path,$domain,$secure,$httponly);
        setcookie('_USER',self::$object->getUser(),$expire,$path,$domain,$secure,$httponly);
        setcookie('_PASS',self::$object->getPassword(),$expire,$path,$domain,$secure,$httponly);
        $this->generateSecret();
        setcookie('_SECRET',Hash::create_hash($this->secrect),$expire,$path,$domain,$secure,$httponly);

        foreach($others as $o){
            setcookie($others['name'],$others['value'],$expire,$path,$domain,$secure,$httponly);
        }

    }

    /**
     * Exclui cookies
     * @return void
     */
    public function dieCookies(){
        // TODO: Implement dieCookies() method.
        if(isset($_COOKIE["_ID"]))
            setcookie("_ID","",time()-3600,'/');
        if(isset($_COOKIE["_USER"]))
            setcookie("_USER","",time()-3600,'/');
        if(isset($_COOKIE["_PASS"]))
            setcookie("_PASS","",time()-3600,'/');
        if(isset($_COOKIE["_SECRET"]))
            setcookie("_SECRET","",time()-3600,'/');
    }

    /**
     * Valida sessao atual
     * @return bool
     */
    public function isAuth()
    {
        if(!isset($_COOKIE['_USER']) || !isset($_COOKIE['_PASS']) || !isset($_COOKIE['_ID']) || !isset($_COOKIE['_SECRET']))
            return false;
        else {
            $this->generateSecret();
            return Hash::validate_password($this->secrect,$_COOKIE['_SECRET']);
        }


    }


}