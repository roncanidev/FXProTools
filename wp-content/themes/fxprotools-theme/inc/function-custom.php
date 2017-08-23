<?php
/**
 * ----------------------------
 * Fxprotools - Cusom Functions
 * ----------------------------
 * All custom functions
 */

add_action('init', 'check_authentication');
function check_authentication(){
	if(!is_user_logged_in()){
		$url = get_site_url() . '/login/';
		// Force using of js to avoid too many redirect and header sent errors
		echo "<script>location.href = {$url};</script>'";
	}
}

add_action('init', 'block_users_wp');
function block_users_wp(){
	if(is_admin() && ! current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)){
		wp_redirect(home_url());
		exit;
	}
}

function get_courses_by_product_id($product_id){
	$courses_ids = get_post_meta($product_id , '_related_course'); 
	$courses     = array();
	if($courses_ids){
		foreach($courses_ids as $id){
			$courses[] = get_post($id[0]);
		}
	}
	return $courses;
}

function get_lessons_by_course_id($course_id){
	$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'menu_order',
			'post_status'      => 'publish',
			'post_type'		   => 'sfwd-lessons',
			'meta_query' => array(
			array(
				'key'     => 'course_id',
				'value'   => $course_id,
				'compare' => '=',
			),
		),
	);
	$lessons = get_posts($args);
	return !$lessons ? false : $lessons;
}

function get_user_progress(){
	if(!is_user_logged_in()) return false;
	$current_user    = wp_get_current_user();
	$user_id         = $current_user->ID;
	$course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );
	return !$course_progress ? false : $course_progress;
}

function get_course_lesson_progress($course_id, $lesson_id){
	if(!$course_id || !$lesson_id) return false;
	$course_progress = get_user_progress();

	return $course_progress[$course_id]['lessons'][$lesson_id];
}