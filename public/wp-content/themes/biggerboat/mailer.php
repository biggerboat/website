<?php

session_start();
ini_set('display_errors', 0);
error_reporting(E_CORE_ERROR);

require_once('../../../wp-load.php');

/**
 * global BB functionality
 */
global $biggerboatJobs;
global $biggerboatJobsMail;
global $biggerboatJobsReminder;


/**
 * Exit on unauthorized call
 */
if (empty($_POST) || !wp_verify_nonce($_POST['nounce'], 'bigger_boat_mail')) {
	echo "_";
	session_destroy();
	die;
}

/**
 * Create a post and send a mail to bigger boat group
 */
$postId = wp_insert_post(array(
	'post_status' => 'publish',
	'post_type' => 'jobs',
	'post_title' => $_POST['subject'],
	'post_content' => $_POST['details']
));


if ($postId > 0) {
	/**
	 * Update post meta
	 */
	update_post_meta($postId, 'bb-jobs-name', $_POST['name']);
	update_post_meta($postId, 'bb-jobs-email', $_POST['email']);
	update_post_meta($postId, 'bb-jobs-phone', $_POST['phone']);

	/**
	 * Schedule reminder
	 */
	$biggerboatJobsReminder->schedule($postId);

	/**
	 * Sending mail to Bigger Boaties!
	 */
	$p = stripslashes_deep($_POST);
	$template = TEMPLATEPATH . '/mail_template.html';
	$body = $biggerboatJobsMail->getTemplate($template, array(
		'title' => 'New Job',
		'subject' => $p['subject'],
		'name' => $p['name'],
		'email' => $p['email'],
		'phone' => $p['phone'],
		'message' => nl2br($p['details']),
		'link_details' => admin_url("admin.php?page=biggerboat-jobs-detail&job_id=$postId"),
		'link_vote_1' => admin_url("admin.php?page=biggerboat-jobs-detail&job_id=$postId&vote=1"),
		'link_vote_0' => admin_url("admin.php?page=biggerboat-jobs-detail&job_id=$postId&vote=0"),
	));

	$to = IS_LIVE ? 'bigger-boat@googlegroups.com' : 'patrick@inlet.nl';
	$subject = "[new job] " . $_POST['subject'];
	$images = array(
		new EmbeddedImage(TEMPLATEPATH . '/img/mail/mail_header.gif', 1001, 'bb-header.gif'),
		new EmbeddedImage(TEMPLATEPATH . '/img/mail/mail_interested_1.gif', 1002, 'vote_1.gif'),
		new EmbeddedImage(TEMPLATEPATH . '/img/mail/mail_interested_0.gif', 1003, 'vote_0.gif'),
	);
	$biggerboatJobsMail->sendHtmlMail($to, $subject, $body, $images);

	/**
	 * Sending mail to client
	 */
	$client_str = "Bigger Boat received your message: " . $_POST['subject'] . " \n\n";
	$client_str .= "Thanks for your message! You can expect a response within 24 hours.\n\n";
	$client_str .= "How does this work? Bigger Boat is a group of independent web developers and we do freelance assignments for clients. We are not one company, therefore we don't have a spokesperson, we don't have a hierarchy and we don't have any contractual agreements with each other. However we talk every day, we meet every few weeks, we work together when possible and we can step in as backup when required.\n\n";
	$client_str .= "You will receive an email or a phone call from one of us as soon as he or she wants to apply for the assignment, or when it becomes clear that we're out of capacity. We have a system in place that will ensure we get back to you within 24 hours. Tired of waiting? Feel free to call any one of us directly.\n\n";
	$client_str .= "Bigger Boat is on its way, 23:59 and counting...";
	wp_mail($_POST['email'], "[Bigger Boat] " . $_POST['subject'], $client_str, 'From: "Bigger Boat" <no-reply@biggerboat.nl>');
}

session_destroy();
exit();

?>
