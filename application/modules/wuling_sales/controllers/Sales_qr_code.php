<?php

use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\QRCode;


if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_qr_code extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_sales_qr_code');
	}

	public function index()
	{
		$this->layout
			->title('Sales QR Code')
			->view('sales_qr_code/index');
	}

	//get data sales
	public function get()
	{
		$qr_options = new QROptions(
			[
			'eccLevel' => QRCode::ECC_H,
			'outputType' => QRCode::OUTPUT_MARKUP_SVG,
			'version' => QRCode::VERSION_AUTO,
			]
		);
		$token = password_hash($this->id_sales, PASSWORD_DEFAULT);
		$ref = encrypt_decrypt('encrypt', $this->id_sales);
		$url = base_url().'sales_qr_customer_add?'.'token='.$token.'&ref='.$ref;
		$qrcode = (new QRCode($qr_options))->render($url);

		$id_sales = $this->id_sales;
		$data 	= $this->model_sales_qr_code->get($id_sales);
		responseJson(['detail'=>$data, 'qrcode'=>$qrcode, 'url'=>$url]);
	}

}

/* End of file Sales_qr_code.php */
/* Location: ./wuling_sales/controllers/Sales_qr_code.php */
