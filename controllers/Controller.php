<?php
namespace Fasttmv\API;

use Fasttmv\Classes\Util;
use Fasttmv\Entity\Entity;
use Fasttmv\Interfaces\IEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Fasttmv\Classes\Conexao;
use Fasttmv\Classes\Config;
use Fasttmv\Dao\DaoGeneric;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Controller
 * @package Atualizador\API
 */
class Controller implements ControllerProviderInterface
{
    /**
     * Entidade que o controlador vai trabalhar
     * @var string
     */
    const ENTITY = '';

    /**
     * Rotas para controlador
     * @param Application $app
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        Conexao::getInstance();
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
     * @param Application $app
     * @param string $entity
     * @return JsonResponse
     */
    public function _fetchAll( Application $app, $entity='' ){
        try {
            $result = DaoGeneric::getInstance($entity)->findDinamic(array());
            if($result['result'] == null || !is_array($result['result']) || !count($result['result']) > 0){
                return new JsonResponse(array('return'=>false),404);
            }

            return new JsonResponse( $this->encodeResult($result) );
        }
        catch( \Exception $e){
            $app->abort(500, $entity . '::' . $e->getMessage());
        }
    }

    /**
     * @param Application $app
     * @param array $params
     * @param $entity
     * @return JsonResponse
     */
    public function _fetchBy( Application $app, array $params, $entity='' ){
        try {
            $result = DaoGeneric::getInstance($entity)->find($params);
            if($result == null || !is_array($result) || !count($result) > 0){
                return new JsonResponse(array('return'=>false),404);
            }

            return new JsonResponse(array('return'=>true, 'embeded'=>$result));
        }
        catch( \Exception $e ){
            $app->abort(500, $entity . '::' . $e->getMessage());
        }
    }

    /**
     * @param Application $app
     * @param array $params
     * @param string $entity
     * @param int $page
     * @return JsonResponse
     */
    public function _fetch( Application $app, array $params, $entity='', $page=1 ){
        try {
            $result = DaoGeneric::getInstance($entity)->findDinamic($params,$page);
            if($result['result'] == null || !is_array($result['result']) || !count($result['result']) > 0) {
                return new JsonResponse(array('return' => false),404);
            }

            return new JsonResponse( $this->encodeResult($result) );
        }
        catch( \Exception $e ){
            $app->abort(500, $entity . '::' . $e->getMessage());
        }
    }

    /**
     * @param Application $app
     * @param $id
     * @param string $entity
     * @return JsonResponse
     */
    public function _get( Application $app, $id, $entity='' ){
        try {
            if(!Util::isValidUuid($id))
                $app->abort(500,"id {$id} não é um UUID válido");

            /**
             * @var Entity|boolean $object
             */
            $object = DaoGeneric::getInstance($entity)->getObject($id);

            if($object == false)
                $app->abort(404, 'Objeto não encontrado');
            else
                return new JsonResponse(array('return'=>true,'embeded'=>$object->toArray()));
        }
        catch(\Exception $e){
            $app->abort(500,$e->getMessage());
        }
    }

    /**
     * @param Application $app
     * @param Request $request
     * @param IEntity $object
     * @param string $entity
     * @return bool|string|JsonResponse
     */
    public function _append( Application $app, Request $request, IEntity $object, $entity='' ){
        try {
            if (!$request->getContentType() == 'json')
                $app->abort(500, 'Content Type não aceito');
            /**
             * Decodifica conteudo da requisição
             */
            $c = json_decode($request->getContent());

            /**
             * passa valores para entidade no formato json
             */
            $object->fromArray($c);

            /**
             * Valida objeto
             */
            $validate = $this->validateObject($object);

            /**
             * Verifica validação
             */
            if(is_string($validate)){
                return $validate;
            }
            else {
                if(DaoGeneric::getInstance($entity)->salvarObject($object))
                    return new JsonResponse(array('return'=>true, 'embeded'=>DaoGeneric::$objeto->toArray()));
                else
                    return new JsonResponse(array('return'=>false));
            }
        }
        catch( \Exception $e ){
            $app->abort(500, $entity . '::' . $e->getMessage());
        }
    }

