<?php

namespace MZ314\JSonFixturesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use MZ314\JSonFixturesBundle\DependencyInjection\JSonFixturesExtension;

class JSonFixturesBundle extends Bundle
{

    public function getContainerExtension()
    {
        return new JSonFixturesExtension();
    }
}
