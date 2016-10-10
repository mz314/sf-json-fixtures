<?php

namespace MZ314\JSonFixturesBundle\Exception;


class JsonLoadException extends \Exception implements JSonFixturesBundleExceptionInterface
{
    public function __construct($message, $code=null, $previous=null)
    {
        parent::__construct($message, $code, $previous);

    }

}
