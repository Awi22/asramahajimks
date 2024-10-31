<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Adm_user_global extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	//ambil data status pegawai untuk kebutuhan select2
	public function select2_status_pegawai()
	{
		$data 	= array();
		$query 	= $this->db
			->select("*")
			->from("status_pegawai")
			->get();

		foreach ($query->result() as $url) {
			$data[] = array(
				'id'        => $url->id_status_pegawai,
				'text'      => $url->nama_status_pegawai,
			);
		}

		responseJson($data);
	}

	//ambil data role user untuk kebutuhan select2
	public function select2_role()
	{
		$data 	= array();
		$query 	= $this->db
			->select("*")
			->from("menu_role")
			->order_by("role_name")
			->get();

		foreach ($query->result() as $url) {
			$data[] = array(
				'id'        => $url->id,
				'kode' 		=> strtolower($this->_angka_ke_huruf($url->id)),
				'text'      => $url->role_name,
			);
		}

		responseJson($data);
	}

	//!ambil data url level untuk kebutuhan select2
	public function select2_url()
	{
		$data 	= array();
		$query 	= $this->db->select("*")->from("p_url")->order_by("deskripsi")->get();
		foreach ($query->result() as $url) {
			$data[] = array(
				'id'        => $url->id_url,
				'text'      => $url->url,
			);
		}
		responseJson($data);
	}

	//!ambil data level user untuk kebutuhan select2
	public function select2_level()
	{
		$data 	= array();
		$query 	= $this->db->select("*")->from("p_level")->order_by("deskripsi")->get();
		foreach ($query->result() as $url) {
			$data[] = array(
				'id'        => $url->id_level,
				'kode' 		=> strtolower($this->_angka_ke_huruf($url->id_level)),
				'text'      => $url->deskripsi,
			);
		}
		responseJson($data);
	}

	//! ambil data area kerja untuk kebutuhan select2
	public function select2_area_kerja()
	{
		$data = array();
		$query = $this->db
			->select("id_area_kerja, nama_area_kerja")
			->from("area_kerja")
			->order_by("nama_area_kerja")->get();
		foreach ($query->result() as $q) {
			$data[] = array(
				'id'        => $q->id_area_kerja,
				'text'      => $q->nama_area_kerja,
			);
		}
		responseJson($data);
	}

	//!ambil data jabatan untuk kebutuhan select2
	public function select2_jabatan()
	{
		$data 	= array();
		$query 	= $this->db->select("*")->from("jabatan")->order_by("nama_jabatan")->get();
		foreach ($query->result() as $jabatan) {
			$data[] = array(
				'id'        => $jabatan->id_jabatan,
				'text'      => $jabatan->nama_jabatan,
			);
		}
		responseJson($data);
	}

	//!ambil data role menu untuk kebutuhan select2
	public function select2_group_menu()
	{
		$data 	= array();
		$query 	= $this->db->select("*")->from("menu_group")->order_by("id")->get();
		foreach ($query->result() as $group) {
			$data[] = array(
				'id'        => $group->id,
				'text'      => $group->title,
			);
		}
		responseJson($data);
	}

	//ambil data coverage cabang untuk kebutuhan datatable coverage
	public function get_coverage()
	{
		$data 	= array();
		$query	= $this->db
			->select("id_area_kerja, nama_area_kerja")
			->from("area_kerja")
			->order_by("nama_area_kerja")
			->get();

		$data = $query->result();

		responseJson(['aaData' => $data]);
	}

	//ambil semua data asn untuk dipilih sebagai user
	public function get_data_asn()
	{
		$datatable = new Datatable;

		//* query utama *//
		$datatable->query = $this->db
			->select('p.*, ja.nama, j.nama_jabatan')
			->from('pegawai p')
			->join('jenis_asn ja', 'ja.id_jenis_asn = p.id_jenis_asn')
			->join('jabatan j', 'j.id_jabatan = p.id_jabatan')
			->where('p.status_aktif', 'Aktif');

		//* untuk filtering */		
		$datatable->setColumns(
			"p.nip",
			"p.nama_pegawai",
			"ja.nama",
			"j.nama_jabatan"
		);

		//* untuk ordering by, kalo ndak dipake jangan dipanggil, komen saja
		$datatable->orderBy('p.nama_pegawai ASC');

		//* untuk langsung ke format json, gunakan getJson(); untuk langsung parsing ke view
		//$raw = $datatable->get();
		return $datatable->getJson();
	}

	//ambil semua data pegawai untuk dipilih sebagai user
	public function get_data_karyawan()
	{
		$datatable = new Datatable;

		//* query utama *//
		$datatable->query = $this->db
			->select('k.kode_karyawan, ak.nama_area_kerja, k.nama_karyawan, j.nama_jabatan')
			->from('karyawan k')
			->join('jabatan j', 'j.id_jabatan = k.id_jabatan')
			->join('area_kerja ak', 'ak.id_area_kerja = k.id_area_kerja')
			->where('k.status_aktif', 'Aktif');

		//* untuk filtering */		
		$datatable->setColumns(
			"k.kode_karyawan",
			"ak.nama_area_kerja",
			"k.nama_karyawan",
			"j.nama_jabatan"
		);

		//* untuk ordering by, kalo ndak dipake jangan dipanggil, komen saja
		$datatable->orderBy('k.kode_karyawan ASC');

		//* untuk langsung ke format json, gunakan getJson(); untuk langsung parsing ke view
		//$raw = $datatable->get();
		return $datatable->getJson();
	}

	private function _angka_ke_huruf($angka)
	{
		$angka = intval($angka);
		if ($angka <= 0) {
			return '';
		}
		$huruf = '';
		while ($angka != 0) {
			$p = ($angka - 1) % 26;
			$angka = intval(($angka - $p) / 26);
			$huruf = chr(65 + $p) . $huruf;
		}
		return $huruf;
	}
}
