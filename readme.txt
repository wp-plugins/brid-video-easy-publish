=== Brid Video Easy Publish ===
Contributors: Sovica, Brid
Donate link: http://www.brid.tv/
Tags: embed video, embed youtube, flash, flash player, html5, html5 player, vpaid, video, mobile, video player, Brid.tv, brid video, brid player, brid.tv video player, webm, h.264, ffmpeg, MP4, ogg, poster, responsive, free video, video library, video gallery, transcoding, encoding, vast, video ads, video advertising, video monetization, playlist widget, video shortcode, video slider, youtube video, youtube player, video plugin, video widget, playlist, veeps, youtube playlist, video blog, video embed, flash video player, html5 video player, free video platform
Requires at least: 3.9
Tested up to: 4.3
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Seamlessly embed your videos (YouTube, streaming, HTML5, Flash) using Brid video players into your WordPress site or blog. 

== Description ==

With this plugin you will be able to seamlessly add Brid video players and content to your WordPress site or blog. 
Brid video is a free to use CMS system where you can add existing YouTube or upload your custom videos and monetize them.

**Main Features**

*   Pure HTML5 player with Flash fallback
*   VAST and VPAID support for video monetization
*   33+ custom designed HTML5 skins to use
*   Responsive player sizing
*   Amazon Cloudfront video hosting
*   Unlimited encoding thanks to our partnership with encoding.com
*   Powerful analytics
*   Absolutely free.  No hidden charges.