    /**
     * @param Application $app
     * @param Request $request
     * @param $id
     * @param string $entity
     * @return string|JsonResponse
     */
    public function _update( Application $app, Request $request, $id, $entity='' ){
        try {
            if(!$request->getContentType() == 'json')
                $app->abort(500, 'Content Type não aceito');

            /**
             * @var $object IEntity
             */
            $object = DaoGeneric::getInstance($entity)->getObject($id);
            if($object == false){
                $app->abort(404,$entity . " não encontrado para update");
            }

            /**
             * Decodifica conteudo da requisição
             */
            $c          = json_decode($request->getContent());

            /**
             * passa valores para entidade no formato json
             */
            $object->fromArray($c);

            /**
             * Valida objeto
             */
            $validate = $this->validateObject($object);

            /**
             * Verifica validação
             */
            if(is_string($validate)){
                return $validate;
            }
            else {
                if(DaoGeneric::getInstance($entity)->salvarObject($object))
                    return new JsonResponse(array('return'=>true, 'embeded'=>DaoGeneric::$objeto->toArray()));
                else
                    return new JsonResponse(array('return'=>false));
            }


        }
        catch( \Exception $e ){
            $app->abort(500, $entity . '::' . $e->getMessage());
        }
    }

    /**
     * @param Application $app
     * @param Request $request
     * @param $id
     * @param string $entity
     * @return JsonResponse
     */
    public function _delete( Application $app, Request $request, $id, $entity='' ){
        try {
            if( DaoGeneric::getInstance($entity)->delete($id) ){
                return new JsonResponse(array('return'=>true));
            }
            else {
                return new JsonResponse(array('return'=>false));
            }

        }
        catch(\Exception $e){
            $app->abort(500, $e->getMessage());
        }

    }

    /**
     * Valida Entidade
     * @param $object
     * @return bool|string
     */
    public function validateObject($object){
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $errors     = $validator->validate($object);
        $messages   = null;

        if(count($errors) > 0){
            foreach($errors as $e){
                $messages[] = array('campo'=>$e->getPropertyPath(), 'mensagem'=>($e->getMessage()));
            }
            return json_encode(array('return'=>false,'validation'=>$messages));
        } else
            return true;
    }

    /**
     * @param $url
     * @param bool $json_decode
     * @return mixed
     */
    public function curlGet( $url, $json_decode = true ){
        $process = curl_init( $url );
        $headers = array(
            'Authorization: Basic '. base64_encode(Config::getInstance()->getConfig('api','user').":". Config::getInstance()->getConfig('api','password')) // <---
        );
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_POST, 0);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($process);
        curl_close($process);

        /**
         * decodifica retorno da requição
         */
        if($json_decode)
            return json_decode($return);
        else
            return $return;

    }

    /**
     * @param array $result
     * @return array
     */
    public function encodeResult( array $result ){
        /**
         * instancia array
         */
        $json = array();

        /**
         * @var Entity $r
         */
        foreach( $result['result'] as $r ){
            // adiciona todos elementos no array em formato de array
            $json[] = $r->toArray();
        }

        return array(
            'return'=>true,
            'embeded'=>$json,
            'next'=>$result['next'],
            'back'=>$result['back'],
            'pageCount'=>$result['pagecount'],
            'pageSize'=>$result['pagesize'],
            'total'=>$result['total']
        );
    }

    /**
     * @param array $result
     * @return array
     */
    public function encodeResultObjects( array $result ){
        /**
         * instancia array
         */
        $json = array();

        /**
         * @var Entity $r
         */
        foreach( $result as $r ){
            // adiciona todos elementos no array em formato de array
            $json[] = $r->toArray();
        }

        return array(
            'return'=>true,
            'embeded'=>$json,
            'total'=>count($result)
        );
    }
}