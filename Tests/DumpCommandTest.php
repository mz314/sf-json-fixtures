<?php

namespace MZ314\JsonFixturesBundle\Tests;

use Symfony\Component\Console\Tester\CommandTester;
use MZ314\JsonFixturesBundle\Services\LoaderService;
use MZ314\JsonFixturesBundle\Services\Helpers\JsonHelper;


class DumpCommandTest extends BaseTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->application->add(new \MZ314\JsonFixturesBundle\Commands\DumpCommand());
        $this->loader = new LoaderService($this->em, new JsonHelper());
        $json = file_get_contents(__DIR__.'/json/TestEntitySimpleReplace.json');
        $this->loader->loadFromJson($json);
        $this->em->flush();
    }

    public function testCommand()
    {
        $command = $this->application->find('json-fixtures:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            '--entity' => 'JsonFixturesBundle:TestEntity',]);
        $output = $commandTester->getDisplay();
        $data = json_decode($output);
        
        $this->assertNotEquals(count($data), 0);
        $this->assertEquals($data->namespace, 'MZ314:JsonFixturesBundle:Tests:Entity');
        $this->assertEquals($data->entityName, 'TestEntity');
        // $this->assertEquals($data->mode, 'replace');
      //  $this->assertEquals($data->pkForce, true);
        $this->assertEquals(isset($data->entries), true);
        $this->assertEquals(count($data->entries), 2);
        $this->assertEquals($data->entries[0]->id, 6);
        $this->assertEquals($data->entries[0]->name, 'test1');
        $this->assertEquals($data->entries[1]->id, 7);
        $this->assertEquals($data->entries[1]->name, 'test2');
        
    }
}
