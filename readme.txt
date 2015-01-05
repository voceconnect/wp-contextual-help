=== WP Contextual Help ===
Contributors: kevinlangleyjr, voceplatforms, Mte90
Donate link: http://voceplatforms.com/
Tags: contextual, help
Requires at least: 3.3
Tested up to: 4.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows a developer to easily extend the contextual help dropdown content area in WordPress.

== Description ==
Adds helper functionality to easily add to the WP Contextual Help throughout the admin of a WordPress site.

= Usage =

When you register a tab you have a few different options as far as what content is displayed there.

If you provide a callback argument in the tab args, that will take precedence and the plugin will not look for any HTML files within the help-docs directory.

If you provide a file argument in the tab args, the plugin will look for that file specifically and if it does not exist will output a warning message in place of the content to notify the developer that the specified help document does not exist.

If no file or callback argument is passed into the tab args, by default the plugin will look for a file with the same name as the id of the tab. So for `post-management` it would look for `post-management.html` within the help docs directory.

= HTML Help Docs =

All help docs should either reside within the `get_template_directory() . '/includes/help-docs/';` directory and all images within the `get_template_directory() . '/includes/help-docs/img/';`

You can use the `wp_contextual_help_docs_dir` filter to change the directory for the HTML files and the `wp_contextual_help_docs_url` filter to change the base URL for the images. Within your help documentation we use the variable `{WP_HELP_IMG_URL}` as a placeholder for the image URL which is then replaced before rendering with the value provided from the filter or defaults to the default help docs image directory.

= Registering a tab =

Help tabs are registered using the `WP_Contextual_Help::register_tab()` method.

**Parameters**

* `$id` (string) - String to be used as the ID for the help tab
* `$title` (string) - Title to display to the user within the tab
* `$args` (array) - An array of options for the help tab
	* `page` (string, array) - Page(s) to enable the help tab
	* `post_type` (string, array) - Limit the tab to only display on these specific post types
	* `file` (string) - HTML file to read and output within the tab
	* `wpautop` (boolean) - Default: False - Apply wpautop to the loaded HTML file
	* `callback` - If a user would rather a custom callback instead of the autoloading of a HTML file, this is where that would be applied

= Example =

`
<?php

add_action( 'init', function(){

	if( !class_exists( 'WP_Contextual_Help' ) )
		return;

	// Only display on the pages - post.php and post-new.php, but only on the post post_type
	// This would automatically look for a file called post-management.html within get_template_directory() . '/includes/help-docs/';
	WP_Contextual_Help::register_tab( 'post-management', 'Post Management', array(
		'page' => array( 'post.php', 'post-new.php' ),
		'post_type' => 'post',
		'wpautop' => true
	) );

	// Add to a custom admin page
	WP_Contextual_Help::register_tab( 'custom-settings', 'Custom Settings', array(
		'page' => 'settings_page_custom-settings-page',
		'wpautop' => true
	) );

	// Add help tab with custom callback
	WP_Contextual_Help::register_tab( 'custom-callback', 'Custom Callback Example', array(
		'page' => array( 'post.php', 'post-new.php' ),
		'post_type' => 'post',
		'callback' => function( $screen, $tab ) {
			echo '<p>It is super easy to add new help tabs!</p>';
		}
	) );
} );
?>
`

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

Please refer to full changelog at https://github.com/voceconnect/wp-contextual-help/releases.