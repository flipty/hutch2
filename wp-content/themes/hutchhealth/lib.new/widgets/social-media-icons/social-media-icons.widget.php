<?php
/*
 Plugin Name: Social Media Icons
 Plugin URI: #
 Description: Display Social Media Icons on your website.
 Version: 1.5.1
 Author: Tyler Steinhaus
 Author URI: #
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if( is_plugin_active( 'social-media-icons/social-media-icons.widget.php' ) ) {
	define( 'SMI_DIR', plugin_dir_url( __FILE__ ).'/images/' );
	define( 'SMI_IMAGES', plugin_dir_url( __FILE__ ).'/images/' );
} else {
	define( 'SMI_DIR', get_stylesheet_directory_uri().'/lib/widgets/social-media-icons/images/' );
	define( 'SMI_IMAGES', get_stylesheet_directory_uri().'/images/' );
}

/**
 * Initiate the widget for use with a plugin.
 */
add_action( 'widgets_init', 'initiate_smi_widget' );
function initiate_smi_widget() {
	register_widget( 'social_media_icons_widget' );
}

/**
 * Creates a widget that allows you to add Social Media Icons
 * in any widget area. You also have the ability to order the
 * social icons.
 *
 * @since 10/26/2014
 * @author Tyler Steinhaus
 */
class social_media_icons_widget extends WP_Widget {

	/**
	 * Default social media services/icons
	 */
	private $social_media = array(
		'facebook'		=> 'Facebook',
		'twitter'		=> 'Twitter',
		'googleplus'	=> 'Google Plus',
		'linkedin'		=> 'LinkedIN',
		'pintrest'		=> 'Pintrest',
		'youtube'		=> 'YouTube',
		'email'			=> 'Email'
	);

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct(
			'social-media-icons',
			__( 'Social Media Icons', 'text_domain' ),
			array(
				'description'	=> __( 'Display\'s Social Media Icons in a widget area.' )
			)
		);
	}

	/**
	 * Form that display's on the backend of Wordpress
	 *
	 * @since 10/26/2014
	 * @author Tyler Steinhaus
	 */
	function form( $instance ) {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function ( $ ) {
 				$( '#social-media-sortable ul' ).sortable();
 				$( '#social-media-sortable ul' ).disableSelection();
 				$( '#social-media-sortable li' ).disableSelection();
			});
		</script>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				Title:
			</label>
			<input type="text" value="<?php echo $instance['title']; ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>">
				Type:
			</label>
			<select name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
				<option value="image" <?php echo $instance['type'] == 'image' ? 'selected="selected"' : ''; ?>>Image</option>
				<option value="sprite" <?php echo $instance['type'] == 'sprite' ? 'selected="selected"' : ''; ?>>Background Sprite</option>
			</select>
		</p>
		<div id="social-media-sortable">
			<ul class="ui-sortable">
				<?php
				/**
				 * Loop through all our social media services so we can
				 * display them in the form.
				 */
				if( !empty( $instance['icons'] ) ) {
					$social_media_services = $instance['icons'];
				} else {
					$social_media_services = $this->social_media;
				}
				foreach( $social_media_services as $social_media => $value ) {
					?>
					<li class="ui-state-default">
						<label for="<?php echo $this->get_field_id( 'icons' ); ?>[<?php echo $social_media; ?>]">
							<?php echo $this->social_media[$social_media]; ?>:
						</label>
						<input type="text" value="<?php echo $instance['icons']["$social_media"]; ?>" id="<?php echo $this->get_field_id( 'icons' ); ?>[<?php echo $social_media; ?>]" name="<?php echo $this->get_field_name( 'icons' ); ?>[<?php echo $social_media; ?>]" class="widefat" />
					</li>
					<?php
				}
				?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Update function for the backend of the widget
	 *
	 * @since 10/26/2014
	 * @author Tyler Steinhaus
	 */
	function update( $new_instance, $old_instance ) {
		$new_instance['title'] = esc_attr( $new_instance['title'] );
		foreach( $this->social_media as $id => $title ) {
			if( $id == 'email' ) {
				$new_instance['icons'][$id] = esc_url( $new_instance['icons'][$id], 'mailto' );
				$new_instance['icons'][$id] = str_replace( 'http://', '', $new_instance['icons'][$id] );
			} else {
				$new_instance['icons'][$id] = esc_url( $new_instance['icons'][$id] );
			}
		}

		return $new_instance;
	}

	/**
	 * The frontend display of the widget
	 *
	 * @since 10/26/2014
	 * @author Tyler Steinhaus
	 */
	function widget( $args, $instance ) {
		echo $args['before_widget'];

		// Does a title exist for this widget?
		if ( !empty( $instance['title'] ) )
			echo $args['before_title'].$instance['title'].$args['after_title'];

		foreach( $instance['icons'] as $id => $url ) {
			if( !empty( $url ) ) {
				// Check to see if this is an email link, if so add mailto:
				if( $id == 'email' ) $url = 'mailto:'.$url;

				// Output our URL into an "a tag"
				echo '<a href="'.$url.'" class="'.$id.'" target="_blank">';

				// Check to see if image is selected, if so display image.
				if( $instance['type'] == 'image' ) {
					echo '<img src="'.$this->check_theme_images( $id ).'" alt="'.$this->social_media[$id].'" />';
				}

				echo '</a>';
			}
		}
		echo $args['after_widget'];
	}

	/**
	 * Checks to see if the images are in the theme images folder so we can use
	 * those instead of the default images. If they do use that url
	 *
	 * @since 10/27/2014
	 * @author Tyler Steinhaus
	 */
	function check_theme_images( $social_media ) {
		if( file_exists( SMI_IMAGES.'/'.$social_media.'.png' ) ) {
			return SMI_IMAGES.$social_media.'.png';
		} else {
			return SMI_DIR.$social_media.'.png';
		}
	}

}
