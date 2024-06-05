<?php


if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_qr_customer_add extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_sales_qr_code');
        $this->load->model('Model_customer');
	}

	public function index()
	{
		$ref = $this->input->get('ref');
		$token = $this->input->get('token');
		if(!empty($token) && !empty($ref)){
			$data = [
				'ref'=> $ref, 
				'token' => $token,
			];
			//cek id_sales exist
			$id_sales = encrypt_decrypt('decrypt', $ref);
			$query_cek = $this->db_wuling
				->select('id_sales')
				->from('adm_sales')
				->where('id_sales', $id_sales)
				->where('status_aktif', 'A')
				->get();
			if ($query_cek->num_rows() == 0) {
				echo 'Invalid Access!!!';
				die();
				// $data['status'] = false;
			}
			$this->load->view('sales_qr_customer_add/index', $data);
		} else {
			echo "Access Denied!!!";
			die();
			// $data['status'] = false;
		}
		// responseJson($id);
		// $this->load->view('sales_qr_customer_add/index', $data);
	}

	public function select2_unit()
    {
        $kode_unit = null;//$this->input->post('kode_unit');
        $data = $this->Model_customer->getDataUnit($kode_unit);
        responseJson($data);
    }

	public function simpan()
	{
		$posts = $this->input->post(NULL, TRUE);
		$data = $this->model_sales_qr_code->simpan($posts);
		responseJson($data);
	}

	public function get()
	{
		$gets = $this->input->get ();
		$data = $this->model_sales_qr_code->get($gets);
		responseJson($data);
	}

}

/* End of file Sales_qr_customer_add.php */
/* Location: ./wuling_sales/controllers/Sales_qr_customer_add.php */
