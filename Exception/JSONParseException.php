<?php

namespace MZ314\JSonFixturesBundle\Exception;

class JSONParseException extends \Exception implements JSonFixturesBundleExceptionInterface
{
    public function __construct($json, $code=null, $previous=null)
    {
        parent::__construct("JSON PARSING ERROR:\n".$json, 500, $previous);
        $this->json = $json;
    }

    public function getJson()
    {
        return $this->json;
    }

}
