<?php

namespace MZ314\JSonFixturesBundle\Services;

class DumperService
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function dumpToJson(Array $entities)
    {
        $json = '';

        return $json;
    }
}
