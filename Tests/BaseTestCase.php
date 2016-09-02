<?php

namespace MZ314\JSonFixturesBundle\Tests;

use Doctrine\ORM\EntityManager;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected $em;

    public function setUp()
    {
        $cache = new \Doctrine\Common\Cache\ArrayCache();

        $config = $this->getMock('Doctrine\ORM\Configuration');
        $conn   = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(__DIR__.'/Entity');

        $config->expects($this->any())
            ->method('getMetadataCacheImpl')
            ->will($this->returnValue($cache));
        $config->expects($this->any())
            ->method('getQueryCacheImpl')
            ->will($this->returnValue($cache));
        $config->expects($this->once())
            ->method('getProxyDir')
            ->will($this->returnValue(sys_get_temp_dir()));
        $config->expects($this->once())
            ->method('getProxyNamespace')
            ->will($this->returnValue('Proxy'));
        $config->expects($this->once())
            ->method('getAutoGenerateProxyClasses')
            ->will($this->returnValue(true));
        $config->expects($this->any())
            ->method('getMetadataDriverImpl')
            ->will($this->returnValue($xmlDriver));
        $config->expects($this->any())
            ->method('getClassMetadataFactoryName')
            ->will($this->returnValue('Doctrine\ORM\Mapping\ClassMetadataFactory'));
        $config->expects($this->any())
            ->method('getDefaultRepositoryClassName')
            ->will($this->returnValue('Doctrine\ORM\EntityRepository'));
        $config->expects($this->any())
            ->method('getRepositoryFactory')
            ->will($this->returnValue(new \Doctrine\ORM\Repository\DefaultRepositoryFactory()));
        $config->expects($this->any())
            ->method('getQuoteStrategy')
            ->will($this->returnValue(new \Doctrine\ORM\Mapping\DefaultQuoteStrategy()));
        $this->em = \Doctrine\ORM\EntityManager::create($conn, $config);
    }

    public function testSomething()
    {
        
    }
}