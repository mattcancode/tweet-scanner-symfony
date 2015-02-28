<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tweeter
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tweeter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_id", type="string", length=20)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="screen_name", type="string", length=20)
     */
    private $screenName;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_image_url", type="string", length=255)
     */
    private $profileImageUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="tweet_count", type="smallint")
     */
    private $tweetCount;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Tweeter
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set screenName
     *
     * @param string $screenName
     * @return Tweeter
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;

        return $this;
    }

    /**
     * Get screenName
     *
     * @return string 
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * Set profileImageUrl
     *
     * @param string $profileImageUrl
     * @return Tweeter
     */
    public function setProfileImageUrl($profileImageUrl)
    {
        $this->profileImageUrl = $profileImageUrl;

        return $this;
    }

    /**
     * Get profileImageUrl
     *
     * @return string 
     */
    public function getProfileImageUrl()
    {
        return $this->profileImageUrl;
    }

    /**
     * Set tweetCount
     *
     * @param integer $tweetCount
     * @return Tweeter
     */
    public function setTweetCount($tweetCount)
    {
        $this->tweetCount = $tweetCount;

        return $this;
    }

    /**
     * Get tweetCount
     *
     * @return integer 
     */
    public function getTweetCount()
    {
        return $this->tweetCount;
    }
}
