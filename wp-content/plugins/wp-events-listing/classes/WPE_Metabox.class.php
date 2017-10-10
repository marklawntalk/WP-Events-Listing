<?php

class WPE_Metabox {

	function __construct() {

		add_action( 'add_meta_boxes_event', array( $this, 'event_add_meta_boxes' ) );
		add_action( 'save_post_event', array( $this, 'event_save_meta_boxes_data' ), 10, 2 );
	}

	function event_add_meta_boxes( $post ) {
		add_meta_box( 'event_meta_box', __( 'Event Settings', 'wp-events-listing' ), array( $this, 'event_build_meta_box' ), 'event', 'normal', 'high' );
	}

	function event_build_meta_box( $post ) {

		wp_enqueue_style( 'jquery-ui-datepicker-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css', false, "1.9.0", false );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'wp-events-admin', WPE_ASSETS_URL . '/js/wp-events-admin.js', array( 'jquery', 'jquery-ui-datepicker' ), '1.0', true );


		$event_date = get_post_meta( $post->ID, '_event_date', true );
		$event_location = get_post_meta( $post->ID, '_event_location', true );
		$event_url = get_post_meta( $post->ID, '_event_url', true );


		include(WPE_TEMPLATES . '/event-meta-box.php');
	}

	function event_save_meta_boxes_data( $post_id ) {

		if ( !isset( $_POST['event_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['event_meta_box_nonce'], 'event-meta-box' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_REQUEST['event_date'] ) ) {

			$date = mysql2date( 'Y-m-d', $_REQUEST['event_date'] );
			update_post_meta( $post_id, '_event_date', $date );
		}

		if ( isset( $_REQUEST['event_location'] ) ) {

			$location = sanitize_text_field( $_REQUEST['event_location'] );
			update_post_meta( $post_id, '_event_location', $location );
		}

		if ( isset( $_REQUEST['event_url'] ) ) {

			$url = sanitize_text_field( $_REQUEST['event_url'] );
			update_post_meta( $post_id, '_event_url', $url );
		}
	}

}
