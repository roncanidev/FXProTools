<?php
/*
 * ----------------------------------------------------------------
 * Include common functionalities
 * ----------------------------------------------------------------
*/
class Eps_affiliates_common {
	/**
	 * --------------------------------------------------------------
	 * Eps_affiliates instance.
	 * --------------------------------------------------------------
	 *
	 * @access private
	 * @since  1.0
	 * @var    Eps_plan The one true Eps_plan
	 *
	*/
		private static $instance;

		public function __construct(){
			add_action( 'admin_enqueue_scripts', array($this,'_load_common_styles'));
			add_action( 'admin_enqueue_scripts', array($this,'_load_common_scritps'));
		}
	/*
 	 * ----------------------------------------------------------------
	 * Load Common scripts for plugin
 	 * ----------------------------------------------------------------
	*/
		public function _load_common_scritps() {
			wp_register_script( 'jquery-js',  EPSAFFILIATE_PLUGIN_ASSETS.'js/jquery.min.js');
			wp_enqueue_script( 'jquery-js' );

			wp_register_script( 'bootstrap-js',  EPSAFFILIATE_PLUGIN_ASSETS.'js/bootstrap.min.js');
			wp_enqueue_script( 'bootstrap-js' );

			wp_register_script( 'jquery-ui',  EPSAFFILIATE_PLUGIN_ASSETS.'plugins/jquery-ui/jquery-ui.min.js');
			wp_enqueue_script( 'jquery-ui' );

			wp_register_script( 'autocomplete-ui',  EPSAFFILIATE_PLUGIN_ASSETS.'js/jquery.autocomplete.min.js');
			wp_enqueue_script( 'autocomplete-ui' );

			wp_register_script( 'bootstrap-typehead-ui',  EPSAFFILIATE_PLUGIN_ASSETS.'js/bootstrap-typeahead.js');
			wp_enqueue_script( 'bootstrap-typehead-ui' );

			wp_register_script( 'common-js',  EPSAFFILIATE_PLUGIN_ASSETS.'js/common.js');
			wp_enqueue_script( 'common-js' );

			wp_register_script( 'widget-scripts',  EPSAFFILIATE_PLUGIN_ASSETS.'js/widget-scripts.js');
			wp_enqueue_script( 'widget-scripts' );

	    wp_localize_script( 'common-js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		}
	/*
 	 * ----------------------------------------------------------------
	 * Load Common styles for plugin
 	 * ----------------------------------------------------------------
	*/
		public function _load_common_styles() {
			wp_enqueue_style( 'fontawsome-css', EPSAFFILIATE_PLUGIN_ASSETS.'plugins/font-awesome-4.7.0/css/font-awesome.min.css');
			wp_enqueue_style( 'bootstrap-css', EPSAFFILIATE_PLUGIN_ASSETS.'css/bootstrap/css/bootstrap.css');
			wp_enqueue_style( 'jquery-ui', EPSAFFILIATE_PLUGIN_ASSETS.'plugins/jquery-ui/jquery-ui.min.css');

		}
}

$common_include = new Eps_affiliates_common();

/*
 * -------------------------------------------------------------------
 * Generate form based on the input array gives to it
 * -------------------------------------------------------------------
*/
	function afl_render_form($form = array()){
		$html 			= '';
		$elements 	= $form;
		$action 		= isset($elements['#action']) ? $elements['#action'] : '#';
		$method 		= isset($elements['#method']) ? $elements['#method'] : 'post';
		$name 			= isset($elements['#name']) 	? $elements['#name'] : '';
		$prefix 		= isset($elements['#prefix']) ? $elements['#prefix'] : '' ;
		$suffix 		= isset($elements['#suffix']) ? $elements['#suffix'] : '' ;
		$attributes = isset($elements['#attributes']) ? $elements['#attributes'] : array() ;
		$classes 		=	'';

		if (isset($attributes['class'])) {
			foreach ($attributes['class'] as $attr_class) {
				$classes .= $attr_class;
			}
		}

		unset($elements['#action']);
		unset($elements['#method']);
		unset($elements['#name']);
		unset($elements['#prefix']);
		unset($elements['#suffix']);
		unset($elements['#attributes']);

		if (!empty($prefix))
			$html .= $prefix;

		$html .= '<form action="' .$action. '"" method="'.$method.'" id="" accept-charset="UTF-8" class="'.$classes.'"> ';
		$html .= '<div class="panel panel-default">';
		$html .= '<div class="panel-body">';

			foreach ($elements as $key => $element) {

				//check the array is a multi dimention array,means the contents
				//comes under any fieldset or container
				if (count($element) != count($element, COUNT_RECURSIVE)) {
					//check the wrapper type
					$wrapper = $elements[$key];
					if (!empty($wrapper['#type']) && $wrapper['#type'] == 'fieldset') {
						$html .= '<fieldset class="form-wrapper" id="'.str_replace("_","-",$key).'">';
						if (!empty($wrapper['#title']))
								$html .= '<legend><span class="fieldset-legend">'.$wrapper['#title'].'</span></legend>';
						$html .= '<div class="fieldset-wrapper">';
						foreach ($elements[$key] as $key => $field_element) {
							$html .= html_input_render($field_element,$key,$attributes);
						}
					} else {
							$html .= html_input_render($element,$key,$attributes);
					}
				} else {

					$html .= html_input_render($element,$key,$attributes);
				}

			}
		$html .= '</div>';
		$html .= '</div>';

			if ($suffix)
				$html .= $suffix;
		return $html;
	}
/*
 * -------------------------------------------------------------------
 * Render Table
 * -------------------------------------------------------------------
*/
	function afl_render_table($table = array()) {
		$table_data = $table;
		$table_html = '';

		$name 			= isset($table_data['#name']) 			? $table_data['#name'] : '';
		$title 			= isset($table_data['#title']) 			? $table_data['#title'] : '';
		$prefix 		= isset($table_data['#prefix']) 		? $table_data['#prefix'] : '' ;
		$suffix 		= isset($table_data['#suffix']) 		? $table_data['#suffix'] : '' ;
		$attributes = isset($table_data['#attributes']) ? $table_data['#attributes'] : array() ;
		$header 		= isset($table_data['#header']) 		? $table_data['#header'] : array() ;
		$rows 			= isset($table_data['#rows']) 			? $table_data['#rows'] : array() ;
		$classes 		=	'';


		//add class if exist
		if (isset($attributes['class'])) {
			foreach ($attributes['class'] as $attr_class) {
				$classes .= ' '.$attr_class;
			}
		}
		//add prefix
		if (!empty($prefix))
			$table_html .= $prefix;
		//add title
		if ($title)
			$table_html .= $title;
		//table starts here
		//table responsive

		$table_html 	.= '<div class="table-responsive">';
		$table_html 	.= '<table class="table-striped '.$classes.'">';

		/* -----------table head :  Begin	----------*/
		$table_html 	.= '<thead>';
			if (!empty($header)) {
				$table_html .= '<tr>';
				foreach ($header as $head) {
					$table_html .= '<th>'.$head.'</th>';
				}
				$table_html .= '<tr>';
			}
		$table_html .= '</thead>';
		/* -----------table head :  End	----------*/

		/* -----------rendering rows :  Begin	----------*/
			if (!empty($rows)) {
				foreach ($rows as $key => $row) {
					$table_html .= '<tr>';
					if (is_array($row)) {
						foreach ($row as $key1 =>$element) {
							$table_html .= '<td>';
							$table_html .= html_input_render($element, $key1);
							$table_html .= '</td>';
						}
					}
					$table_html .= '<tr>';
				}
			}
		/* -----------rendering rows :  End	----------*/
		$table_html .= '</table>';
		$table_html .= '</div>';

		//append suffix
		if (isset($table['#suffix'])) {
			$table_html .= $table['#suffix'];
		}

		return $table_html;
	}
/*
 * -------------------------------------------------------------------
 * Render input elements
 * -------------------------------------------------------------------
*/
	function html_input_render($element, $key, $attributes = array()) {
		$element_type = '';
		$class 				= '';
			$attributes 	= isset($element['#attributes'])  ? $element['#attributes']: array();
		if (!empty($attributes['class'])) {
			foreach ($attributes['class'] as $attr_class) {
				$class .= ' '.$attr_class;
			}
		}

		$html 	= '';
		if (is_array($element)) {
			if (isset($element['#type'])) {
				$element_type = $element['#type'];
			}
		}
		//append prefix
		if (isset($element['#prefix'])) {
			$html .= $element['#prefix'];
		}
		$description = isset($element['#description']) ? $element['#description'] : '';

		if ( !empty($element_type) ) :

			$html .= '<div class="form-group row" data-toggle="tooltip" data-placement="top" title="'.$description.'">';

			switch ($element_type) {
				case 'text':
					$deflt = isset($element['#default_value']) ? $element['#default_value'] : '';
					if (isset($element['#title']) && !empty($element['#title'])) :
						$html .= '<label for="'.str_replace('_','-',$key).'" class="form-label">';
						$html .= isset($element['#title']) ? $element['#title'] : '';

						if (!empty($element['#required']) && $element['#required'] == TRUE ){
							$html .= '<span class="form-required" title="This field is required.">*</span>';
						}
						$html .= '</label>';
					endif;

					$html .= '<input type = "text" name = "'.$key.'" id="'.str_replace('_','-',$key).'" class="form-control '.$class.'" value="'.$deflt.'">';

				break;

				case 'password':
					$deflt = isset($element['#default_value']) ? $element['#default_value'] : '';
					$html .= '<label for="'.str_replace('_','-',$key).'" class="form-label">';
					$html .= isset($element['#title']) ? $element['#title'] : '';

					if (!empty($element['#required']) && $element['#required'] == TRUE){
						$html .= '<span class="form-required" title="This field is required.">*</span>';
					}

					$html .= '</label>';
					// $html .= '<div class="col-md-10">';
					$html .= '<input type = "password" name = "'.$key.'" id="'.str_replace('_','-',$key).'" class="form-control '.$class.'" value="'.$deflt.'">';
					// $html .= '</div>';
				break;
				case 'checkbox':

					$checked = (!empty($element['#default_value']) && isset($element['#default_value'])) ? TRUE : FALSE ;

					// if ($checked) {
					// 	$html .= '<input type = "checkbox" name = "'.$key.'" id="'.str_replace('_','-',$key).'" class="form-control '.$class.'" checked="'.$checked.'" >';
					// }else {
					// 	$html .= '<input type = "checkbox" name = "'.$key.'" id="'.str_replace('_','-',$key).'" class="form-control '.$class.'">';
					// }
					// $html .= '<label for="'.str_replace('_','-',$key).'">';
					// $html .= isset($element['#title']) ? $element['#title'] : '';
					// $html .= '</label>';

					$html .= '<div class="form-item clearfix form-type-checkbox ">';

					$html .='<label class="i-checks">';

					if ($checked) {
						$html .= '<input type = "checkbox" name = "'.$key.'" id="'.str_replace('_','-',$key).'" class="form-checkbox checkbox form-control '.$class.'" checked="'.$checked.'" >';
					}else {
						$html .= '<input type = "checkbox" name = "'.$key.'" id="'.str_replace('_','-',$key).'" class="form-checkbox checkbox form-control '.$class.'">';
					}
					$html .= '<i></i></label>';
					$html .= '<label class="option" for="'.str_replace('_','-',$key).'">';
					$html .= isset($element['#title']) ? $element['#title'] : '';

					if (!empty($element['#required']) && $element['#required'] == TRUE ){
						$html .= '<span class="form-required" title="This field is required.">*</span>';
					}

					$html .= '</label>';

					$html .= '</div>';


				break;
				case 'markup':
					$html .= '<div class="'.$class.'">'.$element['#markup'].'</div>';
				break;
				case 'submit':
					$html .= '<input type="submit" class=" btn btn-primary '.$class.'" value="'.$element['#value'].'" name="submit">';
				break;
				case 'label':
					$html .= '<label class="label-style '.$class.'">'.$element['#title'].'</label>';
					$html .= '<br><small>'.$description.'</small>';
				break;

				case 'select';

					$html .= '<label class="option" for="'.str_replace('_','-',$key).'">';
					$html .= isset($element['#title']) ? $element['#title'] : '';

					if (!empty($element['#required']) && $element['#required'] == TRUE ){
						$html .= '<span class="form-required" title="This field is required.">*</span>';
					}

					$html .= '</label>';
					$html .= '<select class="form-control '.$class.'" name="'.$key.'" >';
					if (!empty($element['#options'])) {
						foreach ($element['#options'] as $data => $value) {

								if(isset($element['#default_value']) && $element['#default_value'] == $data)
									$html .= '<option selected value='.$data .'>'.$value.'</option>';
								else
							 		$html .= '<option value='.$data. '>'.$value.'</option>';
						}
					}
					$html .= '</select>';
				break;
				case 'date_time':
					$deflt = isset($element['#default_value']) ? $element['#default_value'] : '';
					$html .= '<label for="'.str_replace('_','-',$key).'">';
					$html .= isset($element['#title']) ? $element['#title'] : '';
					$html .= '</label>';
					$html .= '<input type = "text" name = "'.$key.'" id="'.str_replace('_','-',$key).'" class=" date_time_picker '.$class.'" value="'.$deflt.'">';
				break;
				case 'auto_complete':
					$path  = isset($element['#auto_complete_path']) ? $element['#auto_complete_path'] : '#';
					$deflt = isset($element['#default_value']) ? $element['#default_value'] : '';
					$html .= '<label for="'.str_replace('_','-',$key).'" class="">';
					$html .= isset($element['#title']) ? $element['#title'] : '';
					$html .= '</label>';
					// $html .= '<div class="col-md-10">';
					$html .= '<input type = "text" name = "'.$key.'" id="'.str_replace('_','-',$key).'" class="form-control auto_complete '.$class.'" value="'.$deflt.'" data-path="'.$path.'" autocomplete="off" >';
					// $html .= '</div>';
				break;
				case 'link':
					$link = !empty($element['#link']) ? $element['#link'] : '#';
					$html .= '<a href="'.$link.'">';
					if (!empty($element['#icon']) && $element['#icon'] == TRUE) {
						$html .= '';
					}
					$html .= '</a>';
				break;

				case 'text-area':
					$html .= '<label for="'.str_replace('_','-',$key).'">';
					$html .= isset($element['#title']) ? $element['#title'] : '';

					if (!empty($element['#required']) && $element['#required'] == TRUE ){
						$html .= '<span class="form-required" title="This field is required.">*</span>';
					}
					$html .= '</label>';
					$html .= '<div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">';
					$cols = isset($element['#cols']) ? $element['#cols'] : 10;
					$rows = isset($element['#rows']) ? $element['#rows'] : 5;

					$html .= '<textarea id="'.str_replace('_','-',$key).'" name="'.$key.'" cols="'.$cols.'" rows="'.$rows.'" class="form-textarea form-control '.$class.'">';
					if ( isset($element['#default_value']))
						$html .= $element['#default_value'];

					$html .= '</textarea>';
					$html .= '</div>';
				break;
				case 'radio':
					$checked = (!empty($element['#default_value']) && isset($element['#default_value'])) ? TRUE : FALSE ;
					$html .= isset($element['#title']) ? $element['#title'] : '';
					if (!empty($element['#required']) && $element['#required'] == TRUE ){
						$html .= '<span class="form-required" title="This field is required.">*</span>';
					}
					$html .= '<div class="form-item clearfix form-type-radio radio">';
					foreach ($element['#options'] as $data => $value) {
						$html .= '<label class="i-checks">';
						if(isset($element['#default_value']) && $element['#default_value'] == $data){
							$html .= '<input type ="radio" checked id = "" name ='.$element['#name'].' value ='.$data.' class ="form-radio radio ">';
						}else{
							$html .= '<input type ="radio" id = "" name ='.$element['#name'].' value ='.$data.' class ="form-radio radio ">';
						}
					$html .= '<i></i></label>'.$value;
					}
					$html .= '</div>';
					break;
			}

			$html .= '</div>';

		endif;

		//append suffix
		if (isset($element['#suffix'])) {
			$html .= $element['#suffix'];
		}

		return $html;
	}
/*
 * ----------------------------------------------------------------------------------
 * Open a form tag
 * ----------------------------------------------------------------------------------
*/
	function afl_form_open($action = '',$method='GET', $attributes = array()){
		$html_tag_form = '';
		$cls 			=  isset($attributes['class']) ? $attributes['class'] : '';
		$id 			=  isset($attributes['id']) ? $attributes['id'] : '';

		$html_tag_form .= '<form action="'.$action.'" class="'.$cls.'" id="'.$id.'" method="'.$method.'">';

		return $html_tag_form;
	}
/*
 * ----------------------------------------------------------------------------------
 * Close a form tag
 * ----------------------------------------------------------------------------------
*/
	function afl_form_close(){
		return '</form>';
	}
/*
 * ----------------------------------------------------------------------------------
 * Create submit button
 * ----------------------------------------------------------------------------------
*/
	function afl_input_button($type = '',$value = 'Submit',$name = 'submit',$attributes = array()){
		$html_tag_button = '';
		$cls 			=  isset($attributes['class']) ? $attributes['class'] : '';
		$id 			=  isset($attributes['id']) ? $attributes['id'] : '';

		$html_tag_button = '<button type="'.$type.'" class="'.$cls.'" id="'.$id.'">'.$value.'</button>';
		if ($type= 'submit') {
			$html_tag_button = '<input type="submit" class="'.$cls.'" name="submit" value="'.$value.'" id="'.$id.'"/>';
		}

		return $html_tag_button;

	}
/*
 * ----------------------------------------------------------------------------------
 * AFL variable set
 * ----------------------------------------------------------------------------------
*/
	if(!function_exists('afl_variable_set')){
		function afl_variable_set($name = '', $value = '',$afl_merchant_id ='', $afl_project_name = '' ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'afl_variable';
		  $query 		= 'SELECT * FROM '.$table_name.' WHERE name = %s';
		  $row 			= $wpdb->get_row(
	                    $wpdb->prepare($query,$name)
	                 );
		  //if name already exist update, else insert
			if (!empty($row)){
				$wpdb->update(
						$table_name,
						array(
							'value' => maybe_serialize($value)
						),
						array('name' => $name)
					);
			} else {
				$wpdb->insert(
						$table_name,
						array(
							'name'	=> $name,
							'value' => maybe_serialize($value)
						)
					);
			}
	  }
	}
/*
 * ----------------------------------------------------------------------------------
 * AFL variable get
 * ----------------------------------------------------------------------------------
*/
	if(!function_exists('afl_variable_get')){
		function afl_variable_get($name = '', $default = '',$afl_merchant_id ='', $afl_project_name = '') {
			global $wpdb;
			$table_name = $wpdb->prefix . 'afl_variable';
		  $query 		= 'SELECT * FROM '.$table_name.' WHERE name = %s';
		  $row 			= $wpdb->get_row(
	                    $wpdb->prepare($query,$name)
	                 );
			if (!empty($row))
				return maybe_unserialize($row->value);
			else
				return $default;
		}
	}

/*
 * ----------------------------------------------------------------------------------
 * AFL date
 * ----------------------------------------------------------------------------------
*/
	if(!function_exists('afl_date')){
		function afl_date(){
		  $afl_testing_date = current_time('timestamp');
		  $afl_enable_test_mode = afl_variable_get('afl_enable_test_mode', FALSE);
		  $afl_enable_test_date = afl_variable_get('afl_enable_test_date', FALSE);

		  if($afl_enable_test_mode && $afl_enable_test_date){
		    $afl_testing_date = strtotime(afl_variable_get('afl_testing_date_date'));
		  }
		  return $afl_testing_date;
		}
	}
/*
 * ----------------------------------------------------------------------------------
 * AFL date splits
 * ----------------------------------------------------------------------------------
*/
	if(!function_exists('afl_date_splits')){
		function afl_date_splits($rdate, $duration = ''){
		  $date_splits = array();
		  if(! $rdate){
		    $rdate = afl_date();
		  }
		  if($duration != ''){
		    $new_date = strtotime($duration, $rdate);
		    $date_splits['y'] = date('Y', $new_date);
		    $date_splits['m'] =  date('m', $new_date);
		    $date_splits['d'] = date('d', $new_date);
		    $date_splits['w'] = date('W', $new_date);
		    $date_splits['D'] = date('D', $new_date);
		  }else{
		    $date_splits['y'] = date('Y', $rdate);
		    $date_splits['m'] = date('m', $rdate);
		    $date_splits['d'] = date('d', $rdate);
		    $date_splits['w'] = date('W', $rdate);
		    $date_splits['D'] = date('D', $rdate);
		  }
		  return $date_splits;

		}
	}
/*
 * ----------------------------------------------------------------------------------
 * AFL Combine dates
 * ----------------------------------------------------------------------------------
*/
	if(!function_exists('afl_date_combined')){
		function afl_date_combined($date_splits){
		  return $date_splits['y'].'/'.$date_splits['m'].'/'.$date_splits['d'];
		}
	}

/*
 * ----------------------------------------------------------------------------------
 * AFL get level
 * ----------------------------------------------------------------------------------
*/

if(!function_exists('afl_get_levels')){
	function afl_get_levels($limit = -1){
	  $normal_limit = 16;
	  $levels = array();
	  if($limit > $normal_limit){
	    $normal_limit = $limit;
	  }
	  $levels = range( 1 , $normal_limit , 1);


	  $levels = array_combine($levels, $levels);
	  return $levels;
	}
}
/*
 * -----------------------------------------------------------
 * Wordpress set messages
 * -----------------------------------------------------------
*/
	function wp_set_message($msg = '', $action = 'success'){
		if ($action == 'error')
			$action = 'danger';
		$alert = '';
		$alert .= '<div class="alert alert-'.$action.'" role="alert">';
	  $alert .= $msg;
		$alert .='</div>';

		return $alert;
	}
/**
 * -----------------------------------------------------------
 * Get user data
 * -----------------------------------------------------------
 * @param $uid : user id
 *
*/
	function afl_user_data($uid = ''){
		require_once ABSPATH . 'wp-includes/pluggable.php';

		if ($uid == '') {
			$uid = get_current_user_id();
		}

		$user = get_userdata($uid);

		return $user->data;
	}
/**
 * -----------------------------------------------------------
 * Get current user id
 * -----------------------------------------------------------
 *
 *
*/
	function afl_current_uid(){

		require_once ABSPATH . 'wp-includes/pluggable.php';

		$uid = get_current_user_id();

		return $uid;
	}
/**
 * -----------------------------------------------------------
 * Get user roles
 * -----------------------------------------------------------
 * @param $uid : user id
 *
*/
	function afl_user_roles($uid = ''){

		require_once ABSPATH . 'wp-includes/pluggable.php';

		if ($uid == '') {
			$uid = get_current_user_id();
		}

		$user = get_userdata($uid);
		$wp_roles = new WP_Roles;
    $names    = $wp_roles->get_names();
    $out      = array ();

    foreach ( $user->roles as $role )
    {
        if ( isset ( $names[ $role ] ) )
            $out[ $role ] = $names[ $role ];
    }

    return $out;
	}


/**
 * ------------------------------------------------------------------------------
 * Locate template.
 * ------------------------------------------------------------------------------
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/woocommerce-plugin-templates/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/woocommerce-plugin-templates/templates/$template_name.
 *
 * ------------------------------------------------------------------------------
 * @since 1.0
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 * ------------------------------------------------------------------------------
 */
	function afl_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		// Set variable to search in woocommerce-plugin-templates folder of theme.
		if ( ! $template_path ) :
			$template_path = 'woocommerce-plugin-templates/';
		endif;
		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = EPSAFFILIATE_PLUGIN_DIR . 'inc/templates/'; // Path to the template folder
		endif;
		// Search template file in theme folder.
		$template = locate_template( array(
			$template_path . $template_name,
			$template_name
		) );
		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;
		return apply_filters( 'afl_locate_template', $template, $template_name, $template_path, $default_path );
	}

/**
 * ------------------------------------------------------------------------------
 * Get template.
 * ------------------------------------------------------------------------------
 *
 * Search for the template and include the file.
 * ------------------------------------------------------------------------------
 *
 * @since 1.0
 *
 * @see afl_locate_template()
 *
 * @param string 	$template_name			Template to load.
 * @param array 	$args					Args passed for the template file.
 * @param string 	$string $template_path	Path to templates.
 * @param string	$default_path			Default path to template files.
 * ------------------------------------------------------------------------------
 */
	function afl_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args );
		endif;

		$template_file = afl_locate_template( $template_name, $tempate_path, $default_path );
		if ( ! file_exists( $template_file ) ) :
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
			return;
		endif;
		include $template_file;
	}
