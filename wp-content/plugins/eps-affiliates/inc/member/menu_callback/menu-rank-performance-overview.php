<?php

function afl_rank_performance_overview () {
	echo afl_eps_page_header();
	
	echo afl_content_wrapper_begin();
		afl_rank_occured_details();
		afl_rank_performance_overview_template();
	echo afl_content_wrapper_end();
}

function afl_rank_performance_overview_template () {
	$uid = afl_current_uid();
	if (isset($_GET['uid'])) {
		$uid = $_GET['uid'];
	}

	$table = array();
	$table['#name'] 			= '';
	$table['#title'] 			= 'Rank Advancement Overview';
	$table['#prefix'] 		= '';
	$table['#suffix'] 		= '';
	$table['#attributes'] = array(
					'class' => array(
							'table',
							'table-bordered',
							'my-table-center',

						)
					);

	$table['#header'] = array(
		__('Rank Name','affiliates-eps'), 
		__('PV','affiliates-eps'), 
		__('GV','affiliates-eps'), 
		__('Distributors','affiliates-eps'),
		__('Qualifications','affiliates-eps'),
		
	);
	$rows = array();
	
 	$max_rank = afl_variable_get('number_of_ranks');
 	for ($i = 1; $i <= $max_rank; $i++) {
 		
 		/* ------ Rank name --------------------------------------------------------------------*/
	 		$rows[$i]['label_1'] = array(
				'#type' => 'label',
				'#title'=> afl_variable_get('rank_'.$i.'_name', 'Rank '.$i),

			);
 		/* ------ Rank name --------------------------------------------------------------------*/
 		
 		
 		/* ------ User PV ----------------------------------------------------------------------*/
			$required = afl_variable_get('rank_'.$i.'_pv',0);
			$earned 	= _get_user_pv($uid); 

			$markup = '';
			$markup .= '<label class="label text-info m-l-xs">Required : '.$required.'</label><br>';
			$markup .= '<label class="label text-info m-l-xs">Earned : '.number_format($earned, 2, '.', ',').'</label><br>';
			if ($required <= $earned) {
				$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-up  text-success m-b-xs"></i></span>';
			} else {
				$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-down  text-danger m-b-xs"></i></span>';
			}

			$rows[$i]['markup_1'] = array(
				'#type' => 'markup',
				'#markup'=> $markup.$condition,
			);
 		
 		/* ------ User PV ----------------------------------------------------------------------*/


 		/* ------ User GV ----------------------------------------------------------------------*/
			$required = afl_variable_get('rank_'.$i.'_gv',0);
			$earned 	= _get_user_gv($uid); 
			// pr($earned);

			$markup = '';
			$markup .= '<label class="label text-info m-l-xs">Required : '.$required.'</label><br>';
			$markup .= '<label class="label text-info m-l-xs">Earned : '.number_format($earned, 2, '.', ',').'</label><br>';
			if ($required <= $earned) {
				$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-up  text-success m-b-xs"></i></span>';
			} else {
				$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-down  text-danger m-b-xs"></i></span>';
			}

			$rows[$i]['markup_2'] = array(
				'#type' => 'markup',
				'#markup'=> $markup.$condition,
			);
 		/* ------ User GV ----------------------------------------------------------------------*/

 		/* ------ No.of distributors -----------------------------------------------------------*/
			$required = afl_variable_get('rank_'.$i.'_no_of_distributors',0);
			$earned 	= _get_user_distributor_count($uid); 

			$markup = '';
			$markup .= '<label class="label text-info m-l-xs">Required : '.$required.'</label><br>';
			$markup .= '<label class="label text-info m-l-xs">Earned : '.$earned.'</label><br>';
			if ($required <= $earned) {
				$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-up  text-success m-b-xs"></i></span>';
			} else {
				$condition = '<span class="text-center"><i class="text-center fa fa-lg fa-thumbs-o-down  text-danger m-b-xs"></i></span>';
			}

			$rows[$i]['markup_3'] = array(
				'#type' => 'markup',
				'#markup'=> $markup.$condition,
			);
 		/* ------ No.of distributors -----------------------------------------------------------*/

 		/* ------ Rank qualifications ----------------------------------------------------------*/
 		$markup = '';
 		$below_rank = $i - 1;
		  if ($below_rank > 0 ) {
		  	for ($j = 1; $j <= $below_rank ; $j++) { 
		  		$required = afl_variable_get('rank_'.$i.'_rank_'.$j.'_required_count',0);
		  		// $in_each 	= afl_variable_get('rank_'.$i.'_rank_'.$j.'_required_each_leg',0);
		  		$in_leg_count = afl_variable_get('rank_'.$i.'_rank_'.$j.'_required_in_legs');

		  		if ($required && $in_leg_count) {
		  			$in_each_t = ($in_leg_count * $required).' '.afl_variable_get('rank_'.$j.'_name', 'Rank '.$j).'- from '.( $in_leg_count ).' legs';
		  			$count_all = FALSE;
		  		}

		  		if (empty($in_leg_count) && $required) {
		  			$in_each_t = ($required).' '.afl_variable_get('rank_'.$j.'_name', 'Rank '.$j).'- from any legs';
		  			$count_all = TRUE;

		  		}


		  		$downlines = afl_get_user_downlines_uid($uid, array('level'=>1), false);

          $condition_statuses  = array();
          $total_downlines 		 = ''; 
          //find the ranks ($i) of this downlines
          foreach ($downlines as $key => $value) {
            //get the downlines users downlines count having the rank $i
            $down_downlines_count = afl_get_user_downlines_uid($value->downline_user_id, array('member_rank'=>$j),TRUE);
            $total_downlines = $total_downlines + $down_downlines_count;
            /*
             * --------------------------------------------------
             * Get the downlines count of members having the rank
             * $i
             * check the downline count meets the required count 
             * in one leg
             * if it meets set status as 1
             * else set 0
             * --------------------------------------------------
            */
            if ( $down_downlines_count >= $required )
              $status = 1;
            else
              $status = 0;
            $condition_statuses[] = $status;
          }
           //count the occurence of 1 and 0
	         $occurence = array_count_values($condition_statuses);

	         if ( $count_all ) {
	         	if ( $required <= $total_downlines )
	         		$flag = 1;
	         	else 
	         		$flag = 0;
	         } else {
	         		if ( isset($occurence[1])  && $occurence[1] >= $in_leg_count )
	         		$flag = 1;
	         	else 
	         		$flag = 0;
	         }
		  		if ( $flag) {
						$condition = '<br><span class="text-center"><i class="text-center fa fa-lg fa-lg fa-thumbs-o-up text-success m-b-xs"></i></span>';
		  		} else {
						$condition = '<br><span class="text-center"><i class="text-center fa fa-lg fa-lg fa-thumbs-o-down text-danger m-b-xs"></i></span>';
		  		}

		  		// $in_each_t = '';
		  		// if ( $in_each ){
		  		// 	$in_each_t = '- in each leg';
		  		// } else {
		  		// 	$in_leg_count = afl_variable_get('rank_'.$i.'_rank_'.$j.'_required_in_legs');
		  		// 	if ( $in_leg_count ) {
		  		// 		$in_each_t = '- in '.$in_leg_count.' leg';
		  		// 	}
		  		// }
		  		if ($required) 
		  			$markup .= $in_each_t.$condition.'<br>';
		  	}
		  }
		 $rows[$i]['markup_4'] = array(
				'#type' => 'markup',
				'#markup'=> $markup,
			);
 		/* ------ Rank qualifications ----------------------------------------------------------*/

 	}
	$table['#rows'] = $rows;
	echo afl_render_table($table);
}

