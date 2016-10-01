<?php

namespace MZ314\JSonFixturesBundle\Tests;

use MZ314\JSonFixturesBundle\Services\DumperService;
use MZ314\JSonFixturesBundle\Services\LoaderService;
use MZ314\JSonFixturesBundle\Services\Helpers\JsonHelper;

class DumperTest extends BaseTestCase
{

    public function setUp()
    {
        parent::setUp();
        $helper = new JsonHelper();
        $this->dumper = new DumperService($this->em, $helper);
        $this->loader = new LoaderService($this->em, $helper);

    }

    public function testArrayDump()
    {
        
        $this->loader->loadFromJson(file_get_contents(__DIR__.'/json/TestEntitySimpleReplace.json'));
        $this->em->flush();
        $json = $this->dumper->dumpArrayToJson($this->em->getRepository('JSonFixturesBundle:TestEntity')->findAll());
        
        $data = json_decode($json);
        
        $this->assertEquals($data->entityName, 'TestEntity');
        $this->assertEquals($data->namespace, 'MZ314:JSonFixturesBundle:Tests:Entity');
        $this->assertEquals(count($data->entries), 2);
        $this->assertEquals($data->entries[0]->id, 6);
        $this->assertEquals($data->entries[0]->name, 'test1');
        $this->assertEquals($data->entries[1]->id, 7);
        $this->assertEquals($data->entries[1]->name, 'test2');
    }
}