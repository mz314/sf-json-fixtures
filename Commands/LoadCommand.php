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
            ->setDescription('Loads fixture from entity')
            ->addOption('fixture-file', null,
                InputOption::VALUE_REQUIRED, //TODO: allow for stdin
                'Fixture file name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $loaderService = $this->getContainer()->get('jsonfixtures.loader');

        $fixtureFn = $input->getOption('fixture-file');

        $output->writeln('Loading fixtures from '.$fixtureFn.' ...');

        $em = $this->getContainer()->get('doctrine')->getManager();

        $data = $loaderService->loadJsonFile($fixtureFn);
        $loaderService->loadFromObject($data);

        $em->flush();

        $output->writeln("Done");
    }
}