<?php

namespace MZ314\JsonFixturesBundle\Services;

use MZ314\JsonFixturesBundle\Services\Helpers\JsonHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MZ314\JsonFixturesBundle\Exception\EmptyTableException;


class DumperService
{

    protected $em;

    public function __construct(EntityManager $em, JsonHelper $jsonHelper)
    {
        $this->em = $em;
        $this->jsonHelper = $jsonHelper;
    }

    protected function entityTostdClass($entity, \ReflectionClass $reflection)
    {
        $class = new \stdClass();

        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $pName = $property->getName();
            $class->$pName = $property->getValue($entity);
        }

        return $class;
    }

    public function dumpArrayToJson(Array $entities)
    {
        $data = new \stdClass();

        if (count($entities) == 0) {
            //return "";
            throw new EmptyTableException();
        }

        $reflection = new \ReflectionClass(get_class($entities[0]));

        $data->entityName = $reflection->getShortName();
        $data->namespace = str_replace('\\', ':', $reflection->getNamespaceName());
        $data->entries = [];

        foreach ($entities as $entity) {
            $data->entries[] = $this->entityTostdClass($entity, $reflection);
        }

        $json = json_encode($data);

        return $json;
    }

    public function dumpRepositoryToJson($repository)
    {
        
        if(is_string($repository)) {
            $repository = $this->em->getRepository($repository);
        }
        
        $entities = $repository
            ->createQueryBuilder('e')
            ->getQuery()
            ->getResult();

        return $this->dumpArrayToJson($entities);
    }
}
