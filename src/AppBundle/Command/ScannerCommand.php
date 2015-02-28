<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScannerCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('scan:tweets')
			->setDescription('Fetch tweets for IBM via Twitter\'s Streaming API');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('running tweet scanner');
	}
}
