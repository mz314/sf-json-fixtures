<?php

namespace MZ314\JsonFixturesBundle\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DateTimeEntity extends BaseTestEntity
{
   
    /**
     * @ORM\Column(type="datetime")
     */
    protected $datetime;
   
   public function getDateTime()
   {
       return $this->datetime;
   }
   
   public function setDateTime(\DateTime $datetime)
   {
       $this->datetime = $datetime;
       
       return $this;
   }

}