/**
 * ------------------------------------------------------------------------------
 * Render the admin dashboard
 * ------------------------------------------------------------------------------
*/
	function afl_eps_afiliate_dashboard_shortcode(){
			return afl_get_template( 'eps-affiliate-dashboard.php' );
	}
/**
 * ------------------------------------------------------------------------------
 * Create new widget
 * ------------------------------------------------------------------------------
*/
	function eps_affiliates_dashboard_menu_widget() {
		register_sidebar( array(
			'name'          => __( 'AFL Dashboard widget', 'AFL Dashboard widget' ),
			'id'            => 'afl-dashboard-menus',
			'description'   => __( 'Add the widget here that will display in the admin', 'AFL Dashboard widget' ),
		) );
	}

/**
 * ------------------------------------------------------------------------------
 * Render left side dropdown menu
 * ------------------------------------------------------------------------------
*/
	function render_dropdown_menu ($menu = array()) {
		$html_tag 	= '';
		$prefix 	 	= isset($menu['#prefix']) 		? $menu['#prefix'] : '';
		$suffix 	 	= isset($menu['#suffix']) 		? $menu['#suffix'] : '';
		$attributes	= isset($menu['#attributes']) ? $menu['#attributes'] : '';
		$class 			=	'';

		if (!empty($attributes['class'])) {
			foreach ($attributes['class'] as $attr_class) {
				$class .= ' '.$attr_class;
			}
		}

		unset($menu['#prefix']);
		unset($menu['#suffix']);

		$html_tag .= '<nav class="navbar navbar-default " role="navigation">';
		$html_tag .= '<ul class="nav navbar-nav menu-dropdown-ul '.$class.'">';

		if (!empty($menu)) {

			foreach ($menu as $key => $element) {
				if (!empty($element['#childrens']) ){
					$html_tag .= '<li class="panel panel-default" id="dropdown">';
					$html_tag .= '<a data-toggle="collapse" href="#dropdown-lvl1">';
					$html_tag .= isset($element['#icon']) ? $element['#icon'] : '';
					$html_tag .= isset($element['#title']) ? $element['#title'] : '';
					$html_tag .= '<span class="caret"></span>';
					$html_tag .= '</a>';
					$html_tag .= '<div id="dropdown-lvl1" class="panel-collapse collapse">';
					$html_tag .= '<div class="panel-body">';
					$html_tag .= '<ul class="nav navbar-nav">';

					foreach ($element['#childrens'] as $submenu_key => $submenu) :
						$subattributes	= isset($submenu['#attributes']) ? $submenu['#attributes'] : '';
						$submenu_cls 		= '';
						if (!empty($subattributes['class'])) {
							foreach ($subattributes['class'] as $attr_class) {
								$submenu_cls .= ' '.$attr_class;
							}
						}
						$link 		 = '#';
						if ($submenu['#link'])
							$link = $submenu['#link'];
						$html_tag .= '<li class="'.$submenu_cls.'">';
						$html_tag .= '<a href="'.$link.'">';
						$html_tag .= isset($submenu['#icon']) ? $submenu['#icon'] : '';
						$html_tag .= isset($submenu['#title']) ? $submenu['#title'] : '';
						$html_tag .= '</a>';
						$html_tag .= '</li>';
					endforeach;

					$html_tag .= '</ul>';
					$html_tag .= '</div>';
					$html_tag .= '</div>';
					$html_tag .= '</li>';
				}else{
					$link 		 = '#';
					if ($submenu['#link'])
						$link = $submenu['#link'];

					$html_tag .= '<li>';
					$html_tag .= '<a href="'.$link.'">';
					$html_tag .= isset($element['#icon']) ? $element['#icon'] : '';
					$html_tag .= isset($element['#title']) ? $element['#title'] : '';
					$html_tag .= '</a>';
					$html_tag .= '</li>';
				}

			}
		}
		$html_tag .= '</ui>';
		$html_tag .= '</nav>';
		return $html_tag;
	}

