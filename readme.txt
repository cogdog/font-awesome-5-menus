=== Font Awesome 5 For Menus ===
Contributors: cogdog, new-nine
Donate link: https://patreon.com/cogdog
Tags: menu, icon, fontawesome
Requires at least: 4.0
Tested up to: 5.3
Stable tag: 4.3
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Easily create WordPress menus that use Font Awesome 5 icons.

== Description ==

This is an update to the [Font Awesome 4 Menus plugin by New Nine Media](https://wordpress.org/plugins/font-awesome-4-menus/) updated to work with Font Awesome 5 (their plugin has not been updated).

The settings allow you to use the Font Awesome 5 fonts included in the plugin, or to specify a URL to a CDN hosted one, or to skip using if one is enabled by another plugin or theme.

With this plugin, just add the full Font Awesome classes, e.g. `fab fa-(icon name)`  as a class/classes to your menu and the plugin will pull that out, put the icon before or after your link text, and wrap your link text in a span so you can show or hide it as you see fit.

In Font Awesome 5 Menus, you also have ability to add multiple Font Awesome classes for multiple effects. 

In addition, you can use shortcodes to add icons to your posts and pages, as well as shortcodes to take advantage of the new stacked feature of Font Awesome 5.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/font-awesome-5-menus` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Font Awesome 5 Menus screen to configure the plugin.

== Frequently Asked Questions ==

= Why not use the Official Font Awesome Plugin =

It's great! I use it often. This one merely makes it possibly to create a WordPress menu of icons only by using CSS class names. There are no conflicts.

= Where can I find all of the available icons? =

Head over to [the Font Awesome website](https://fontawesome.com/icons "the Font Awesome website") to find a full list of icons available. The plugin works with all free icons.

= How to I add an icon to my menu?  =

Go to **Appearance** -> **Menus**. Use the **Screen** Options tab (upper right) and check the box for CSS Classes to make it available for all menu items. 

Select which menu item to which you want to add the icon and add the icon class(es) under 'CSS Classes (optional)'.

![Adding Font Awesome classes to Github menu item](images/edit-css-menu.jpg "Adding Font Awesome classes to Github menu item")

To add the [home icon](https://fontawesome.com/icons/home?style=solid) to your 'Home' link, enter "fas fa-home" (without quotes) as a class. To make it spin, add "fas fa-home fa-spin" as your classes. 

Save your menu and enjoy the icons!

= How do I use the shortcodes? =

Use `[fa class="fab fa-twitter"]` to create a twitter icon.

You can include the [size](https://fontawesome.com/how-to-use/on-the-web/styling/sizing-icons) and [rotation](https://fontawesome.com/how-to-use/on-the-web/styling/rotating-icons) classes as well. 

Here it can entered the editor:

     I got my [fa class="fas fa-apple-alt fa-5x"] 
     and then I went [fa class="fab fa-twitter fa-rotate-270 fa-5x"]

which the plugin renders as:

![Example shortcode displayed](images/shortcode-fa.jpg "Example shortcode displayed")

There is also a `[fa-stack]` shortcode for rendering [stacked icons](https://fontawesome.com/how-to-use/on-the-web/styling/stacking-icons). This format requires opening and closing shortcode tags, and inside you will enter separate `[fa]` shortcodes for the icons- e.g. for 2 icons stacked (note wrapping one in a span tag to color it, if anyone really uses this I could add a wrapping style option)):

     [fa-stack class="fa-2x"]
       [fa class="fas fa-camera fa-stack-1x"]
       <span style="color:Tomato">[fa class="fas fa-ban fa-stack-2x"]</span>
     [/fa-stack]
 
which produces

![Example stack shortcode of red circle around a camera displayed](images/shortcode-stack.jpg "Example stack shortcode of red circle around a camera displayed")   


== Screenshots ==

1. Plugin Settings


== Changelog ==

= 5.2 =

* Cleaned up documentation for hopeful submission to WordPress repo. Wish me luck.

= 5.1 =

* Added plugin links to settings
* Renamed the menu name to not be confused with the official Font Awesome plugin

= 5.01 =
* Adjusted to fix `fa` shortcode and verify the `fa-stack` one works.

= 5.0 =
The very first attempt to get this to work, just tweaked the original plugin slightly. Keeping the versions to build off of the original.


