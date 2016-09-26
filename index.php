<?php

require 'bootstrap.php';

use Fasttmv\Classes\Log;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

$app = new Silex\Application();
$app['debug'] = DEV_MODE;

/**
 * Registro dos providers usados na API
 */
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

/**
 * provider para render das views
 */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

/**
 * provider para segurança da api
 * dados de login fixos, criar controle utilizando um provider novo com banco de dados da API
 */
/*$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/rest',
            'stateless' => true,
            'http'=>true,
            'users' => array(
                'admin'=> array('ROLE_ADMIN',(new MessageDigestPasswordEncoder())->encodePassword('vT+ZP?@6Kk\g4Ap,',''))
            )
        ),
    ),
));*/

/**
 * Tratamento de Erros da API
 */
$app->error(function (\Exception $e, $code) use ($app) {
    Log::getInstance()->addError('Erro API',array('return'=>false, 'message'=>$e->getMessage(),'code'=>$code));
    return $app->json(array('return'=>false, 'message'=>$e->getMessage(),'code'=>$code));
});

/**
 * configurações TWIG
 */
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
        return sprintf(URL_RESOURCE . '%s', ltrim($asset, '/'));
    }));

    $twig->addFunction(new \Twig_SimpleFunction('link', function ($url) {
        return sprintf(URL_RAIZ . '%s', ltrim($url, '/'));
    }));
    return $twig;
}));


/**
 * Configuração de rotas da API contendo as funcionalidades das classes DAO
 */
$app->mount('/rest/agendamento-categoria', new \Fasttmv\API\AgendamentoCategoriaController());

/**
 * Configuração de rotas das views
 */

$app->run();