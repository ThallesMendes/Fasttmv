<?php
namespace Fasttmv\API;

use Silex\ControllerProviderInterface;
use Silex\Application;

abstract class ViewController implements ControllerProviderInterface
{
    const TITLE         = '';
    const PAGE_HEADER   = '';
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
        $factory = $app['controllers_factory'];

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


}