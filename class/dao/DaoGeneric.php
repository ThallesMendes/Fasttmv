<?php
namespace Fasttmv\Dao;

use Fasttmv\Classes\Config;
use Fasttmv\Entity\Entity;
use Fasttmv\Interfaces\IDao;
use Fasttmv\Interfaces\IEntity;
use Fasttmv\Classes\Conexao;
use Fasttmv\Classes\Log;

/**
 * Class DaoGeneric
 * @package Fasttmv\Dao
 */
class DaoGeneric extends Dao
{
    /**
     * @var DaoGeneric
     */
    public static $instance;
    /**
     * @var IEntity
     */
    public static $objeto;

    /**
     * @var string
     */
    private $entity;

    /**
     * DaoGeneric constructor.
     * private singleton
     */
    private function __construct()
    {

    }

    /**
     * @param string $entidade
     * @return IDao
     */
    public static function getInstance( $entidade = '' )
    {
        if (!isset(self::$instance)){
            self::$instance = new DaoGeneric();
        }
        self::$instance->entity = Config::getInstance()->getConfig('global','namespace_entity','Fasttmv\\Entity\\') . $entidade;
        return self::$instance;
    }

    /**
     * Metodo que salva entidade no banco de dados
     * Para entidades onde a chave primaria é diferente de Id o metodo deve ser alterado na classe filha
     * @return bool
     * @throws \Exception
     */
    public function salvar()
    {
        try {
            if (!isset(self::$objeto))
                throw new \Exception('Entidade não criada na memoria !');

            if (self::$objeto->getId() <> '')
                Conexao::getInstance()->merge(self::$objeto);
            else
                Conexao::getInstance()->persist(self::$objeto);
            Conexao::getInstance()->flush();

            return true;
        } catch (\Exception $e) {
            throw new \Exception('erro ao salvar : ' . $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param IEntity $objeto
     * @return bool
     * @throws \Exception
     */
    public function salvarObject($objeto)
    {
        try {
            if (!isset($objeto))
                throw new \Exception('Objeto inválido');

            self::$objeto = $objeto;
            return self::salvar();
        } catch (\Exception $e) {
            throw new \Exception('erro ao salvar object : ' . $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param $id
     * @return IEntity|bool|null|object
     * @throws \Exception
     */
    public function getObject($id)
    {
        try {
            self::$objeto = Conexao::getInstance()->find($this->entity, $id);
            if (self::$objeto == null) {
                return false;
            } else {
                return self::$objeto;
            }
        } catch (\Exception $e) {
            throw new \Exception('Erro ao consultar registro no banco : ' . $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param array $params
     * @param bool $One
     * @param null $orderBy
     * @return array|null|object
     * @throws \Exception
     */
    public function find(Array $params, $One = false, $orderBy = null)
    {
        try {
            if ($One)
                $result = Conexao::getInstance()->getRepository($this->entity)->findOneBy($params);
            else
                $result = Conexao::getInstance()->getRepository($this->entity)->findBy($params, $orderBy);

            if (is_array($result)) {
                if (count($result) > 0)
                    return $result;
                else
                    return null;
            } else {
                if (!isset($result) || !$result->getId() > 0)
                    return null;
                else
                    return $result;
            }
        } catch (\Exception $e) {
            throw new \Exception('Erro ao pesquisar no banco :  : ' . $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param array $params
     * @param int $page
     * @return mixed
     * @throws \Exception
     */
    public function findDinamic(Array $params, $page = 1)
    {
        try {
            $repository = Conexao::getInstance()->getRepository($this->entity);
            $query = $repository->createQueryBuilder('c');
            $query->where('c.id is not null');
            $query = $this->addWhere($query,$params,'c');

            $result = $this->page($query, $page);

            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao pesquisar dinamicamente no banco : ' . $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param $id
     * @param $throwNaoEncontrado
     * @return bool
     * @throws \Exception
     */
    public function delete($id, $throwNaoEncontrado=false)
    {
        try {
            /**
             * @var $object IEntity
             */
            $object = Conexao::getInstance()->find($this->entity, $id);
            if (!$object == null) {
                return $this->deleteObject($object);
            } else {
                if($throwNaoEncontrado)
                    throw new \Exception('Registro nao encontrado para exclusão');
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception('Erro ao excluir registro : ' . $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param IEntity $object
     * @return bool
     * @throws \Exception
     */
    public function deleteObject($object)
    {
        try {
            Conexao::getInstance()->remove($object);
            Conexao::getInstance()->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao excluir objeto : ' . $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}