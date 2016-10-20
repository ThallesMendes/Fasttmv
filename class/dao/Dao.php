<?php
namespace Fasttmv\Dao;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Fasttmv\Interfaces\IDao;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class Dao
 * @package Atualizador\DAO
 */
abstract class Dao implements IDao
{
    /**
     * @var Dao
     */
    public static $instance;

    /**
     * @var object
     */
    public static $objeto;

    /**
     * @var string
     */
    private $entity = '';

    private function __construct(){

    }

    public static function getInstance( $entidade = '' ){

    }

    # call static
    final public static function __callStatic( $chrMethod, $arrArguments ) {

        $objInstance = self::getInstance();

        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments);

    }

    public function salvar()
    {
        // TODO: Implement salvar() method.
        return true;
    }

    public function salvarObject($objeto)
    {
        // TODO: Implement salvarObject() method.
        return true;
    }

    public function getObject($id)
    {
        // TODO: Implement getObject() method.
        return self::$objeto;
    }

    public function find(Array $params, $One = false, $orderBy = null)
    {
        // TODO: Implement find() method.
        return array();
    }

    public function findDinamic(Array $params, $page = 1, $orderBy=null)
    {
        // TODO: Implement findDinamic() method.
        return array();
    }

    public function delete($id, $throwNaoEncontrado=false)
    {
        // TODO: Implement delete() method.
    }

    public function deleteObject($object)
    {
        // TODO: Implement deleteObject() method.
    }

    /**
     * @param QueryBuilder $query
     * @param int $page
     * @return mixed
     */
    public function page(QueryBuilder $query , $page = 1 ){
        $pageSize = PAGE_SIZE;

        $paginator  = new Paginator($query);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);

        $paginator->getQuery()->setFirstResult($pageSize * ($page-1))->setMaxResults($pageSize);
        $result['result']     = $paginator->getQuery()->getResult();
        $result['next']       = null;
        $result['back']       = null;
        if($pagesCount > $page)
            $result['next'] = $page + 1;
        if($page > 1)
            $result['back'] = $page - 1;
        $result['pagecount']  = $pagesCount;
        $result['pagesize']   = $pageSize;
        $result['total']      = $totalItems;

        return $result;
    }

    /**
     * @param QueryBuilder $query
     * @param array $params
     * @param string $alias
     * @return QueryBuilder
     */
    public function addWhere( QueryBuilder $query, Array $params, $alias = "c" ){
        /**
         * Exemplo de uso
         * $param['nome_do_campo'] = array('value'=>'%termo para consulta%', 'operador'=>'like');
         * $param['id'] = array('value'=>'valor', 'operador'=>'=');
         */
        $i = 1;
        foreach( $params as $p ){
            if($p['value'] <> '' && $p['value'] <> 'null' && $p['value'] <> "%null%" && $p['value'] <> "(null)"){
                if( $p['operador'] == 'like' || $p['operador'] == '=' ) {
                    if($i==1)
                        $query->where($alias . '.' . key($params) . ' ' . $p['operador'] . ' :' . key($params) . '')->setParameter(':' . key($params), $p['value']);
                    else
                        $query->andWhere($alias . '.' . key($params) . ' ' . $p['operador'] . ' :' . key($params) . '')->setParameter(':' . key($params), $p['value']);
                }
                else if ( $p['operador'] == 'between' ){
                    /**
                     * Para passagem de periodos o parametro deve ser passado com duas data separadas pelo delimitador "|"
                     */
                    $values = explode('|',$p['value']);

                    if($i==1)
                        $query->where($alias . '.' . key($param) . ' between ' . ':' . key($params) . '1' . ' and :' . key($params) . '2')
                            ->setParameter(':' . key($params) . '1', $values[0])->setParameter(':' . key($params) . '2', $values[1]);
                    else
                        $query->andWhere($alias . '.' . key($param) . ' between ' . ':' . key($params) . '1' . ' and :' . key($params) . '2')
                            ->setParameter(':' . key($params) . '1', $values[0])->setParameter(':' . key($params) . '2', $values[1]);
                }
                $i++;
            }
            next($params);
        }

        return $query;
    }


}