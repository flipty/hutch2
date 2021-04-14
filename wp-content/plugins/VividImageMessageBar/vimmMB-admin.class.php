<?php
/**
 * Vivid Image Message Bar
 * Admin Constructing class
 *
 * @since 08/13/2014
 * @author Tyler Steinhaus
 */

class vimmMessageBarAdmin {

	private $options;

	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_js' ) );

		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	function enqueue_js() {
		wp_register_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
		wp_enqueue_style( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		// Let's enqueue our Javascript
		wp_enqueue_script( 'vimm-message-admin-js', message_bar_plugin_js.'vimm-mb-admin.js', array( 'jquery' ) );
	}

	function admin_menu() {
		$page_title = 'Vivid Image Message Bar';
		$menu_title = 'Message Bar';
		$capability = 'upload_files';
		$menu_slug = 'vimmMB-page';
		$callback = array( $this, 'vimmMB_page' );
		$icon = 'dashicons-warning';
		$position = 25;

		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $callback, $icon, $position );
	}

	function vimmMB_page() {
		//Set class property
		$this->options = get_option( 'vimmMB' );
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2>Vivid Image Message Bar</h2>
			<?php
				if( isset( $_POST['vimmMB-submit'] ) || wp_verify_nonce( $_POST['vimmMB-submit'], 'vimmMB' ) ) {
					update_option( 'vimmMB', $this->sanitize( $_POST['vimmMB'] ) );
					$this->redirect( 'admin.php?page=vimmMB-page&settings-updated=true' );
				}
				
				if( $_GET['settings-updated'] == 'true' ) {
					?>
					<div id="setting-error-settings_updated" class="updated settings-error"> 
						<p>
							<strong>Settings saved.</strong>
						</p>
					</div>
					<?php
				}
			?>
			<form method="post" action="admin.php?page=vimmMB-page" autocomplete="off">
				<?php wp_nonce_field( 'vimmMB', 'vimmMB-submit' ); ?>
				<h3>General Settings</h3>
				<table class="form-table">
					<tr>
						<th scope="row">On/Off</th>
						<td>
							<?php $this->on_off_field(); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">Displayed Message</th>
						<td>
							<?php $this->displayed_message_field(); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">Load Type</th>
						<td>
							<?php $this->load_type_field(); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">Background Color</th>
						<td>
							<?php $this->priority_field(); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">Scroll on Desktop?</th>
						<td>
							<?php $this->desktop_scroll_field(); ?>
						</td>
					</tr>
				</table>
				<hr>
				<h3>Message Scheduling</h3>
				<table class="form-table">
					<tr>
						<td style="padding:0px" colspan="2"><span><i>The times entered must be in 24-hour format. For example 4:00 PM would be entered as 16:00</i></span></td>
					</tr>
					<tr>
						<th scope="row">Message Display From:</th>
						<td>
							<?php $this->start_field(); ?> @ <?php $this->start_hour_field(); ?> : <?php $this->start_minutes_field(); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">Message Display To:</th>
						<td>
							<?php $this->expiration_field(); ?> @ <?php $this->expiration_hour_field(); ?> : <?php $this->expiration_minutes_field(); ?>
						</td>
					</tr>
				</table>
				<hr>
				<h3>Message Bar Button</h3>
				<table class="form-table">
					<tr>
						<th scope="row">Button On/Off</th>
						<td>
							<?php $this->button_onoff_field(); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">Button Text</th>
						<td>
							<?php $this->button_text_field(); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">Button Link</th>
						<td>
							<?php $this->button_link_field(); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">Button Target</th>
						<td>
							<?php $this->button_target_field(); ?>
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />
				</p>
			</form>
		</div>
		<?php
	}

