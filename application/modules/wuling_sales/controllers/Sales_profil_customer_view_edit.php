<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\models\elo\sales\ModelCustomer;
use app\models\elo\sales\ModelHotProspek;
use app\models\elo\sales\ModelProspek;
use app\models\elo\sales\ModelSuspect;
use Illuminate\Database\Capsule\Manager as DB;
/* Memanggil file rakitvalidate */
use Rakit\Validation\Validator;

class Sales_profil_customer_view_edit extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_customer_view_edit');
        $this->load->library('WSA_API');
    }

    public function index()
    {
        $data = [
            'id_prospek' => $this->uri->segment(2),

        ];
        $this->layout
            ->title('Edit Customer')
            ->data($data)
            ->view('customer/edit_customer');
    }

    public function getDataCustomerProses()
    {
        $id_prospek = $this->input->post('id_prospek');
        $data = $this->Model_customer_view_edit->getDataCustomerProses($id_prospek);
        responseJson($data);
    }


    public function getDataProvinsi()
    {
        $id_provinsi = $this->input->post('id_provinsi');
        $data = $this->Model_customer_view_edit->getDataProvinsi($id_provinsi);
        responseJson($data);
    }

    public function getDataKabupaten()
    {
        $id_provinsi = $this->input->post('id_provinsi');
        $id_kabupaten = $this->input->post('id_kabupaten');
        $data = $this->Model_customer_view_edit->getDataKabupaten($id_provinsi, $id_kabupaten);
        responseJson($data);
    }

    public function getDataKecamatan()
    {
        $id_kabupaten = $this->input->post('id_kabupaten');
        $id_kecamatan = $this->input->post('id_kecamatan');
        $data = $this->Model_customer_view_edit->getDataKecamatan($id_kabupaten, $id_kecamatan);
        responseJson($data);
    }

    public function getDataKelurahan()
    {
        $id_kecamatan = $this->input->post('id_kecamatan');
        $id_kelurahaan = $this->input->post('id_kelurahan');
        $data = $this->Model_customer_view_edit->getDataKelurahan($id_kecamatan, $id_kelurahaan);
        responseJson($data);
    }

    public function getDataUnit()
    {
        $kode_unit = $this->input->post('kode_unit');
        $data = $this->Model_customer_view_edit->getDataUnit($kode_unit);
        responseJson($data);
    }

    public function getDataSumberProspek()
    {
        $id_sumber_prospek = $this->input->post('id_sumber_prospek');
        $data = $this->Model_customer_view_edit->getDataSumberProspek($id_sumber_prospek);
        responseJson($data);
    }

    public function getDataMediaMotivaor()
    {
        $id_media = $this->input->post('id_media');
        $data =  $this->Model_customer_view_edit->getDataMediaMotivaor($id_media);
        responseJson($data);
    }

    public function editCustomerProspek()
    {
        $post = $this->input->post();

        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'nama'              => $post['nama_customer'],
                'alamat'            => $post['alamat'],
                'telepone'          => $post['tlpn'],
                'id_provinsi'       => $post['provinsi'],
                'id_kabupaten'      => $post['kabupaten'],
                'id_kecamatan'      => $post['kecamatan'],
                'id_kelurahan'      => $post['kelurahan'],
                'kode_pos'          => $post['kode_pos'],
                'id_sumber_prospek' => $post['opt_sumber_prospek'],
                'cara_bayar'        => $post['cara_bayar'],
                'tgl_prospek'       => $post['tgl_prospek'],
                'id_media'          => $post['opt_media_motivator'],
                'kode_unit'         => $post['opt_model_diminati'],
                'kebutuhan'         => $post['kebutuhan_prospek'],
                'bln'               => $post['kebutuhan_bulan'],
                'dipakai'           => $post['mobil_dipakai'],
                'jml_keluarga'      => $post['jml_anggota'],
                'decision'          => $post['decision_maker'],
                'rute'              => $post['rute'],
                'tgl_h_prospek'     => $post['tgl_hot_prospek'],
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
                'cara_bayar'        => 'required',
                'tgl_prospek'       => 'required',
                'id_media'          => 'required',
                'kode_unit'         => 'required',
                'kebutuhan'         => 'required',
                'bln'               => 'required',
                'dipakai'           => 'required',
                'jml_keluarga'      => 'required',
                'decision'          => 'required',
                'rute'              => 'required',
                'tgl_h_prospek'     => 'required',

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
            'cara_bayar'        => 'Cara Bayar tidak boleh kosong',
            'tgl_prospek'       => 'Tanggal Prospek tidak boleh kosong',
            'id_media'          => 'Media tidak boleh kosong',
            'kode_unit'         => 'Model tidak boleh kosong',
            'kebutuhan'         => 'Kebutuhan tidak boleh kosong',
            'bln'               => 'Bulan tidak boleh kosong',
            'dipakai'           => 'Dipakai tidak boleh kosong',
            'jml_keluarga'      => 'Jumalah keluarga tidak boleh kosong',
            'decision'          => 'Decision tidak boleh kosong',
            'rute'              => 'Rute tidak boleh kosong',
            'tgl_h_prospek'     => 'Tanggal Hot Prospek tidak boleh kosong',


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

            $updateCustomerProspek = [
                'nama'              => $post['nama_customer'],
                'alamat'            => $post['alamat'],
                'id_provinsi'       => $post['provinsi'],
                'id_kabupaten'      => $post['kabupaten'],
                'id_kecamatan'      => $post['kecamatan'],
                'id_kelurahan'      => $post['kelurahan'],
                'kode_pos'          => $post['kode_pos'],
                'telepone'          => $post['tlpn'],
                'id_sumber_prospek' => $post['opt_sumber_prospek'],
                'id_cus_digital'    => $post['code_digital'],
                'cara_bayar'        => $post['cara_bayar'],
            ];
            ModelCustomer::whereId_prospek($post['id_prospek'])->update($updateCustomerProspek);

            $updateSuspect = [
                'tgl_suspect'   => $post['tgl_suspect'],
            ];
            ModelSuspect::whereId_prospek($post['id_prospek'])->update($updateSuspect);

            $updateProspek = [
                'tgl_prospek'  => $post['tgl_prospek'],
                'id_media'     => $post['opt_media_motivator'],
                'kode_unit'    => $post['opt_model_diminati'],
                'kebutuhan'    => $post['kebutuhan_prospek'],
                'bln'          => $post['kebutuhan_bulan'],
                'dipakai'      => $post['mobil_dipakai'],
                'jml_keluarga' => $post['jml_anggota'],
                'decision'     => $post['decision_maker'],
                'rute'         => $post['rute'],
            ];
            ModelProspek::whereId_prospek($post['id_prospek'])->update($updateProspek);


            $updateHotProspek = [
                'tgl_h_prospek' => $post['tgl_hot_prospek'],
                'tdp'           => $post['tdp'],
                'cicilan'       => $post['cicilan'],
            ];
            ModelHotProspek::whereId_prospek($post['id_prospek'])->update($updateHotProspek);


            DB::commit();
            return responseJson(
                [
                    'status'     => true,
                    'pesan'      => 'Berhasil Simpan Data',
                ]
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return responseJson(
                [
                    'status' => false,
                    'pesan' => $th->errorInfo
                ]
            );
        }
    }


    public function view()
    {
        $data = [
            'id_prospek' => $this->uri->segment(2),
            'history' => $this->Model_customer_view_edit->getDataDetailFuPerHistory($this->uri->segment(2)),
        ];
        $this->layout
            ->title('View Customer')
            ->data($data)
            ->view('customer/view_customer');
    }
}
