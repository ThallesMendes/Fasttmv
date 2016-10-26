<?php
namespace Fasttmv\Entity;


use Fasttmv\Classes\Config;
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

    /**
     * @param string $entidade
     * @return string
     */
    public static function getNamespace( $entidade='' ){
        if($entidade == '')
            $entidade = __CLASS__;

        return Config::getInstance()->getConfig('global','namespace_entity','Fasttmv\\Entity\\') . $entidade;
    }
}