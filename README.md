WP Contextual Help
==================

Contributors: kevinlangleyjr, voceplatforms  
Tags: contextual, help  
Requires at least: 3.3  
Tested up to: 3.9.1  
Stable tag: 0.0.1  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows a developer to easily extend the contextual help dropdown content area in WordPress.

## Description
Adds helper functionality to easily add to the WP Contextual Help throughout the admin of a WordPress site.

## Installation

### As standard plugin:
> See [Installing Plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

### As theme or plugin dependency:
> After dropping the plugin into the containing theme or plugin, add the following:
```php
if( ! class_exists( 'WP_Contextual_Help' ) ) {
	require_once( $path_to_help . '/wp-contextual-help.php' );
}
```

### As a composer dependency
Add the following to your composer.json required dependencies
```json
{
    // ...
    "require": {
        "voceconnect/wp-contextual-help": "~0.0.1"	// Most recent tagged version
    },
    // ...
}
```

## Usage

### Registering a connection

Help tabs are registered using the ```WP_Contextual_Help::register_tab()``` method.

#### Parameters
* ```$id``` (string) - String to be used as the ID for the help tab
* ```$title``` (string) - Title to display to the user within the tab
* ```$args``` (array) - An array of options for the help tab
	* ```page``` (string, array) - Page(s) to enable the help tab
	* ```post_type``` (string, array) - Limit the tab to only display on these specific post types
	* ```file``` (string) - HTML file to read and output within the tab
	* ```wpautop``` (boolean) - Default: False - Apply wpautop to the loaded HTML file
	* ```callback``` - If a user would rather a custom callback instead of the autoloading of a HTML file, this is where that would be applied

#### Example

```php
<?php

add_action( 'init', function(){

	if( !class_exists( 'WP_Contextual_Help' ) )
		return;

	// Only display on the pages - post.php and post-new.php, but only on the `post` post_type
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
			echo 'Test 123';
		}
	) );
} );
```