<?php

namespace MZ314\JsonFixturesBundle\Tests;

use MZ314\JsonFixturesBundle\Services\LoaderService;
use MZ314\JsonFixturesBundle\Services\Helpers\JsonHelper;

class LoaderTest extends BaseTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->loader = $this->container->get('jsonfixtures.loader'); 
    }

    public function testLoaderParsing()
    {
        $json = file_get_contents(__DIR__ . '/json/TestEntitySimpleReplace.json');
        $data = $this->loader->loadJsonData($json);
        $this->assertEquals($data->namespace, 'MZ314\JsonFixturesBundle\Tests\Entity');
        $this->assertEquals($data->entityName, 'TestEntity');
        $this->assertEquals($data->mode, 'replace');
        $this->assertEquals(count($data->entries), 2);
        $this->assertTrue(is_array($data->entries));
        $a = ["id" => 6, "name" => "test1"];
        $b = ["id" => 7, "name" => "test2"];
        $this->assertEquals($data->entries, [(object) $a, (object) $b]);
    }

    public function testLoaderFileLoading()
    {
        $data = $this->loader->loadJsonFile(__DIR__ . '/json/TestEntitySimpleReplace.json');
        $this->assertFalse(is_null($data));
    }

    public function testLoading()
    {
        $json = file_get_contents(__DIR__ . '/json/TestEntitySimpleReplace.json');


        $this->loader->loadFromJson($json);
        $this->em->flush();

        $loaded = $this->em->getRepository('JsonFixturesBundle:TestEntity')->findAll();
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

    public function testRelated()
    {
        $jsonA = file_get_contents(__DIR__ . '/json/ManyToOneANodeps.json');
        $jsonB = file_get_contents(__DIR__ . '/json/ManyToOneB.json');

        $this->loader->loadFromJson($jsonB);
        $this->em->flush();

        $this->loader->loadFromJson($jsonA);
        $this->em->flush();
    }

    public function testDependencies()
    {
        $jsonA = file_get_contents(__DIR__ . '/json/ManyToOneA.json');
        $this->loader->loadFromJson($jsonA);
        $this->em->flush();
    }

    public function testExceptions()
    {
        $this->expectException(\MZ314\JsonFixturesBundle\Exception\JSONParseException::class);
        
        $this
            ->loader
            ->loadJsonData(null);
    }
}
