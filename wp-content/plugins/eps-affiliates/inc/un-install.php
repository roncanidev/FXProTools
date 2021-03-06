<?php 
class Eps_affiliates_uninstall {
	public function __construct () {
		$this->remove_roles();
		//remove page
		$page_id = get_option('eps_affiliate_page');
		if( $page_id ) {
	    wp_delete_post( $page_id ); // this will trash, not delete
		}
		//remove the tables
		$this->eps_afl_remove_tables() ;

		//set option as uninstalled
		if (get_option( 'eps_afl_is_installed' ) ) {
			update_option( 'eps_afl_is_installed', '0' );
		}

	}
	/*
	 * ------------------------------------------------------------
	 * Remove roles
	 * ------------------------------------------------------------
	*/
	 public function remove_roles () {
	 	remove_role( 'afl_member' );
	 	remove_role( 'business_admin' );
	 	remove_role( 'business_director' );
	 }
	 /* 
	 * -----------------------------------------------------------
	 * Remove tables
	 * -----------------------------------------------------------
	*/
	 public function eps_afl_remove_tables () {
		global $wpdb;
		$tables = $this->system_tables_list();
		foreach ($tables as $table) {
			$delete = $wpdb->query('DROP TABLE `'.$table.'`');
		}
	 }
	 /*
	  * ----------------------------------------------------------
	  * All tables names
	  * ----------------------------------------------------------
	 */
	  public function system_tables_list () {
	  	global $wpdb;
			$tbl_prefix = $wpdb->prefix;
	  	$tables = array();
	  	$tables = array(
	  		// $tbl_prefix.'afl_variable',
	  		$tbl_prefix.'afl_user_downlines',
	  		$tbl_prefix.'afl_user_genealogy',
	  		$tbl_prefix.'afl_user_transactions',
	  		$tbl_prefix.'afl_business_transactions',
	  		$tbl_prefix.'afl_business_funds',
	  		$tbl_prefix.'afl_user_transactions_overview',
	  		$tbl_prefix.'afl_user_holding_tank'
	  	);
	  return $tables;
	  }
}

	 /*
	 * ------------------------------------------------------------
	 * Un-Install functions and Features 
	 * ------------------------------------------------------------
	*/
		function eps_affiliates_uninstall() {

			$obj = new Eps_affiliates_uninstall();
		}


