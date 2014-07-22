=== WP Contextual Help ===
Contributors: kevinlangleyjr, voceplatforms
Donate link: http://voceplatforms.com/
Tags: contextual, help
Requires at least: 3.3
Tested up to: 3.9.1
Stable tag: 0.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows a developer to easily extend the contextual help dropdown content area in WordPress.

== Description ==
Adds helper functionality to easily add to the WP Contextual Help throughout the admin of a WordPress site.

== Installation ==

= As standard plugin: =
> See [Installing Plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

= As theme or plugin dependency: =
> After dropping the plugin into the containing theme or plugin, add the following:
`
if( ! class_exists( 'WP_Contextual_Help' ) ) {
	require_once( $path_to_help . '/wp-contextual-help.php' );
}
`

= As a composer dependency =
Add the following to your composer.json required dependencies
`
{
    // ...
    "require": {
        "voceconnect/wp-contextual-help": "~0.0.1"	// Most recent tagged version
    },
    // ...
}
`

== Screenshots ==

1. Example display of a custom help tab

== Changelog ==

= 0.0.2 =
* Fixing Readme

= 0.0.1 =
* Initial Commit