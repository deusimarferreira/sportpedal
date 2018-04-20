=== WP-Picasa ===
Contributors: jake1981
Tags: picasa, gallery, album, image
Requires at least: 3.0
Tested up to: 3.0.1
Stable tag: 1.0.4

WP-Picasa adds support for displaying picasa albums/gallery on posts or pages using customized Jon Design's Smooth Gallery as a embedded viewer.

== Description ==

WP-Picasa adds a short code wp-picasa, where you are enabled to give a option
albumid if you wish to display a specific album. Plugin does not use Jon Design's
original gallery view as album lister, but uses it's own version. It displays
6 albums per page and uses AJAX to load views, or when pages are being changed.
Best way to experience, is to try it.

Here's some features:
 - Loads album lists (gallery) and albums and images using AJAX (no need to refresh window)
 - Has it's own very nice albm list view (gallery view) with pagination support
 - Uses Jon Design's popular Smooth Gallery to display albums/pictures
 - Caches queries to picas to speed up things

== Installation ==

Installing wp-picasa is very easy:

1. Upload 'wp-picasa' to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Enter your picasa user ID on the settings page.
1. Place [wp_picasa] or [wp_picasa albumid=1234] to your posts or pages to make gallery appear.
1. We're done!

== Frequently Asked Questions ==

= It doesn't work - There's a javascript error =
WP-Picasa uses mootools. If you have another plugin which uses jquery, then
there is a conflict. Somewhere I have seen a solution for this, but don't
remember where. Search on forums and use google. If I happen to bump on it, 
I'll link it here.. Or you can e-mail me the link if you happen to find it :)

= I tried to put my albums name to albumid setting but it didn't work, why? =

Because albumID numbers are not album titles or descriptions. They are unique
identification numbers used internally by Picasa. You need to study picasa a
bit to know this, so I'll help you out so you'll find it easier. Go to Picasa
web albums (not to software, browse to picasaweb.google.com/[YOUR_USERID]) then
open album you want to embed. Now, find RSS somewhere on the right side of
the screen (in the grey bar) and open it, or check where it points. Address
looks like this:
feed://picasaweb.google.com/data/feed/base/user/[YOUR_USERID]/albumid/[ALBUMID]
so - copy albumid number from that link..

= What about future support for flickr and other similar systems? =

Nope. This was it so far..

= Are there multiple languages supported on wp-picasa? =

Yes. I provided english and finnish. Someone else may provide more.

= I tried to browse pictures with carousel but even though carousel detects multiple pictures, carousel is empty, why? =

Are you maybe using Safari, Chrome or Firefox? I suspect that you have AdBlock extension enabled. Disable it and it works.
AdBlock seems to be hiding carousel..

= It queries xml requests from picasa's rss feed and caches them? =

Yes. Cache age has been set in common.php - it's as seconds and is
initially set to 7 minutes. Change variable $cache_time if this
doesn't suite your needs.

== Screenshots ==

1. Gallery view
2. Album view
3. Setup view

== Changelog ==

= 1.0.4 =
 * Fixed javascript problems for IE. Should function now in all browsers just fine.

= 1.0.3 =
 * Fixed plugin's header
 * Fidex lingual support

= 1.0.2 =
 * Moved settings from plugins sub-menu to settings

= 1.0.1 =
 * Compatibility check for wp 3.0.1 wp support
 * Added some css3 transitions to opacity changes on album list view
 * Moved language files to sub-directory lang in plugin's root directory
 * Removed some additional css definitions which weren't in use

= 1.0 =
* Initial version.

`<?php code(); // goes in backticks ?>`
