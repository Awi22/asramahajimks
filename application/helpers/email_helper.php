<?php
defined('BASEPATH') or exit('No direct script access allowed');


//apakah sudah login atau tidak
if (!function_exists('send_email')) {
	function send_esmail($from, $title, $to, $subject, $message)
	{
		$this->load->library(['email']);
		$email_config = $this->config->item('config', 'email');
		$this->email->initialize($email_config);

		$ci = get_instance();
		$this->email->clear();
		$this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
		$this->email->to($email);
		$this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_activation_subject'));
		$this->email->message($message);
	}
}
