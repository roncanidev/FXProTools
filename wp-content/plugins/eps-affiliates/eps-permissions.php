<?php 
/*
 * ------------------------------------------------------------------------------
 * Afl Custom permissions
 * ------------------------------------------------------------------------------
*/
	function custom_permissions(){
		$permissions = array();
		//eps system member
		$permissions['eps_system_member'] = array(
			'#title' 				=> __('Eps affiliates member'),
			'#description' 	=> 'Only those can acces the admin bar and admin menus'
		);
		//affiliates dashboard
		$permissions['eps_affiliates_dashboard'] = array(
			'#title' 				=> __('Affiliates Dashboard'),
			'#description' 	=> 'Eps affiliates dashboard'
		);

		//genealogy view
		$permissions['afl_network_view'] = array(
			'#title' 				=> __('AFL Network View'),
			'#description' 	=> 'View the affiliate network'
		);
		//new member
		$permissions['afl_add_new_member'] = array(
			'#title' 				=> __('AFL Add New Member'),
			'#description'	=> 'Add new affiliate under the user'
		);
		//ewallet
		$permissions['ewallet'] = array(
			'#title' 				=> __('E-wallet'),
			'#description' 	=> 'Access for E-wallet'
		);
		//epin
		$permissions['epin'] = array(
			'#title' 				=> __('E-pin'),
			'#description' 	=> 'Access for E-pin'
		);
		//business transaction
		$permissions['business_transactions'] = array(
			'#title' 				=> __('Manage Business transactions '),
			'#description' 	=> 'Manage Business transactions'
		);
		//manage members
		$permissions['manage_members'] = array(
			'#title' 				=> __('Manage System members'),
			'#description' 	=> 'Manage System members'
		);
		//promotional tools
		$permissions['promotional_tools'] = array(
			'#title' 				=> __('Manage Promotional Tools'),
			'#description' 	=> 'Manage Promotional Tools'
		);
		//payout
		$permissions['payout'] = array(
			'#title' 				=> __('AFL System Payout'),
			'#description' 	=> 'Payout from the system to different wallet'
		);
		//business system members create
		$permissions['business_system_members'] = array(
			'#title' 				=> __('AFL manage Business system members'),
			'#description' 	=> 'Add or eidt the business system members '
		);
			//features and settings
		$permissions['afl_purchase'] = array(
			'#title' 				=> __('AFL Purchase'),
			'#description' 	=> 'affiliates system purchases '
		);
		//rank performance overview
		$permissions['afl_rank_performance_overview'] = array(
			'#title' 				=> __('AFL Rank performance Overview'),
			'#description' 	=> 'affiliates rank performance overview '
		);
		//rank performance overview
		$permissions['afl_team_purchases_overview'] = array(
			'#title' 				=> __('AFL Team purchases Overview'),
			'#description' 	=> 'affiliates team purchases overview '
		);
		//user payment method configuration
		$permissions['user_payment_method_conf'] = array(
			'#title' 				=> __('AFL User payment method configuration'),
			'#description' 	=> 'user paymnet method configuration '
		);



		
		//system settings permissions
		$permissions['system_settings'] = array(
			'#title' 				=> __('EPS Affiliates System settings'),
			'#description' 	=> 'System settings permission'
		);
		//advanced config
		$permissions['advanced_configurations'] = array(
			'#title' 				=> __('Advanced System Configuration'),
			'#description' 	=> 'System advanced configurations'
		);
		//compensation plan
		$permissions['compensation_plan_configurations'] = array(
			'#title' 				=> __('AFL Compensation Plan Configuration'),
			'#description' 	=> 'Compensation plan configuration'
		);
		//set roles
		$permissions['afl_roles_configuration'] = array(
			'#title' 				=> __('AFL Roles configuration'),
			'#description' 	=> 'Configuration settings form for roles and permissions'
		);
		//rank configurations
		$permissions['system_rank_configurations'] = array(
			'#title' 				=> __('AFL system rank configurations'),
			'#description' 	=> 'affiliates system rank configurations '
		);
		//rank configurations
		$permissions['system_plan_configurations'] = array(
			'#title' 				=> __('AFL system Plan configurations'),
			'#description' 	=> 'affiliates system plan configurations '
		);
		//features and settings
		$permissions['features_and_configuration'] = array(
			'#title' 				=> __('AFL system Features and configurations'),
			'#description' 	=> 'affiliates system features and configurations '
		);
		


		//code testing
		$permissions['afl_code_testing'] = array(
			'#title' 				=> __('AFL Code testing'),
			'#description' 	=> 'affiliates system code testing '
		);
		
		return $permissions;
	}