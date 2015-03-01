<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Command\TweetConsumer;

use \Phirehose;

define("TWITTER_CONSUMER_KEY", "g4ZmEa04OzaOdGTQ8ywSLyCxv");
define("TWITTER_CONSUMER_SECRET", "6hAsOVrcnx1XzLhIwFDQoDOoBoN3ZjDmqiJm8UPbbQ2I3N61vN");
define("OAUTH_TOKEN", "3063168321-kOiUpwHDGEyv5pmuHVep6m37WEsuxc0xMNUihuT");
define("OAUTH_SECRET", "YGm9QkgVRcJTPhUR8yP0xrlC6sR1t2B3dOVTMEYIJ5ydW");

class ScannerCommand extends ContainerAwareCommand
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

		$consumer = new TweetConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
		$consumer->setEntityManager($this->getContainer()->get('doctrine')->getManager());
		$consumer->setTrack(array('IBM'));
//		$consumer->setPersist();
		$consumer->consume();
	}
}
