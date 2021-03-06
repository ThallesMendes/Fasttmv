<?php
namespace Fasttmv\API;

use Silex\ControllerProviderInterface;
use Silex\Application;

abstract class ViewController implements ControllerProviderInterface
{
    const TITLE         = '';
    const PAGE_HEADER   = '';

    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * Rotas para controlador
     * @param Application $app
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        /**
         * @var \Silex\ControllerCollection $factory
         */
        $factory    = $app['controllers_factory'];
        $this->twig = $app['twig'];

        /**
         * Requisições GET
         */

        /**
         * Requisições POST
         */

        /**
         * Requisições PUT
         */

        /**
         * Requisições Delete
         */


        return $factory;
    }

    /**
     * metodo que chama a pagina inicial
     * @param Application $app
     */
    public function index( Application $app ){

    }

    /**
     * @param Application $app
     * @param array $params
     * @return bool|mixed
     */
    public function session( Application $app, array $params ){
        foreach( $params as $p ){
            if($app['session']->get($p) === null){
                return false;
                break;
            }
            return $app['session'];
        }
    }


}