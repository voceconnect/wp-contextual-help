<?php
/*
Plugin Name: WP Contextual Help
Description: Allows a developer to easily extend the contextual help dropdown content area in WordPress
Version: 0.0.1
Author: kevinlangleyjr
Plugin URI: http://voceplatforms.com
*/

if( !class_exists( 'WP_Contextual_Help' ) ){

	class WP_Contextual_Help {

		static $help_docs_dir = '';
		static $help_docs_img_url = '';
		static $tabs = array();

		/**
		 * Initialize plugin
		 * @return void
		 */
		static function init(){
			global $pagenow;

			self::$help_docs_dir = apply_filters( 'wp_contextual_help_docs_dir', get_template_directory() . '/includes/help-docs' );
			self::$help_docs_img_url = apply_filters( 'wp_contextual_help_docs_url', get_template_directory_uri() . '/includes/help-docs/img' );

			foreach( self::$tabs as $tab ){
				foreach( (array) $tab['page'] as $page ){
					add_action( 'load-' . $page, function() use ($tab) {
						self::add_tab_to_screen($tab);
					} );
				}
			}
		}

		/**
		 * Registers new contextual help tab
		 * @param string $page      Page path that is compared to the pagenow global
		 * @param string $id        Help tab id
		 * @param string $title     Help tab title
		 * @param array  $args      Arguments for the tab
		 */
		static function register_tab( $id, $title, $args ) {
			if( empty( $args['page'] ) ){
				_doing_it_wrong( __METHOD__, 'Cannot register help tab without specifying the page or pages to display it on', '0.0.1' );
			}

			$page = $args['page'];
			unset( $args['page'] );

			self::$tabs[$id] = array(
				'page' => $page,
				'id' => $id,
				'title' => $title,
				'args' => $args
			);
		}

		/**
		 * Adds tabs to screen on 'load-' . $tab['page']
		 *
		 * Loops through all tabs and adds them on the appropriate screen
		 */
		static function add_tab_to_screen($tab){
			// if post type arg is set, check the post type - if not same return
			if( isset( $tab['args']['post_type'] ) ){
				if( ! self::is_current_post_type( $tab ) ){
					return;
				}
			}

			$callback = !empty( $tab['args']['callback'] ) ? $tab['args']['callback'] : array( __CLASS__, 'echo_tab_html' );

			get_current_screen()->add_help_tab( array(
					'id' => $tab['id'],
					'title' => $tab['title'],
					'callback' => $callback
			) );
		}

		/**
		 * Loads the tab html
		 * @param  WP_Screen $screen     Screen that the help tab is being added to
		 * @param  array     $screen_tab Screen tab array
		 * @return void
		 */
		static function echo_tab_html( $screen, $screen_tab ){
			$tab = self::$tabs[$screen_tab['id']];
			$file_name = !empty($tab['file']) ? $tab['file'] : $tab['id'] . '.html';
			$file = self::$help_docs_dir . DIRECTORY_SEPARATOR . $file_name;

			$post_type_pages = array( 'post.php', 'post-new.php' );
			$current_page = false;

			if( file_exists( $file ) ){
				if( !empty( $tab['args']['wpautop'] ) ){
					$content = wpautop( file_get_contents( $file ) );
				} else {
					$content = file_get_contents( $file );
				}
			} else {
				$content = 'The provided HTML file is invalid.';
			}

			$content = str_replace( '{WP_HELP_IMG_URL}', self::$help_docs_img_url, $content );

			echo $content;
		}

		/**
		 * Checks to see if the current screen's post type is equivelent to the post type parameter provided when registering help tab
		 * @param  array   $tab
		 * @return boolean
		 */
		static function is_current_post_type( $tab ){
			$screen = get_current_screen();
			$current_post_type = isset( $screen->post_type ) ? $screen->post_type : false;

			if( !empty( $current_post_type ) && isset( $tab['args']['post_type'] ) ){
				if( is_array( $tab['args']['post_type'] ) ){
					return in_array( $current_post_type, $tab['args']['post_type'] );
				} else {
					return (bool) ( $tab['args']['post_type'] == $current_post_type );
				}
			}

			return false;
		}
	}
	add_action( 'init', array( 'WP_Contextual_Help', 'init' ), 99 );

}