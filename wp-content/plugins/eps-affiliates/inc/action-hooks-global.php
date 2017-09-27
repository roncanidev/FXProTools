<?php
/*
 * ------------------------------------------------------------
 * Hook after purchase complete save details to eps backend
 * ------------------------------------------------------------
*/
 add_filter('eps_commerce_purchase_complete', 
 						'eps_commerce_purchase_complete', 10, 1);
/*
 * ------------------------------------------------------------
 * Hook after joining package purchase complete save details 
 * to eps backend
 * ------------------------------------------------------------
*/
 add_filter('eps_commerce_joining_package_purchase_complete', 
 						'eps_commerce_joining_package_purchase_complete', 10, 1);
/*
 * ------------------------------------------------------------
 * Hook calculate the rank of a user
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_calculate_affiliate_rank', 
 						'eps_affiliates_calculate_affiliate_rank_callback', 
 						 10, 1);
 // do_action('eps_affiliates_calculate_affiliate_rank',924);


/*
 * ------------------------------------------------------------
 * Add a user to holding tank
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_place_user_in_holding_tank', 
 						'eps_affiliates_place_user_in_holding_tank_callback', 
 						10, 2);

/*
 * ------------------------------------------------------------
 * Add a unilevel  user to holding tank
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_unilevel_place_user_in_holding_tank', 
 						'eps_affiliates_unilevel_place_user_in_holding_tank_callback', 
 						10, 2);



/*
 * ------------------------------------------------------------
 * Place user under a sponsor
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_place_user_under_sponsor', 
 						'eps_affiliates_place_user_under_sponsor_callback', 
 						10, 2);
/*
 * ------------------------------------------------------------
 * Place unilevel user under a sponsor
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_unilevel_place_user_under_sponsor', 
 						'eps_affiliates_unilevel_place_user_under_sponsor_callback', 
 						10, 2);




/*
 * ------------------------------------------------------------
 * Place user under a sponsor from the holding tank validity 
 * expired
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_force_place_after_holding_expired', 
 						'eps_affiliates_force_place_after_holding_expired_callback', 
 						10, 2);


/*
 * ------------------------------------------------------------
 * Place unilevel user under a sponsor from the holding tank validity 
 * expired
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_unilevel_force_place_after_holding_expired', 
 						'eps_affiliates_unilevel_force_place_after_holding_expired_callback', 
 						10, 2);




/*
 * ------------------------------------------------------------
 * Block a user
 *
 * Get an as input to the action, the member account has 
 * been blocked using this id
 * ------------------------------------------------------------
*/
 add_filter('eps_affiliates_block_member', 
 						'eps_affiliates_block_member_callback', 10, 1);

/*
 * ------------------------------------------------------------
 * UN Block a user
 *
 * Get an as input to the action, the member account has 
 * been blocked using this id
 * ------------------------------------------------------------
*/
 add_filter('eps_affiliates_unblock_member', 
 						'eps_affiliates_unblock_member_callback', 10, 1);

/*
 * ------------------------------------------------------------
 * EPS Affiliates Menus
 * ------------------------------------------------------------
*/
	add_action('eps_affiliate_system_menus','afl_system_admin_menu',10,1);
/*
 * ------------------------------------------------------------
 * EPS Affiliates Page header
 * ------------------------------------------------------------
*/
	add_action('eps_affiliate_page_header','afl_eps_page_header');
/*
 * ------------------------------------------------------------
 * EPS Affiliates content warpper
 * ------------------------------------------------------------
*/
	add_action('afl_content_wrapper_begin','afl_content_wrapper_begin');
/*
 * ------------------------------------------------------------
 * EPS Affiliates content warpper end
 * ------------------------------------------------------------
*/
	add_action('afl_content_wrapper_end','afl_content_wrapper_end');
/*
 * ------------------------------------------------------------
 * EPS Affiliates render table
 * ------------------------------------------------------------
*/
	add_filter('afl_render_table','afl_render_table',10,1);
/*
 * ------------------------------------------------------------
 * EPS Affiliates render form
 * ------------------------------------------------------------
*/
	add_filter('afl_render_form','afl_render_form',10,1);
/*
 * ------------------------------------------------------------
 * Place a customer under a sponsor
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_place_customer_under_sponsor', 
 						'eps_affiliates_place_customer_under_sponsor_callback', 
 						 10, 2 );
/*
 * ------------------------------------------------------------
 * Change the customer to distributor
 * ------------------------------------------------------------
*/
 add_action('eps_affiliates_become_distributor_from_customer', 
 						'eps_affiliates_become_distributor_from_customer_callback', 
 						 10, 1 );
