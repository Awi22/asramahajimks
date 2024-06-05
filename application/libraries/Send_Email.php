<?php

class Send_Email
{
	public function __construct()
	{
		$this->load->library(['email']);
		$this->config->load('email');
		$email_config = $this->config->item('email_config');
		$this->email->initialize($email_config);
	}

	public function __get($var) //magic method
	{
		return get_instance()->$var;
	}

	/**
	 * Fungsi sendsemail menggunakan library email bawaan CI, 
	 * dengan memanfaatkan config setup email dari file config yang sudah dibuat sebelumnya
	 *
	 * @param string $template 		template html email yang digunakan
	 * @param string $title 		judul email
	 * @param string $to 			tujuan email
	 * @param string $subject 		subject email
	 * @param array  $message 		isi email
	 *
	 * @return mixed status true jika sukses kirim email dan FALSE jika gagal, dengan email debugger
	 */
	public function send($template, $title, $to, $subject, $data)
	{
		$message = '';

		switch ($template) {
			case 'password_confirmation':
				$message = $this->load->view($this->config->item('email_templates') . $this->config->item('email_password_confirmation'), $data, true);
				break;
			default:
				$message = $data;
		}

		$this->email->clear();
		$this->email->from($this->config->item('email_admin'), $title);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);

		if ($this->email->send() === TRUE) {
			return ['status' => TRUE, 'pesan' => 'Kirim email sukses'];
		}

		return ['status' => FALSE, 'pesan' => $this->email->print_debugger()];
	}
}
