<?php
//http://stackoverflow.com/questions/27501321/functionnal-tests-inside-a-standalone-symfony2s-bundle

namespace MZ314\JSonFixturesBundle\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Common\Annotations\AnnotationRegistry;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected $em, $application;

    protected function executeCommand($command,
                                      Array $options = array())
    {
        $options["--env"]   = "test";
        $options["--quiet"] = true;
        $options            = array_merge($options, array('command' => $command));

        $this->application->run(new ArrayInput($options));
    }

    public function setUp()
    {

        AnnotationRegistry::registerFile(__DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
        $kernel      = new AppKernel('test', true); // create a "test" kernel
        $kernel->boot();
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);

        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
        $this->container = $kernel->getContainer();
        $this->executeCommand("doctrine:schema:create");

    }

   
}