	function admin_init() {
		register_setting( 'vimmMB', 'vimmMB', array( $this, 'sanitize' ) );
		add_settings_section( 'vimmMB-section', 'General Settings', function() { echo ''; }, 'vimmMB-page' );
		add_settings_field( 'on_off', 'On/Off', array( $this, 'on_off_field' ), 'vimmMB-page', 'vimmMB-section' );
		add_settings_field( 'message', 'Displayed Message', array( $this, 'displayed_message_field' ), 'vimmMB-page', 'vimmMB-section' );
		add_settings_field( 'load', 'Load Type', array( $this, 'load_type_field' ), 'vimmMB-page', 'vimmMB-section' );
		add_settings_field( 'priority', 'Background Color', array( $this, 'priority_field'), 'vimmMB-page', 'vimmMB-section' );
		add_settings_field( 'desktop_scroll', 'Background Color', array( $this, 'desktop_scroll'), 'vimmMB-page', 'vimmMB-section' );


		add_settings_field( 'start', 'Message Start', array( $this, 'start_field'), 'vimmMB-page', 'vimmMB-section' );
		add_settings_field( 'starthour', 'Message Start Hour', array( $this, 'start_hour_field'), 'vimmMB-page', 'vimmMB-section' );
		add_settings_field( 'startminutes', 'Message Start Minutes', array( $this, 'start_minutes_field'), 'vimmMB-page', 'vimmMB-section' );

		add_settings_field( 'expiration', 'Message Expiration', array( $this, 'expiration_field'), 'vimmMB-page', 'vimmMB-section' );
		add_settings_field( 'expirationhour', 'Message Expiration Hour', array( $this, 'expiration_hour_field'), 'vimmMB-page', 'vimmMB-section' );
		add_settings_field( 'expirationminutes', 'Message Expiration Minutes', array( $this, 'expiration_minutes_field'), 'vimmMB-page', 'vimmMB-section' );

		add_settings_section( 'vimmMB-button-section', 'Message Bar Button', function() { echo ''; }, 'vimmMB-page' );
		add_settings_field( 'button_onoff', 'Button On/Off', array( $this, 'button_onoff_field' ), 'vimmMB-page', 'vimmMB-button-section' );
		add_settings_field( 'button_text', 'Button Text', array( $this, 'button_text_field' ), 'vimmMB-page', 'vimmMB-button-section' );
		add_settings_field( 'button_link', 'Button Link', array( $this, 'button_link_field' ), 'vimmMB-page', 'vimmMB-button-section' );
		add_settings_field( 'button_target', 'Button Target', array( $this, 'button_target_field' ), 'vimmMB-page', 'vimmMB-button-section' );
	}

	function sanitize( $input ) {
		$new_input = array();
		if( isset( $input['on_off' ] ) ) {
			$new_input['on_off'] = absint( $input['on_off'] );
		}

		if( isset( $input['message'] ) ) {
			$new_input['message'] = sanitize_text_field( $input['message'] );
		}

		if( isset( $input['load'] ) ) {
			$new_input['load'] = absint( $input['load'] );
		}

		if( isset( $input['priority'] ) ) {
			$new_input['priority'] = sanitize_text_field( $input['priority'] );
		}

		if( isset( $input['desktop_scroll'] ) ) {
			$new_input['desktop_scroll'] = sanitize_text_field( $input['desktop_scroll'] );
		}

		if( isset( $input['expiration'] ) ) {
			$new_input['expiration'] = sanitize_text_field( $input['expiration'] );
		}

		if( isset( $input['expirationhour'] ) ) {
			$new_input['expirationhour'] = sanitize_text_field( $input['expirationhour'] );
		}

		if( isset( $input['expirationminutes'] ) ) {
			$new_input['expirationminutes'] = sanitize_text_field( $input['expirationminutes'] );
		}

		if( isset( $input['start'] ) ) {
			$new_input['start'] = sanitize_text_field( $input['start'] );
		}

		if( isset( $input['starthour'] ) ) {
			$new_input['starthour'] = sanitize_text_field( $input['starthour'] );
		}

		if( isset( $input['startminutes'] ) ) {
			$new_input['startminutes'] = sanitize_text_field( $input['startminutes'] );
		}

		if( isset( $input['button_onoff'] ) ) {
			$new_input['button_onoff'] = absint( $input['button_onoff'] );
		}

		if( isset( $input['button_text'] ) ) {
			$new_input['button_text'] = sanitize_text_field( $input['button_text'] );
		}

		if( isset( $input['button_link'] ) ) {
			$new_input['button_link'] = sanitize_text_field( $input['button_link'] );
		}

		if( isset( $input['button_target'] ) ) {
			$new_input['button_target'] = absint( $input['button_target'] );
		}

		return $new_input;
	}

	function on_off_field() {
		$on_off = ( $this->options['on_off'] == 1 ) ? ' selected="selected"' : '';
		echo '<select id="on_off" name="vimmMB[on_off]">';
			echo '<option value="0">Off</option>';
			echo '<option value="1"'.$on_off.'>On</option>';
		echo '</select>';
	}

	function desktop_scroll_field() {
		$desktop_scroll = ( $this->options['desktop_scroll'] == 1 ) ? ' selected="selected"' : '';
		echo '<select id="desktop_scroll" name="vimmMB[desktop_scroll]">';
			echo '<option value="0">Off</option>';
			echo '<option value="1"'.$desktop_scroll.'>On</option>';
		echo '</select>';
	}

	function displayed_message_field() {
		$message = stripslashes(esc_attr( $this->options['message'] ));
		echo '<textarea name="vimmMB[message]" id="message" cols="45" rows="5">'.$message.'</textarea>';
	}

