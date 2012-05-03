=== Plugin Name ===
Contributors: webdevdesigner
Donate link: http://minitwitter.webdevdesigner.com
Tags: twitter, twitter feed, mini twitter, tweets, widget, shortcode 
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 1.2

Embed your twitter feed or the feed from your favorite users on your Wordpress blog. Shortcodes and widgets are used.

== Description ==

The plugin "mini Twitter feed" puts Twitter on your Wordpress blog, you can add your tweets or the tweets from the folks you like, lists, queries...

You can display up to 100 tweets within 7 days (limit set by Twitter's Search API).
	
It displays tweets from your feed or from the Twitter Search, from a list or from your favorite users. It is very flexible and modular.

You can read more on how to [Embed twitter on your Wordpress blog: mini Twitter](http://minitwitter.webdevdesigner.com/ "Put the twitter feed on your Wordpress blog").

== Installation ==

1. Upload `/mini-twitter_feed` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `[minitwitter username="YOUR_USERNAME"]` in your templates or use the widget section.

You can limit the number of tweets displayed [minitwitter username="webdevdesigner" limit=7]: it will show the last 7 tweets of the user @webdevdesigner.

It is possible to add a list of users to show [minitwitter username="twitter" list="team"]: it will show 5 tweets of the list "team" of the "twitter" user.

You can show the tweets of a query [minitwitter query="#awesome"]: it will show the tweets from the query #awesome.

You can change the color of your links by the color of your website changing `<style>.tweets a { color:#your_color; }</style>` in the `<head>` after the file `jquery.minitwitter.css`.

== Frequently Asked Questions ==

= How to add more than one twitter feed on my blog? =

You have to use the "id" section on your shortcode. For example, the first twitter feed will be: [minitwitter id=1 username="ladygaga"] and the second feed: [minitwitter id=2 username="justinbieber"]. The widget section does it automatically.

== Screenshots ==

1. The twitter feed on your blog.

== Changelog ==

= 1.0 =

= 1.1 =

Bug fix with for color of the links, now CSS is used.
Font -1px on all plugin

= 1.2 =

Bug fix for IE
Bug fix quotes query

== Upgrade Notice ==

= 1.1 =

Bug fix with for color of the links, now CSS is used.
Font -1px on all plugin

