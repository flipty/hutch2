<?php
/**
 * Upgrade process will start here
 *
 * If a plugin needs to have something in the DB updated you need to put it here
 * so we can run a check to see what version they were on and see which changes
 * need to be made.
 *
 * @author Tyler Steinhaus
 * @since 09/12/2014
 */

if( class_exists( 'vimmcms_upgrades' ) ) return;

class vimmcms_upgrades extends vimm_cms {

	/**
	 * Constructor
	 */
	function __construct() {
		$this->whatUpgrade();
	}

	/**
	 * Figure out what upgrade needs to take place for the
	 * current version of vimm cms
	 *
	 * @since 09/12/2014
	 * @author Tyler Steinhaus
	 */
	function whatUpgrade() {

		// Check to see if our "option" is even created, if not create one and proceed
		if( !get_option( PLUGIN_DB_NAME.'_version' ) ) {
			add_option( PLUGIN_DB_NAME.'_version', PLUGIN_VERSION );
			$this->upgradeOptionNames();
		} elseif( get_option( PLUGIN_DB_NAME.'_version' ) != PLUGIN_VERSION  ) {
			update_option( PLUGIN_DB_NAME.'_version', PLUGIN_VERSION );
		}
	}

	/**
	 * Upgrade from the old "wlcms_o" option prefix
	 * Change to PLUGIN_DB_NAME
	 *
	 * @since 09/12/2014
	 * @author Tyler Steinhaus
	 */
	function upgradeOptionNames() {
		global $vimmcms_admin;

		//Old Name
		$old_prefix = "wlcms_o";
		$new_prefix = PLUGIN_DB_NAME;

		// Gather all vimm cms "options"
		$options = $vimmcms_admin->options;

		foreach( $options as $option ) {

			// Get option and rename to the old prefix so we can get value from db
			$option_id = $option['id'];
			$option_id = str_replace( $new_prefix, $old_prefix, $option_id );

			// Get option value from old prefix so we can give it to the new prefix
			$option_value = get_option( $option_id );

			// Remove old prefix from db
			delete_option( $option_id );

			// Create new option with new prefix
			add_option( $option['id'], $option_value );
		}

	}
}
