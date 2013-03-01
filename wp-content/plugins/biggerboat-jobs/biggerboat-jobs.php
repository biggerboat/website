<?php
/*
Plugin Name: Bigger Boat Job functionality
Description: With this function you can create a contact form which creates jobs
Version: 2.0
Author: Patrick Brouwer & Jankees van Woezik
*/


class BiggerBoatJobs
{
	/**
	 * CONSTANTS
	 */
	const BOATIE_NOT_INTERESTED = 0;
	const BOATIE_INTERESTED = 1;
	const BOATIE_NOT_RESPONDED = 2;

	public function __construct()
	{
		add_action('init', array(&$this, 'register_jobs'));
		add_action('admin_menu', array(&$this, 'add_jobs_page'));
		add_action('save_post', array(&$this, 'save_job'));

		// voting ajax
		add_action('wp_ajax_bigger_boat_jobs_submit_vote', array(&$this, 'bigger_boat_jobs_submit_vote'));
		add_action('wp_ajax_bigger_boat_jobs_submit_vote', array(&$this, 'bigger_boat_jobs_submit_vote'));

		// activity log ajax
		add_action('wp_ajax_bigger_boat_jobs_get_activity_log', array(&$this, 'bigger_boat_jobs_get_activity_log'));
		add_action('wp_ajax_bigger_boat_jobs_get_activity_log', array(&$this, 'bigger_boat_jobs_get_activity_log'));
	}

	function register_jobs()
	{
		if (current_user_can("edit_posts")) {

			/**
			 * Jobs
			 */
			register_post_type('jobs', array(
				'labels' => array(
					'name' => __('Jobs'),
					'singular_name' => __('Job'),
					'all_items' => __('All Jobs'),
					'add_new_item' => __('Add New Job'),
					'add_new' => __('Add New Job'),
					'edit_item' => __('Edit Job'),
					'new_item' => __('New Job'),
					'view_item' => __('View Job'),
					'not_found' => __('No Jobs found'),
					'not_found_in_trash' => __('No Jobs found in Trash'),
				),
				'exclude_from_search' => true,
				'public' => false,
				'show_ui' => current_user_can('manage_options'),
				'capability_type' => 'post',
				'hierarchical' => false
			));

			/**
			 * Jobs Activity
			 */
			register_post_type('jobs-activity', array(
				'labels' => array(
					'name' => __('Jobs Activities'),
					'singular_name' => __('Jobs Activity'),
					'all_items' => __('Jobs Activities'),
				),
				'exclude_from_search' => true,
				'public' => false,
				'show_ui' => false,
				'capability_type' => 'post',
				'hierarchical' => false
			));


			flush_rewrite_rules();

			// add styles and scripts
			add_action('admin_enqueue_scripts', array(&$this, 'add_admin_scripts'));
			add_action('admin_print_styles', array(&$this, 'add_admin_styles'));

			// add the meta boxes for admin users
			add_action('add_meta_boxes', array(&$this, 'add_jobs_metaboxes'));
		}
	}

	/**
	 * Add admin scripts
	 */
	function add_admin_scripts()
	{
		wp_enqueue_script('bb-jobs-js', plugin_dir_url(__FILE__) . "js/bigger-boat-jobs-script.js");
	}

	/**
	 * Add admin styles
	 */
	function add_admin_styles()
	{
		wp_enqueue_style('bb-jobs-css', plugin_dir_url(__FILE__) . "css/bigger-boat-jobs-style.css");
	}


	function add_jobs_metaboxes()
	{
		add_meta_box('bb-job-contact-details', 'Contact Details', array(&$this, 'meta_box_contact_details'), 'jobs', 'normal', 'low');
	}

	function add_jobs_page()
	{
		add_menu_page('bigger_boat_jobs', 'Bigger Boat Jobs', 'edit_posts', 'biggerboat-jobs', array(&$this, 'bigger_boat_jobs_options'), '', 4);
		add_submenu_page('bigger_boat_jobs', 'bigger_boat_job', 'Bigger Boat Job', 'edit_posts', 'biggerboat-jobs-detail', array(&$this, 'bigger_boat_job_options'), '');
	}

	function bigger_boat_jobs_options()
	{
		if (!current_user_can("edit_posts")) {
			wp_die("You do not have sufficient permissions to access this page.");
		}

		echo '<div class="wrap">';
		include_once('biggerboat-jobs-list.php');
		echo '</div>';
	}

	function bigger_boat_job_options()
	{
		if (!current_user_can("edit_posts")) {
			wp_die("You do not have sufficient permissions to access this page.");
		}

		echo '<div class="wrap">';
		include_once('biggerboat-jobs-detail.php');
		echo '</div>';
	}


	/**
	 * META BOXES FOR MANUALLY ADDING JOBS
	 * DEBUGGING PURPOSES >. THIS IS DONE BY MAIL FORM ON OUR BB FRONT-END
	 */
	function meta_box_contact_details( $post )
	{
		$agency_name = get_post_meta($post->ID, 'bb-jobs-name', true);
		$agency_email = get_post_meta($post->ID, 'bb-jobs-email', true);
		$agency_phone = get_post_meta($post->ID, 'bb-jobs-phone', true);
		?>

	<input type="hidden" name="bb-jobs_contact_details_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>"/>
	<div class="wrap">
		<label for="bb-jobs-name">Name</label>
		<input type="text" name="bb-jobs-name" id="bb-jobs-name" value="<?php echo esc_attr($agency_name); ?>" class="field"/>
	</div>

	<div class="wrap">
		<label for="bb-jobs-email">Email</label>
		<input type="text" name="bb-jobs-email" id="bb-jobs-email" value="<?php echo esc_attr($agency_email); ?>" class="field"/>
	</div>

	<div class="wrap">
		<label for="bb-jobs-phone">Phone</label>
		<input type="text" name="bb-jobs-phone" id="bb-jobs-phone" value="<?php echo esc_attr($agency_phone); ?>" class="field"/>
	</div>

	<?php

	}

