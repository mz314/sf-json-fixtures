<?php
namespace MZ314\JsonFixturesBundle\Exception;

/*
 * Maybe later
 */

class EmptySetException extends \Exception implements JsonFixturesBundleExceptionInterface
{
    public function __construct($code=null, $previous=null)
    {
        parent::__construct("dumpArrayToJson - empty array supplied", 500, $previous);
    }
}

