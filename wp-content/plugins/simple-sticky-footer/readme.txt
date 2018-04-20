=== Simple Sticky Footer ===
Contributors: almos20
License: GPLv2 or later
Donate link: http://www.sandorkovacs.ro/en/
Tags: sticky footer, advertising, div always on top, sticky div
Requires at least: 3.1.0
Tested up to: 3.8.1
Stable tag: 1.3.0


Simple Sticky Footer is a lightweight plugin, it allows to promote/advertise a WP Page (rich-text document)  as a sticky footer (always on top div). 

== Description ==

Instructions: First of all activate the plugin. 

Step1: Create a new page. I suggest to add as title "Sticky Footer" 

Step2: Go to the configuration page APPEARANCE -> SIMPLE STICKY FOOTER. 

Step3: Select the page which will be shown on your website. 

Step4(optional): Define a width, in most cases the width of your page. 

Step5(optional): Define an animation effect. 

Step6(optional): Define a delay. Sometimes you want to show the sticky footer after 10-15 seconds. Now you can do this.

Step7(optional): Define additional CSS rules like: rounded borders, gradient background, shadows, etc ... Do not use { }, just enter the css properties ex: background:gray;border-top:1px; 

Have fun!

PS: If you have useful feature tip related to this plugin please write in the plugins support section.

== Installation ==

1. Install Simple Sticky Footer either via the WordPress.org plugin directory, or by uploading the files to your server
2. Activate the plugin through the 'Plugins' menu in WordPress
3. (optional) Configure the plugin settings in APPEARANCE -> STICKY FOOTER. 
4. That's it. You're ready to go!

== Frequently Asked Questions ==

= How can I add custom sticky footer wherever I want? = 
Shortcode feature was added since v1.2.0. 

Examples:

1. Insert shortcode into a page/post - :  [simple_sf pid=900], where pid is the id of your (sticky footer) page. 
2. Insert shortcode into a template file:  &lt;?php echo do_shortcode('[simple_sf pid=900]'); ?&gt;


You might create as many sticky footers you want, and easily can integrate in any template file. 
= Why I can't see the bottom part of the page ? =
Sticky footer has a fixed position. It's recommended to define padding bottom for your body with the height of the sticky div. 
Eg: Sticky footer height is 160px. You might define in your themes style.css :   body {padding-bottom: 160px;}


= How can I customize 100% ? =
If it is not enough the customizaton options from the administration panel, you should add extra CSS properties in your style.css from the active theme directory. 
Of course you can add interactions in your theme's javascript file. 
Sticky footer has 2 divs: 

- container: #simple-sticky-footer-container

- content:   #simple-sticky-footer

== Screenshots ==

1. Settings page.
2. Front-end exampe.

== Changelog ==

= 1.3.0 = 
* [Fix] Editor collapse issue http://wordpress.org/support/topic/sticky-footer-update-has-broken-the-editor

= 1.2.9 = 
* [Fix] Create a separate javascript file for the plugin.
* [Fix] Conflict in the twentytwelve default theme.
* [Test] WordPress 3.8.1.

= 1.2.8 = 
* [Fix] Update for WordPress 3.8

= 1.2.0 =
* [New feature] Shortcode for Sticky Footer:  [simple_sf pid={page_id}]

= 1.1.0 =
* Added delay configuration option
* Added animation configuration option

= 1.0 =
* First version.


== Upgrade Notice ==
No Upgrade Notice. This is the first release.

