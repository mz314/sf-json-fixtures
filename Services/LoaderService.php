<?php

namespace MZ314\JSonFixturesBundle\Services;

use MZ314\JSonFixturesBundle\Exception\JSONParseException;
use MZ314\JSonFixturesBundle\Tests\Entity\TestEntity;

class LoaderService
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    protected function addDefaults($data) {
        $defaults = [
            'namespace'=>'',
            'pkForce'=>false,
            'mode'=>'replace',
            'entries'=>[],
        ];

        foreach($defaults as $key=>$def) {
            if(!isset($data->$key)) {
                $data->$key = $def;
            }
        }

        return $data;
    }

    public function loadJsonData($json)
    {
        $data = json_decode($json);

        if (is_null($data)) {
            throw new JSONParseException($json);
        }

        $data = $this->addDefaults($data);

        if (!empty($data->namespace)) {
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

    public function loadFromJson($json)
    {
        $data = $this->loadJsonData($json);

        $nsPrefix = '';

        if (!empty($data->namespace)) {
            $nsPrefix = $data->namespace.'\\';
        }

        $entityClassName = $nsPrefix.$data->entityName;

        if ($data->mode == 'replace') {
            
        }

        foreach ($data->entries as $entry) {
            $entryArr = (array) $entry;
            $entity   = new $entityClassName(); //TODO: make it work with parametered constructors
            // var_dump($entity);
            foreach ($entryArr as $key => $val) {
                $reflection = new \ReflectionProperty(get_class($entity), $key);
                $reflection->setAccessible(true);
                $reflection->setValue($entity, $val);
            }


            if ($data->pkForce) {
              $this->em->getClassMetaData(get_class($entity))->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            }

            $this->em->persist($entity);
        }
    }
}