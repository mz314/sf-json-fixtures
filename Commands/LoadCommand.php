<?php

namespace MZ314\JSonFixturesBundle\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class LoadCommand extends ContainerAwareCommand
{ 
    protected function configure()
    {
    
        $this
            ->setName('json-fixtures:load')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
    }
    
}