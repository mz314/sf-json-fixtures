<?php
namespace MZ314\JsonFixturesBundle\Exception;


class EmptyTableException extends \Exception implements JsonFixturesBundleExceptionInterface
{
    public function __construct($code=null, $previous=null)
    {
        parent::__construct("dumpArrayToJson - empty array supplied", 500, $previous);
    }
}