/*
 * -----------------------------------------------------------
 * Get the user wallet balance amount
 * -----------------------------------------------------------
*/
	add_filter('afl_user_e_wallet_balance',
						 'afl_user_e_wallet_balance_callback',
						 10,1);
/*
 * -----------------------------------------------------------
 * Set the ewaalet transaction complete
 * -----------------------------------------------------------
*/
	add_filter('afl_withdrawal_completed',
						 'afl_withdrawal_completed_callback',
						 10,1);
/*
 * -----------------------------------------------------------
 * Set the ewaalet transaction complete
 * -----------------------------------------------------------
*/
	add_filter('afl_withdrawal_fee_credited',
						 'afl_withdrawal_fee_credited_callback',
						 10,1);
/*
 * -----------------------------------------------------------
 * Give the faststart bonus
 * -----------------------------------------------------------
*/
	add_action('afl_calculate_fast_start_bonus',
						 'afl_calculate_fast_start_bonus_callback',
						 10,2);

/*
 * -----------------------------------------------------------
 * Save the fsb PV when refer someone
 * -----------------------------------------------------------
*/
	add_action('afl_calculate_fast_start_bonus_pv',
						 'afl_calculate_fast_start_bonus_pv_callback',
						 10,1);
/*
 * ----------------------------------------------------------
 * Get how many days the current rank holding of a user
 * ----------------------------------------------------------
*/
 add_action('afl_rank_holding_days_template',
 						'afl_rank_holding_days_template_callback',
 						10,1);
/*
 * ----------------------------------------------------------
 * my customers count
 * ----------------------------------------------------------
*/
 add_filter('afl_my_customers_count',
 						'afl_my_customers_count_callback',
 						10,1);
/*
 * ----------------------------------------------------------
 * my customers count
 * ----------------------------------------------------------
*/
 add_filter('afl_my_distributors_count',
 						'afl_my_distributors_count_callback',
 						10,1);
/*
 * ----------------------------------------------------------
 * my customers count
 * ----------------------------------------------------------
*/
 add_action('afl_my_customers_count_template',
 						'afl_my_customers_count_template_callback',
 						10,1);
/*
 * ----------------------------------------------------------
 * my customers count
 * ----------------------------------------------------------
*/
 add_action('afl_my_distributors_count_template',
 						'afl_my_distributors_count_template_callback',
 						10,1);


/* ----------------------------------- E_WALLET ----------------------------------------------------------*/
/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_filter('afl_ewallet_today_earnings',
 						'afl_ewallet_today_earnings_callback',
 						10,1);
/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_action('afl_ewallet_today_earnings_template',
 						'afl_ewallet_today_earnings_template_callback');

/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_filter('afl_ewallet_yesterday_earnings',
 						'afl_ewallet_yesterday_earnings_callback',
 						10,1);
/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_action('afl_ewallet_yesterday_earnings_template',
 						'afl_ewallet_yesterday_earnings_template_callback');

/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_filter('afl_ewallet_last_week_earnings',
 						'afl_ewallet_last_week_earnings_callback',
 						10,1);
/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_action('afl_ewallet_last_week_earnings_template',
 						'afl_ewallet_last_week_earnings_template_callback');

/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_filter('afl_ewallet_last_month_earnings',
 						'afl_ewallet_last_month_earnings_callback',
 						10,1);
/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_action('afl_ewallet_last_month_earnings_template',
 						'afl_ewallet_last_month_earnings_template_callback');

/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_filter('afl_ewallet_all_time_earnings',
 						'afl_ewallet_all_time_earnings_callback',
 						10,1);
/*
 * ---------------------------------------------------------
 * E-wallet today earnings
 * ---------------------------------------------------------
*/
	 add_action('afl_ewallet_all_time_earnings_template',
 						'afl_ewallet_all_time_earnings_template_callback');

/*
 * ---------------------------------------------------------
 * E-wallet All summary blocks 
 * ---------------------------------------------------------
*/
	 add_action('afl_ewallet_all_earnings_summary_blocks_template',
 							'afl_ewallet_all_earnings_summary_blocks_template_callback');
/* ----------------------------------- E_WALLET ----------------------------------------------------------*/

add_filter('afl_distributor_team_volume',
 						'afl_distributor_team_volume_callback',
 						10,1);

add_filter('afl_distributor_personal_volume',
 						'afl_distributor_personal_volume_callback',
 						10,1);
// pr(apply_filters('afl_ewallet_last_week_earnings',get_uid()),1);