function afl_rank_occured_details () {
	$uid = get_uid();

	$table = array();
	$table['#name'] 			= '';
	$table['#title'] 			= 'Downlines Rank Occured Overview';
	$table['#prefix'] 		= '';
	$table['#suffix'] 		= '';
	$table['#attributes'] = array(
					'class' => array(
							'table',
							'table-bordered',
							'my-table-center',

						)
					);

	$table['#header'] = array(
		__('Downlines','affiliates-eps')
	);

	$max_ranks = afl_variable_get('number_of_ranks',0);
	for ($i = 1; $i <= $max_ranks; $i++) {
		$table['#header'][] = afl_variable_get('rank_'.$i.'_name', 'Rank '.$i);
	}

	$rows = array();

	$rows[0]['markup_0'] = array(
		'#type' =>'markup',
		'#markup'=>'Direct Legs'
	);

	$width = afl_variable_get('matrix_plan_width', 0);
	for ($i = 1; $i <= $width; $i++ ) {
		$rows[$i]['markup_1'] = array(
			'#type' =>'markup',
			'#markup'=>'Leg '.$i.' Downlines'
		);
	}
/* -------------------------- Get first level users occured ranks count -------------------------------*/

	//get the direct downlines ranks occured count
	$downline_uids = afl_get_user_downlines($uid, array('level'=>1), false);
	
	$downlines  = array();
  foreach ($downline_uids as $key => $value) {
    $downlines[$value->relative_position] = $value->downline_user_id;
  }
  // pr($downline_uids);
  $implodes = implode(',', $downlines);
  //check the ranks under this users
  $query = array();
  $query['#select'] = _table_name('afl_user_genealogy');
  $query['#fields'] = array(
  	_table_name('afl_user_genealogy') => array('member_rank')
  );
  $query['#expression'] = array(
  	'COUNT(`'._table_name('afl_user_genealogy').'`.`member_rank`) as count'
  );

  $query['#where'] = array(
    '`'._table_name('afl_user_genealogy').'`.`uid` IN ('.$implodes.')'
  );
  $query['#group_by'] = array(
  	'member_rank'
  );

  $result = array();
  if (!empty($downlines)) 
  	$result = db_select($query, 'get_results');

  // here get the first level users ranks
  $ranks_count = array();
  foreach ($result as $key => $value) {
  	$ranks_count[$value->member_rank] = $value->count;
  }

  //print the rank count
  for ($i = 1; $i <= $max_ranks; $i++) {
		$rows[0]['markup_0'.$i] = array(
			'#type' => 'markup',
			'#markup' => !empty($ranks_count[$i]) ? $ranks_count[$i] : '-'
		);
	}
/* -------------------------- Get first level users occured ranks count -------------------------------*/


/*---------------- Find the ranks occured under the downlines of first legs ---------------------------*/
 //get all doenlines under this users
	foreach ($downlines as $rel_pos => $value) {
		$query = array();
		$query['#select'] = _table_name('afl_user_downlines');
		$query['#fields'] = array(
		 	_table_name('afl_user_downlines') => array('member_rank')
		);
		$query['#expression'] = array(
		 	'COUNT(`'._table_name('afl_user_downlines').'`.`member_rank`) as count'
		);
		$query['#where'] = array(
		   '`'._table_name('afl_user_downlines').'`.`uid` = '.$value
		);
		$query['#group_by'] = array(
		 	'member_rank'
		);
	  $result = array();
  	$result = db_select($query, 'get_results');
	 	
	 	// here get the first level users ranks
	  $ranks_count = array();
	  foreach ($result as $key => $value) {
	  	$ranks_count[$value->member_rank] = $value->count;
	  }
	   //print the rank count
	  for ($i = 1; $i <= $max_ranks; $i++) {
			$rows[$rel_pos]['markup_1'.$i] = array(
				'#type' => 'markup',
				'#markup' => !empty($ranks_count[$i]) ? $ranks_count[$i] : '-'
			);
		}
	}
/*---------------- Find the ranks occured under the downlines of first legs ---------------------------*/
	$table['#rows'] = $rows;
	echo afl_render_table($table);

}