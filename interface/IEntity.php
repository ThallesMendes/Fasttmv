<?php
namespace Fasttmv\Interfaces;

/**
 * Interface IEntity
 * @package Fasttmv\Interfaces
 */
interface IEntity
{
    /**
     * Passa todas as propiedades da entidade para um array
     * @return array
     */
    public function toArray();

    /**
     * Passa um array ou stdClass para as propiedades da entidade
     * @param $arr \stdClass|array
     * @return object
     */
    public function fromArray( $arr );
}