/**
 * ------------------------------------------------------------------------------
 * Get all commision periods
 * ------------------------------------------------------------------------------
*/
if(!function_exists('afl_get_periods')){
	function afl_get_periods(){
	  $periods['dialy'] = "Dialy";
	  $periods['Weekly'] = "Weekly";
    $periods['monthly'] = "Monthly";
    $periods['yearly'] = "Yearly";
    $periods['instant'] = "Instant";

	  return $periods;
	}
}


/**
 * ------------------------------------------------------------------------------
 * Get Rank names
 * ------------------------------------------------------------------------------
*/
if(!function_exists('afl_get_rank_names')){
	function afl_get_rank_names($count=0,$limit=TRUE){
		if($limit != TRUE){
			return afl_variable_get('rank_'.$count.'_name');
		}
		if($count==0){
		$count = afl_variable_get('number_of_ranks');}
			$rank_name = array();
			for ($i=1; $i <= $count ; $i++) {
				$rank_name['rank_'.$i.'_name'] = afl_variable_get('rank_'.$i.'_name');
			}
			return $rank_name;
		}

}

/*
 * ------------------------------------------------------------------------------
 * Set the capability
 * ------------------------------------------------------------------------------
*/
 	function add_permission ($permission = '',$role = '') {
		global $wp_roles;
		if ( class_exists('WP_Roles') ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}
		if ( is_object( $wp_roles ) ) {
			$wp_roles->add_cap($role,$permission );
		}
 	}
