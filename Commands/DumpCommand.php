<?php

namespace MZ314\JSonFixturesBundle\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class DumpCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        // TODO entity arg. optional, when not supplied ALL
        $this
            ->setName('json-fixtures:dump')
            ->setDescription('Dumps entity')
            ->addOption('entity', null, InputOption::VALUE_REQUIRED, 'Entity name')
            ->addOption('file', null, InputOption::VALUE_OPTIONAL, 'Target file')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $dumperService = $this->getContainer()->get('jsonfixtures.dumper');
         $em = $this->getContainer()->get('doctrine')->getManager();
         $entityName = $input->getOption('entity');
         //$fileName = $input->getOption('file');
         $fileName = null;
         $entities = $em->getRepository($entityName)->findAll();
         $json = $dumperService->dumpToJson($entities);
         
        
         if(!$fileName || $fileName== 'stdout') {
             $output->write($json);
         } else {
             file_put_contents($fileName, $json);
         }
         
         
         
         
    }
}