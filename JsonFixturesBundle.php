<?php

namespace MZ314\JsonFixturesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use MZ314\JsonFixturesBundle\DependencyInjection\JsonFixturesExtension;

class JsonFixturesBundle extends Bundle
{

    public function getContainerExtension()
    {
        return new JsonFixturesExtension();
    }
}
