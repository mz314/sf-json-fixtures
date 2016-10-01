<?php
namespace MZ314\JSonFixturesBundle\Exception;

/*
 * Maybe later
 */

class EmptySetException extends \Exception implements JSonFixturesBundleExceptionInterface
{
    public function __construct($code=null, $previous=null)
    {
        parent::__construct("dumpArrayToJson - empty array supplied", 500, $previous);
    }
}