	function load_type_field() {
		$load_delay = ( $this->options['load'] == 0 ) ? ' selected="selected"' : '';
		$load_load = ( $this->options['load'] == 1 ) ? ' selected="selected"' : '';
		echo '<select id="load" name="vimmMB[load]">';
			echo '<option value="0"'.$load_delay.'>Delay</option>';
			echo '<option value="1"'.$load_load.'>Immediately</option>';
		echo '</select>';
	}

	function priority_field() {
		// Set some default colors
		$defaultColors = array( 
								'one' => '#ffffff', 
								'two' => '#000000', 
								'three' => '#ff0000', 
								'four' => '#ffff00'
							);
		// Create a filter so we can add custom message bar colors
		$filterColors = apply_filters( 'message_bar_colors', null );

		//Merge our defaults with our custom colors
		if ( $filterColors ) {
			// $colors = array_unique(array_merge($defaultColors,$filterColors));
			$colors = $filterColors;
		} else {
			$colors = $defaultColors;
		}

		// Loop through each one to create our radio buttons
		foreach( (array) $colors as $id => $color ) {
			$checked = ( $this->options['priority'] == $id ) ? ' checked="checked"' : '';
			echo '<div style="display: inline-block;margin-right: 10px;">';
				echo '<input type="radio" style="margin-top: -16px;" name="vimmMB[priority]" id="priority" value="'.$id.'"'.$checked.'>';
				echo '<div style="display:inline-block;width: 25px;height: 25px;background: '.$color.';"></div>';
			echo '</div>';
		}
	}

	function start_field() {
		$start = esc_attr( $this->options['start'] );
		echo '<input type="text" name="vimmMB[start]" id="messagestart" value="'.$start.'" />';
	}
	
	function start_hour_field() {
		$starthour = esc_attr( $this->options['starthour'] );
		echo '<input type="number" min="0" max="24" width="2" name="vimmMB[starthour]" id="messagestarthour" value="'.$starthour.'" />';
	}

	function start_minutes_field() {
		$startminutes = esc_attr( $this->options['startminutes'] );
		echo '<input type="number" min="0" max="60" width="2" name="vimmMB[startminutes]" id="messagestartminutes" value="'.$startminutes.'" />';
	}

	function expiration_field() {
		$expiration = esc_attr( $this->options['expiration'] );
		echo '<input type="text" name="vimmMB[expiration]" id="messageexpiration" value="'.$expiration.'" />';
	}

	function expiration_hour_field() {
		$expirationhour = esc_attr( $this->options['expirationhour'] );
		echo '<input type="number" min="0" max="24" width="2" name="vimmMB[expirationhour]" id="messageexpirationhour" value="'.$expirationhour.'" />';
	}

	function expiration_minutes_field() {
		$expirationminutes = esc_attr( $this->options['expirationminutes'] );
		echo '<input type="number" min="0" max="60" width="2" name="vimmMB[expirationminutes]" id="messageexpirationminutes" value="'.$expirationminutes.'" />';
	}

	function button_onoff_field() {
		$on_off = ( $this->options['button_onoff'] == 1 ) ? ' selected="selected"' : '';
		echo '<select id="on_off" name="vimmMB[button_onoff]">';
			echo '<option value="0">Off</option>';
			echo '<option value="1"'.$on_off.'>On</option>';
		echo '</select>';
	}

	function button_text_field() {
		$button_text = esc_attr( $this->options['button_text'] );
		echo '<input type="text" name="vimmMB[button_text]" id="button_text" value="'.$button_text.'" />';
	}

	function button_link_field() {
		$button_link = esc_attr( $this->options['button_link'] );
		echo '<input type="text" name="vimmMB[button_link]" id="button_text" value="'.$button_link.'" />';
	}

	function button_target_field() {
		$button_target = $this->options['button_target'];
		$button_target = ( $button_target == 1 ) ? ' checked="checked"' : '';

		echo '<input type="checkbox" name="vimmMB[button_target]" id="button_target" value="1"'.$button_target.' /> Yes';
		echo '<br /><small class="description">Opens the button link in a new window.</small>';
	}
	
	function redirect( $url ) {
		$baseUri = get_admin_url();
	
		if( headers_sent() ) {
		    $string = '<script type="text/javascript">';
				$string .= 'window.location = "'.$baseUri.$url.'"';
			$string .= '</script>';
		
		    echo $string;
		} else {
			if( isset( $_SERVER['HTTP_REFERER'] ) && ( $url == $_SERVER['HTTP_REFERER'] ) ) {
				header('Location: '.$_SERVER['HTTP_REFERER']);
			} else {
		    	header('Location: '.$baseUri.$url);
		    }
		    exit;
		}
	}
}