/*
 * ------------------------------------------------------------------------------
 * Remove the capability
 * ------------------------------------------------------------------------------
*/
 function remove_permission ( $permission = '',$role = '') {
 		global $wp_roles;
		if ( class_exists('WP_Roles') ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}
		if ( is_object( $wp_roles ) ) {
			$wp_roles->remove_cap( $role, $permission );
		}
 }
/*
 * ------------------------------------------------------------------------------
 * Has the capability
 * ------------------------------------------------------------------------------
*/
 function has_permission ($permission = '',$role = '', $uid = '') {
 	//get permissions of role
 	$role_permissions = get_role($role)->capabilities;
 	//check the given permission  name exist or not
 	if (!empty($role_permissions)) {
	 	if (array_key_exists($permission, $role_permissions)) {
	 		return TRUE;
	 	}
 	}

 	return FALSE;

 }

/*
 * ------------------------------------------------------------------------------
 * Replace the admin side menus icons custom
 * ------------------------------------------------------------------------------
*/
	function replace_afl_eps_custom_pages_icons() {
		echo afl_get_template( 'eps-change-menu-icons.php' );
	}
/*
 * ------------------------------------------------------------------------------
 * Function that create admin menu/ admin sub menu
 * ------------------------------------------------------------------------------
*/
	function afl_system_admin_menu ($menus_array = array()){
		if (!empty($menus_array)) {
			foreach ($menus_array as $key => $menu) {
				$page_title 		= isset($menu['#page_title']) 		? $menu['#page_title'] : '';
				$menu_title 		= isset($menu['#menu_title']) 		? $menu['#menu_title'] : '';
				$capability 		= isset($menu['#access_callback'])? $menu['#access_callback'] : '';
				$menu_slug			= isset($menu['#menu_slug']) 			? $menu['#menu_slug'] : '';
				$page_callback	= isset($menu['#page_callback']) 	? $menu['#page_callback'] : '';
				$icon_url 			= isset($menu['#icon_url']) 			? $menu['#icon_url'] : '';
				$parent 				= isset($menu['#parent']) 				? $menu['#parent'] : '';
				$weight 				= isset($menu['#weight']) 				? $menu['#weight'] : null;


				//Single menu page
				if (empty($parent)) {
					add_menu_page(
						$page_title,
						$menu_title,
						$capability,
						$menu_slug,
						$page_callback,
						$icon_url,
						$weight
						);
				//submenu
				} else {
					add_submenu_page(
						$parent,
						$page_title,
						$menu_title,
						$capability,
						$menu_slug,
						$page_callback,
						$icon_url,
						$weight
					);
				}
			}
		}
	}