	function save_job( $post_id )
	{
		if (isset($_POST['post_type']) && ($_POST['post_type'] == "jobs")) {

			// check autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return $post_id;
			}

			// verify nonce
			if (!wp_verify_nonce($_POST['bb-jobs_contact_details_nonce'], basename(__FILE__))) {
				return $post_id;
			}

			// check permissions
			if (!current_user_can('edit_post', $post_id)) {
				return $post_id;
			}

			// update meta data
			update_post_meta($post_id, "bb-jobs-name", $_POST["bb-jobs-name"]);
			update_post_meta($post_id, "bb-jobs-email", $_POST["bb-jobs-email"]);
			update_post_meta($post_id, "bb-jobs-phone", $_POST["bb-jobs-phone"]);
		}

		return $post_id;
	}

	/**
	 * Save user meta data for job voting
	 * @return void
	 */
	function bigger_boat_jobs_submit_vote()
	{
		$t = $_POST;
		// save activity post
		$activity_post_id = wp_insert_post(array(
			'post_status' => 'publish',
			'post_type' => 'jobs-activity',
			'post_title' => 'job[' . $_POST['postId'] . '] by user[' . $_POST['userId'] . '] is changed to ' . $_POST['activityText']
		));
		if ($activity_post_id > 0) {
			update_post_meta($activity_post_id, 'user_id', $_POST['userId']);
			update_post_meta($activity_post_id, 'post_id', $_POST['postId']);
			update_post_meta($activity_post_id, 'activity_text', $_POST['activityText']);
		}

		$data = array(
			'interested' => $_POST['interested'],
			'contactedClient' => $_POST['contactedClient'],
			'gotJob' => $_POST['gotJob'],
			'date' => current_time('timestamp')
		);

		// save user meta
		update_user_meta($_POST['userId'], 'job-vote-' . $_POST['postId'], maybe_serialize($data));

		// response
		header('Content-type: text/json');
		echo json_encode($data);
		die;
	}

	/**
	 * Get the activity log by post type jobs-activity
	 * @return void
	 */
	function bigger_boat_jobs_get_activity_log()
	{
		header('Content-type: text/html');

		query_posts(array(
			'post_type' => 'jobs-activity',
			'posts_per_page' => -1,
			'meta_key' => 'post_id',
			'meta_value' => $_POST['postId'],
			'order' => 'ASC'
		));

		echo '<ul>';
		while (have_posts()):
			the_post();
			$sinceJobDate = human_time_diff(get_the_time('U', get_post($_POST['postId'])), get_the_time('U'));
			$sincePostDate = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago';
			$userData = get_userdata(get_post_meta(get_the_ID(), 'user_id', true));

			// determine label class
			$labelClass = '';
			$activityText = get_post_meta(get_the_ID(), 'activity_text', true);

			switch ( $activityText ) {
				case 'is interested':
					$labelClass = 'success';
					break;
				case 'is not interested':
					$labelClass = 'important';
					break;
				case 'got the job':
					$labelClass = 'gold';
					break;
				case 'contacted the client':
					$labelClass = 'notice';
					break;
				case 'mail sent to client that no one is interested':
					$labelClass = 'notice';
					break;
				default:
					$labelClass = '';
			}
			?>
		<li>After <?php echo $sinceJobDate; ?>
			<span class="label <?php echo $labelClass; ?>"><?php echo $userData->first_name . ' ' . $userData->last_name; ?></span> <?php echo $activityText; ?>
			<em style="font-size:0.7em;color:#cccccc;">(<?php echo $sincePostDate; ?>)</em>
		</li>

		<?php
		endwhile;
		echo '</ul>';
		wp_reset_query();
		die;
	}

	/**
	 * Get an object of interested people
	 * @param $jobId
	 * @return mixed { interested, uninterested, notresponded }
	 */
	function boaties_interested( $jobId )
	{
		$result = array();
		$result[0] = 0; // not interested
		$result[1] = 0; // interested
		$result[2] = 0; // not responded

		$users = get_users();
		foreach ( $users as $user ) $result[$this->boatie_interested($user->ID, $jobId)]++;
		return $result;
	}

	function boatie_interested( $userId, $jobId )
	{
		$userId = isset($userId) ? $userId : get_current_user_id();
		$login = get_userdata($userId)->user_login;
		$userstatus = maybe_unserialize(get_user_meta($userId, "job-vote-$jobId", true));
		if ($userstatus && is_array($userstatus)):
			if ((string)$userstatus['interested'] == (string)self::BOATIE_INTERESTED) return self::BOATIE_INTERESTED;
			if ((string)$userstatus['interested'] == (string)self::BOATIE_NOT_INTERESTED) return self::BOATIE_NOT_INTERESTED;
		endif;

		return self::BOATIE_NOT_RESPONDED;
	}
}

define("BB_JOBS_PLUGIN_PATH", plugin_dir_path(__FILE__));

include('extends/mail.php');
include('extends/reminder.php');

$biggerboatJobs = new BiggerBoatJobs();