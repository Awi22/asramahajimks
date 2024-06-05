<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\models\elo\sales\ModelCustomer;
use app\models\elo\sales\ModelHistoryFollowupSales;
use app\models\elo\sales\ModelHotProspek;
use app\models\elo\sales\ModelJadwalSales;
use app\models\elo\sales\ModelNoSpk;
use app\models\elo\sales\ModelPengajuanDiskon;
use app\models\elo\sales\ModelProspek;
use app\models\elo\sales\ModelSspk;
use app\models\elo\sales\ModelSsurvaiProses;
use app\models\elo\sales\ModelSuspect;
use app\models\elo\sales\ModelTestDrive;
use app\models\elo\sales\ModelWsaDataSuspect;
use app\models\elo\sales\ModelWsaFollowup;
use Illuminate\Database\Capsule\Manager as DB;
/* Memanggil file rakitvalidate */
use Rakit\Validation\Validator;

class Sales_jadwal_kunjungan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_jadwal_kunjungan');
        $this->load->library('WSA_API');
    }

    public function index()
    {
        $this->layout
            ->title('Jadwal Kunjungan')
            ->view('jadwal_kunjungan/jadwal_kunjungan');
    }

    public function getDataJadwalKunjungan()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $data = $this->Model_jadwal_kunjungan->getDataJadwalKunjungan($tgl_awal, $tgl_akhir, $this->id_sales);
        responseJson(['aaData' => $data]);
    }

    public function getDataProvinsi()
    {
        $id_provinsi = $this->input->post('id_provinsi');
        $data = $this->Model_jadwal_kunjungan->getDataProvinsi($id_provinsi);
        responseJson($data);
    }

    public function getDataKabupaten()
    {
        $id_provinsi = $this->input->post('id_provinsi');
        $id_kabupaten = $this->input->post('id_kabupaten');
        $data = $this->Model_jadwal_kunjungan->getDataKabupaten($id_provinsi, $id_kabupaten);
        responseJson($data);
    }

    public function getDataKecamatan()
    {
        $id_kabupaten = $this->input->post('id_kabupaten');
        $id_kecamatan = $this->input->post('id_kecamatan');
        $data = $this->Model_jadwal_kunjungan->getDataKecamatan($id_kabupaten, $id_kecamatan);
        responseJson($data);
    }

    public function getDataKelurahan()
    {
        $id_kecamatan = $this->input->post('id_kecamatan');
        $id_kelurahaan = $this->input->post('id_kelurahan');
        $data = $this->Model_jadwal_kunjungan->getDataKelurahan($id_kecamatan, $id_kelurahaan);
        responseJson($data);
    }

    public function getDataUnit()
    {
        $kode_unit = $this->input->post('kode_unit');
        $data = $this->Model_jadwal_kunjungan->getDataUnit($kode_unit);
        responseJson($data);
    }

    public function getDataSumberProspek()
    {
        $id_sumber_prospek = $this->input->post('id_sumber_prospek');
        $data = $this->Model_jadwal_kunjungan->getDataSumberProspek($id_sumber_prospek);
        responseJson($data);
    }

    public function getDataAktivitas()
    {
        $id_sumber_prospek = $this->input->post('id_sumber_prospek');
        $tgl_aktivitas = $this->input->post('tgl_aktivitas');
        $id_aktivitas = $this->input->post('id_aktivitas');
        $data = $this->Model_jadwal_kunjungan->getDataAktivitas($id_sumber_prospek, $this->id_perusahaan, $tgl_aktivitas, $id_aktivitas);
        responseJson($data);
    }

    //** Data Suspect */

    public function getDataSuspect()
    {
        $id_prospek = $this->input->post('id_prospek');
        $data = $this->Model_jadwal_kunjungan->getDataSuspect($id_prospek);
        responseJson($data);
    }


    public function simpanDataSuspect()
    {
        $post = $this->input->post();
        // debug($post);

        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'nama'              => $post['customer_suspect'],
                'alamat'            => $post['alamat_suspect'],
                'telepone'          => $post['tlpn_suspect'],
                'id_provinsi'       => $post['opt_provinsi_suspect'],
                'id_kabupaten'      => $post['opt_kabupaten_suspect'],
                'id_kecamatan'      => $post['opt_kecamatan_suspect'],
                'id_kelurahan'      => $post['opt_kelurahan_suspect'],
                'kode_pos'          => $post['kode_pos_suspect'],
                'status'            => 'suspect',
                'id_sumber_prospek' => $post['opt_sumber_prospek_suspect'],
                'keterangan'        => $post['ket_suspect'],
                'kode_unit'         => $post['opt_model_diminati_suspect'],
                'tgl_kunjungan'     => $post['kunjungan_berikut_suspect'],

                'email'      => $post['email_wsa'],
                'model'      => $post['model_minat_wsa'],
                'form'       => $post['form_wsa'],
                'pekerjaan'  => $post['pekerjaan_wsa'],
                'chanel'     => $post['chanel_wsa'],
                // 'event'      => $post['event_wsa'],
                'penawaran'  => $post['penawaran_harga_wsa'],
                'kebutuhan'  => $post['kebutuhan_wsa'],
                'cabang'     => $post['cabang_sgwm_wsa'],
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

                'email'      => 'required',
                'model'      => 'required',
                'form'       => 'required',
                'pekerjaan'  => 'required',
                'chanel'     => 'required',
                // 'event'      => 'required',
                'penawaran'  => 'required',
                'kebutuhan'  => 'required',
                'cabang'     => 'required',


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

            'email'      => 'Email tidak boleh kosong',
            'model'      => 'Model diminati tidak boleh kosong',
            'form'       => 'Form Wsa tidak boleh kosong',
            'pekerjaan'  => 'Pekerjaan tidak boleh kosong',
            'chanel'     => 'Chanel tidak boleh kosong',
            // 'event'      => 'Event tidak boleh kosong',
            'penawaran'  => 'penawaran tidak boleh kosong',
            'kebutuhan'  => 'Kebutuhan Prospek tidak boleh kosong',
            'cabang'     => 'Cabang Wsa tidak boleh kosong',

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

            //** Data Customer */
            $sumber_prospek = $post['opt_sumber_prospek_suspect'];
            if ($sumber_prospek == '1' || $sumber_prospek == '3' || $sumber_prospek == '11' || $sumber_prospek == '13' || $sumber_prospek == '14' || $sumber_prospek == '16' || $sumber_prospek == '17') {
                $customerSumberProspek = [
                    'tgl_event'         => $post['tgl_aktivitas_suspect'],
                    'id_event'          => $post['opt_aktivitas_suspect'],
                    'tgl_telpon_masuk'  => null,
                    'nama_stnk'         => null,
                    'tgl_pembelian'     => null,
                    'tgl_walk_in'       => null,
                    'nama_agent'        => null,
                    'telepon_agent'     => null,
                    'id_sales_digital'  => null,
                ];
            } elseif ($sumber_prospek == '2') {
                $customerSumberProspek = [
                    'tgl_event'         => $post['tgl_aktivitas_suspect'],
                    'id_event'          => $post['opt_aktivitas_suspect'],
                    'tgl_telpon_masuk'  => null,
                    'nama_stnk'         => null,
                    'tgl_pembelian'     => null,
                    'tgl_walk_in'       => null,
                    'nama_agent'        => null,
                    'telepon_agent'     => null,
                    'id_sales_digital'  => null,
                ];
            } elseif ($sumber_prospek == '5') {
                $customerSumberProspek = [
                    'tgl_event'         => $post['tgl_aktivitas_suspect'],
                    'id_event'          => $post['opt_aktivitas_suspect'],
                    'tgl_telpon_masuk'  => null,
                    'nama_stnk'         => null,
                    'tgl_pembelian'     => null,
                    'tgl_walk_in'       => null,
                    'nama_agent'        => null,
                    'telepon_agent'     => null,
                    'id_sales_digital'  => null,
                ];
            } elseif ($sumber_prospek == '6') {
                $customerSumberProspek = [
                    'tgl_event'         => $post['tgl_aktivitas_suspect'],
                    'id_event'          => $post['opt_aktivitas_suspect'],
                    'tgl_telpon_masuk'  => null,
                    'nama_stnk'         => null,
                    'tgl_pembelian'     => null,
                    'tgl_walk_in'       => null,
                    'nama_agent'        => null,
                    'telepon_agent'     => null,
                    'id_sales_digital'  => null,
                ];
            } elseif ($sumber_prospek == '8') {
                $customerSumberProspek = [
                    'tgl_event'         => null,
                    'id_event'          => null,
                    'tgl_telpon_masuk'  => null,
                    'nama_stnk'         => null,
                    'tgl_pembelian'     => null,
                    'tgl_walk_in'       => null,
                    'nama_agent'        => $post['nama_agent_suspect'],
                    'telepon_agent'     => $post['tlpn_agent_suspect'],
                    'id_sales_digital'  => null,
                ];
            } elseif ($sumber_prospek == '15') {
                $customerSumberProspek = [
                    'tgl_event'         => null,
                    'id_event'          => null,
                    'tgl_telpon_masuk'  => null,
                    'nama_stnk'         => null,
                    'tgl_pembelian'     => null,
                    'tgl_walk_in'       => null,
                    'nama_agent'        => null,
                    'telepon_agent'     => null,
                    'id_sales_digital'  => $post['opt_sales_digital_suspect'],
                ];
            } elseif ($sumber_prospek == '26') {
                $customerSumberProspek = [
                    'tgl_event'              => null,
                    'id_event'               => null,
                    'tgl_telpon_masuk'       => null,
                    'nama_stnk'              => $post['nama_stnk_sumber_suspect'],
                    'no_rangka_repeat_order' => $post['norak_sumber_prospek_suspect'],
                    'tgl_pembelian'          => null,
                    'tgl_walk_in'            => null,
                    'nama_agent'             => null,
                    'telepon_agent'          => null,
                    'id_sales_digital'       => null,
                ];
            } elseif ($sumber_prospek == '30') {
                $customerSumberProspek = [
                    'tgl_event'              => null,
                    'id_event'               => null,
                    'tgl_telpon_masuk'       => null,
                    'nama_stnk'              => null,
                    'no_rangka_repeat_order' => null,
                    'tgl_pembelian'          => null,
                    'tgl_walk_in'            => null,
                    'nama_agent'             => null,
                    'telepon_agent'          => null,
                    'id_sales_digital'       => null,
                ];
            } elseif ($sumber_prospek == '31') {
                $customerSumberProspek = [
                    'tgl_event'         => null,
                    'id_event'          => null,
                    'tgl_telpon_masuk'  => null,
                    'nama_stnk'         => null,
                    'tgl_pembelian'     => null,
                    'tgl_walk_in'       => $post['tgl_walk_in_suspect'],
                    'nama_agent'        => null,
                    'telepon_agent'     => null,
                    'id_sales_digital'  => null,
                ];
            } elseif ($sumber_prospek == '32') {
                $customerSumberProspek = [
                    'tgl_event'         => null,
                    'id_event'          => null,
                    'tgl_telpon_masuk'  => null,
                    'nama_stnk'         => null,
                    'tgl_pembelian'     => null,
                    'tgl_walk_in'       => $post['tgl_walk_in_suspect'],
                    'nama_agent'        => null,
                    'telepon_agent'     => null,
                    'id_sales_digital'  => null,
                ];
            } elseif ($sumber_prospek == '33') {
                $customerSumberProspek = [
                    'tgl_event'        => '',
                    'id_event'         => '',
                    'tgl_telpon_masuk' => '',
                    'nama_stnk'        => '',
                    'tgl_pembelian'    => '',
                    'tgl_walk_in'      => '',
                    'nama_agent'       => '',
                    'telepon_agent'    => '',
                    'id_sales_digital' => '',
                    'nama_refrensi'    => $post['nama_refrensi_suspect'],
                    'tlpn_refrensi'    => $post['tlpn_refrensi_suspect'],
                ];
            }

            $updateCustomer = [
                'id_prospek'        => $post['id_prospek_suspect'],
                'nama'              => $post['customer_suspect'],
                'alamat'            => $post['alamat_suspect'],
                'id_provinsi'       => $post['opt_provinsi_suspect'],
                'id_kabupaten'      => $post['opt_kabupaten_suspect'],
                'id_kecamatan'      => $post['opt_kecamatan_suspect'],
                'id_kelurahan'      => $post['opt_kelurahan_suspect'],
                'kode_pos'          => $post['kode_pos_suspect'],
                'telepone'          => $post['tlpn_suspect'],
                'status'            => 'suspect',
                'id_sumber_prospek' => $post['opt_sumber_prospek_suspect'],
                'tgl_kunjungan'     => $post['kunjungan_berikut_suspect'],
                'keterangan'        => $post['ket_suspect'],
                'id_cus_digital'    => $post['digital_customer_suspect'],
                'sales'             => $this->id_sales,
                'type_customer'     => 'r',
                'cara_bayar'        => $post['cara_bayar_wsa'],
                'email'             => $post['email_wsa'],
                'jenis_kelamin'     => $post['jenis_kelamin_wsa'],

            ];

            $setCustomer = array_merge($updateCustomer, $customerSumberProspek);
            ModelCustomer::whereId_prospek($post['id_prospek_suspect'])->update($setCustomer);

            //** Data Jadwal Sales */
            ModelJadwalSales::updateOrCreate(
                [
                    'id_prospek' => $post['id_prospek_suspect']
                ],
                [
                    'id_prospek' => $post['id_prospek_suspect'],
                    'tgl_selanjutnya' => $post['kunjungan_berikut_suspect'],
                    'sales' => $this->id_sales,
                ]
            );

            //** Data Suspect */
            $setSuspect = [
                'tgl_suspect'   => $post['tgl_suspect'],
                'id_perusahaan' => $this->id_perusahaan,
            ];
            ModelSuspect::whereId_prospek($post['id_prospek_suspect'])->update($setSuspect);

            //** Data Prospek */
            $setProspek = [
                'kode_unit'      => $post['opt_model_diminati_suspect'],
            ];
            ModelProspek::whereId_prospek($post['id_prospek_suspect'])->update($setProspek);

            //** Data Survai Proses */
            $srv_kategori_prospek = '';
            if ($post['opt_fu_survai'] == 'y' && $post['opt_test_drive_survai'] == 'y') {
                $srv_kategori_prospek = 'medium';
            }
            if ($post['opt_estimasi_survai'] == 'y' && $post['opt_fitur_survai'] == 'y') {
                $srv_kategori_prospek = 'hot';
            }

            if ($srv_kategori_prospek == '') {
                $upSurvaiProses = [
                    'respon_fu'  => $post['opt_fu_survai'],
                    'test_drive' => $post['opt_test_drive_survai'],
                    'fitur'      => $post['opt_fitur_survai'],
                    'estimasi'   => $post['opt_estimasi_survai'],
                ];
            } else {
                $upSurvaiProses = [
                    'respon_fu'        => $post['opt_fu_survai'],
                    'test_drive'       => $post['opt_test_drive_survai'],
                    'fitur'            => $post['opt_fitur_survai'],
                    'estimasi'         => $post['opt_estimasi_survai'],
                    'kategori_prospek' => $srv_kategori_prospek,
                ];
            }
            ModelSsurvaiProses::whereId_prospek($post['id_prospek_suspect'])->update($upSurvaiProses);

            //** Data WSA */
            if (empty($post['digital_customer'])) {
                $setDataWsaSuspect = [
                    'id_prospek'        => $post['id_prospek_suspect'],
                    'prospect_id'       => null,
                    'source'            => 'Offline Prospect',
                    'form_id'           => $post['form_wsa'],
                    'occupation_id'     => $post['pekerjaan_wsa'],
                    'channel_id'        => $post['chanel_wsa'],
                    'price_offering'    => $post['penawaran_harga_wsa'],
                    'kode_unit_alt'     => $post['model_minat_wsa'],
                    'plan_to_buy'       => $post['kebutuhan_wsa'],
                    'dealer_id'         => $post['cabang_sgwm_wsa'],
                    'salesman_id'       => $this->kode_sales_sgmw,
                    'national_event_id' => $post['event_wsa'],
                ];
            } else {
                $dataXylo = $this->Model_jadwal_kunjungan->getDataXyloWsa($post['digital_customer']);
                $setDataWsaSuspect = [
                    'id_prospek'        => $post['id_prospek_suspect'],
                    'prospect_id'       => $dataXylo['id'],
                    'source'            => $dataXylo['source'],
                    'form_id'           => $dataXylo['form_id'],
                    'occupation_id'     => $dataXylo['occupation_id'],
                    'channel_id'        => $dataXylo['channel_id'],
                    'price_offering'    => $dataXylo['price_offering'],
                    'kode_unit_alt'     => $dataXylo['kode_unit'],
                    'plan_to_buy'       => $dataXylo['plan_to_buy'],
                    'dealer_id'         => $dataXylo['dealer_id'],
                    'salesman_id'       => $this->kode_sales_sgmw,
                    'national_event_id' => $dataXylo['event_wsa'],
                ];
            }

            ModelWsaDataSuspect::whereId_prospek($post['id_prospek_suspect'])->update($setDataWsaSuspect);

            $setHistoryFu = [
                'id_prospek'      => $post['id_prospek_suspect'],
                'tgl_followup'    => $post['tgl_suspect'],
                'tgl_selanjutnya' => $post['kunjungan_berikut_suspect'],
                'keterangan'      => $post['ket_suspect'],
                'sales'           => $this->id_sales,
            ];
            ModelHistoryFollowupSales::insert($setHistoryFu);

            DB::commit();
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Berhasil Simpan Data Suspect',
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

    //** Data WSA */
    public function getDataFormWsa()
    {
        $form_id = $this->input->post('form_id');
        $data =  $this->Model_jadwal_kunjungan->getDataFormWsa($form_id);
        responseJson($data);
    }

    public function getOccupationsWsa()
    {
        $occupation_id = $this->input->post('occupation_id');
        $data =  $this->Model_jadwal_kunjungan->getOccupationsWsa($occupation_id);
        responseJson($data);
    }

    public function getCannelsWsa()
    {
        $channel_id = $this->input->post('channel_id');
        $data =  $this->Model_jadwal_kunjungan->getCannelsWsa($channel_id);
        responseJson($data);
    }

    public function getNasonalEventWsa()
    {
        $national_event_id = $this->input->post('national_event_id');
        $data =  $this->Model_jadwal_kunjungan->getNasonalEventWsa($national_event_id);
        responseJson($data);
    }

    public function getDataDealer()
    {
        $dealer_id = $this->input->post('dealer_id');
        $data =  $this->Model_jadwal_kunjungan->getDataDealer($dealer_id, $this->id_perusahaan);
        responseJson($data);
    }

    public function getDataStatusFu()
    {
        $data =  $this->Model_jadwal_kunjungan->getDataStatusFu();
        responseJson($data);
    }

    public function getDataRemaksFu()
    {
        $data =  $this->Model_jadwal_kunjungan->getDataRemaksFu();
        responseJson($data);
    }

    public function getDataNextFu()
    {
        $data =  $this->Model_jadwal_kunjungan->getDataNextFu();
        responseJson($data);
    }

    public function simpanDataWsa()
    {
        if (empty($this->kode_sales_sgmw)) {
            responseJson([
                'status' => false,
                'pesan' => "ID Sales SGMW belum ada",
            ]);
            exit;
        }

        DB::beginTransaction();
        try {

            $this->wsa_api->input_prospect_api();
            DB::commit();
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

    //** Data Followup */
    public function simpanDataFolloup()
    {
        $post = $this->input->post();
        // debug($post);
        // Inisialisai Rakit Validate
        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'id_prospek'      => $post['id_prospek_fu'],
                'tgl_followup'    => $post['tgl_fu'],
                'tgl_selanjutnya' => $post['tgl_selanjutnya_fu'],
                'hasil'           => $post['hasil'],
                'keterangan'      => $post['ket_fu'],

            ],
            /* Validasi yg dilakukan */
            [
                'id_prospek'      => 'required',
                'tgl_followup'    => 'required',
                'tgl_selanjutnya' => 'required',
                'hasil'           => 'required',
                'keterangan'      => 'required',

            ]
        );
        /* Membuat pesan custom */
        $validasi->setMessages([
            'id_prospek'      => 'Id Prospek tidak boleh kosong',
            'tgl_followup'    => 'Tanggal Followup tidak boleh kosong',
            'tgl_selanjutnya' => 'Tanggal selanjutnya tidak boleh kosong',
            'hasil'           => 'Hasil tidak boleh kosong',
            'keterangan'      => 'Keterangan tidak boleh kosong',
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
            $setHistoryFu = [
                'id_prospek'      => $post['id_prospek_fu'],
                'tgl_followup'    => $post['tgl_fu'],
                'tgl_selanjutnya' => $post['tgl_selanjutnya_fu'],
                'hasil'           => $post['hasil'],
                'keterangan'      => $post['ket_fu'],
                'sales'           => $this->id_sales,
            ];
            $objectId = ModelHistoryFollowupSales::insertGetId($setHistoryFu);

            $updateFuJadwalSales = [
                'tgl_selanjutnya' => $post['tgl_selanjutnya_fu'],
                'last_update'     => $post['tgl_fu'],
            ];
            ModelJadwalSales::whereId_prospek($post['id_prospek_fu'])->update($updateFuJadwalSales);

            $updateFuCustomer = [
                'tgl_kunjungan' => $post['tgl_selanjutnya_fu'],
            ];
            ModelCustomer::whereId_prospek($post['id_prospek_fu'])->update($updateFuCustomer);

            $lastId = $objectId;
            $setFuWsa = [
                'id_followup'      => $lastId,
                'id_prospek'       => $post['id_prospek_fu'],
                'status_id'        => $post['status_fu'],
                'next_followup_id' => $post['next_fu'],
                'remarks_id'       => $post['remaks_fu'],
                'buy_plan'         => $post['buy_plan_fu'],
            ];
            ModelWsaFollowup::insert($setFuWsa);

            DB::commit();
            return responseJson(
                [
                    'status'     => true,
                    'pesan'      => 'Berhasil Simpan Data Folloup',
                    'id_prospek' => $post['id_prospek_fu'],
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

    public function simpanFollowupForWsa()
    {
        DB::beginTransaction();
        try {
            $this->wsa_api->input_followup_api();
            DB::commit();
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


    //** Data Test Drive */

    public function getCekDataProspekIdWsa()
    {
        $id_prospek = $this->input->post('id_prospek');
        $data =  $this->Model_jadwal_kunjungan->cekDataProsepkIdWsa($id_prospek);
        if (empty($data->prospect_id)) {
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Maaf Anda belum bisa requset Test Drive, Silahkan lengkapi isian suscpect lalu klick simpan suspect, pastikan muncul pesan bahwa data terimpan WSA',
                ]
            );
        } else {
            return response(
                [
                    'status' => true,
                ]
            );
        }
        // debug($data);
    }

    public function getDataType()
    {
        $data =  $this->Model_jadwal_kunjungan->getDataTypeUnit();
        responseJson($data);
    }

    public function getDataVarian()
    {
        $id_type = $this->input->post('id_type');
        $data =  $this->Model_jadwal_kunjungan->getDataVarian($id_type);
        responseJson($data);
    }

    public function simpanTestDrive()
    {
        $post = $this->input->post();
        // debug($post);

        // Inisialisai Rakit Validate
        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'id_model'  => $post['model_test_drive'],
                'id_varian' => $post['varian_test_drive'],
                'tgl_jam'   => $post['tgl_test_drive'],
                'tempat'    => $post['tempat_test_drive'],
            ],
            /* Validasi yg dilakukan */
            [
                'id_model'  => 'required',
                'id_varian' => 'required',
                'tgl_jam'   => 'required',
                'tempat'    => 'required',
            ]
        );
        /* Membuat pesan custom */
        $validasi->setMessages([
            'id_model'  => 'Type tidak boleh kosong',
            'id_varian' => 'Varian tidak boleh kosong',
            'tgl_jam'   => 'Tanggal dan Jam tidak boleh kosong',
            'tempat'    => 'Tempat tidak boleh kosong',
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
            ModelTestDrive::updateOrCreate(
                [
                    'id_prospek' => $post['id_prospek_test_drive']
                ],
                [
                    'id_model'  => $post['model_test_drive'],
                    'id_varian' => $post['varian_test_drive'],
                    'tgl_jam'   => $post['tgl_test_drive'],
                    'tempat'    => $post['tempat_test_drive'],
                    'tahapan'   => $post['status_customer'],
                ]
            );

            $statusTestDrive = [
                'test_drive' => 'y',
            ];
            ModelCustomer::whereId_prospek($post['id_prospek_test_drive'])->update($statusTestDrive);

            DB::commit();
            return responseJson(
                [
                    'status'     => true,
                    'pesan'      => 'Berhasil Simpan Data Test Drive',
                    'id_prospek' => $post['id_prospek_test_drive'],
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

    public function simpanTestDriveWsa()
    {
        $id_prospek = $this->input->post('id_prospek');
        DB::beginTransaction();
        try {
            $this->wsa_api->schedule_test_drive_api($id_prospek);
            DB::commit();
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


    //** Data Prospek */

    public function getDataProspek()
    {
        $id_prospek = $this->input->post('id_prospek');
        $data = $this->Model_jadwal_kunjungan->getDataProspek($id_prospek);
        responseJson($data);
    }

    public function getDataMediaMotivaor()
    {
        $id_media = $this->input->post('id_media');
        $data =  $this->Model_jadwal_kunjungan->getDataMediaMotivaor($id_media);
        responseJson($data);
    }

    public function getDataStockUnit()
    {
        $kode_unit = $this->input->post('kode_unit');
        $data =  $this->Model_jadwal_kunjungan->getDataStockUnit($kode_unit);
        responseJson($data);
    }

    public function simpanProspek()
    {
        $post = $this->input->post();

        // Inisialisai Rakit Validate
        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'tgl_prospek'  => $post['tgl_prospek'],
                'id_media'     => $post['opt_media_motivator_prospek'],
                'kode_unit'    => $post['opt_model_diminati_prospek'],
                'kebutuhan'    => $post['kebutuhan_prospek'],
                'bln'          => $post['kebutuhan_bulan'],
                'dipakai'      => $post['mobil_dipakai'],
                'jml_keluarga' => $post['jml_anggota'],
                'decision'     => $post['decision_maker'],
                'rute'         => $post['rute'],
                'keterangan'   => $post['ket_prospek'],
            ],
            /* Validasi yg dilakukan */
            [
                'tgl_prospek'  => 'required',
                'id_media'     => 'required',
                'kode_unit'    => 'required',
                'kebutuhan'    => 'required',
                'bln'          => 'required',
                'dipakai'      => 'required',
                'jml_keluarga' => 'required',
                'decision'     => 'required',
                'rute'         => 'required',
                'keterangan'   => 'required',
            ]
        );
        /* Membuat pesan custom */
        $validasi->setMessages([
            'tgl_prospek'  => 'Tanggal Prospektidak boleh kosong',
            'id_media'     => 'Media tidak boleh kosong',
            'kode_unit'    => 'Model tidak boleh kosong',
            'kebutuhan'    => 'Kebutuhan tidak boleh kosong',
            'bln'          => 'Bulan tidak boleh kosong',
            'dipakai'      => 'Dipakai tidak boleh kosong',
            'jml_keluarga' => 'Jumalah keluarga tidak boleh kosong',
            'decision'     => 'Decision tidak boleh kosong',
            'rute'         => 'Rute tidak boleh kosong',
            'keterangan'   => 'Keterangan tidak boleh kosong',
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

            $updateProspek = [
                'tgl_prospek'  => $post['tgl_prospek'],
                'id_media'     => $post['opt_media_motivator_prospek'],
                'kode_unit'    => $post['opt_model_diminati_prospek'],
                'kebutuhan'    => $post['kebutuhan_prospek'],
                'bln'          => $post['kebutuhan_bulan'],
                'dipakai'      => $post['mobil_dipakai'],
                'jml_keluarga' => $post['jml_anggota'],
                'decision'     => $post['decision_maker'],
                'rute'         => $post['rute'],
                'keterangan'   => $post['ket_prospek'],
            ];
            ModelProspek::whereId_prospek($post['id_prospek_prospek'])->update($updateProspek);

            $setHistoryFu = [
                'id_prospek'      => $post['id_prospek_prospek'],
                'tgl_followup'    => $post['tgl_prospek'],
                'tgl_selanjutnya' => $post['kunjungan_berikut_prospek'],
                'keterangan'      => $post['ket_prospek'],
                'sales'           => $this->id_sales,
            ];
            ModelHistoryFollowupSales::insert($setHistoryFu);

            $updateCustomerProspek = [
                'tgl_kunjungan' => $post['kunjungan_berikut_prospek'],
            ];
            ModelCustomer::whereId_prospek($post['id_prospek_prospek'])->update($updateCustomerProspek);

            //** Data Jadwal Sales */
            ModelHotProspek::updateOrCreate(
                [
                    'id_prospek' => $post['id_prospek_prospek']
                ],
                [
                    'id_prospek' => $post['id_prospek_prospek'],
                    'id_sales' => $this->id_sales,
                ]
            );

            DB::commit();
            return responseJson(
                [
                    'status'     => true,
                    'pesan'      => 'Berhasil Simpan Data Prospek',
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

    //** Data Hot Prospek */

    public function getDataHotProspek()
    {
        $id_prospek = $this->input->post('id_prospek');
        $data = $this->Model_jadwal_kunjungan->getDataHotProspek($id_prospek);
        responseJson($data);
    }

    public function simpanHotProspek()
    {
        $post = $this->input->post();
        // debug($post);

        $cekProspekIdWsa =  $this->Model_jadwal_kunjungan->cekDataProsepkIdWsa($post['id_prospek_hot_prospek']);
        // dd($cekProspekIdWsa);
        if (!empty($cekProspekIdWsa->prospect_id) == '' || !empty($cekProspekIdWsa->prospect_id) == null && !empty($cekProspekIdWsa->dealer_id) == '' || !empty($cekProspekIdWsa->dealer_id) == null && !empty($cekProspekIdWsa->salesman_id) == '' || !empty($cekProspekIdWsa->salesman_id) == null) {
            responseJson(
                [
                    'status'          => false,
                    'pesan'           => 'Maaf ID Prospek ini belum terdaftar ke WSA silahkan lengkapi data disuspect',
                    'status_customer' => 'suspect',
                    'id_prospek'      => $post['id_prospek_hot_prospek'],
                ]
            );
            exit;
        }
        // Inisialisai Rakit Validate
        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'tgl_h_prospek' => $post['tgl_hot_prospek'],
                'jenis_kelamin' => $post['jenis_kelamin'],
                'email'         => $post['email'],
                'cara_bayar'    => $post['cara_bayar'],

            ],
            /* Validasi yg dilakukan */
            [
                'tgl_h_prospek' => 'required',
                'jenis_kelamin' => 'required',
                'email'         => 'required',
                'cara_bayar'    => 'required',


            ]
        );
        /* Membuat pesan custom */
        $validasi->setMessages([
            'tgl_h_prospek' => 'Tanggal Hot Prospek tidak boleh kosong',
            'jenis_kelamin' => 'Jenis Kelamin tidak boleh kosong',
            'email'         => 'Email tidak boleh kosong',
            'cara_bayar'    => 'Cara Bayar tidak boleh kosong',

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

            $updateHotProspek = [
                'tgl_h_prospek' => $post['tgl_hot_prospek'],
            ];
            ModelHotProspek::whereId_prospek($post['id_prospek_hot_prospek'])->update($updateHotProspek);

            $setHistoryFu = [
                'id_prospek'      => $post['id_prospek_hot_prospek'],
                'tgl_followup'    => $post['tgl_hot_prospek'],
                'tgl_selanjutnya' => $post['kungjungan_berikut_hot_prospek'],
                // 'keterangan'      => $post['ket_prospek'],
                'sales'           => $this->id_sales,
            ];
            ModelHistoryFollowupSales::insert($setHistoryFu);

            $updateCustomerHotProspek = [
                'tgl_kunjungan' => $post['kungjungan_berikut_hot_prospek'],
                'jenis_kelamin' => $post['jenis_kelamin'],
                'email'         => $post['email'],
                'cara_bayar'    => $post['cara_bayar'],
            ];
            ModelCustomer::whereId_prospek($post['id_prospek_hot_prospek'])->update($updateCustomerHotProspek);

            ModelSspk::updateOrCreate(
                [
                    'id_prospek' => $post['id_prospek_hot_prospek']
                ],
                [
                    'id_prospek' => $post['id_prospek_hot_prospek'],
                    'id_sales' => $this->id_sales,
                ]
            );
            DB::commit();
            return responseJson(
                [
                    'status'     => true,
                    'pesan'      => 'Berhasil Simpan Data Hot Prospek',
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

    //** Data SPK */

    public function getDataSpk()
    {
        $id_prospek = $this->input->post('id_prospek');
        $data = $this->Model_jadwal_kunjungan->getDataSpk($id_prospek);
        responseJson($data);
    }

    public function getDataNoSpk()
    {
        $no_spk = $this->input->post('no_spk');
        $data = $this->Model_jadwal_kunjungan->getDataNoSpk($no_spk, $this->id_sales);
        responseJson($data);
    }

    public function getDataLeasing()
    {
        $id_leasing = $this->input->post('id_leasing');
        $data = $this->Model_jadwal_kunjungan->getDataLeasing($id_leasing);
        responseJson($data);
    }

    public function simpanFotoPayment()
    {
        $post = $this->request->all();

        DB::beginTransaction();
        try {
            $uploadPaymentFoto = ModelCustomer::whereId_prospek($post['id_prospek'])->first();
            $fullPath = './public/upload/images/payment_foto/' . $uploadPaymentFoto->foto_visit;

            // if (!empty($post['hasil_foto_visit'])) {
            //     unlink($fullPath);
            // }

            $file = $post['file'];
            $path = './public/upload/images/payment_foto';
            $fileName = date("dmYHis") . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);

            $uploadPaymentFoto->payment_foto = $fileName;
            $uploadPaymentFoto->save();

            DB::commit();
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Berhasil Upload Foto Payment',
                ]
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return responseJson(
                [
                    'status' => false,
                    'pesan'  => $th->errorInfo,
                ]
            );
        }
    }

    public function simpanSpk()
    {
        $post = $this->input->post();
        // debug($post);

        $cekProspekIdWsa =  $this->Model_jadwal_kunjungan->cekDataProsepkIdWsa($post['id_prospek_spk']);
        if (!empty($cekProspekIdWsa->prospect_id) == '' || !empty($cekProspekIdWsa->prospect_id) == null && !empty($cekProspekIdWsa->dealer_id) == '' || !empty($cekProspekIdWsa->dealer_id) == null && !empty($cekProspekIdWsa->salesman_id) == '' || !empty($cekProspekIdWsa->salesman_id) == null) {
            responseJson(
                [
                    'status' => false,
                    'pesan'  => 'Maaf ID Prospek ini belum terdaftar ke WSA silahkan lengkapi data disuspect',
                ]
            );
            exit;
        }
        // Inisialisai Rakit Validate
        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'tgl_spk'       => $post['tgl_spk'],
                'nama_stnk'     => $post['nama_stnk'],
                'uang_muka'     => $post['tanda_jadi'],
                'jenis_bayar'   => $post['tt'],
                'id_leasing'    => $post['leasing'],
                'form_spk'      => $post['form_spk'],
                'motif_beli'    => $post['motif_beli'],

            ],
            /* Validasi yg dilakukan */
            [
                'tgl_spk'     => 'required',
                'nama_stnk'   => 'required',
                'uang_muka'   => 'required',
                'jenis_bayar' => 'required',
                'id_leasing'  => 'required',
                'form_spk'    => 'required',
                'motif_beli'  => 'required',


            ]
        );
        /* Membuat pesan custom */
        $validasi->setMessages([
            'tgl_spk'     => 'Tanggal SPK tidak boleh kosong',
            'nama_stnk'   => 'Nama STNK tidak boleh kosong',
            'uang_muka'   => 'Uang Muka / Tanda Jadi tidak boleh kosong',
            'jenis_bayar' => 'Jenis Bayar tidak boleh kosong',
            'id_leasing'  => 'Leasing tidak boleh kosong',
            'form_spk'    => 'Form SPK tidak boleh kosong',
            'motif_beli'  => 'Motif Beli tidak boleh kosong',

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


        if (!empty($post['form_spk'])) {
            $form_spk = implode(',', $post['form_spk']);
        } else {
            $form_spk = null;
        }

        if (!empty($post['motif_beli'])) {
            $motif_beli = implode(',', $post['motif_beli']);
        } else {
            $motif_beli = null;
        }
        DB::beginTransaction();
        try {

            $updateSpk = [
                'tgl_spk'       => $post['tgl_spk'],
                'nama_stnk'     => $post['nama_stnk'],
                'no_spk'        => !empty($post['no_spk']) ? $post['no_spk'] . 'x' . $this->id_perusahaan : null,
                'diskon'        => 0,
                'uang_muka'     => remove_separator($post['tanda_jadi']),
                'jenis_bayar'   => $post['tt'],
                'id_leasing'    => $post['leasing'],
                'form_spk'      => $form_spk,
                'motif_beli'    => $motif_beli,
                'id_perusahaan' => $this->id_perusahaan,
                'id_sales'      => $this->id_sales,
                'id_supervisor' => $this->id_team_sales_by_spv,
                'id_sm'         => $this->id_team_sales_by_sm,
            ];
            ModelSspk::whereId_prospek($post['id_prospek_spk'])->update($updateSpk);


            $updateStatusNoSpk = [
                'status' => '1',
            ];
            ModelNoSpk::whereNo_spk($post['no_spk'])->update($updateStatusNoSpk);

            ModelPengajuanDiskon::updateOrCreate(
                [
                    'no_spk' => $post['no_spk'],
                ],
                [
                    'no_spk'   => !empty($post['no_spk']) ? $post['no_spk'] . 'x' . $this->id_perusahaan : null,
                    'diskon'   => remove_separator($post['pengajuan_diskon']),
                    'id_sales' => $this->id_sales,
                ]
            );

            $setHistoryFu = [
                'id_prospek'      => $post['id_prospek_spk'],
                'tgl_followup'    => $post['tgl_spk'],
                'tgl_selanjutnya' => $post['tgl_spk'],
                'sales'           => $this->id_sales,
            ];
            ModelHistoryFollowupSales::insert($setHistoryFu);

            DB::commit();
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Berhasil Simpan Data SPK',
                ]
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return responseJson(
                [
                    'status' => false,
                    'pesan'  => $th->errorInfo,
                ]
            );
        }
    }


    //** Porses Lanjut Tahapan */

    public function simpanProsesLanjutTahapan()
    {
        $post = $this->input->post();

        if ($post['status_customer'] == 'suspect') {
            $status_customer = 'prospek';
            $id_prospek = $post['id_prospek_suspect'];
        } elseif ($post['status_customer'] == 'prospek') {
            $status_customer = 'hot prospek';
            $id_prospek = $post['id_prospek_prospek'];
        } elseif ($post['status_customer'] == 'hot prospek') {
            $id_prospek = $post['id_prospek_hot_prospek'];
            $status_customer = 'spk';
        }

        DB::beginTransaction();
        try {

            $updateCustomerLanjut = [
                'status'      => $status_customer,
            ];
            ModelCustomer::whereId_prospek($id_prospek)->update($updateCustomerLanjut);

            DB::commit();
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Berhasil Lanjut Tahapan ke ' . $status_customer,
                ]
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return responseJson(
                [
                    'status' => false,
                    'pesan'  => $th->errorInfo,
                ]
            );
        }
    }
}
