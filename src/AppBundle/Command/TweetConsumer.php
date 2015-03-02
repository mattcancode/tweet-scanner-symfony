<?php

namespace AppBundle\Command;

use \AppBundle\Entity\Tweet;
use \AppBundle\Entity\Tweeter;

use \OauthPhirehose;

class TweetConsumer extends \OauthPhirehose
{
	private $em;
	private $processed = 0;

	public function setEntityManager($em)
	{
		$this->em = $em;
	}

	public function enqueueStatus($status)
	{
		$data = json_decode($status, true);

		if (!is_array($data))
		{
			print "WARNING: ignoring tweet since it couldn't be decoded properly\n";
		}
		else if (!isset($data['id']))
		{
			print "WARNING: ignoring tweet since id is missing\n";
		}
		elseif (!isset($data['user'])) {
			print "WARNING: ignoring tweet since user is missing\n";
		}
		else
		{
			$user = $data['user'];

			$this->processed++;

			print "processing tweet " . $this->processed
					. " (id = " . $data['id']
					. ", user = " . $user['screen_name']
					. ")\n";

			if ($this->em) {
				$tweet = new Tweet();
				$tweet->setTweetId($data['id_str']);
				$tweet->setTweet(base64_encode(serialize($data)));

				$tweeter = $this->em->getRepository('AppBundle:Tweeter')
						->findOneByUserId($user['id_str']);

				if (!$tweeter) {
					$tweeter = new Tweeter();
					$tweeter->setUserId($user['id_str']);
					$tweeter->setName($user['name']);
					$tweeter->setScreenName($user['screen_name']);
					$tweeter->setProfileImageUrl($user['profile_image_url']);
					$tweeter->setTweetCount(1);
				} else {
					$tweeter->setTweetCount($tweeter->getTweetCount() + 1);
				}

				$this->em->persist($tweet);
				$this->em->persist($tweeter);

				$this->em->flush();

				if ($this->processed % 100 == 0) {
					$this->em->clear();
				}
			} else {
				print $status . "\n";
				print $user['screen_name'] . ':' . $data['id'] . ': ' . urldecode($data['text']) . "\n";
			}
		}
	}
}
