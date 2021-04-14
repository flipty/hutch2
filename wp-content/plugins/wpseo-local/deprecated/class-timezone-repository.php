<?php

use Yoast\WP\Local\Repositories\Timezone_Repository;

/**
 * Class WPSEO_Local_Timezone_Repository
 *
 * This is the old Timezone Repository.
 *
 * @deprecated Use \Yoast\WP\Local\Repositories\Timezone_Repository instead
 */
class WPSEO_Local_Timezone_Repository extends Timezone_Repository {

	public function __construct() {
		parent::__construct( new WPSEO_Local_Api_Keys_Repository() );

		// code that relies on this class is unlikely to call initialize, so we make sure to call it here.
		$this->initialize();
	}
}
