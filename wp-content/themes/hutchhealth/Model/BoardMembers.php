<?php
/**
 * Model for Board Members
 * @author Justin McGuire
 */

class BoardMembers extends Model {
	function adjust_query( $query ) {
		if ( $query->is_main_query() && $query->is_post_type_archive( 'boardmembers' ) && !is_admin() ) {
	        $query->set( 'posts_per_page', -1 );
	        return;
		}
	}

}