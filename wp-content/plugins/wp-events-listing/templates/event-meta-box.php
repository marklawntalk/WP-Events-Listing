<?php
if ( !defined( 'ABSPATH' ) )
	exit();
?>
<div id="wp-events-listing-metabox">
	<h3><?php _e( 'Event Date', 'wp-events-listing' ); ?></h3>
	<p>
		<input type="text" name="event_date" class="date-picker" value="<?php echo esc_attr( $event_date ); ?>" /> 
	</p>

	<h3><?php _e( 'Event Location', 'wp-events-listing' ); ?></h3>
	<p>
		<input type="text" name="event_location" class="event-location" value="<?php echo esc_attr( $event_location ); ?>" /> 
	</p>

	<h3><?php _e( 'Event URL', 'wp-events-listing' ); ?></h3>
	<p>
		<input type="text" name="event_url" class="event-location" value="<?php echo esc_url( $event_url ); ?>" /> 
	</p>

	<?php wp_nonce_field( 'event-meta-box', 'event_meta_box_nonce' ); ?>
</div>
<?php

