<?php

namespace MZ314\JsonFixturesBundle\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ManyToOneB extends BaseTestEntity
{

    /**
     * @ORM\OneToOne(targetEntity="MZ314\JsonFixturesBundle\Tests\Entity\ManyToOneA")
     */
    protected $relA;

    public function getRelA()
    {

        return $this->relA;
    }
}

