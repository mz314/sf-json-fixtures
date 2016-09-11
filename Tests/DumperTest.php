<?php

namespace MZ314\JSonFixturesBundle\Tests;

use MZ314\JSonFixturesBundle\Services\DumperService;
use MZ314\JSonFixturesBundle\Services\LoaderService;

class DumperTest extends BaseTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->dumper = new DumperService($this->em);
        $this->loader = new LoaderService($this->em);

    }

    public function testDump()
    {
        
        $this->loader->loadFromJson(file_get_contents(__DIR__.'/json/TestEntitySimpleReplace.json'));
        $this->em->flush();
        $json = $this->dumper->dumpToJson($this->em->getRepository('JSonFixturesBundle:TestEntity')->findAll());
        
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