<?php

namespace MZ314\JSonFixturesBundle\Services;

use MZ314\JSonFixturesBundle\Exception\JSONParseException;

class LoaderService
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function loadJsonData($json)
    {
        $data = json_decode($json);

        if(is_null($data)) {
            throw new JSONParseException($json);
        }

        if(isset($data->namespace)) {
           $data->namespace = str_replace(":", "\\", $data->namespace);
        } else {
            $data->namespace = null;
        }

        return $data;
    }

    public function loadJsonFile($file)
    {
        $json = file_get_contents($file);

        return $this->loadJsonData($json);
    }


    public function loadEntityFromJson($json)
    {
        $data = $this->loadJsonData($json);

        $nsPrefix = '';

        if(!empty($data->namespace)) {
            $nsPrefix = $data->namespace.'\\';
        }

        $entityClassName = $nsPrefix.$data->entityName;

        //http://php.net/manual/pl/class.reflectionclass.php
        //http://php.net/manual/pl/reflectionproperty.setvalue.php
        //http://stackoverflow.com/questions/6448551/is-there-any-way-to-set-a-private-protected-static-property-using-reflection-cla

        $refClass = new \ReflectionClass($entityClassName);

        var_dump($refClass);

        foreach($data->entries as $entry) {
            $entryArr = (array)$entry;
            $entity = new $entityClassName(); //TODO: make it work with parametered constructors
            foreach($entryArr as $key=>$val) {
                $property = $refClass->getProperty($key);
                $property->setValue($entity, $property);
            }

            var_dump($entry);
        }
        
    }

    

}

