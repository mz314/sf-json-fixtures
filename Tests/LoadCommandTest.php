<?php

namespace MZ314\JSonFixturesBundle\Tests;

use Symfony\Component\Console\Tester\CommandTester;
use MZ314\JSonFixturesBundle\Services\LoaderService;
use MZ314\JSonFixturesBundle\Services\Helpers\JsonHelper;

class LoadCommandTest extends BaseTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->application->add(new \MZ314\JSonFixturesBundle\Commands\LoadCommand());
    }

    public function testCommand()
    {
        $command       = $this->application->find('json-fixtures:load');
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            [
                'command' => $command->getName(),
                '--fixture-file' => __DIR__.'/json/TestEntitySimpleReplace.json',
            ]
        );

        $testRepository = $this->em->getRepository('JSonFixturesBundle:TestEntity');

        $entities = $testRepository->findAll();

        $out = $commandTester->getDisplay();


        $this->assertEquals(count($entities), 2);
        $this->assertEquals($entities[0]->getId(), 6);
        $this->assertEquals($entities[1]->getId(), 7);
        $this->assertEquals($entities[0]->getName(), 'test1');
        $this->assertEquals($entities[1]->getName(), 'test2');
    }
}