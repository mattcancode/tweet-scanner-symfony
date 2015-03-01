<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Tweet;
use AppBundle\Entity\Tweeter;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
    * @Route("/fetch", name="fetch")
    */
    public function fetchAction()
    {
    	$request = $this->getRequest();
    	$since = $request->get('since');

    	// first we'll fetch the tweeters since they're easy
    	$tweeters = $this->fetchTopTweeters();

    	// and then the tweets
    	$tweetEntities = $this->fetchLatestTweets($since);

    	// we really only need the actual tweets and not anything else
    	// in the entity (and, of course, we'll need to decode them)
    	$tweets = array();
    	foreach ($tweetEntities as $tweet) {
    		array_push($tweets, unserialize(base64_decode($tweet['tweet'])));
    	}

    	return new JsonResponse(array('tweeters' => $tweeters, 'tweets' => $tweets));
    }

    private function fetchLatestTweets($since = null, $maxrows = 50)
    {
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Tweet');
    	$qb = $repository->createQueryBuilder('t');


    	if ($since) {
	    	$qb->where('t.tweetId > :since')
	    		->setParameter('since', $since);
    	}

    	$qb->orderBy('t.id', 'DESC')
    		->setMaxResults($maxrows);

    	return $qb->getQuery()->getArrayResult();
    }

    private function fetchTopTweeters($maxrows = 5)
    {
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Tweeter');

    	$query = $repository->createQueryBuilder('t')
    		->orderBy('t.tweetCount', 'DESC')
    		->setMaxResults($maxrows)
    		->getQuery();

    	return $query->getArrayResult();
    }
}
