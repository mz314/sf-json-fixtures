<?php

namespace MZ314\JSonFixturesBundle\Tests;

use MZ314\JSonFixturesBundle\Services\LoaderService;
use MZ314\JSonFixturesBundle\Services\Helpers\JsonHelper;

class LoaderTest extends BaseTestCase
{

    public function setUp()
    {
        parent::setUp();
        
        //TODO: get service using application->container->get

        $this->loader = new LoaderService($this->em, new JsonHelper());
    }

    public function testLoaderParsing()
    {
        $json = file_get_contents(__DIR__.'/json/TestEntitySimpleReplace.json');
        $data = $this->loader->loadJsonData($json);
        $this->assertEquals($data->namespace,
            'MZ314\JSonFixturesBundle\Tests\Entity');
        $this->assertEquals($data->entityName, 'TestEntity');
        $this->assertEquals($data->mode, 'replace');
        $this->assertEquals(count($data->entries), 2);
        $this->assertTrue(is_array($data->entries));
        $a    = ["id" => 6, "name" => "test1"];
        $b    = ["id" => 7, "name" => "test2"];
        $this->assertEquals($data->entries, [(object) $a, (object) $b]);
    }

    public function testLoaderFileLoading()
    {
        $data = $this->loader->loadJsonFile(__DIR__.'/json/TestEntitySimpleReplace.json');
        $this->assertFalse(is_null($data));
    }

    public function testLoading()
    {
        $json = file_get_contents(__DIR__.'/json/TestEntitySimpleReplace.json');


        $this->loader->loadFromJson($json);
        $this->em->flush();

        $loaded = $this->em->getRepository('JSonFixturesBundle:TestEntity')->findAll();
        $this->assertEquals(count($loaded), 2);
        $this->assertEquals(6, $loaded[0]->getId());
        $this->assertEquals('test1', $loaded[0]->getName());
        $this->assertEquals(7, $loaded[1]->getId());
        $this->assertEquals('test2', $loaded[1]->getName());
    }

    public function testDefaults()
    {
        $json = '{
                    "entityName": "TestEntity"
                  }';

        $data = $this->loader->loadJsonData($json);

        $this->assertEquals('replace', $data->mode);
        $this->assertEquals('', $data->namespace);
        $this->assertEquals(false, $data->pkForce);
        $this->assertEquals([], $data->entries);
        $this->assertEquals('TestEntity', $data->entityName);

    }
}