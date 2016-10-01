<?php

namespace MZ314\JSonFixturesBundle\Services;

use MZ314\JSonFixturesBundle\Services\Helpers\JsonHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
/**
 * TODO: add method using entitymanager and taking entity name as param
 */
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

        if(count($entities) == 0) {
            return "";
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
    
    public function dumpRepositoryToJson(EntityRepository $repository) {
        //TODO: use custom select * to prevent from using overriden findAll 
        $entities = $repository->findAll(); 
        
        if(count($entities)>0) {
            $this->dumpArrayToJson($entities);
        }
    }
}