/*
 * ------------------------------------------------------------------------------
 * Forms field validations
 * ------------------------------------------------------------------------------
 *
 * Here gets an array and the $rule array contains
 *  1 - value
 *  2 - array(validation rules)
 *
*/
 function set_form_validation_rule ($rules = array()) {
 		global $reg_errors;
		$reg_errors = new WP_Error;

 		$validation_response = '';
		require_once EPSAFFILIATE_PLUGIN_DIR . 'inc/eps-form-validation-rules.php';
			if (class_exists('Form_validation_rules')) {
				$rule_object = new Form_validation_rules;
				foreach ($rules as $rule) {
					$value 						= $rule['value'];
					$name 						= $rule['name'];
					$field 						= !empty($rule['field']) ?$rule['field'] : '';
					$validation_rules = $rule['rules'];
					foreach ($validation_rules as  $rule_function) {
						if (method_exists($rule_object, $rule_function)) {
							//here calls the rule function
							$response = $rule_object->$rule_function($name, $value, $field);

							if (!empty($response)) {
								if ($response['status'] != 1) {
									$reg_errors->add($name, $response['message']);
									$validation_response .= '<p> * '.$response['message'].'</p>';
								}
							}
						}
					}
			}
		}
		if ( is_wp_error( $reg_errors ) ) {
			$wp_error = '';
	    foreach ( $reg_errors->get_error_messages() as $error ) {
	    	$wp_error .= '<p>* '.$error.'</p>';
	    }
	    if (!empty($wp_error))
	   		return wp_set_message($wp_error,'danger');
		}
 }