See more about brid.tv at our [product page](http://www.brid.tv "Brid Video").

Users will be able to easily search for videos in their Brid Video library. In addition all of your playlists and videos will be easily accessible with editable thumbnail, title and other information about the video. Using a simple user interface, click on the video you want and insert it into your post or page.

Default players for videos and playlists can be set throughout the site to create a consistent look as well as default heights and widths which depend on the player setup. All of these defaults can be overridden at the time of video insertion to allow for customization of a video or player.

In addition this plugin features a live preview of the video or playlist and player so you will know that you have the right video before you add it to your site.

== Installation ==

1. Upload the Brid Video Easy Publish plugin to your site via the "Add New" section of the "Plugins" tab.

2. Once the plugin has been uploaded, activate the plugin.

3. Once activated, click on the "Configure" link that appears at the top.

4. You will be prompted to authorize plugin usage with Brid.tv. Click on the Authorize button.

5. You will now be prompted with a login page in which you should input your Brid login credentials. If you don't have an Brid.tv account you can create one on the same page for free.

6. Once you login or signup, you will be prompted again to authorize Brid.tv usage with the installed plugin. Click on the authorize button and you are done!

Alternatively, you can install the plugin right from your WordPress admin dashboard. Simply search for "brid video easy publish" in the plugin section of the admin. WordPress will download and install the plugin for you automatically.
 
You will be able to use Brid videos and players in your regular Wordpress posting screen by clicking on the Brid.tv button located above the formatting bar of your post screen. 
You can also manage your Brid video library and playlists under Media > Brid video.

== Frequently asked questions ==

= I have installed the plugin but it does not work. =

Make sure that your WordPress version is at least 3.9, as versions below are not supported.

= Can I use this plugin to host videos on my own server? =

Yes! Once you first start to add a video into Brid you will be prompted to choose wether you would want us to host your video files or not.

= What shortcodes can I use for Brid playlist widgets? =

[brid_widget items="25" player="1" height="540" type="0" autoplay="1"]
This is the basic template for a Brid playlist widget shortcode:

*   items: set the number of videos you want to appear in the widget. Maximum allowed is 50.
*   player: input the ID of the Brid player you wish to use. Contact Brid support if you are not sure what your player ID is.
*   height: set the height in pixels for the widget.
*   type: 1 for a playlist using YouTube videos. 0 for anything else.
*   autoplay: 1 if you wish for the widget to autoplay. 0 for click to play.

= Have any further questions? =

See our extensive FAQ and documentation section here - https://brid.zendesk.com/hc/en-us

== Screenshots ==

1. Video library
2. Video edit view
3. Monetization screen where you can add a custom ad tag URL to monetize your content
4. Playlists screen
5. Add to post Brid video button
6. Upload video to your account
7. Add a YouTube video to your account
8. Add an externally hosted video to your account
9. Brid settings page
10. Brid player configuration
11. Brid quick post video screen
12. Embedded Brid player in a WordPress post
13. Related videos screen in Brid player with a Brid latest playlist widget in the site sidebar

== Changelog ==

= Version 2.1.0 =

*   Added option to disable player preview in posts or pages when embedding.
*   Massive optimizations and design changes to the Brid playlist widget.
*   Added more playlist options to the Brid playlist widget.
*   Added new options to the plugin in regards to the Brid partnership program.
*   Added shortcode support for Brid playlist widgets.

= Version 2.0.6 =

*   Fixed YouTube replacer functionality to not replace Dailymotion embeds.
*   Changed behavior for width and height player replacer for YouTube videos.
*   Fixed Api header response for certain premium themes compatibility.

= Version 2.0.5 =

*   Fixed YouTube replacer functionality when embed code is used without http(s) prefix.
*   Fixed YouTube replacer functionality if Vimeo embeds are used. It will not try to replace these embeds now.
*   Fixed Fit to Post option when no default width values were present for a player.

= Version 2.0.4 =

*   Fixed minor incompatibility with Jetpack's share plugin when displaying Twitter share buttons.

= Version 2.0.3 =

*   Fixed certain YouTube URL's that would not ingest properly.
*   Added notice for monetization options in regards to YouTube.
*   Fixed YouTube replacer functionality for certain premium themes.

= Version 2.0.2 =

*   Added compatibility with YouTube embed plugin.
*   Added new resize setting on the player level to set player size to the post/page size.
*   Changed certain HTML id's so that ad blockers do not recognize them as ads.
*   Changed the YouTube API version used to 3.0.

= Version 2.0.1 =

*   Added invalid URL check for intro videos.
*   Made plugin compatible with 3.9 WordPress version and onwards.
*   Optmized skin changing operation in settings menu to now use the player API. As a result, the change player skin operation is much faster.
*   Added a couple of checks on the settings page so changes propagate correctly between the CMS and the WP plugin.

= Version 2.0.0 =

This is almost a complete rework of our original plugin. There have been numerous changes and we could not list them all even if we wanted to. Here is brief overview of all the main features:

*   JavaScript backend optimizations in WordPress admin - Brid JavaScript are loaded only on admin pages that have Brid functionality.
*	Optimized Brid JavaScript front-end delivery when more than one Brid embed code is located on a single post or page.
*   Added a new settings page which contains additional monetization options for your player.
*   Added two new Brid replacers which can replace any YouTube or other WordPress video that was added to any post or page with a Brid player.
*   Added many configuration options for Brid players under the new settings page.
*	Added a FAQ section which contains valuable information regarding the plugin functionality.
*	All Brid plugin options are now centralized under a new entry in your main left hand menu under Brid.tv.
*	Added a Brid preview player on the Visual tab of any WordPress post or page.
*	Re-worked the new Brid quick post button on WordPress pages and posts.
*   Added functionality so that users can add any type of video or playlist through the Brid quick post button.
*	Added a report a bug section on the right sidebar.
*	Added a Brid playlist widget which you can find under your WordPress widgets section. It can currently display only your latest video playlist.
*	Added numerous optimizations for WordPress sites under HTTPS.
*   Fixed a couple of minor bugs on the video library page.

= Version 1.0.11 =

*   Resolved CSS class conflicts with some premium plugins and themes (SmartMag and WPtouch PRO).
*   Added feature so that re-authorization of the plugin is not needed anymore when upgrading to a newer version.

= Version 1.0.10 =

*   Added editor permissions to see Brid Video entry under Media menu.

= Version 1.0.9 =

*   Resolved JavaScript conflict on the videos list.

= Version 1.0.8 =

*   Removed redundant code that is not in use anymore.
*   Removed all references to fancybox due to GPL license.

= Version 1.0.7 =

*   Fixed bug where the plugin would recognize a plugin installation as a dev environment when in fact the site was not.
*   Fixed add video link when no videos were added.
*   Improved uploader functionality when a user cancels an upload.
*   Improved authorization protocols.

= Version 1.0.6 =

*   Updated WP plugin to work with new changes in the CMS backend.
*   Added new plan options.

= Version 1.0.5 =

*   Added a couple of security checks in the backend.
*   Fixed small preview player on edit playlist and edit video screens.
*   Added default preview player.
*   Fixed pagination when adding videos to an already created playlist.
*   Updated API to support newly added options in the WordPress plugin.

= Version 1.0.4 =

*   Fixed certain URL's to player to point to the right servers.Many 

= Version 1.0.3 =

*   Added classification of playlists to differentiate between YouTube and internal Brid playlists.
*   Shortcode now displays JavaScript Brid player embed code for better ad support.
*   Removed field for landing pages that could appear on certain sections.

= Version 1.0.2 =

*   Fixed various CSS overrides so that the plugin does not interfere with different core CSS elements in WordPress.

= Version 1.0.1 =

*   Fixed radial button initialization when a Brid user tries to add their first video.

= Version 1.0.0 =

*   Primary stable plugin release.



== Upgrade Notice ==

= 2.1.0 =
We suggest that you always upgrade to the latest version. This is the only way to make sure proper functionality of the plugin.