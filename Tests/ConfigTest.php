<?php

namespace MZ314\JsonFixturesBundle\Tests;

class ConfigTest extends BaseTestCase
{

    public function setUp()
    {
      parent::setUp();
      $this->configService = $this->container->get('jsonfixtures.config');
    }

    public function testData() {
        $config = $this->configService->getConfig();
        $this->assertNotEquals($config, null);
        $this->assertEquals($config['default_output'], 'stdout');
        $this->assertEquals(empty($config['fixtures_dir']), False);

    }
}