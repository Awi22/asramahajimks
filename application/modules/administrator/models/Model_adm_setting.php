<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_adm_setting extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function upload_background()
	{
		$hasil = false;
		$pesan = 'Unknown error';

		$folder_name = 'public/upload/images/background/';

		$config = [
			'upload_path'   	=> './' . $folder_name,
			'allowed_types' 	=> 'jpg|png|jpeg|webp',
			'max_size' 			=> 2048,
			'overwrite' 		=> TRUE,
			'create_thumb' 		=> FALSE,
			'maintain_ratio'	=> TRUE,
			'encrypt_name'		=> TRUE,
		];
		$this->load->library('upload', $config);

		$files    = $_FILES;
		$dataInfo = [];

		$num_files = count($_FILES['background_file']['name']);

		for ($i = 0; $i < $num_files; $i++) {
			$_FILES['background_file']['name']       = $files['background_file']['name'][$i];
			$_FILES['background_file']['type']       = $files['background_file']['type'][$i];
			$_FILES['background_file']['tmp_name']   = $files['background_file']['tmp_name'][$i];
			$_FILES['background_file']['error']      = $files['background_file']['error'][$i];
			$_FILES['background_file']['size']       = $files['background_file']['size'][$i];
			// $this->upload->do_upload('background_file');
			if (empty($files['background_file']['name'][$i])) {
				$dataInfo[] = $this->upload->data();
			} else {
				if ($this->upload->do_upload('background_file')) {
					$hasil         = true;
					$dataInfo[]    = $this->upload->data();
					$pesan         = 'Berhasil upload gambar';
				} else {
					$dataInfo[]    = $this->upload->data();
					$hasil         = false;
					$pesan         = $this->upload->display_errors();
					return ['status' => $hasil, 'pesan' => $pesan];
				}
			}
		}

		// $id_karyawan = $this->session->userdata('id_karyawan');

		$row = $this->db->get('system_setting')->row();

		if ($files['background_file']['name'][0] != null) {
			if (!empty($row->background_login)) {
				if (file_exists('./' . $row->background_login)) {
					unlink($row->background_login);
				}
			}
			$hasil = $this->db->update('system_setting', ['background_login' => $folder_name . $dataInfo[0]['file_name']]);
		}
		if ($files['background_file']['name'][1] != null) {
			if (!empty($row->background_home)) {
				if (file_exists('./' . $row->background_home)) {
					unlink($row->background_home);
				}
			}
			$hasil = $this->db->update('system_setting', ['background_home' => $folder_name . $dataInfo[1]['file_name']]);
		}
		return ['status' => $hasil, 'pesan' => $pesan];
	}
}

/* End of file Model_adm_setting.php */
/* Location: ./administrator/models/Model_adm_setting.php */
