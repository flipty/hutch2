<?php
/**
 * Single Event Meta (Additional Fields) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/pro/modules/meta/additional-fields.php
 *
 * @package TribeEventsCalendarPro
 */

if ( ! isset( $fields ) || empty( $fields ) || ! is_array( $fields ) ) {
	return;
}


?>






<div class="tribe-events-meta-group tribe-events-meta-group-other">
	<dl>
		<?php foreach ( $fields as $name => $value ): ?>

		  <?php  if(( $name != 'Register') && ( $name != 'Topic') && ( $name != 'Type')){ ?>


			<dt> <?php echo esc_html( $name );  ?> </dt>
			<dd class="tribe-meta-value">
				<?php
				// This can hold HTML. The values are cleansed upstream
				echo $value;
				?>
			</dd>

			<?php } ?>
		<?php endforeach ?>
	</dl>
</div>