/*
 * ------------------------------------------------------------------------------
 * Get all user name and id from db
 * ------------------------------------------------------------------------------
*/
	function afl_get_users(){
		global $wpdb;
		$querystr = " SELECT * from wp_users;";
		$result = $wpdb->get_results($querystr) or die(mysql_error());

		return $result;
	}
/*
 * -----------------------------------------------------------------------------
 * Main content Wrapper
 * -----------------------------------------------------------------------------
*/
 function afl_content_wrapper_begin (){
 	echo '<div class="wrapper-md">';
 }
/*
 * -----------------------------------------------------------------------------
 * Main content Wrapper End
 * -----------------------------------------------------------------------------
*/
 function afl_content_wrapper_end (){
 	echo '</div>';
 }
/*
 * -----------------------------------------------------------------------------
 * get the downlines details of uid
 * -----------------------------------------------------------------------------
*/
	function afl_get_user_downlines ($uid = '3', $filter = array(), $count = false){
		global $wpdb;

		$query = array();
		$query['#select'] = _table_name('afl_user_downlines');

		$query['#join'] 	= array(
			_table_name('users') => array(
				'#condition' => '`'._table_name('users').'`.`ID`=`'._table_name('afl_user_downlines').'`.`downline_user_id`'
			),
			_table_name('afl_user_genealogy') => array(
				'#condition' => '`'._table_name('afl_user_genealogy').'`.`uid`=`'._table_name('afl_user_downlines').'`.`downline_user_id`'
			)
		);

		$query['#where'] = array(
			'`'._table_name('afl_user_downlines').'`.`uid`='.$uid.''
		);

		$query['#order_by'] = array(
			'`'._table_name('afl_user_downlines').'`.`level`' => 'ASC'
		);

		$limit = '';
		if (isset($filter['start']) && isset($filter['length'])) {
			$limit .= $filter['start'].','.$filter['length'];
		}

		if (!empty($limit)) {
			$query['#limit'] = $limit;
		}

		if (!empty($filter['search_valu'])) {
			$query['#like'] = array('`display_name`' => $filter['search_valu']);
		}

		$result = db_select($query, 'get_results');

		// pr($result = db_select($query, 'get_results'),1);
		if ($count)
			return count($result);
		return $result;
	}
/*
 * -----------------------------------------------------------------------------
 * get the downlines uid details of uid
 * -----------------------------------------------------------------------------
*/
	function afl_get_user_downlines_uid ($uid = '3', $filter = array(), $count = false){
		global $wpdb;

		$query = array();
		$query['#select'] = 'wp_afl_user_downlines';

		$query['#join'] 	= array(
			'wp_users' => array(
				'#condition' => '`wp_users`.`ID`=`wp_afl_user_downlines`.`downline_user_id`'
			)
		);
		$query['#fields'] = array(
			'wp_afl_user_downlines' => array('downline_user_id')
		);
		$query['#where'] = array(
			'`wp_afl_user_downlines`.`uid`='.$uid.''
		);

		$query['#order_by'] = array(
			'`level`' => 'ASC'
		);

		$limit = '';
		if (isset($filter['start']) && isset($filter['length'])) {
			$limit .= $filter['start'].','.$filter['length'];
		}

		if (!empty($limit)) {
			$query['#limit'] = $limit;
		}

		if (!empty($filter['search_valu'])) {
			$query['#like'] = array('`display_name`' => $filter['search_valu']);
		}
		$result = db_select($query, 'get_results');

		// pr($result = db_select($query, 'get_results'),1);
		if ($count)
			return count($result);
		return $result;
	}
	/*
	 * -----------------------------------------------------------------------------
	 * get the downlines uid details of sponsor
	 * -----------------------------------------------------------------------------
	*/
		function afl_get_sponsor_downlines_uid ($sponsor_uid = '', $filter = array(), $count = false){
			global $wpdb;

			$query = array();
			$query['#select'] = _table_name('afl_user_genealogy');

			$query['#fields'] = array(
				_table_name('afl_user_genealogy') => array('uid')
			);
			$query['#where'] = array(
				'`'._table_name('afl_user_genealogy').'`.`referrer_uid`='.$sponsor_uid.''
			);

			$query['#order_by'] = array(
				'`level`' => 'ASC'
			);
			$result = db_select($query, 'get_results');

			// pr($result = db_select($query, 'get_results'),1);
			if ($count)
				return count($result);
			return $result;
		}
/*
 * -----------------------------------------------------------------------------
 * get the downlines details of uid
 * -----------------------------------------------------------------------------
*/
	function afl_get_direct_user_downlines ($uid = '3', $filter = array(), $count = false){
		global $wpdb;

		$query = array();
		$query['#select'] = 'wp_afl_user_downlines';

		$query['#join'] 	= array(
			'wp_users' => array(
				'#condition' => '`wp_users`.`ID`=`wp_afl_user_downlines`.`downline_user_id`'
			)
		);

		$query['#where'] = array(
			'`wp_afl_user_downlines`.`uid`='.$uid.'',
			'`wp_afl_user_downlines`.`level`=1',
		);

		$query['#order_by'] = array(
			'`level`' => 'ASC'
		);

		$limit = '';
		if (isset($filter['start']) && isset($filter['length'])) {
			$limit .= $filter['start'].','.$filter['length'];
		}

		if (!empty($limit)) {
			$query['#limit'] = $limit;
		}

		if (!empty($filter['search_valu'])) {
			$query['#like'] = array('`display_name`' => $filter['search_valu']);
		}
		$result = db_select($query, 'get_results');

		// pr($result = db_select($query, 'get_results'),1);
		if ($count)
			return count($result);
		return $result;
	}
