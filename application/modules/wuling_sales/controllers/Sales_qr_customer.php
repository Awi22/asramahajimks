<?php

use app\models\elo\sales\ModelCustomer;
use app\models\elo\sales\ModelHotProspek;
use app\models\elo\sales\ModelJadwalSales;
use app\models\elo\sales\ModelProspek;
use app\models\elo\sales\ModelSsurvaiProses;
use app\models\elo\sales\ModelSuspect;
use app\models\elo\sales\ModelWsaDataSuspect;
use app\models\elo\sales\ModelCustomerQR;
use Illuminate\Database\Capsule\Manager as DB;
/* Memanggil file rakitvalidate */
use Rakit\Validation\Validator;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_qr_customer extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_customer_qr');
        $this->load->model('model_customer');
	}

	public function index()
	{
		$this->layout
			->title('QRCode Customer')
			->view('sales_qr_customer/index');
	}

	public function get()
	{
		$data = $this->model_customer_qr->get();
		responseJson(['aaData'=>$data]);
	}

	public function select2_unit()
    {
        $kode_unit = null;//$this->input->post('kode_unit');
        $data = $this->model_customer->getDataUnit($kode_unit);
        responseJson($data);
    }


	public function simpan()
    {
        $post = $this->input->post();

        // Inisialisai Rakit Validate
        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'nama'              => $post['nama_customer'],
                'alamat'            => $post['alamat_customer'],
                'telepone'          => $post['tlpn'],
                'id_provinsi'       => $post['opt_provinsi'],
                'id_kabupaten'      => $post['opt_kabupaten'],
                'id_kecamatan'      => $post['opt_kecamatan'],
                'id_kelurahan'      => $post['opt_kelurahan'],
                'kode_pos'          => $post['kode_pos'],
                'status'            => 'suspect',
                'id_sumber_prospek' => $post['opt_sumber_prospek'],
                'keterangan'        => $post['ket_tambah'],
                'kode_unit'         => $post['opt_model_diminati'],
                'tgl_kunjungan'     => $post['kunjungan_berikut_tambah'],
                'sumber_prospek'    => $post['opt_sumber_prospek_survai'],
                'telp_valid'        => $post['opt_telp_valid'],
                'promo_product'     => $post['opt_promo_product'],
                'info_dokumen'      => $post['opt_info_dokumen'],
            ],
            /* Validasi yg dilakukan */
            [
                'nama'              => 'required',
                'alamat'            => 'required',
                'telepone'          => 'required',
                'id_provinsi'       => 'required',
                'id_kabupaten'      => 'required',
                'id_kecamatan'      => 'required',
                'id_kelurahan'      => 'required',
                'kode_pos'          => 'required',
                'id_sumber_prospek' => 'required',
                'keterangan'        => 'required',
                'kode_unit'         => 'required',
                'tgl_kunjungan'     => 'required',
                'sumber_prospek'    => 'required',
                'telp_valid'        => 'required',
                'promo_product'     => 'required',
                'info_dokumen'      => 'required',
            ]
        );
        /* Membuat pesan custom */
        $validasi->setMessages([
            'nama'              => 'Customer tidak boleh kosong',
            'alamat'            => 'Alamat tidak boleh kosong',
            'telepone'          => 'Telepone tidak boleh kosong',
            'id_provinsi'       => 'Provinsi tidak boleh kosong',
            'id_kabupaten'      => 'Kabupaten tidak boleh kosong',
            'id_kecamatan'      => 'Kecamatan tidak boleh kosong',
            'id_kelurahan'      => 'Kelurahan tidak boleh kosong',
            'kode_pos'          => 'Kode Pos tidak boleh kosong',
            'id_sumber_prospek' => 'Sumber Prospek tidak boleh kosong',
            'keterangan'        => 'Keterangan tidak boleh kosong',
            'kode_unit'         => 'Unit tidak boleh kosong',
            'tgl_kunjungan'     => 'Tanggal Kunjungan tidak boleh kosong',
            'sumber_prospek'    => 'Sumber Prospek Suvai tidak boleh kosong',
            'telp_valid'        => 'Telepone Valid tidak boleh kosong',
            'promo_product'     => 'Promo Product tidak boleh kosong',
            'info_dokumen'      => 'Info Dokumen tidak boleh kosong',
        ]);
        $validasi->validate();
        /* Jika data tidak valid */
        if ($validasi->fails()) {
            $pesan_errors = $validasi->errors()->all();
            /* Parsing error */
            for ($i = 0; $i < count($pesan_errors); $i++) {
                $pesan[] = $pesan_errors[$i] . " ";
            }
            responseJson([
                'status' => false,
                'pesan' => $pesan,
            ]);
            exit;
        }

        DB::beginTransaction();
        try {
            $setSuspect = [
                'id_prospek'     => $post['id_prospek'],
                'tgl_suspect'    => $post['tgl_suspect_tambah'],
                'keterangan'     => $post['ket_tambah'],
                'id_sales'       => $this->id_sales,
                'id_perusahaan'  => $this->id_perusahaan

            ];
            ModelSuspect::insert($setSuspect);

            $setJadwalSales = [
                'id_prospek'      => $post['id_prospek'],
                'tgl_selanjutnya' => $post['tgl_suspect_tambah'],
                'sales'           => $this->id_sales,
            ];
            ModelJadwalSales::insert($setJadwalSales);

            $setSurvaiProses = [
                'id_prospek'     => $post['id_prospek'],
                'sumber_prospek' => $post['opt_sumber_prospek_survai'],
                'telp_valid'     => $post['opt_telp_valid'],
                'promo_product'  => $post['opt_promo_product'],
                'info_dokumen'   => $post['opt_info_dokumen'],
            ];

            ModelSsurvaiProses::insert($setSurvaiProses);

            $setCustomer = [
                'id_prospek'        => $post['id_prospek'],
                'tgl_kunjungan'     => $post['kunjungan_berikut_tambah'],
                'nama'              => $post['nama_customer'],
                'telepone'          => $post['tlpn'],
                'alamat'            => $post['alamat_customer'],
                'id_provinsi'       => $post['opt_provinsi'],
                'id_kabupaten'      => $post['opt_kabupaten'],
                'id_kecamatan'      => $post['opt_kecamatan'],
                'id_kelurahan'      => $post['opt_kelurahan'],
                'kode_pos'          => $post['kode_pos'],
                'status'            => 'suspect',
                'id_sumber_prospek' => $post['opt_sumber_prospek'],
                'keterangan'        => $post['ket_tambah'],
                'id_cust_qr'    	=> $post['id_customer_qr'],
                'sales'             => $this->id_sales,
                'type_customer'     => 'r'

            ];
            ModelCustomer::insert($setCustomer);


            $setProspek = [
                'id_prospek'     => $post['id_prospek'],
                'kode_unit'      => $post['opt_model_diminati'],
                'id_sales'       => $this->id_sales,
                'id_media'       => '0',
                'id_perusahaan'  => $this->id_perusahaan
            ];
            ModelProspek::insert($setProspek);

            $setHotProspek = [
                'id_prospek'     => $post['id_prospek'],
                'id_sales'       => $this->id_sales,
                'id_perusahaan'  => $this->id_perusahaan
            ];
            ModelHotProspek::insert($setHotProspek);

            $setWsaSuspect = [
                'id_prospek' => $post['id_prospek'],
                'source'     => 'Offline Prospect',
            ];

            ModelWsaDataSuspect::insert($setWsaSuspect);

			$setQRCustomer = [
                'status'     => '1',
            ];

            ModelCustomerQR::whereId($post['id_customer_qr'])->update($setQRCustomer);

            DB::commit();
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Berhasil Simpan Data',
                ]
            );
        } catch (\Throwable $th) {
            DB::rollback();
			debug($th->getMessage());
            return responseJson(
                [
                    'status' => false,
                    'pesan' => $th
                ]
            );
        }
    }

	public function get_customer_by_id()
	{
		$gets = $this->input->get();
		$data = $this->model_customer_qr->get_customer_by_id($gets);
		responseJson($data);
	}

	public function hapus()
	{
		$posts = $this->input->post();
		$data = $this->model_customer_qr->hapus($posts);
		responseJson($data);;
	}

}

/* End of file Sales_qr_customer.php */
/* Location: ./wuling_sales/controllers/Sales_qr_customer.php */
