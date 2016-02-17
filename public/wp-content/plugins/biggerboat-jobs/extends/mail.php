<?php

class BiggerBoatJobsMailUtils
{
	private $embeddedImages;

	public function __construct()
	{
		add_action('phpmailer_init', array(&$this, 'setup_phpmailer'));
	}

	/**
	 * Setup the PHPMailer object before sending mail though wp_mail
	 * @param $phpmailer
	 */
	public function setup_phpmailer( $phpmailer )
	{
		// send over SMTP
//		$phpmailer->IsSMTP();
//		$phpmailer->Host = 'smtp.gmail.com';
//		$phpmailer->Port = '465';
//		$phpmailer->SMTPAuth = true;
//		$phpmailer->Username = '';
//		$phpmailer->Password = '';
//		$phpmailer->SMTPSecure = 'ssl';

		// add embedded images if available
		if (is_array($this->embeddedImages)) {
			foreach ( $this->embeddedImages as $att ) {
				$phpmailer->AddEmbeddedImage($att->url, $att->cid, $att->asUrl);
			}
		}
	}

	/**
	 * Get the template
	 * And apply object variables {var} to content
	 * @param $template
	 * @param $obj
	 * @return string
	 */
	public function getTemplate( $template, $obj )
	{
		// load mail template
		$file = $template;
		$file_handle = fopen($file, 'r');
		$data = fread($file_handle, filesize($file));
		fclose($file_handle);

		// replace variables
		$patterns = array();
		$replacements = array();
		$iterator = 0;

		foreach ( $obj as $key => $value ) {
			$patterns[$iterator] = '/\$\{' . $key . '\}/';
			$replacements[$iterator] = $value;
			$iterator++;
		}

		$data = preg_replace($patterns, $replacements, $data);
		return $data;
	}

	/**
	 * Sending HTML mail
	 * @param $to
	 * @param $subject
	 * @param $body
	 * @param $embedded_images
	 */
	public function sendHtmlMail( $to, $subject, $body, $embedded_images )
	{
		$this->embeddedImages = $embedded_images;
		add_filter('wp_mail_content_type', array(&$this, 'html_content_type'));

		wp_mail($to, $subject, $body, 'From: "Bigger Boat Website" <website@biggerboat.nl>');

		remove_filter('wp_mail_content_type', array(&$this, 'html_content_type'));
		$this->embeddedImages = array();
	}

	public function html_content_type() {
		return "text/html";
	}
}



/**
 * Value Object for Embedding Images
 * @param url absolute url of the image to embed
 * @param cid reference in template to this embedded file
 * @param asUrl embed as filename
 */
class EmbeddedImage
{
	public $url;
	public $cid;
	public $asUrl;

	public function __construct( $url, $cid, $asUrl )
	{
		$this->url = $url;
		$this->cid = $cid;
		$this->asUrl = $asUrl;
	}
}

$biggerboatJobsMail = new BiggerBoatJobsMailUtils();