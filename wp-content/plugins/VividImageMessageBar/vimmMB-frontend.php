<?php
/**
 * Vivid Image Message Bar
 * Front End Constructing class
 *
 * @since 08/13/2014
 * @author Tyler Steinhaus
 */

class vimmMessageBarFrontEnd {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Constructer for the Front End
	 * Enqueue's the CSS, JS, and HTML
	 *
	 * @since 08/13/2014
	 * @author Tyler Steinhaus
	 */
	function __construct() {
		$this->options = get_option( 'vimmMB' );

		// date_default_timezone_set('America/Chicago');
		$tz = new DateTimeZone( get_option('timezone_string') );
		$dt = new DateTime( "now", $tz );

		// Check to see if the message bar is turned on.
		$today_time = strtotime($dt->format("Y-m-d G:i"));

		if ( $_COOKIE['MBcookie'] ) {
			return;
		}

		if ( $this->options['start'] ) {
			//check to see if an hour and minute has been set
			if ( $this->options['starthour'] && $this->options['startminutes'] ) {
				$message_start = $this->options['start'] . ' ' . $this->options['starthour'] . ':' . $this->options['startminutes'];
			} else {
				$message_start = $this->options['start'] . ' ';
			}
			$message_start = strtotime($message_start);
		}
		
		if ( $message_start && ($today_time <= $message_start) ) {
			//if message start is set and today is equal to or greater than start
			return;
		}

		if ( $this->options['expiration'] ) {
			//check to see if an hour and minute has been set
			if ( $this->options['expirationhour'] && $this->options['expirationminutes'] ) {
				$message_expiration = $this->options['expiration'] . ' ' . $this->options['expirationhour'] . ':' . $this->options['expirationminutes'];
			} else {
				$message_expiration = $this->options['expiration'] . ' ';
			}
			$message_expiration = strtotime($message_expiration);
		}

		if ( $message_expiration && ($today_time >= $message_expiration) ) {
			//if message expiration is set and today is equal to or greater than today escape
			return;
		}

		if( $this->options['on_off'] == 1 ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueJSAndCSS' ) ); // Enqueue the css and js
			add_action( 'genesis_after_header', array( $this, 'buildBar' ), 20 ); // Display the bar on the page
			add_filter( 'body_class', array( $this, 'bodyClass' ) );
		}
	}

	/**
	 * Add a body class to let scripts/css know messagebar is active
	 *
	 * @since 08/28/2014
	 * @author Tyler Steinhaus
	 */
	function bodyClass( $classes ) {
		$classes[] = 'message-bar';

		return $classes;
	}

	/**
	 * Enqueue's all the CSS and Javascript
	 *
	 * @since 08/13/2014
	 * @author Tyler Steinhaus
	 */
	function enqueueJSAndCSS() {
		// Let's enqueue our Javascript
		wp_enqueue_script( 'vimmMB-JS', message_bar_plugin_js.'jscript.js', array( 'jquery' ) );

		// Let's enqueue our Stylesheet
		wp_enqueue_style( 'vimmMB-CSS', message_bar_plugin_css.'style.css' );
	}

	/**
	 * HTML that will be displayed on the front end of the website
	 *
	 * You can customize this using the filter 'vimmMB-html'
	 *
	 * @since 08/13/2014
	 * @author Tyler Steinhaus
	 */
	function buildBar() {

		// Determine if we want it to load right away or a delay
		$delay = '';
		if ( $this->options['load'] == 0 ) {
			$delay = ' delay';
		}

		// Check to see if the admin bar is showing
		$admin_bar = '';
		if ( is_user_logged_in() ) {
			$admin_bar = ' admin-bar';
		}

		if( $this->options['desktop_scroll'] == 1 ) {
			$scroll_feature = ' scrollenabled';
		}

		// Check to see if there is button text & link
		$button = '';
		if ( $this->options['button_onoff'] == 1 ) {
			// Check to see if button opens in new window
			$button_target = ( $this->options['button_target'] == 1 ) ? ' target="_blank"' : '';
			$button = '<a href="'.$this->options['button_link'].'" class="button"'.$button_target.'>';
			$button .= ( $this->options['button_text'] != NULL ) ? $this->options['button_text'] : 'Click Here';
			$button .= '</a>';
		}

		$defaultColors = array( 
								'one' => '#ffffff', 
								'two' => '#000000', 
								'three' => '#ff0000', 
								'four' => '#ffff00'
							);
		// Use an existing filter that's for the admin panel to get the proper color that's needed
		$filterColors = apply_filters( 'message_bar_colors', null );

		//Merge our defaults with our custom colors
		if ( $filterColors ) {
			// $colors = array_unique(array_merge($defaultColors,$filterColors));
			$colors = $filterColors;
		} else {
			$colors = $defaultColors;
		}

		// Build our html to be displayed
		ob_start();

		?>
		<div id="vi-message-bar" style="background: <?php echo $colors[$this->options['priority']]; ?>" class="vi-message-bar <?php echo $this->options['priority'].$admin_bar.$scroll_feature.$delay; ?>">
			<p>
				<?php echo stripslashes($this->options['message']); ?>
				<?php echo $button; ?>
			</p>
			<span class="close">X</span>
		</div>
		<?php
		$contents = ob_get_contents();
		ob_end_clean();

		// Output the html but also setup a filter so we can modify the template if needed
		echo apply_filters( 'vimmMB-html', $contents, $this->options  );
	}
}
