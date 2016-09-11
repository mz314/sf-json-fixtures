<?php

namespace MZ314\JSonFixturesBundle\Services;


class DumperService
{

    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    protected function entityTostdClass($entity, \ReflectionClass $reflection)
    {
        $class = new \stdClass();
        
        $properties = $reflection->getProperties();
        
        foreach($properties as $property) {
            $property->setAccessible(true);
            $pName = $property->getName();
            $class->$pName = $property->getValue($entity);
        }
        
        return $class;
        
    }
    
    public function dumpToJson(Array $entities)
    {
        $data = new \stdClass();
        
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
}