/*
 * -----------------------------------------------------------------------
 * Database select query
 * -----------------------------------------------------------------------
*/
	function db_select($data = array(), $fetch_mode = '') {
		global $wpdb;
		$sql = '';
		$alias = isset($data['#alias']) ? $data['#alias'] : '';
		$fields = '';
		if (isset($data['#fields'])) {
			foreach ($data['#fields'] as $key => $value) {
				foreach ($value as $field) {
					if (!empty($fields))
						$fields .= ',`'.$key.'`.`'.$field.'`';
					else
						$fields .= '`'.$key.'`.`'.$field.'`';
				}
			}
		}
		$fields = !empty($fields) ? $fields : '*';

		//expressions
		$expression = '';
		if (isset($data['#expression'])) {
			foreach ($data['#expression'] as $value) {
				$expression = empty($expression) ? $value : ','.$value;
			}
		}

		$fields = (!empty($expression)) ? $fields.','.$expression : $fields;

		//select from
		if ($data['#select'] && empty($alias)){
			$sql .= 'SELECT '.$fields.' FROM `'.$data['#select'].'` ';
		} else if ($data['#select'] && !empty($alias)) {
			$sql .= 'SELECT '.$fields.' as '.$alias.' FROM `'.$data['#select'].'` ';
		}
		//join
		if (isset($data['#join']) ){
			foreach ($data['#join'] as $table => $value) {
					$sql .= 'JOIN `'.$table.'`'.'ON '.$value['#condition'].' ';
			}
		}
		//where condition
		$where_flag 	= 0;
		if (isset($data['#where'])) {
			$where_flag = 1;

			$where = 'WHERE ';
			if (count($data['#where']) > 1 ){
				$where .= $data['#where'][0];
				$sql 	 .= $where;
				foreach ($data['#where'] as $condition) {
					$sql .= ' AND '.$condition.' ';
				}
			} else {
				foreach ($data['#where'] as $condition) {
					$sql .= 'WHERE '.$condition.' ';
				}
			}
		}

		//where in
		$where_in = '';
		if (isset($data['#where_in'])) {
			foreach ($data['#where_in'] as $key => $value) {
		 		$val = implode(',', $value);
		 		if (empty($val) ) {
		 			return array();
		 		}
		 		$where_in .='`'.$key.'` IN ('.$val.')';
		 	}
		}

		if (!empty($where_in) ){
			if (!$where_flag) {
				$sql .= 'WHERE '.$where_in;
				$where_flag = 1;
			} else {
				$sql .= 'AND '.$where_in;
			}
		}

		//like
		if(isset($data['#like'])){

			if (!$where_flag) {
				$sql .= 'WHERE ';
			}
			//check multiple like cluase exists
			$count = count($data['#like']);
			if ( $count == 1) {
				foreach ($data['#like'] as $key => $value) {
					$sql .= $key.' LIKE "%'.$value.'%"'.' ';
				}
			}
		}




		//order by
		if (isset($data['#order_by'])) {
			foreach ($data['#order_by'] as $key => $order) {
				$sql .= 'ORDER BY '.$key.' '.$order.' ';
			}
		}

		//limit
		if (isset($data['#limit'])) {
				$sql .= 'LIMIT '.$data['#limit'].' ';
		}

		return $wpdb->$fetch_mode($sql);
	}
/*
 * -----------------------------------------------------------------------
 * Database update query
 * -----------------------------------------------------------------------
*/
	function db_update($data = array()) {
		$sql = '';
		if ( !empty( $data ) ) {
			if (isset($data['#table'])) {
				$sql .= 'UPDATE '.$data['#table'];
			}

			if ( isset( $data['#set'] ) ){
				foreach ($data['#set'] as $key => $value) {

				}
			}
		}
	}
/*
 * -----------------------------------------------------------------------
 * Genealogy Node details
 * -----------------------------------------------------------------------
*/
	function afl_genealogy_node($uid = '') {
		if (empty($uid))
			$uid = get_current_user_id();

		$query = array();
   	$query['#select'] = 'wp_afl_user_genealogy';
  	$query['#join']  = array(
      'wp_users' => array(
        '#condition' => '`wp_users`.`ID`=`wp_afl_user_genealogy`.`uid`'
      )
    );
   	$query['#where'] = array(
      '`wp_afl_user_genealogy`.`uid`='.$uid.''
    );
    $result = db_select($query, 'get_row');
    return $result;
	}
 /* -----------------------------------------------------------------------
 * convert to Commerce Amount
 * -----------------------------------------------------------------------
*/
function afl_commerce_amount($amount_paid){
  return $amount_paid * 100;
}
/*
 * -----------------------------------------------------------------------
 * convert to Commerce Amount
 * -----------------------------------------------------------------------
*/
function afl_get_commerce_amount($amount_paid){
  return $amount_paid / 100;
}
/*
 * -----------------------------------------------------------------------
 * convert to payment amount
 * -----------------------------------------------------------------------
*/

function afl_payment_amount($amount = 0){
  return $amount * 100;
}
/*
 * -----------------------------------------------------------------------
 * Convert from payment Amount
 * -----------------------------------------------------------------------
*/
function afl_get_payment_amount($amount = 0){
  if($amount == 0){
    return 0;
  }
  return $amount / 100;

}

/*
 * -----------------------------------------------------------------------
 * Convert the amount to number format
 * -----------------------------------------------------------------------
*/
 function afl_format_payment_amount($amount, $number_format = TRUE){
  // $amount = afl_get_payment_amount($amount);
  $amount = ($amount/100);
  if($number_format){
    return number_format($amount, 2, '.', ',');
  }
  else{
    return $amount;
  }


}
/*
 * -----------------------------------------------------------------------
 * get upline users IDS
 * -----------------------------------------------------------------------
*/
 function afl_get_upline_uids ($uid = '', $uids = array()) {
 	if (empty($uid))
 		$uid = get_current_user_id();

 	$node  = afl_genealogy_node($uid);
 	if ($node) {
 		if ($node->parent_uid) {
 			$uids[] =  $node->parent_uid;
 			return afl_get_upline_uids($node->parent_uid,$uids);
 		}
 	}
 	return $uids;
 }
 /*
  * -----------------------------------------------------------------------
  * get upline users IDS
  * -----------------------------------------------------------------------
 */
  function afl_get_referrer_upline_uids ($uid = '', $uids = array()) {
  	if (empty($uid))
  		$uid = get_current_user_id();

  	$node  = afl_genealogy_node($uid);
  	if ($node) {
  		if ($node->referrer_uid) {
  			$uids[] =  $node->referrer_uid;
  			return afl_get_upline_uids($node->referrer_uid,$uids);
  		}
  	}
  	return $uids;
  }
/*
 * -----------------------------------------------------------------------
 * Truncate tables
 * -----------------------------------------------------------------------
*/
if (!function_exists('afl_truncate')) {
	function afl_truncate($table, $reset = FALSE){
		global $wpdb;
		$tbl_prefix = $wpdb->prefix;
		$table 			= $tbl_prefix . $table;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
			$wpdb->query('TRUNCATE TABLE `'.$table.'`');
	     if($reset === TRUE){
	        $wpdb->query('ALTER TABLE `'.$table.'` AUTO_INCREMENT = 1');
	     }

	  }
	}
}
/*
 * -----------------------------------------------------------------------
 * All the Page title design
 * -----------------------------------------------------------------------
*/
 function afl_page_title() {
 	return '<h1>'.get_admin_page_title().'</h1>';
 }
/*
 * -----------------------------------------------------------------------
 * Dashboard Header template
 * -----------------------------------------------------------------------
*/
 function afl_eps_page_header () {
 	return afl_get_template('dashboard/eps_dashboard_header.php');
 }

