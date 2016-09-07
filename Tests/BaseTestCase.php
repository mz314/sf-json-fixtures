<?php
//http://stackoverflow.com/questions/27501321/functionnal-tests-inside-a-standalone-symfony2s-bundle

namespace MZ314\JSonFixturesBundle\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Common\Annotations\AnnotationRegistry;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected $em;

    protected function executeCommand($application, $command,
                                      Array $options = array())
    {
        $options["--env"]   = "test";
        $options["--quiet"] = true;
        $options            = array_merge($options, array('command' => $command));

        $application->run(new ArrayInput($options));
    }

    public function setUp()
    {

        AnnotationRegistry::registerFile(__DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
        $kernel      = new AppKernel('test', true); // create a "test" kernel
        $kernel->boot();
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $this->em = $kernel->getContainer()->get('doctrine')->getManager();

        $this->executeCommand($application, "doctrine:schema:create");
      //  $this->executeCommand($application, "doctrine:schema:update");
        


//        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver('AnnotationReader', __DIR__.'/Entity');
//
//        $config->expects($this->any())
//            ->method('getMetadataCacheImpl')
//            ->will($this->returnValue($cache));
//        $config->expects($this->any())
//            ->method('getQueryCacheImpl')
//            ->will($this->returnValue($cache));
//        $config->expects($this->once())
//            ->method('getProxyDir')
//            ->will($this->returnValue(sys_get_temp_dir()));
//        $config->expects($this->once())
//            ->method('getProxyNamespace')
//            ->will($this->returnValue('Proxy'));
//        $config->expects($this->once())
//            ->method('getAutoGenerateProxyClasses')
//            ->will($this->returnValue(true));
//        $config->expects($this->any())
//            ->method('getMetadataDriverImpl')
//            ->will($this->returnValue($xmlDriver));
//        $config->expects($this->any())
//            ->method('getClassMetadataFactoryName')
//            ->will($this->returnValue('Doctrine\ORM\Mapping\ClassMetadataFactory'));
//        $config->expects($this->any())
//            ->method('getDefaultRepositoryClassName')
//            ->will($this->returnValue('Doctrine\ORM\EntityRepository'));
//        $config->expects($this->any())
//            ->method('getRepositoryFactory')
//            ->will($this->returnValue(new \Doctrine\ORM\Repository\DefaultRepositoryFactory()));
//        $config->expects($this->any())
//            ->method('getQuoteStrategy')
//            ->will($this->returnValue(new \Doctrine\ORM\Mapping\DefaultQuoteStrategy()));
//        $this->em = \Doctrine\ORM\EntityManager::create($conn, $config);
    }

    public function testSomething()
    {
        
    }
}