<?php

namespace MVC;


/**
 * Db
 *
 * Interact with custom Database Tables
 *
 * Set the necessary class vars in the child class like so
 *
 * protected $db_option = "auth_db";
 * protected $db_version = 1;
 *
 * $this->id_field = "ID";
 *
 * private function __construct(){
		$this->table = $wpdb->prefix . 'saved_items';

		if( $this->update_required() ){
			$this->run_updates();
		}
 * }
 *
 */
abstract class Db {

	protected $table = null;
	protected $id_field = null;


	/**
	 * Columns
	 *
	 * Db columns with corresponding data type
	 * Used to sanitize queries
	 *
	 * @example array(
			'user_id'      => "%d",
			'content_id'   => "%s",
			'content_type' => "%s",
			'date'         => "%d"
		);
	 *
	 *
	 * @var array
	 */
	protected $columns = array();


	/**
	 * create_table
	 *
	 * Create the custom db table
	 *
	 * @example
	 * require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$sql = "CREATE TABLE IF NOT EXISTS " . $this->table . " (
			uid bigint(50) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) NOT NULL,
			content_id varchar(100) NOT NULL,
			content_type varchar(100) NOT NULL,
			date TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY  (uid),
			KEY lang_id (user_id),
			KEY post_id (content_id),
			KEY blog_id (content_type)
		);";

		dbDelta( $sql );
	 *
	 * @return void
	 */
	abstract protected function create_table();


	/**
	 * get
	 *
	 * Retrieve data from this db table
	 *
	 * @param array|string $columns - array or csv of columns we want to return
	 *                                If only one column is specified this will return
	 *                                either a single value or an array of single values
	 *                                depending on what $count is set to
	 *
	 * @param array|string [$id_or_wheres] - row id or array or where column => value
	 *
	 * @param  bool [$count] - number of rows to return.
	 *                         If set to 1 this will return a single var or
	 *                         row depending on the number of columns set in
	 *                         $columns, instead of an array of results
	 *
	 * @param string [ $order_by ] - an orderby value used verbatim in query
	 *
	 * @return array|string
	 *
	 */
	public function get( $columns, $id_or_wheres = null, $count = null, $order_by = null ){
		global $wpdb;

		if( is_array( $columns ) ){
			$columns = implode( ',', $columns );
		}

		if( empty( $id_or_wheres ) ){
			return $wpdb->get_results( "SELECT $columns FROM $this->table" );
		}

		if( is_numeric( $id_or_wheres ) ){
			$id_or_wheres = array( $this->id_field => $id_or_wheres );
		}


		$where_formats = $this->get_formats( $id_or_wheres );
		foreach( $id_or_wheres as $column => $value ){
			if( !empty( $value ) ){
				$wheres[ $column ] = "`$column` = " . array_shift( $where_formats );
				$values[ ]         = $value;
			}
		}


		$sql = "SELECT $columns FROM $this->table WHERE " . implode( ' AND ', $wheres );
		$sql = $wpdb->prepare( $sql, $values );

		if( $order_by != null ){
			$sql .= " ORDER BY $order_by";
		}

		if( $count != null ){
			$sql .= " LIMIT $count";
		}

		if( "*" == $columns || count( explode( ',', $columns ) ) > 1 ){
			if( $count === 1 ){
				return $wpdb->get_row( $sql );
			} else {
				return $wpdb->get_results( $sql );
			}

		} else {
			if( $count === 1 ){
				return $wpdb->get_var( $sql );
			} else {
				return $wpdb->get_col( $sql );
			}
		}

	}


	/**
	 * Add
	 *
	 * Add a row to the table
	 *
	 * @param array $columns
	 *
	 * @see $this->columns for args
	 *
	 * @return bool
	 */
	public function add( $columns ){
		global $wpdb;

		$columns = $this->sort_columns( $columns );

		return $wpdb->insert( $this->table, $columns, $this->columns );
	}


	/**
	 * Remove
	 *
	 * Add a meta row will delete if exists
	 *
	 * @param int|array $id_or_wheres - row id or array or column => values to use as where
	 *
	 * @return void
	 */
	public function remove( $id_or_wheres ){
		global $wpdb;

		if( is_numeric( $id_or_wheres ) ){
			$id_or_wheres = array( $this->id_field => $id_or_wheres );
		}

		foreach( $id_or_wheres as $column => $value ){
			if( $column == $this->id_field ){
				$formats[] = "%d";
			} elseif( !empty( $this->fields[ $column ] ) ) {
				$formats[] = $this->fields[ $column ];
			} else {
				$formats[] = "%s";
			}
		}

		$wpdb->delete( $this->table, $id_or_wheres );

	}


	/**
	 * Update
	 *
	 * @param int|array $id_or_wheres - row id or array or column => values to use as where
	 * @param array $columns- data to change
	 *
	 * @see $this->columns for columns
	 *
	 * @return bool
	 */
	public function update( $id_or_wheres, $columns ){
		global $wpdb;

		if( is_numeric( $id_or_wheres ) ){
			$id_or_wheres = array( $this->id_field => $id_or_wheres );
		}

		$column_formats = $this->get_formats( $columns );

		$formats = $this->get_formats( $id_or_wheres );

		return $wpdb->update( $this->table, $columns, $id_or_wheres, $column_formats, $formats );

	}


	/**
	 * Sort Columns
	 *
	 * Sorts columns to match $this->columns for use with query sanitization
	 *
	 * @uses $this->columns;
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function sort_columns( $columns ){
		$clean = array();

		foreach( $this->columns as $column => $type ){
			if( array_key_exists( $column, $columns ) ){
				$clean[ $column ] = $columns[ $column ];
			} else {
				$clean[ $column ] = null;
			}
		}

		return $clean;
	}


	/**
	 * get_formats
	 *
	 * Get the sprintf style formats matching an array of columns
	 *
	 * @uses $this->fields
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	protected function get_formats( $columns ){
		foreach( $columns as $column => $value ){
			if( $column == $this->id_field ){
				$formats[] = "%d";
			} elseif( !empty( $this->fields[ $column ] ) ) {
				$formats[] = $this->fields[ $column ];
			} else {
				$formats[] = "%s";
			}
		}

		return $formats;
	}


	/** Table creation *************************** */

	/**
	 * Run Updates
	 *
	 * Run specified updates based on db version and update the option to match
	 *
	 * @uses self::DB_OPTION
	 * @uses self::DB_VERSION
	 *
	 * @return void
	 */
	protected function run_updates(){
		$this->create_table();
		if( method_exists( $this, 'update_table' ) ){
			$this->update_table();
		}

		update_option( $this->db_option, $this->db_version );

	}


	/**
	 * Update Required ?
	 *
	 * Check if the db version is less than specified by this class
	 *
	 * @uses self::DB_OPTION
	 *
	 * @return bool
	 */
	protected function update_required(){
		if( !isset( $this->db_option ) ){
			trigger_error( "You must define a db_option in class extending db to use update_required" );
			return false;
		}

		if( !isset( $this->db_version ) ){
			trigger_error( "You must define a db_version in class extending db to use update_required" );
			return false;
		}

		if( $this->table == null ){
			trigger_error( "You must define a table in class extending db to use update_required" );
			return false;
		}

		if( $this->id_field == null ){
			trigger_error( "You must define a table in class extending db to use update_required" );
			return false;
		}


		$version = get_option( $this->db_option, 0.1 );

		if( version_compare( $version, $this->db_version ) == - 1 ){
			return true;
		} else {
			return false;
		}
	}

} 