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
        var_dump($json);
        
    }
}