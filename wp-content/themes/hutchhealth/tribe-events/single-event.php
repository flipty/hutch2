<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();


$formID = get_field('form_id');

//Check ot see if we should be hiding an event's date if so add a special class below for CSS targeting
$hide_event_date = get_field('hide_date') == 1 ? ' vimm-hide-event-date ' : '' ;
?>

<?php if ( !empty( $formID ) ) { ?>
	<div class="tribe-events-gravity-form">
		<?php echo do_shortcode( '[gravityform id="'.$formID.'" title="false" description="false" ajax="true"]' ); ?>
	</div>
<?php } ?>


<div id="tribe-events-content" class="tribe-events-single <?php echo $hide_event_date ?>">



	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

	<div class="tribe-events-schedule tribe-clearfix">

		<?php echo tribe_get_start_date( $post->ID, false, 'F j, Y' ); ?> <span class="tribe-events-divider">|</span> <div class="event-time"> <?php echo tribe_get_start_time( $post->ID ); ?> - <?php echo tribe_get_end_time( $post->ID); ?></div>

	    <?php

			if ( tribe_is_recurring_event( $post_id ) ) {
				$tooltip .= '<div class="recurringinfo">';
				$tooltip .= '<div class="event-is-recurring">';
				$tooltip .= sprintf( ' <a href="%s">%s</a>',
					esc_url( tribe_all_occurences_link( $post_id, false ) ),
					__( 'See Recurring event', 'tribe-events-calendar-pro' )
				);
				$tooltip .= '</div>';
				$tooltip .= '</div>';

				echo $tooltip;
			}
		?>
		
		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-divider">|</span>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div>



	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'post-feed', false ); ?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<?php the_content(); ?>
			</div>
			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

			
				<!-- Event meta -->
				<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			

			<div class="tribe-events-single-event-box">
				<?php tribe_get_template_part( 'modules/meta' ); ?>
			</div>


			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>


	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>" class="button back"> <?php printf( esc_html__( '%s', 'the-events-calendar' ), 'Back to All Events' ); ?></a>
	</p>

</div><!-- #tribe-events-content -->