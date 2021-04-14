<?php
/**
 * Single Event Meta (Map) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */

$map = tribe_get_embedded_map();
$register = get_post_meta(get_the_ID(), '_ecp_custom_6', true);
//$register_link = get_post_meta(get_the_ID(), 'registration_document', true);
$register_link = get_field('registration_document');
$pay_link = get_field('registration_link');
$formID = get_field('form_id');

if ( empty( $map ) ) {
	return;
}

?>

<div class="tribe-events-venue-map">
	<?php
	// Display the map.
	echo '<h2 class="screen-reader-text">Google Map of Event Location</h2>';
	do_action( 'tribe_events_single_meta_map_section_start' );
	echo $map;
	do_action( 'tribe_events_single_meta_map_section_end' );
	?>
</div>

<?php if ( !empty( $register ) ) { ?>
	
<div class="tribe-events-register">
	<dt>Register</dt>
	<dd><?php echo $register ?></dd>
</div>

<?php } ?>


<?php if ( !empty( $register_link ) ) { ?>
	<div class="tribe-events-register-linke">
		<?php echo '<a href="' .  $register_link . '" target="_blank" class="button">Download Registration PDF</a>'; ?>
	</div>
<?php } ?>

<?php if ( !empty( $formID ) ) { ?>
	<div class="tribe-events-pay-link">
		<?php echo '<a href="#" class="button">Register and Pay Online</a>'; ?>
	</div>
<?php } ?>

