<?php

namespace MZ314\JsonFixturesBundle\Exception;


class JsonLoadException extends \Exception implements JsonFixturesBundleExceptionInterface
{
    public function __construct($message, $code=null, $previous=null)
    {
        parent::__construct($message, $code, $previous);

    }

}
