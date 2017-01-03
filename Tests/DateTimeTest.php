<?php
namespace MZ314\JsonFixturesBundle\Tests;

use MZ314\JsonFixturesBundle\Tests\Entity\DateTimeEntity;

class DateTimeTest extends BaseTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->loader = $this->container->get('jsonfixtures.loader'); 
        $this->dumper = $this->container->get('jsonfixtures.dumper'); 
    }
    
    public function testDateTimeLoading() 
    {
        $e = new DateTimeEntity();
        $e->setName("test1");
        $e->setDateTime(new \DateTime('1987-09-20 06:06:06'));
        $this->em->persist($e);
        $this->em->flush();
        
        $dateEntityRepository = $this->em->getRepository('MZ314\JsonFixturesBundle\Tests\Entity\DateTimeEntity');
        
        $json = $this->dumper->dumpRepositoryToJson($dateEntityRepository);
        
       
        
        $this->assertTrue(count($json)!=0);
        
        $this->em->remove($e);
        $this->em->flush();
        
        $this->loader->loadFromJson($json);
        
        $entities = $dateEntityRepository->findAll();
        
        $this->assertEquals(count($entities), 1);
        $this->assertEquals($entities[0]->getDateTime()->format('Y-m-d H:i:s'), '1987-09-20 06:06:06');
        
        
    }
}
