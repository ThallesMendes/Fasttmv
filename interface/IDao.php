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
     * @return array|bool|null|object
     */
    public function find(Array $params , $One = false );

    /**
     * @param array $params
     * @return array|null
     */
    public function findDinamic(Array $params );

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