<?php
namespace Fasttmv\Interfaces;

/**
 * Interface IAuth
 * @package Portal\Interfaces
 */
interface IAuth
{
    /**
     * @return object
     */
    public static function getInstance();

    /**
     * @param string $user
     * @return object
     */
    public function findUser($user);

    /**
     * @param string $password
     * @return boolean
     */
    public function authenticate($password);

    /**
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param null $secure
     * @param null $httponly
     * @return void
     */
    public function setCookies($expire = 0, $path = "/", $domain = null, $secure = null, $httponly = null);

    /**
     * @return void
     */
    public function dieCookies();

    /**
     * @return true
     */
    public function isAuth();
}