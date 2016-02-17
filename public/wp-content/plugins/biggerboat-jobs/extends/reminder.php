<?php
/**
 * @author Patrick Brouwer <patrick@inlet.nl>
 */

class BiggerBoatJobsReminder
{

	private $action_hook = 'bb_cron_contacted_client';

	public function __construct( )
	{
		add_action($this->action_hook, array(&$this, 'cronjob_contacted_client'), 1, 1);
	}

	/**
	 * Schedule cron job for reminder contact the client
	 * @param $postId
	 */
	function schedule( $postId )
	{
		// 60*60*24 = 24 hours
		wp_schedule_single_event(time() + 60*60*24, $this->action_hook, array('postId' => $postId));
	}

	/**
	 * Cronjob
	 * Sends a html mail when no one contacted the client within 24 hours
	 */
	function cronjob_contacted_client( $postId )
	{
		global $biggerboatJobsMail;

		if (!$this->hasContactedClient($postId)) {
			$p = get_post($postId);
			setup_postdata($p);

			$agency_name = get_post_meta($postId, 'bb-jobs-name', true);
			$agency_email = get_post_meta($postId, 'bb-jobs-email', true);
			$agency_phone = get_post_meta($postId, 'bb-jobs-phone', true);

			$template = BB_JOBS_PLUGIN_PATH . '/mails/not_contacted_client.html';
			$obj = array(
				'title' => 'Reminder to contact client',
				'subject' => get_the_title($postId),
				'name' => $agency_name,
				'email' => $agency_email,
				'phone' => $agency_phone,
				'message' => nl2br(get_the_content()),
				'link_details' =>  admin_url("admin.php?page=biggerboat-jobs-detail&job_id=$postId"),
			);

			$to = IS_LIVE ? 'bigger-boat@googlegroups.com' : 'patrick@inlet.nl';
			$subject = "[reminder] " . get_the_title($postId);
			$body = $biggerboatJobsMail->getTemplate($template, $obj);

			$images = array(
				new EmbeddedImage(TEMPLATEPATH . '/img/mail/mail_header.gif', 1001, 'bb-header.gif'),
			);

			$biggerboatJobsMail->sendHtmlMail($to, $subject, $body, $images);
		}
	}

	/**
	 * Has anybody contacted the client of a job post?
	 * @param $postId
	 * @return bool
	 */
	function hasContactedClient( $postId )
	{
		$act_posts = get_posts(array(
			'post_type' => 'jobs-activity',
			'numberposts' => -1,
			'meta_key' => 'post_id',
			'meta_value' => $postId,
			'order' => 'ASC'
		));

		$contacted_client = false;
		foreach ( $act_posts as $act_post ) :
			$a1 = get_post_meta($act_post->ID, 'activity_text', true) === 'contacted the client';
			$a2 = get_post_meta($act_post->ID, 'activity_text', true) === 'mail sent to client that no one is interested';
			if ($a1 || $a2) {
				$contacted_client = true;
				break;
			}
		endforeach;

		return $contacted_client;
	}
}

$biggerboatJobsReminder = new BiggerBoatJobsReminder();