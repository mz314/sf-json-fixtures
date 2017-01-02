<?php

namespace MZ314\JsonFixturesBundle\Tests;

use MZ314\JsonFixturesBundle\Services\DumperService;
use MZ314\JsonFixturesBundle\Services\LoaderService;
use MZ314\JsonFixturesBundle\Services\Helpers\JsonHelper;

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


        $this->loader->loadFromJson(file_get_contents(__DIR__ . '/json/TestEntitySimpleReplace.json'));
        $this->em->flush();
        $json = $this->dumper->dumpArrayToJson($this->em->getRepository('JsonFixturesBundle:TestEntity')->findAll());

        $data = json_decode($json);

        $this->assertEquals($data->entityName, 'TestEntity');
        $this->assertEquals($data->namespace, 'MZ314:JsonFixturesBundle:Tests:Entity');
        $this->assertEquals(count($data->entries), 2);
        $this->assertEquals($data->entries[0]->id, 6);
        $this->assertEquals($data->entries[0]->name, 'test1');
        $this->assertEquals($data->entries[1]->id, 7);
        $this->assertEquals($data->entries[1]->name, 'test2');
    }

    public function testRepositoryDump()
    {
        $this->loader->loadFromJson(file_get_contents(__DIR__ . '/json/TestEntitySimpleReplace.json'));
        $this->em->flush();
        $json1 = $this->dumper->dumpRepositoryToJson($this->em->getRepository('JsonFixturesBundle:TestEntity'));
        $json2 = $this->dumper->dumpRepositoryToJson('JsonFixturesBundle:TestEntity');
        
        $data = json_decode($json1);

        $this->assertEquals($data->entityName, 'TestEntity');
        $this->assertEquals($data->namespace, 'MZ314:JsonFixturesBundle:Tests:Entity');
        $this->assertEquals(count($data->entries), 2);
        $this->assertEquals($data->entries[0]->id, 6);
        $this->assertEquals($data->entries[0]->name, 'test1');
        $this->assertEquals($data->entries[1]->id, 7);
        $this->assertEquals($data->entries[1]->name, 'test2');
    }
    
    
    
    public function testExceptions()
    {
         $this->expectException(\MZ314\JsonFixturesBundle\Exception\EmptyTableException::class);
        $this
            ->dumper
            ->dumpArrayToJson($this->em->getRepository('JsonFixturesBundle:TestEntity')->findAll());
        
        
    }
}
