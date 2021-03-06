<?php

namespace MZ314\JsonFixturesBundle\Tests;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;


class AppKernel extends Kernel
{

    public function registerBundles()
    {
        $bundles = array();


        $bundles[] = new FrameworkBundle();
        $bundles[] = new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle();
        $bundles[] = new \MZ314\JsonFixturesBundle\JsonFixturesBundle();


        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config.yml');
    }
}