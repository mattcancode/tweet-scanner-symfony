(function($, undefined) {

	var tweeters = undefined;
	var tweets = undefined;

	var latestTweetId = undefined;

	var createStreamItem = function(type, name, text, avatarUrl) {
		var wrapper = $('<div class="' + type + '" />');
		var content = $('<div class="content" />');
		var header = $('<div class="stream-item-header" />');

		if (avatarUrl) {
			header.append($('<img class="avatar" />').attr('src', avatarUrl));
		}

		header.append($('<strong class="name" />').text(name));

		content.append(header);
		content.append($('<p />').text(text));

		wrapper.append(content);

		return $('<li class="stream-item" />').append(wrapper);
	};

	var replaceTweeters = function(newTweeters) {
		var items = $();

		$.each(newTweeters, function(i, tweeter) {
			var item = createStreamItem('tweeter',
					tweeter.name,
					'Total tweets: ' + tweeter.tweetCount,
					tweeter.profileImageUrl);

			items = items.add(item);
		});

		// first remove the old list
		tweeters.children().slice(1, -1).remove();

		// and insert the new
		tweeters.children().eq(0).after(items);
	};

	// for now, we're adding all of the new tweets in one big chunk
	// but maybe it would be prettier to add them one at a time and
	// include some animation to draw attention to the updates
	var addTweets = function(newTweets) {
		var items = $();
		var count;

		$.each(newTweets, function(i, tweet) {
			var item = createStreamItem('tweet',
				tweet.user.name,
				tweet.text,
				tweet.user.profile_image_url);

			items = items.add(item);

			if (latestTweetId === undefined || tweet.id_str > latestTweetId) {
				latestTweetId = tweet.id_str;
			}
		});

		// add the new items to the DOM at the top of the list
		tweets.children().eq(1).after(items);

		// and update the tweet count
		items = tweets.children();
		count = items.length - 3;

		items.eq(1).text(count + ' result' + (count == 1 ? '' : 's'));
	};

	var addTweet = function(tweet) {
		var item = createStreamItem('tweet',
				tweet.screenNname,
				tweet.tweet,
				tweet.profileImageUrl);

		var items = tweets.children();
		var count = items.length - 2;

		// update the tweet count
		items.eq(1).text(count + ' result' + (count == 1 ? '' : 's'));

		// and add the new tweet at the top
		items.eq(1).after(item);
	};

	var iteration = 0;
	var tweetId = 0;

	var fetchLatest = function() {
		var params = {};

		if (latestTweetId !== undefined) {
			params.since = latestTweetId
		};

		$.getJSON('fetch', params).done(function(json) {
			if (json) {
				if (json.tweets) {
					addTweets(json.tweets);
				}

				if (json.tweeters) {
					replaceTweeters(json.tweeters);
				}
			}
		}).fail(function(xhr, status, error) {
			//TODO handle this
		});

		// when finished, trigger next fetch

		setTimeout(fetchLatest, 2000);
	};

	$(document).ready(function() {
		tweeters = $('#tweeters');
		tweets = $('#tweets');

		setTimeout(fetchLatest, 2000);
	});

}(jQuery, undefined));
