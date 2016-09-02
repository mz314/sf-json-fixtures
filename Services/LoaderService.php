<?php

namespace MZ314\JSonFixturesBundle\Services;

use MZ314\JSonFixturesBundle\Exception\JSONParseException;

class LoaderService
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function loadJsonData($json)
    {
        $data = json_decode($json);

        if(is_null($data)) {
            throw new JSONParseException($json);
        }

        return $data;
    }
}

