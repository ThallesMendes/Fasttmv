<?php
namespace Fasttmv\Entity;


use Fasttmv\Dao\DaoGeneric;
use Fasttmv\Interfaces\IEntity;

/**
 * Class Entity
 * @package Fasttmv\Entity
 */
abstract class Entity implements IEntity
{
    /**
     * @return array
     */
    public abstract function toArray() : array;

    /**
     * @param array|\stdClass $arr
     * @return object
     */
    public function fromArray($arr)
    {
        // TODO: Implement fromArray() method.
        return $this;
    }

    /**
     * @param $id
     * @param $entity
     * @return null|object
     */
    public function issetEntity( $id, $entity ){
        $object = DaoGeneric::getInstance($entity)->getObject($id);
        if($object == false)
            return null;
        return $object;
    }
}