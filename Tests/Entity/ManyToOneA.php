<?php

namespace MZ314\JSonFixturesBundle\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ManyToOneA extends BaseTestEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="MZ314\JSonFixturesBundle\Tests\Entity\ManyToOneB", inversedBy="relA")
     */
    protected $relM;

    public function getRelM()
    {

        return $this->relM;
    }
}