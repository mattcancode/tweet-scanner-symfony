Tweet Scanner
=============

This app is currently up and running on an [Amazon Web Services][10] EC2 instance:
[http://ec2-54-152-218-134.compute-1.amazonaws.com:8080/](http://ec2-54-152-218-134.compute-1.amazonaws.com:8080/)

This is just a simple prototype app to try out [PHP][1], [Symfony2][2],
[Doctrine][3], and the [Twitter Streaming API][4]. (And the
[Sublime Text 2][5] editor for the Mac, which is pretty cool but I've
never been able to do much with it since I've mostly been stuck with
Eclipse in my day job. I finally bought a license mid-way through this effort.)

Tweet Scanner is pretty simple - it simply displays recent tweets that
mention the keyword "IBM" and displays them in reverse chronological order
so the most recent is on top. It also shows the 5 tweeters who have
mentioned "IBM" the most. Using an Ajax service, it continually updates
the lists with new tweets and any new top 5 tweeters should the rankings change.

When deciding where to deploy the project, I originally tried a variety of
pre-configured Amazon Machine Instances (AMI) including a couple of Symfony
and LAMP servers, but none really had exactly what I wanted so ended up using
a barebones Amazon Linux AMI and just installing and configuring the tools manually.

The app consists primarily of the following components:

**ScannerCommand**

This is the [Symfony2][2] Console Command that actually fetches the tweets
from [Twitter][6] using the [Twitter Streaming API][4] and stashes them in
a [MySQL][8] database using the [Doctrine][3] ORM. I had tinkered with the
[Twitter REST API][9] in some Android apps a couple of years ago, but wasn't
familiar with the [Streamin API][4]. After cobbling together my own
implementation to handle the OAuth authentication, I came across the
[Phirehose][7] library and opted to use that instead. It seems to work nicely.

**Fetch Service**

This is the service that the browser client uses to fetch tweets and tweeters.
It takes an optional parameter to indicate which tweet id it received last to
avoid handling duplicates. If called without that parameter, it simply returns
the 50 most recent tweets. If the parameter is provided, then it obviously
returns any tweets whose ids are greater than tweet id passed.
 
**Front End Client**

The front end is a single page application that includes a simple script that
fetches tweets and tweeters from the Fetch Service via Ajax and displays them.
While the service sends the entire original tweet from [Twitter][6], the client
currently just shows a few details: the user's full name, screen name, avatar,
and the actual text for the tweet. It could be enhanced to add additional details
and provide links back to [Twitter][6], that seems a bit much for a simple
prototype.


[1]:  http://www.php.net/
[2]:  http://symfony.com/
[3]:  http://www.doctrine-project.org/
[4]:  https://dev.twitter.com/streaming/overview
[5]:  http://www.sublimetext.com/
[6]:  http://www.twitter.com/
[7]:  https://github.com/fennb/phirehose
[8]:  http://www.mysql.com/
[9]:  https://dev.twitter.com/rest/public
[10]: http://aws.amazon.com/
