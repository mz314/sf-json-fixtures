<?php

namespace MZ314\JSonFixturesBundle\Tests;

use Symfony\Component\Console\Tester\CommandTester;

class DumpCommandTest extends BaseTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->application->add(new \MZ314\JSonFixturesBundle\Commands\DumpCommand());
    }

    public function testCommand()
    {
        $command = $this->application->find('json-fixtures:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            '--entity' => 'JSonFixturesBundle:TestEntity',]);
        // $this->executeCommand('json-fixtures:dump JSonFixturesBundle:TestEntity');
    }
}
