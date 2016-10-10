<?php

namespace MZ314\JSonFixturesBundle\Services;

use MZ314\JSonFixturesBundle\Exception\JSONParseException;
use MZ314\JSonFixturesBundle\Tests\Entity\TestEntity;
use MZ314\JSonFixturesBundle\Services\Helpers\JsonHelper;

/**
 * TODO:
 * add dependency param and/or next in json fixture to chain fixtures
 * move addDefaults method so it will be available for dumper too
 */
class LoaderService
{
    protected $em;

    public function __construct($em, JsonHelper $jsonHelper)
    {
        $this->em         = $em;
        $this->jsonHelper = $jsonHelper;
    }

    public function loadJsonData($json)
    {
        $data = json_decode($json);

        if (is_null($data)) {
            throw new JSONParseException($json);
        }

        $data = $this->jsonHelper->addDefaults($data);

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

    public function loadFromObject($data)
    {
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
            $metadata = $this->em->getClassMetadata($entityClassName);


            foreach ($entryArr as $key => $val) {

                $value = $val;

                if (!$metadata->getTypeOfField($key)) {
                    $mapping          = $metadata->getAssociationMapping($key);
                    $refColName       = $mapping['joinColumns'][0]['referencedColumnName'];
                    $targetRepository = $this->em->getRepository($mapping['targetEntity']);
                    $value            = $targetRepository->findOneBy([
                        $refColName => $val,
                    ]);
                }

                $reflection = new \ReflectionProperty(get_class($entity), $key);
                $reflection->setAccessible(true);
                $reflection->setValue($entity, $value);
            }

            if ($data->pkForce) {
                $this->em->getClassMetaData(get_class($entity))->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            }

            $this->em->persist($entity);
        }
    }

    public function loadFromJson($json)
    {
        $data = $this->loadJsonData($json);

        $this->loadFromObject($data);
    }
}