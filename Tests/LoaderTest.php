<?php
namespace MZ314\JSonFixturesBundle\Tests;

use MZ314\JSonFixturesBundle\Services\LoaderService;

class LoaderTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->loader = new LoaderService($this->em);
        
    }

    public function testLoaderParsing()
    {
        $json = file_get_contents(__DIR__.'/json/TestEntitySimpleReplace.json');
        $data = $this->loader->loadJsonData($json);
        $this->assertEquals($data->namespace, 'MZ314\JSonFixturesBundle\Tests\Entity');
        $this->assertEquals($data->entityName, 'TestEntity');
        $this->assertEquals($data->mode, 'replace');
        $this->assertEquals(count($data->entries), 2);
        $this->assertTrue(is_array($data->entries));
        $a =["id"=>0, "name"=> "test1"];
        $b = ["id"=>1, "name"=> "test2"];
        $this->assertEquals($data->entries, [(object)$a, (object)$b]);   
    }

    public function testLoaderFileLoading()
    {
        $data = $this->loader->loadJsonFile(__DIR__.'/json/TestEntitySimpleReplace.json');
        $this->assertFalse(is_null($data));
    }

    public function testLoadingEntity()
    {
        $json = file_get_contents(__DIR__.'/json/TestEntitySimpleReplace.json');
        

        $this->loader->loadEntityFromJson($json);
    }
}

