<?php
namespace Fasttmv\Interfaces;


/**
 * Interface IDao
 * @package Correcao\Interfaces
 */
interface IDao
{
    /**
     * @param string $entidade
     * @return object
     */
    public static function getInstance($entidade = '');

    /**
     * @return boolean
     */
    public function salvar();

    /**
     * @param $objeto
     * @return boolean
     */
    public function salvarObject($objeto);

    /**
     * @param $id
     * @return object
     */
    public function getObject($id);

    /**
     * @param array $params
     * @param bool $One
     * @param mixed $orderBy
     * @return array|bool|null|object
     */
    public function find(Array $params , $One = false, $orderBy = null );

    /**
     * @param array $params
     * @param int $page
     * @return array|null
     */
    public function findDinamic(Array $params , $page = 1);

    /**
     * @param $id
     * @param $throwNaoEncontrado
     * @return mixed
     */
    public function delete($id, $throwNaoEncontrado=false);

    /**
     * @param $objeto
     * @return mixed
     */
    public function deleteObject($objeto);

}