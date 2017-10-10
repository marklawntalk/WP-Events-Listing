<?php

/**
 * Plugin Name: WP Events Listing
 * Description: Events Listing plugin
 * Author: Mark Lontoc
 * Version:1.0
 * Text Domain: wp-events-listing
 */
if ( !defined( 'ABSPATH' ) )
	exit();

spl_autoload_register( function ($class) {
	include plugin_dir_path( __FILE__ ) . 'classes/' . $class . '.class.php';
} );

define( 'WPE_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPE_TEMPLATES', WPE_PLUGIN_DIR_PATH . 'templates' );
define( 'WPE_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets' );

class WPEventsListing {

	function __construct() {

		add_action( 'init', array( $this, 'init_functions' ) );
		add_filter( 'the_content', array( $this, 'event_post_content' ) );


		new WPE_Metabox();
	}

	function init_functions() {
		$this->register_event_post_type();
	}

	function register_event_post_type() {
		$labels = array(
			'name' => _x( 'Events', 'post type general name', 'wp-events-listing' ),
			'singular_name' => _x( 'Event', 'post type singular name', 'wp-events-listing' ),
			'menu_name' => _x( 'Events', 'admin menu', 'wp-events-listing' ),
			'name_admin_bar' => _x( 'Event', 'add new on admin bar', 'wp-events-listing' ),
			'add_new' => _x( 'Add New', 'event', 'wp-events-listing' ),
			'add_new_item' => __( 'Add New Event', 'wp-events-listing' ),
			'new_item' => __( 'New Event', 'wp-events-listing' ),
			'edit_item' => __( 'Edit Event', 'wp-events-listing' ),
			'view_item' => __( 'View Event', 'wp-events-listing' ),
			'all_items' => __( 'All Events', 'wp-events-listing' ),
			'search_items' => __( 'Search Events', 'wp-events-listing' ),
			'parent_item_colon' => __( 'Parent Events:', 'wp-events-listing' ),
			'not_found' => __( 'No events found.', 'wp-events-listing' ),
			'not_found_in_trash' => __( 'No events found in Trash.', 'wp-events-listing' )
		);

		$args = array(
			'labels' => $labels,
			'description' => __( 'Description.', 'wp-events-listing' ),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'events' ),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-calendar-alt',
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'event', $args );
	}

	function event_post_content( $content ) {
		global $post;

		if ( $post->post_type == 'event' ) {
			$date = get_post_meta( $post->ID, '_event_date', true );

			if ( !empty( $date ) ) {
				$content .= sprintf( '<div>Event Date: %s</div>', $date );
				$content .= sprintf( '<div>Event Location: %s</div>', get_post_meta( $post->ID, '_event_location', true ) );
				$content .= sprintf( '<div>Event URL: %s</div>', esc_url( get_post_meta( $post->ID, '_event_url', true ) ) );
				$content .= sprintf( '<div><a href="http://www.google.com/calendar/event?
action=TEMPLATE
&text=%s
&dates=%s
&location=%s
&details"
target="_blank" rel="nofollow">Add to my calendar</a>', urlencode( $post->post_title ), urlencode( mysql2date( 'Ymd', $date ) . '/' . mysql2date( 'Ymd', $date ) ), urlencode( get_post_meta( $post->ID
										, '_event_location', true ) ) );
			}
		}
		return $content;
	}

}

new WPEventsListing();