/*
 * -----------------------------------------------------------------------
 * Get all rank names
 * -----------------------------------------------------------------------
*/
 function afl_get_ranks_names () {
 	$ranks = array();
 	$max_rank = afl_variable_get('number_of_ranks');
 	for ($i = 1; $i <= $max_rank; $i++) {
 		$ranks[$i] = afl_variable_get('rank_'.$i.'_name');
 	}
 	return $ranks;
 }

/*
 * -----------------------------------------------------------------------
 * Get root user
 * -----------------------------------------------------------------------
*/

function afl_root_user() {
 	$root = afl_variable_get('root_user');
 	preg_match('#\((.*?)\)#', $root, $uid);
	return $uid[1];
}
/*
 * -----------------------------------------------------------------------
 * echo the status
 * -----------------------------------------------------------------------
*/
 function afl_member_status_render ($status = 0) {
 	$status = afl_variable_get();
 }
/*
 * -----------------------------------------------------------------------
 * Extract the text area data
 * -----------------------------------------------------------------------
*/
 function list_extract_allowed_values($string, $field_type, $generate_keys) {
  	$values = array();

	  $list = explode("\n", $string);
	  $list = array_map('trim', $list);
	  $list = array_filter($list, 'strlen');

	  $generated_keys = $explicit_keys = FALSE;
	  foreach ($list as $position => $text) {
	    $value = $key = FALSE;

	    // Check for an explicit key.
	    $matches = array();
	    if (preg_match('/(.*)\|(.*)/', $text, $matches)) {
	      $key = $matches[1];
	      $value = $matches[2];
	      $explicit_keys = TRUE;
	    }
	    // Otherwise see if we can use the value as the key. Detecting true integer
	    // strings takes a little trick.
	    elseif ($field_type == 'list_text'
	     || ($field_type == 'list_float' && is_numeric($text))
	       || ($field_type == 'list_integer' && is_numeric($text) && (float) $text == intval($text))) {
	      $key = $value = $text;
	      $explicit_keys = TRUE;
	    }
	    // Otherwise see if we can generate a key from the position.
	    elseif ($generate_keys) {
	      $key = (string) $position;
	      $value = $text;
	      $generated_keys = TRUE;
	    }
	    else {
	      return;
	    }

	    // Float keys are represented as strings and need to be disambiguated
	    // ('.5' is '0.5').
	    if ($field_type == 'list_float' && is_numeric($key)) {
	      $key = (string) (float) $key;
	    }

	    $values[$key] = $value;
	  }

	  // We generate keys only if the list contains no explicit key at all.
	  if ($explicit_keys && $generated_keys) {
	    return;
	  }

	  return $values;
	}
/*
 * -----------------------------------------------------------------------
 * Extract the sponsor id from the string
 * -----------------------------------------------------------------------
*/
	function extract_sponsor_id ($string = '') {
		if (!empty($string)) {
			preg_match('#\((.*?)\)#', $string, $matches);
	    $sponsor = $matches[1];
	    return $sponsor;
		}
	}
/*
 * -----------------------------------------------------------------------
 * check the user is admin
 * -----------------------------------------------------------------------
*/
 if (!function_exists('eps_is_admin')){
 	function eps_is_admin(){
 		if (current_user_can('administrator')) {
 			return TRUE;
    } else {
    	return FALSE;
    }
 	}
 }
 /*
  * ----------------------------------------------------------------------
  * Check user has a role
  * ----------------------------------------------------------------------
 */
  if (!function_exists('has_role') ){
  	function has_role($uid = '', $role = '') {
  		if (user_can($uid, $role)) {
  			return TRUE;
  		} else{
  			return FALSE;
  		}
  	}
  }
 /*
  * ----------------------------------------------------------------------
  * Add a role to uid
  * ----------------------------------------------------------------------
 */
  if (!function_exists('add_role')) {
  	function add_role ($uid = '', $role = '') {
  		//add new role if he has this role
    	$theUser = new WP_User($uid);
			$theUser->add_role( 'afl_member' );
  	}
  }
/*
 * ----------------------------------------------------------------------
 * Afl product purchase details enter to db
 * ----------------------------------------------------------------------
*/
 if (!function_exists('afl_purchase')) {
 	function afl_purchase ($arguments = array()) {
 		global $wpdb;
	  if( !empty($arguments)){
	  	$table = $wpdb->prefix.'afl_purchases';
	  	$afl_date_split = afl_date_splits(afl_date());

	  	$purchase_data = array();
	  	$purchase_data['uid']				 	   = $arguments['uid'];
	  	$purchase_data['category'] 		   = 'product purchase';
	  	$purchase_data['member_rank']    = 1;
	  	$purchase_data['amount_paid'] 	 = afl_commerce_amount($arguments['amount_paid']);
	  	$purchase_data['afl_points'] 	   = afl_commerce_amount($arguments['afl_point']);;
	  	$purchase_data['order_id'] 		   = $arguments['order_id'];
	  	$purchase_data['created'] 			 = afl_date();
	  	$purchase_data['processed_date'] = afl_date();
	  	$purchase_data['processed_date'] = afl_date();
	  	$purchase_data['purchase_day'] 	 = $afl_date_split['d'];
	  	$purchase_data['purchase_month'] = $afl_date_split['m'];
	  	$purchase_data['purchase_year']  = $afl_date_split['y'];
	  	$purchase_data['purchase_week']  = $afl_date_split['w'];
	  	$purchase_data['purchase_date']  = afl_date_combined($afl_date_split);

	  	$id = $wpdb->insert($table, $purchase_data);
	  	if ($id)
	  		return true;
	  	else
	  		return false;
	  }

 	}
 }
/*
 * ----------------------------------------------------------------------
 * Get table name
 * ----------------------------------------------------------------------
*/
 if ( !function_exists( '_table_name' ) ){
 	function  _table_name ($table_name = '') {
 		global $wpdb;
 		$table_prefix = $wpdb->prefix;
 		return $table_prefix.$table_name;
 	}
 }
/*
 * ----------------------------------------------------------------------
 * Check the roles exist or not
 * ----------------------------------------------------------------------
*/
function role_exists( $role ) {

  if( ! empty( $role ) ) {
    return WP_Roles()->is_role( $role );
  }

  return false;
}
if ( !function_exists('get_user_by') ){
	require_once ABSPATH . 'wp-includes/pluggable.php';
}
/*
* ----------------------------------------------------------------------
* Render rank in the html format
* ----------------------------------------------------------------------
*/
 function render_rank ($rank = '') {
		if ( empty( $rank ) ) {
			$rank_name = 'Active';
		} else {
			$rank_name = afl_variable_get('rank_'.$rank.'_name');
		}

		$rank_color = afl_variable_get('rank_'.$rank.'_color','#eea236');

 	  return '<span style="display: inline; padding: .2em .6em .3em; font-size: 100%;font-weight: 700;line-height: 1; color: #fff;
        text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .25em;background-color:'.$rank_color.';">'.$rank_name.' </span>';
 }
