<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tambah_pengajuan_biaya extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_tambah_pengajuan_biaya');
	}

	public function index()
	{
		$this->layout
			->title('Tambah Pengajuan Biaya')
			->view('tambah_pengajuan_biaya/index');
	}

	public function get()
	{
		$cabang = $this->input->get('cabang');
		$data = [];
		$no_po = "";
		if(!empty($cabang)){
			$data 	= $this->model_tambah_pengajuan_biaya->get($cabang);
			$no_po 	= $this->model_tambah_pengajuan_biaya->generate_no_po($cabang);
		}
		responseJson(['aaData' => $data, 'no_po'=>$no_po]);
	}

	public function select2_cabang() {				
		$data = array();
		$coverage = explode(",",$this->coverage);
		$query = $this->db
			->select("id_perusahaan,lokasi,kode_perusahaan")
			->from("kmg.perusahaan")
			->where("id_brand","5")
			->where_in("id_perusahaan",$coverage)
			->order_by("lokasi")->get();
		foreach ($query->result() as $q) {
			$data[] = array(
				'id'        => $q->id_perusahaan,
				'kode' 		=> strtolower($q->kode_perusahaan),
				'text'      => $q->lokasi,
			);
		}		
		responseJson($data);		
	}

	public function select2_coa_budget()
	{
		$cabang = $this->input->get('cabang');
		$hasil	= $this->model_tambah_pengajuan_biaya->select2_coa_budget($cabang);
		responseJson($hasil);
	}

	public function get_planning_budget_from_coa()
	{
		$gets = $this->input->get();
		$hasil 	= $this->model_tambah_pengajuan_biaya->get_planning_budget_from_coa($gets);
		responseJson($hasil);
	}

	public function simpan()
	{
		$posts 	= $this->input->post();
		$hasil 	= $this->model_tambah_pengajuan_biaya->simpan($posts);
		responseJson($hasil);
	}

	public function get_pengajuan_biaya_by_id()
	{
		$id 	= $this->input->get('id');
		$data 	= $this->model_tambah_pengajuan_biaya->get_pengajuan_biaya_by_id($id);
		responseJson($data);
	}

	public function simpan_po_budget()
	{
		$posts 	= $this->input->post();
		$data 	= $this->model_tambah_pengajuan_biaya->simpan_po_budget($posts);
		responseJson($data);
	}

	public function hapus()
	{
		$id 	= $this->input->post('id');
		$hasil 	= $this->model_tambah_pengajuan_biaya->hapus($id);
		responseJson($hasil);
	}
}

/* End of file Tambah_pengajuan_biaya.php */
/* Location: ./application/controllers/Tambah_pengajuan_biaya.php */
