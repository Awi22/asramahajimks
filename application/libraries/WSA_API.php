<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class WSA_API
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->database();
        $this->ci->load->library('input');
    }

    private function request_api($endpoint, $request_type, $params = null, $data = null)
    {
        if (ENVIRONMENT === 'development') {
            // * staging
            $token = '7|l0kWWS4sLe9RnxLcZshhWDPLK0vwCI9lLtme14MK';
            $url = 'https://dashboard.sales.wuling.id/api/kumala/' . $endpoint . '?';
        } else {
            // ! production
            $token = '5|s2XaRF7GpHXtqmZaLewPKJkWR5hctHAgRcS2Qc0Y';
            $url = 'https://sales.wuling.id/api/kumala/' . $endpoint . '?';
        }

        $headers = [
            'Authorization: Bearer ' . $token,
            'Accept:application/json'
        ];

        $curl = curl_init();

        if ($request_type == 'get') {
            $options = [
                CURLOPT_URL                => $url,
                CURLOPT_HTTPHEADER         => $headers,
                CURLOPT_RETURNTRANSFER     => true,
                CURLOPT_CUSTOMREQUEST      => 'GET',
                CURLOPT_SSL_VERIFYHOST     => false, // ! This option disables SSL verification
                CURLOPT_SSL_VERIFYPEER     => false  // ! This option disables SSL verification
            ];
            if ($params) $options[CURLOPT_URL] = $url . http_build_query($params);
        } else if ($request_type == 'post') {
            $options = [
                CURLOPT_URL                => $url,
                CURLOPT_HTTPHEADER         => $headers,
                CURLOPT_RETURNTRANSFER     => true,
                CURLOPT_POST               => true,
                CURLOPT_POSTFIELDS         => $data,
                CURLOPT_SSL_VERIFYHOST     => false, // ! This option disables SSL verification
                CURLOPT_SSL_VERIFYPEER     => false  // ! This option disables SSL verification
            ];
        }

        curl_setopt_array($curl, $options);

        $result = new stdClass();
        $result->response = curl_exec($curl);
        $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_error($curl)) {
            die(curl_error($curl));
        }

        curl_close($curl);

        return $result;
    }

    private function validasi_data_insert($data_validasi, $nama_data = '')
    {
        $kolomWajib = array_keys($data_validasi);
        $kolomKosong = [];

        foreach ($kolomWajib as $kolom) {
            if (!isset($data_validasi[$kolom]['value']) || $data_validasi[$kolom]['value'] === '') {
                $kolomKosong[] = $data_validasi[$kolom]['name'];
            }
        }

        if (!empty($kolomKosong)) {
            $kolomKosongString = '- ';
            $kolomKosongString .= implode(", \n- ", $kolomKosong);
            return "Gagal update data $nama_data ke WSA. Data-data berikut diperlukan: \n $kolomKosongString.";
        }
        return 0;
    }

    private function format_response_messages($json)
    {
        // debug($json);
        $data = json_decode($json, true);
        $result = "\n";

        foreach ($data as $key => $value) {
            $result .= "\n" . $key . ': ' . $value[0];
        }

        return $result;
    }

    public function get_master($nama_master)
    {
        return json_decode($this->request_api($nama_master, 'get')->response)->data;
    }

    public function input_prospect_api()
    {
        $id_prospek        = $this->ci->input->post('id_prospek');
        $data_customer     = $this->ci->db_wuling->get_where('s_customer', ['id_prospek' => $id_prospek])->first_row();
        $data_wsa          = $this->ci->db_wuling
            ->select('wsa_data_suspect.*, pv_alt.wsa_product_id AS product_interest_alt_id,
                pv.wsa_product_id AS product_interest_id, city.id AS city_id')
            ->from('wsa_data_suspect')
            ->join('unit AS u_alt', 'wsa_data_suspect.kode_unit_alt = u_alt.kode_unit', 'left')
            ->join('p_varian AS pv_alt', 'u_alt.id_varian = pv_alt.id_varian', 'left')
            ->join('s_prospek AS sp', 'wsa_data_suspect.id_prospek = sp.id_prospek', 'left')
            ->join('unit AS u', 'sp.kode_unit = u.kode_unit', 'left')
            ->join('p_varian AS pv', 'u.id_varian = pv.id_varian', 'left')
            ->join('s_customer AS sc', 'wsa_data_suspect.id_prospek = sc.id_prospek', 'left')
            ->join('wsa_cities AS city', 'sc.id_kabupaten = city.id_kabupaten', 'left')
            ->where('wsa_data_suspect.id_prospek', $id_prospek)->get()->first_row();
        $request_url       = 'prospect';

        if (!empty($data_wsa->prospect_id) || $data_wsa->prospect_id != 0) {
            return responseJson([
                'status' => false,
                'pesan'  => 'Data prospect sudah ada di WSA dengan prospect id WSA ' . $data_wsa->prospect_id,
            ]);
            // echo 'Data prospect sudah ada di WSA dengan prospect id WSA ' . $data_wsa->prospect_id;
            // return;
        }

        $city_id = $data_wsa->city_id;

        $source            = $data_wsa->source;
        $form_id           = $data_wsa->form_id;
        $occupation_id     = $data_wsa->occupation_id;
        $channel_id        = $data_wsa->channel_id;
        $national_event_id = $data_wsa->national_event_id;

        // * kalau mau where data di array string pake FIND_IN_SET
        // $dealer_id         = $this->ci->db_wuling->select('*')->from('wsa_dealers AS wsd')
        //     ->where("FIND_IN_SET($data_wsa->id_perusahaan, id_perusahaan) > 0")->get()->first_row()->id;
        $dealer_id         = $data_wsa->dealer_id;

        $payment_type = '';
        if ($data_customer->cara_bayar == 'c') $payment_type = 'Cash';
        else if ($data_customer->cara_bayar == 'k') $payment_type = 'Credit';

        $price_offering = $data_wsa->price_offering;
        $test_drive = $data_customer->test_drive == 'y' ? 'Yes' : 'No';

        $product_interest_id = $data_wsa->product_interest_id;
        $product_interest_alt_id = $data_wsa->product_interest_alt_id;

        $salesman_id = $data_wsa->salesman_id;

        $data_wsa_insert = [
            'category_name'           => 'Kumala',
            'category_id'             => $id_prospek,
            'name'                    => $data_customer->nama,
            'email'                   => $data_customer->email,
            'city_id'                 => $city_id,
            'phone_number'            => $data_customer->telepone,
            'source'                  => $source,
            'form_id'                 => $form_id,
            'occupation_id'           => $occupation_id,
            'channel_id'              => $channel_id,
            'status_id'               => 'Uncontacted',
            'dealer_id'               => $dealer_id,
            'plan_to_buy'             => $data_wsa->plan_to_buy,
            'payment_type'            => $payment_type,
            'price_offering'          => $price_offering,
            'test_drive'              => $test_drive,
            'product_interest_id'     => $product_interest_id,
            'product_interest_alt_id' => $product_interest_alt_id,
            'register_at'             => $data_wsa->w_insert,
            'salesman_id'             => $salesman_id,
            'national_event_id'       => ($national_event_id == 0 || empty($national_event_id) || $national_event_id == null) ? null : $national_event_id,
        ];

        // debug($data_wsa_insert);

        $nama2_data = [
            'category_name'           => 'Nama Kategori',
            'category_id'             => 'id prospek',
            'name'                    => 'nama',
            'email'                   => 'email',
            'city_id'                 => 'Id Kota/Kabupaten SGMW',
            'phone_number'            => 'No. telp',
            'source'                  => 'Jenis Prospek',
            'form_id'                 => 'Form',
            'occupation_id'           => 'Pekerjaan',
            'channel_id'              => 'Channel',
            'status_id'               => 'status_id',
            'dealer_id'               => 'ID Dealer SGMW',
            'plan_to_buy'             => 'Kebutuhan',
            'payment_type'            => 'Pilihan Cara Bayar',
            'price_offering'          => 'Penawaran Harga',
            'test_drive'              => 'Test Drive',
            'product_interest_id'     => 'Model yg diminati',
            'product_interest_alt_id' => 'Model yg diminati alternatif',
            'register_at'             => 'register_at',
            'salesman_id'             => 'Kode Sales SGMW',
            'national_event_id'       => 'National Event Id',
        ];

        $data_validasi = [];
        foreach ($data_wsa_insert as $key => $value) {
            $data_validasi[$key] = [
                'name'  => $nama2_data[$key],
                'value' => $value,
            ];
        }
        unset($data_validasi['category_name']);
        unset($data_validasi['status_id']);
        unset($data_validasi['national_event_id']);

        $validasi_kolom = $this->validasi_data_insert($data_validasi);
        if ($validasi_kolom) {
            return responseJson([
                'status' => false,
                'pesan'  => $validasi_kolom,
            ]);
            // echo $validasi_kolom;
            // return;
        }

        if (!filter_var($data_customer->email, FILTER_VALIDATE_EMAIL)) {
            return responseJson([
                'status' => false,
                'pesan'  => "Gagal update data prospect ke WSA: Email customer tidak valid."
            ]);
            // echo "Gagal update data prospect ke WSA: Email customer tidak valid.";
            // return;
        }

        if (empty($data_customer->id_kabupaten) || $data_customer->id_kabupaten == 0 || $data_customer->id_kabupaten == null) {
            return responseJson([
                'status' => false,
                'pesan'  => "Gagal update data prospect ke WSA: Kota/Kabupaten customer kosong."
            ]);
            // echo "Gagal update data prospect ke WSA: Kota/Kabupaten customer kosong.";
            // return;
        }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);
        // debug($response);
        if ($result->status_code == '200' && $response->success) {
            $this->ci->db_wuling->update('wsa_data_suspect', ['prospect_id' => $response->data->id], ['id_prospek' => $id_prospek]);
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Data prospect sukses diupdate ke WSA dengan prospect id WSA ' . $response->data->id,
                ]
            );
            // echo 'Data prospect sukses diupdate ke WSA dengan prospect id WSA ' . $response->data->id;
        } else {
            return responseJson([
                'status' => false,
                'pesan'  => "Gagal update data prospect ke WSA:"
            ]);
            // echo 'Gagal update data prospect ke WSA: ';
            if (isset($response->data)) {
                return responseJson([
                    'status' => false,
                    'pesan'  => $this->format_response_messages(json_encode($response->data->messages)),
                ]);
                // echo $this->format_response_messages(json_encode($response->data->messages));
            }
            if (isset($result->status_code)) {
                return responseJson([
                    'status' => false,
                    'pesan'  => " (error code: {$result->status_code})",
                ]);
                // echo " (error code: {$result->status_code})";
            }
        }
    }

    public function input_followup_api($data_fu = null)
    {
        $id_prospek        = $this->ci->input->post('id_prospek_follow');
        $data_wsa          = $data_fu ? $data_fu : $this->ci->db_wuling
            ->select('wsas.id_prospek, wsas.prospect_id, adm_sales.kode_sales_sgmw AS salesman_id')
            ->select('wsaf.status_id, wsaf.next_followup_id, wsaf.w_insert AS w_insert_fu_wsa, wsaf.id_followup')
            ->select('wsaf.buy_plan, wsaf.remarks_id')
            ->from('wsa_data_suspect AS wsas')
            ->join('s_customer', 'wsas.id_prospek = s_customer.id_prospek')
            ->join('adm_sales', 's_customer.sales = adm_sales.id_sales')
            ->join('wsa_data_followup AS wsaf', 'wsas.id_prospek = wsaf.id_prospek')
            ->order_by('wsaf.id_followup', 'DESC')
            ->where('wsas.id_prospek', $id_prospek)->get()->first_row();
        $prospect_id       = $data_wsa->prospect_id ?? '';
        $request_url       = 'followup/' . $prospect_id;

        $salesman_id = $data_wsa->salesman_id ?? '';

        $data_wsa_insert = [
            'prospect_id'         => $prospect_id,   //  '{{prospect_id}}',
            'salesman_id'         => $salesman_id,   //  '{{salesman_id}}',
            'status_id'           => $data_wsa->status_id ?? '',   // '4',
            'remarks_id'          => $data_wsa->remarks_id ?? '',   // '4',
            'next_follow_up'      => $data_wsa->next_followup_id ?? '', //4
            'input_at'            => $data_wsa->w_insert_fu_wsa ?? '',   // '2023-02-01 10:00:00',
            'buy_plan'            => $data_wsa->buy_plan ?? '',   // '0-3 Months',
        ];

        $nama2_data = [
            'prospect_id'         => 'ID Prospek SGMW',
            'salesman_id'         => 'Kode Sales SGMW',
            'status_id'           => 'Status',
            'remarks_id'          => 'Remarks',
            'next_follow_up'      => 'Next Follow Up',
            'input_at'            => 'input_at',
            'buy_plan'            => 'Buy Plan',
        ];

        $data_validasi = [];
        foreach ($data_wsa_insert as $key => $value) {
            $data_validasi[$key] = [
                'name' => $nama2_data[$key],
                'value' => $value,
            ];
        }

        $validasi_kolom = $this->validasi_data_insert($data_validasi);
        if ($validasi_kolom) {
            return responseJson([
                'status' => false,
                'pesan'  => $validasi_kolom,
            ]);
            // echo $validasi_kolom;
            // return;
        }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        if ($result->status_code == '200' && $response->success) {
            $this->ci->db_wuling->update('wsa_data_followup', ['followup_id' => $response->data->id], ['id_followup' => $data_wsa->id_followup]);
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Data Follow Up sukses diupdate ke WSA dengan followup id WSA ' . $response->data->id,
                ]
            );
            // echo 'Data Follow Up sukses diupdate ke WSA dengan followup id WSA ' . $response->data->id;
        } else {
            return responseJson([
                'status' => false,
                'pesan'  => "Gagal update data Follow Up ke WSA! :"
            ]);
            // echo 'Gagal update data Follow Up ke WSA!';
            if (isset($response->data)) {
                return responseJson([
                    'status' => false,
                    'pesan'  => $this->format_response_messages(json_encode($response->data->messages)),
                ]);
                // echo $this->format_response_messages(json_encode($response->data->messages));
            }
            if (isset($result->status_code)) {
                return responseJson([
                    'status' => false,
                    'pesan'  => " (error code: {$result->status_code})",
                ]);
                // echo " (error code: {$result->status_code})";
            }
        }
    }

    public function input_followup_api_xylo($id_dl_customer)
    {
        $data_wsa = $this->ci->db_wuling
            ->select('fx.*')
            ->from('wsa_data_followup_xylo AS fx')
            ->join('digital_leads_followup AS dlf', 'dlf.id_followup = fx.id_followup_dl')
            ->join('digital_leads_customer AS dlc', 'dlc.id_dl_customer = dlf.id_dl_customer')
            ->where('dlc.id_dl_customer', $id_dl_customer)
            ->where('dlc.id_status_customer', 6) // ! lost
            ->order_by('fx.id_followup_dl', 'DESC')
            ->get()->first_row();
        $prospect_id       = $data_wsa->prospect_id;
        $request_url       = 'followup/' . $prospect_id;

        $data_wsa_insert = [
            'prospect_id'         => $prospect_id,
            'status_id'           => $data_wsa->status_id,
            'remarks_id'          => $data_wsa->remarks_id,
            'input_at'            => $data_wsa->w_insert,   // '2023-02-01 10:00:00',
            'buy_plan'            => $data_wsa->buy_plan,
        ];

        $nama2_data = [
            'prospect_id'         => 'ID Prospek SGMW',
            'status_id'           => 'Status',
            'remarks_id'          => 'Remarks',
            'input_at'            => 'input_at',
            'buy_plan'            => 'Buy Plan',
        ];

        $data_validasi = [];
        foreach ($data_wsa_insert as $key => $value) {
            $data_validasi[$key] = [
                'name' => $nama2_data[$key],
                'value' => $value,
            ];
        }
        $data_wsa_insert['follow_up_dummy'] = 1;

        $validasi_kolom = $this->validasi_data_insert($data_validasi);
        if ($validasi_kolom) {
            echo $validasi_kolom;
            return;
        }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        if ($response->success) {
            $this->ci->db_wuling->update('wsa_data_followup_xylo', ['followup_id' => $response->data->id], ['id_followup_dl' => $data_wsa->id_followup_dl]);
            echo 'Data Follow Up sukses diupdate ke WSA dengan followup id WSA ' . $response->data->id;
        } else {
            echo 'Gagal update data Follow Up ke WSA!';
            if (isset($response->data)) {
                echo $this->format_response_messages(json_encode($response->data->messages));
            }
            if (isset($result->status_code)) {
                echo " (error code: {$result->status_code})";
            }
        }
    }

    public function schedule_test_drive_api($id_prospek)
    {
        // $id_prospek        = $this->ci->input->post('id_prospek');
        $data_test_drive   = $this->ci->db_wuling
            ->select('wsts.id, wsas.prospect_id, wsas.salesman_id')
            ->select('CASE st.tempat 
                        WHEN "d" THEN "Dealer" 
                        WHEN "r" THEN "Rumah Customer" 
                        WHEN "k" THEN "Kantor" 
                        WHEN "p" THEN "Area Publik" 
                        WHEN "l" THEN "Lain-lain" ELSE "Lain-lain" 
                    END AS location', false)
            ->select('st.tgl_jam AS start_at, st.tgl_jam, st.w_insert AS input_at')
            ->from('wsa_data_suspect AS wsas')
            ->join('wsa_data_test_drive AS wsts', 'wsas.id_prospek = wsts.id_prospek', 'left')
            ->join('s_survei_proses AS ssp', 'wsas.id_prospek = ssp.id_prospek')
            ->join('s_test_drive AS st', 'wsas.id_prospek = st.id_prospek')
            // ->where('st.verified', '1') // dari marketing_admin/.../M_wuling_marketing_support: verifikasi_test_drive()
            ->where('wsas.id_prospek', $id_prospek)->get()->first_row();

        // debug($data_test_drive);

        $prospect_id       = $data_test_drive->prospect_id;
        $request_url       = 'testdrive/' . $prospect_id;

        $startAt = new DateTime($data_test_drive->start_at);
        $endAt = new DateTime($data_test_drive->tgl_jam);
        $endAt->add(new \DateInterval('PT2H')); //add 1 hour

        $inputAt = new DateTime($data_test_drive->input_at);

        $data_wsa_insert = [
            'prospect_id'  => $prospect_id, //{{prospect_id}}
            'salesman_id'  => $data_test_drive->salesman_id, //{{salesman_id}}
            'category'     => 'Test Drive', //Test Drive
            'location'     => $data_test_drive->location, //Dealer
            'start_at'     => $startAt->format('Y-m-d H:i:s'), //2023-01-03 15:00:00
            'end_at'       => $endAt->format('Y-m-d H:i:s'), //2023-01-03 15:30:00
            'input_at'     => $inputAt->format('Y-m-d H:i:s'), //2023-01-02 10:25:00
        ];


        $hasil['success'] = false;
        $hasil['message'] = 'Gagal update data Test Drive ke WSA';

        $nama2_data = [
            'prospect_id'  => 'ID Prospek SGMW',
            'salesman_id'  => 'Kode Sales SGMW',
            'category'     => 'Test Drive',
            'location'     => 'Tempat Test Drive',
            'start_at'     => 'Tanggal/Jam Test Drive',
            'end_at'       => 'end_at',
            'input_at'     => 'input_at',
        ];

        $data_validasi = [];
        foreach ($data_wsa_insert as $key => $value) {
            $data_validasi[$key] = [
                'name' => $nama2_data[$key],
                'value' => $value,
            ];
        }

        $validasi_kolom = $this->validasi_data_insert($data_validasi);
        if ($validasi_kolom) {
            $hasil['message'] = $validasi_kolom;
            echo json_encode($hasil);
            return;
        }

        if (!empty($data_test_drive->id) || $data_test_drive->id != 0) {
            $hasil['message'] = 'Data sudah ada di WSA dengan test drive id ' . $data_test_drive->id;
            echo json_encode($hasil);
            return;
        }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        if ($result->status_code == '200' && $response->success) {
            $this->ci->db_wuling->insert('wsa_data_test_drive', [
                'id' => $response->data->id,
                'id_prospek' => $id_prospek,
                'prospect_id' => $prospect_id,
                'schedule_id' => $response->data->schedule_id,
            ]);

            $hasil['success'] = true;
            $hasil['message'] = 'Data Test Drive sukses diupdate ke WSA dengan id ' . $response->data->id;

            // $upload_test_drive_proof_api = $this->upload_test_drive_proof_api($response->data->id);

            // if ($upload_test_drive_proof_api['status']) {
            //     $hasil['message'] .= ".\n" . $upload_test_drive_proof_api['message'];
            // } else {
            //     $hasil['success'] = false;
            //     $hasil['message'] .= ".\n" . $upload_test_drive_proof_api['message'];
            // }
        } else {
            $hasil['message'] .= ".\n" . json_encode($response->data->messages);
        }

        echo json_encode($hasil);
    }

    public function upload_test_drive_proof_api($test_drive_id)
    {
        $data_test_drive   = $this->ci->db_wuling
            ->select('wsas.id_prospek, wsas.prospect_id, wsas.salesman_id, 
                wstd.id AS test_drive_id, wstd.schedule_id AS schedule_id, stdt.foto_sim AS sim_photo, 
                stdt.foto_test_drive AS proof_photo, pt.wsa_model_id AS test_drive_product, std.w_insert AS upload_at')
            ->from('wsa_data_suspect AS wsas')
            ->join('s_customer AS sc', 'wsas.id_prospek = sc.id_prospek')
            ->join('wsa_data_test_drive AS wstd', 'wsas.prospect_id = wstd.prospect_id')
            ->join('s_test_drive AS std', 'wsas.id_prospek = std.id_prospek')
            ->join('s_test_drive_detail AS stdt', 'std.id_test_drive = stdt.id_test_drive')
            ->join('p_varian AS pv', 'std.id_varian = pv.id_varian')
            ->join('p_type AS pt', 'pv.id_type = pt.id_type')
            ->where('wstd.id', $test_drive_id)->get()->first_row();
        $prospect_id       = $data_test_drive->prospect_id;
        $request_url       = 'testdrive/' . $prospect_id . '/' . $test_drive_id;

        $sim_photo         = FCPATH . 'assets/images_test_drive/' . $data_test_drive->sim_photo;
        $proof_photo       = FCPATH . 'assets/images_test_drive/' . $data_test_drive->proof_photo;

        $data_wsa_insert = [
            'prospect_id'        => $prospect_id, //{{prospect_id}}
            'salesman_id'        => $data_test_drive->salesman_id, //{{salesman_id}}
            'test_drive_id'      => $data_test_drive->test_drive_id, //{{test_drive_id}}
            'schedule_id'        => $data_test_drive->schedule_id, //{{schedule_id}}
            'sim_photo'          => new CURLfile($sim_photo), // pic
            'proof_photo'        => new CURLfile($proof_photo), // pic
            'test_drive_product' => $data_test_drive->test_drive_product, //5
            'upload_at'          => $data_test_drive->upload_at, //2023-01-03 16:00:00
        ];

        $nama2_data = [
            'prospect_id'        => 'ID Prospek SGMW',
            'salesman_id'        => 'Kode Sales SGMW',
            'test_drive_id'      => 'ID Test Drive SGMW',
            'schedule_id'        => 'schedule_id SGMW',
            'sim_photo'          => 'sim_photo',
            'proof_photo'        => 'proof_photo',
            'test_drive_product' => 'Type Kendaraan Test Drive',
            'upload_at'          => 'upload_at',
        ];

        $data_validasi = [];
        foreach ($data_wsa_insert as $key => $value) {
            $data_validasi[$key] = [
                'name' => $nama2_data[$key],
                'value' => $value,
            ];
        }
        unset($nama2_data['sim_photo']);
        unset($nama2_data['proof_photo']);

        $validasi_kolom = $this->validasi_data_insert($data_validasi, 'Test Drive Proof');
        if ($validasi_kolom) {
            $hasil['status'] = false;
            $hasil['message'] = $validasi_kolom;
            return $hasil;
        }

        $sim_photo_bisa_terbuka = @fopen($sim_photo, 'r');
        $proof_photo_bisa_terbuka = @fopen($proof_photo, 'r');
        if (!$sim_photo_bisa_terbuka || !$proof_photo_bisa_terbuka) {
            $hasil['status'] = false;
            $hasil['message'] = "Gagal update data Test Drive Proof ke WSA: \n";
            $hasil['message'] .= !$sim_photo_bisa_terbuka ? "- file foto pengenal (sim photo) tidak bisa terbuka.\n" : "";
            $hasil['message'] .= !$proof_photo_bisa_terbuka ? "- file foto test drive (proof photo) tidak bisa terbuka.\n" : "";
            fclose($sim_photo_bisa_terbuka);
            fclose($proof_photo_bisa_terbuka);
            return $hasil;
        } else {
            fclose($sim_photo_bisa_terbuka);
            fclose($proof_photo_bisa_terbuka);
        }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $data_wsa_insert['id_prospek'] = $data_test_drive->id_prospek;
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        $hasil['status'] = $result->status_code == '200' && $response->success;

        if ($hasil['status']) {
            $updateProofTestDrive = [
                'proof_test_drive' => '1'
            ];

            $this->ci->db_wuling->where('prospect_id', $prospect_id);
            $this->ci->db_wuling->update('wsa_data_test_drive', $updateProofTestDrive);

            $hasil['message'] = 'Data Test Drive Proof sukses diupdate ke WSA dengan id Test Drive ' . $response->data->id;
        } else {
            $hasil['message'] = 'Gagal update data Test Drive Proof ke WSA: ' .
                (isset($response->data) ? $this->format_response_messages(json_encode($response->data->messages)) : '');
        }

        return $hasil;
    }

    public function input_spk_api()
    {
        $id_prospek        = $this->ci->input->post('id_prospek');
        $data_spk          = $this->ci->db_wuling
            ->select('wsas.prospect_id, wspk.spk_id, wsas.salesman_id, s.tgl_spk AS spk_at, 
                s.harga_otr AS otr_price, s.keterangan AS notes, s.no_rangka AS vin_no, hp.tdp AS payment_dp, 
                hp.tenor AS payment_tenor, hp.cicilan AS payment_installment, s.diskon AS payment_discount, 
                sp.kode_unit AS product, sc.nama AS faktur_name, sc.alamat AS faktur_address, 
                sc.cara_bayar AS payment_type, pt.wsa_model_id AS product_model_id, 
                pw.wsa_color_id AS product_color_id, pv.wsa_product_id AS product_type_id, 
                s.w_insert AS input_at, wsas.id_prospek, s.no_spk AS spk_no, s.uang_muka AS payment_booking_fee,
                l.id_leasing, l.id_leasing_wsa')
            ->from('wsa_data_suspect AS wsas')
            ->join('wsa_data_spk AS wspk', 'wsas.id_prospek = wspk.id_prospek', 'left')
            ->join('s_customer AS sc', 'wsas.id_prospek = sc.id_prospek', 'left')
            ->join('s_spk AS s', 'wsas.id_prospek = s.id_prospek', 'left')
            ->join('s_prospek AS sp', 'wsas.id_prospek = sp.id_prospek', 'left')
            ->join('s_hot_prospek AS hp', 'wsas.id_prospek = hp.id_prospek', 'left')
            ->join('unit AS u', 'sp.kode_unit = u.kode_unit', 'left')
            ->join('p_type AS pt', 'u.id_type = pt.id_type', 'left')
            ->join('p_varian AS pv', 'u.id_varian = pv.id_varian', 'left')
            ->join('p_warna AS pw', 'u.id_warna = pw.id_warna', 'left')
            ->join('leasing AS l', 's.id_leasing = l.id_leasing', 'left')
            ->where('wsas.id_prospek', $id_prospek)->get()->first_row();

        if (!isset($data_spk->prospect_id)) {
            $this->ci->output->set_status_header(500);
            echo 'Customer tidak memiliki prospect id WSA';
            return;
        }

        $prospect_id       = $data_spk->prospect_id;
        $request_url       = 'spk/' . $prospect_id;

        $data_additional_accessories = '-';

        $payment_dp_percentage = floor(($data_spk->payment_dp / $data_spk->otr_price) * 100);

        $payment_type = '';
        if ($data_spk->payment_type == 'c') $payment_type = 'Cash';
        else if ($data_spk->payment_type == 'k') $payment_type = 'Credit';

        // payment_paying_off = harga - diskon (yg belum diapprove) - tanda jadi (walaupun belum terbayarkan)
        // (s_spk.harga_otr - s_spk.payment_discount - s_spk.uang_muka)
        $payment_paying_off = 0;
        if ($data_spk->payment_type == 'c') {
            $payment_paying_off = $data_spk->otr_price - $data_spk->payment_discount - $data_spk->payment_booking_fee;
        }

        $data_wsa_insert = [
            'prospect_id'               => $prospect_id, //{{prospect_id}}
            'salesman_id'               => $data_spk->salesman_id, //{{salesman_id}}
            'spk_no'                    => $data_spk->spk_no, // 19-0056
            'faktur_name'               => $data_spk->faktur_name, // Andi Susanto
            'faktur_address'            => $data_spk->faktur_address, // Jl Selalu Bahagia No. 70, Jakarta
            'additional_accessories'    => $data_additional_accessories, // banw
            'qty'                       => 1, // 1
            'product_type_id'           => $data_spk->product_type_id, // 28
            'product_color_id'          => $data_spk->product_color_id, // 13
            'product_model_id'          => $data_spk->product_model_id, // 5
            'otr_price'                 => $data_spk->otr_price, // 300000000
            'payment_type'              => $payment_type, // Credit
            'payment_dp_percentage'     => $payment_dp_percentage, // 25
            'payment_dp'                => $data_spk->payment_dp, // 75000000
            'payment_installment'       => $data_spk->payment_installment, // 5000000
            'payment_tenor'             => $data_spk->payment_tenor, // 60
            'payment_booking_fee'       => $data_spk->payment_booking_fee, // 5000000
            'payment_discount'          => $data_spk->payment_discount, // 150000000
            'payment_paying_off'        => $payment_paying_off, // 150000000
            'notes'                     => $data_spk->notes, // notes
            'spk_at'                    => $data_spk->spk_at, // 2023-01-03
            'input_at'                  => date('Y-m-d H:i:s'), // 2023-01-03 16:50:00
        ];
        if ($data_spk->payment_type == 'k') $data_wsa_insert['leasing_id'] = $data_spk->id_leasing_wsa;

        // if (!empty($data_spk->spk_id) || $data_spk->spk_id != 0) {
        //     echo 'Data sudah ada di WSA dengan SPK id WSA ' . $data_spk->spk_id;
        //     return;
        // }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $data_wsa_insert['no_spk'] = $data_spk->spk_no;
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        if ($result->status_code == '200' && $response->success && $response->data->id) {
            $this->ci->db_wuling->replace('wsa_data_spk', [
                'id_prospek'    => $id_prospek,
                'prospect_id'   => $prospect_id,
                'spk_id'        => $response->data->id,
                'no_spk'        => $data_spk->spk_no,
            ], ['id_prospek' => $data_spk->id_prospek]);

            $upload_spk_proof_api = $this->upload_spk_proof_api($response->data->id);

            if ($upload_spk_proof_api['status']) {
                $hasil = 'Data SPK sukses diupdate ke WSA dengan SPK id ' . $response->data->id;
                $hasil .= ".\n" . $upload_spk_proof_api['message'];
            } else {
                $hasil = $upload_spk_proof_api['message'];
            }
            echo $hasil;
        } else {
            echo 'Gagal input data SPK ke WSA: ';
            if (isset($response->code) && $response->code == 115) {
                echo $this->format_response_messages(json_encode($response->data->messages));
            } else if (isset($response->error) && $response->error == 403) {
                echo json_encode($response->message);
            }
        }
    }

    public function upload_spk_proof_api($spk_id)
    {
        $data_wsa          = $this->ci->db_wuling
            ->select('wsas.id_prospek, wspk.spk_id, wspk.no_spk, wsas.prospect_id, wsas.salesman_id,
                    sc.payment_foto AS payment_photo')
            ->from('wsa_data_suspect AS wsas')
            ->join('wsa_data_spk AS wspk', 'wsas.prospect_id = wspk.prospect_id')
            ->join('s_customer AS sc', 'wsas.id_prospek = sc.id_prospek')
            ->where('wspk.spk_id', $spk_id)->get()->first_row();
        $prospect_id       = $data_wsa->prospect_id;
        $spk_id            = $data_wsa->spk_id;
        $request_url       = 'spk/' . $prospect_id . '/' . $spk_id;

        $payment_photo     = FCPATH . 'assets/payment_foto/wuling/' . $data_wsa->payment_photo;

        $data_wsa_insert = [
            'prospect_id'      => $prospect_id, //{{prospect_id}}
            'salesman_id'      => $data_wsa->salesman_id, //{{salesman_id}}
            'spk_id'           => $data_wsa->spk_id,
            'payment_photo'    => new CURLfile($payment_photo),
            'upload_at'        => date('Y-m-d H:i:s'), // 2023-01-03 16:50:00
        ];

        $payment_photo_bisa_terbuka = @fopen($payment_photo, 'r');
        if (!$payment_photo_bisa_terbuka) {
            $hasil['status'] = false;
            $hasil['message'] = "Gagal update data SPK Proof ke WSA: \n";
            $hasil['message'] .= !$payment_photo_bisa_terbuka ? "- file Bukti Pembayaran SPK (payment photo) tidak bisa terbuka.\n" : "";
            return $hasil;
        } else {
            fclose($payment_photo_bisa_terbuka);
        }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $data_wsa_insert['no_spk'] = $data_wsa->no_spk;
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        $hasil['status'] = $result->status_code == '200' && $response->success;
        if ($hasil['status']) {
            $updateProofSpk = [
                'proof_spk' => '1',
            ];
            $this->ci->db_wuling->where('spk_id', $spk_id);
            $this->ci->db_wuling->update('wsa_data_spk', $updateProofSpk);
            $hasil['message'] = 'Data SPK Proof sukses diupdate ke WSA dengan SPK id ' . $response->data->spk_id;
        } else {
            $hasil['message'] = 'Gagal update data SPK Proof ke WSA' .
                json_encode(isset($response->data) ? ': ' . $response->data : '');
        }

        return $hasil;
    }

    public function input_do_api($no_spk, $data_wsa, $tgl_do_sgmw, $tgl_do_pengiriman, $code_pos, $kode_sales_wsa)
    {

        $tgl_do         = tgl_sql($tgl_do_sgmw);
        $tgl_pengiriman = tgl_sql($tgl_do_pengiriman);
        $input_at       = date($tgl_do . ' H:i:s');
        $schedule_at    = date($tgl_pengiriman . ' H:i:s');

        $id_do_sgmw  = $this->ci->db_wuling->select('id_do_sgmw')->from('wsa_do')
            ->where('no_faktur', $data_wsa->no_transaksi)
            ->order_by('id_do_sgmw', 'DESC')
            ->limit(1)->get()->row('id_do_sgmw');
        if (!empty($id_do_sgmw) || $id_do_sgmw != null) {
            $return = [
                'status' => false,
                'pesan'  => 'Data sudah ada di WSA dengan DO id WSA ' . $id_do_sgmw,
            ];
            echo json_encode($return);
            exit;
        }

        $data_suspect_wsa  = $this->ci->db_wuling->get_where('wsa_data_suspect', ['id_prospek' => $data_wsa->id_prospek])->first_row();
        $prospect_id       = $data_suspect_wsa->prospect_id;
        $spk_id            = $data_wsa->spk_id;
        $request_url       = 'do/' . $prospect_id;
        $salesman_id       = $kode_sales_wsa;

        $data_wsa_insert = [
            'prospect_id'                      => $prospect_id, //{{prospect_id}}
            'salesman_id'                      => $salesman_id, //{{salesman_id}}
            'spk_id'                           => $spk_id, //{{spk_id}}
            'faktur_no'                        => $data_wsa->no_transaksi, //19-0056
            'shipping_name'                    => $data_wsa->nama, //Andi Susanto
            'shipping_phone_number'            => $data_wsa->telepone, //+62812344434
            'shipping_address'                 => $data_wsa->alamat, //Jl Selalu Bahagia
            'shipping_address_detail'          => $data_wsa->alamat, //No. 70 Jakarta
            'shipping_address_code'            => $code_pos, //12345
            'vehicles_identification_number'   => $data_wsa->no_rangka, //MK3AACE24PJ000553
            'product_color_id'                 => $data_wsa->wsa_color_id,
            'schedule_at'                      => $schedule_at,
            'input_at'                         => $input_at, //2023-01-03 17:00:00
        ];
        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        // debug($data_wsa, $data_wsa_insert, $response);
        if ($result->status_code == '200' && $response->success && $response->data->id) {
            $this->ci->db_wuling->replace('wsa_do', [
                'prospek_id'             => $prospect_id,
                'id_spk_sgwm'            => $spk_id,
                'id_do_sgmw'             => $response->data->id,
                'no_faktur'              => $response->data->faktur_no,
                'tgl_do_sgmw'            => $input_at,
                'tgl_do_pengiriman_sgmw' => $schedule_at,
                'id_perusahaan'          => $data_wsa->id_perusahaan,
            ], ['prospek_id' => $prospect_id]);
            $return = [
                'status' => true,
                'pesan' => 'Data sukses diupdate ke WSA dengan id DO WSA ' . $response->data->id,
            ];
            echo json_encode($return);
        } else {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data DO ke WSA: ',
            ];
            if (isset($response->code) && $response->code == 115) {
                $return['pesan'] .= $this->format_response_messages(json_encode($response->data->messages));
                echo json_encode($return);
            } else if (isset($response->error) && $response->error == 403) {
                $return['pesan'] .= $response->message;
                echo json_encode($return);
            }
        }
    }

    public function upload_do_proof_api($id_prospek, $data_wsa, $kode_sales_wsa)
    {
        $data_suspect_wsa = $this->ci->db_wuling->get_where('wsa_data_suspect', ['id_prospek' => $id_prospek])->first_row();
        $data_do_wsa      = $this->ci->db_wuling->get_where('wsa_do', ['no_faktur' => $data_wsa->no_transaksi])->first_row();
        $prospect_id      = $data_suspect_wsa->prospect_id;
        $do_id            = $data_do_wsa->id_do_sgmw;
        $request_url      = 'do/' . $prospect_id . '/' . $do_id;
        $salesman_id      = $kode_sales_wsa;

        $bukti_penerimaan_unit = FCPATH . 'assets/penerimaan_unit_foto/wuling/' . $data_wsa->payment_foto;
        // debug($bukti_penerimaan_unit);
        $data_wsa_insert = [
            'prospect_id'      => $prospect_id, //{{prospect_id}}
            'salesman_id'      => $salesman_id, //{{salesman_id}}
            'do_id'            => $do_id, //{{do_id}}
            'proof_photo'      =>  new CURLfile($bukti_penerimaan_unit),
            'upload_at'        => date('Y-m-d H:i:s'),
        ];

        $payment_photo_bisa_terbuka = @fopen($bukti_penerimaan_unit, 'r');
        if (!$payment_photo_bisa_terbuka) {
            $return['status'] = false;
            $return['pesan'] = "Gagal update data DO Proof ke WSA: \n";
            $return['pesan'] .= !$payment_photo_bisa_terbuka ? "- foto Bukti DO tidak bisa terbuka.\n" : "";
            echo json_encode($return);
            return;
        } else {
            fclose($payment_photo_bisa_terbuka);
        }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);

        $response = json_decode($result->response);
        // debug($response, $result);
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        // debug($response, $data_wsa_insert, $request_url);
        if ($result->status_code == '200' && $response->success) {
            $updateProofDo = [
                'proof_do' => 'Sukses Proof Do'
            ];
            $this->ci->db_wuling->where('id_do_sgmw', $do_id);
            $this->ci->db_wuling->update('wsa_do', $updateProofDo);
            $return = [
                'status' => true,
                'pesan'  => 'Data sukses diupdate ke WSA dengan id DO WSA ' . $response->data->id,
            ];
            echo json_encode($return);
        } else {
            $return = [
                'status' => false,
                'pesan' => 'Gagal update data DO Proof ke WSA : ' . $response->messag,
            ];
            if (isset($response->code) && $response->code == 115) {
                $return['pesan'] .= $this->format_response_messages(json_encode($response->data->messages));
                echo json_encode($return);
            } else if (isset($response->error) && $response->error == 403) {
                $return['pesan'] .= $response->message;
                echo json_encode($return);
            } else {
                echo json_encode($return);
            }
        }
    }

    public function cancel_do_api($tgl_cencel_do_sgmw, $reson_cencel, $no_faktur, $id_prospek)
    {
        $tgl_do_cencel    = tgl_sql($tgl_cencel_do_sgmw);
        $cancel_at        = date($tgl_do_cencel . ' H:i:s');
        $data_suspect_wsa = $this->ci->db_wuling->get_where('wsa_data_suspect', ['id_prospek' => $id_prospek])->first_row();
        $data_do_wsa      = $this->ci->db_wuling->get_where('wsa_do', ['no_faktur' => $no_faktur])->first_row();
        $prospect_id      = $data_suspect_wsa->prospect_id;
        $do_id            = $data_do_wsa->id_do_sgmw;
        $request_url      = 'do/' . $prospect_id . '/' . $do_id . '/cancel';

        $data_wsa_insert = [
            'prospect_id' => $prospect_id, //{{prospect_id}}
            'salesman_id' => $data_suspect_wsa->salesman_id, //{{salesman_id}}
            'do_id' => $do_id, //{{do_id}}
            'cancel_reason' => $reson_cencel, //membeli mobil lain
            'cancel_at' => $cancel_at, //2023-01-03 16:00:00
        ];
        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        debug($response);
        if ($result->status_code == '200' && $response->success) {
            $this->ci->db_wuling->insert('wsa_do_cencel', [
                'id_do_sgmw'    => $response->data->id,
                'no_faktur'     => $no_faktur,
                'tgl_do_cencel' => $cancel_at,
            ]);
            $return = [
                'status' => true,
                'pesan' => 'Data batal DO sukses diupdate ke WSA dengan id DO WSA ' . $response->data->id,
            ];
            responseJson($return);
        } else {
            $return = [
                'status' => false,
                'pesan' => 'Gagal update data batal DO ke WSA: ',
            ];
            if (isset($response->code) && $response->code == 115) {
                $return['pesan'] .= $this->format_response_messages(json_encode($response->data->messages));
                echo json_encode($return);
            } else if (isset($response->error) && $response->error == 403) {
                $return['pesan'] .= $response->message;
                echo json_encode($return);
            }
        }
    }
    public function cancel_spk_api()
    {
        $no_spk        = $this->ci->input->post('no_spk');
        $data_wsa      = $this->ci->db_wuling
            ->select('wsas.id_prospek, wspk.spk_id, wspk.no_spk, wsas.prospect_id, wsas.salesman_id, 
                    spkbtl.keterangan AS cancel_reason, spkbtl.w_insert AS cancel_at')
            ->from('wsa_data_suspect AS wsas')
            ->join('wsa_data_spk AS wspk', 'wsas.prospect_id = wspk.prospect_id')
            ->join('s_spk_batal AS spkbtl', 'wspk.no_spk = spkbtl.no_spk')
            ->where('wspk.no_spk', $no_spk)->get()->first_row(); // todo: tes
        $prospect_id       = $data_wsa->prospect_id;
        $spk_id            = $data_wsa->spk_id;
        $request_url       = 'spk/' . $prospect_id . '/' . $spk_id . '/cancel';

        $data_wsa_insert = [
            'prospect_id'      => $prospect_id, //{{prospect_id}}
            'salesman_id'      => $data_wsa->salesman_id, //{{salesman_id}}
            'spk_id'           => $spk_id, //{{spk_id}}
            'cancel_reason'    => $data_wsa->cancel_reason, //membeli mobil lain
            'cancel_at'        => $data_wsa->cancel_at, //2023-01-03 16:00:00
        ];

        $nama2_data = [
            'prospect_id'      => 'ID Prospek SGMW',
            'salesman_id'      => 'Kode Sales SGMW',
            'spk_id'           => 'SPK id SGMW',
            'cancel_reason'    => 'Keterangan Batal',
            'cancel_at'        => 'cancel_at',
        ];

        $data_validasi = [];
        foreach ($data_wsa_insert as $key => $value) {
            $data_validasi[$key] = [
                'name' => $nama2_data[$key],
                'value' => $value,
            ];
        }

        $validasi_kolom = $this->validasi_data_insert($data_validasi);
        if ($validasi_kolom) {
            echo $validasi_kolom;
            return;
        }

        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $data_wsa_insert['no_spk'] = $data_wsa->no_spk;
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        if ($result->status_code == '200' && $response->success && $response->data->id) {
            $hasil = 'Batal SPK sukses diupdate ke WSA dengan SPK id ' . $response->data->id;
            echo $hasil;
        } else {
            echo 'Gagal update data batal SPK ke WSA: ';
            if (isset($response->code) && $response->code == 115) {
                echo $this->format_response_messages(json_encode($response->data->messages));
            } else if (isset($response->error) && $response->error == 403) {
                echo json_encode($response->message);
            }
        }
    }

    public function validasi_prospek_wsa($post, $data_suspect_wsa, $kode_spv_wsa)
    {
        // debug('tes');
        $request_url       = 'prospect/' . $data_suspect_wsa->prospect_id . '/validate';
        $data_wsa_insert = [
            'prospect_id'   => $data_suspect_wsa->prospect_id,   //{{prospect_id}}
            'supervisor_id' => $kode_spv_wsa,                    //{{salesman_id}}
            'buy_plan'      => $post['buy_plan'],               //{{0-3 Months", "3-6 Months", atau ">6 Months}}
            'input_at'      => date('Y-m-d H:i:s'),              //2023-01-03 17:00:00
        ];
        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);


        if ($response->success == true && $result->status_code == '200' && $response->success) {
            $updateValidasiSuspect = [
                'validasi_suspect' => '1'
            ];

            $this->ci->db_wuling->where('prospect_id', $data_suspect_wsa->prospect_id);
            $this->ci->db_wuling->update('wsa_data_suspect', $updateValidasiSuspect);
            $return = [
                'status' => true,
                'pesan' => 'Data sukses diupdate ke WSA : ' . $response->message,
            ];
            echo json_encode($return);
        } else {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data DO ke WSA: ' . $response->message,
            ];
            if (isset($response->code) && $response->code == 115) {
                $return['pesan'] .= $this->format_response_messages(json_encode($response->data->messages));
                echo json_encode($return);
            } else if (isset($response->error) && $response->error == 403) {
                $return['pesan'] .= $response->message;
                echo json_encode($return);
            }
        }
    }

    public function validasi_test_drive_wsa($post)
    {
        $request_url       = 'testdrive/' . $post['id_test_drive_wsa'] . '/validate';
        $data_wsa_insert = [
            'test_drive_id' => $post['id_test_drive_wsa'],
            'status'        => $post['status_wsa'],
            'reason'        => $post['reson_wsa'],
        ];
        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        if ($response->success == true && $result->status_code == '200') {
            $updateValidasiTestDrive = [
                'validation_status' => $response->data->validation_status,
            ];
            $this->ci->db_wuling->where('prospect_id', $post['prospect_id']);
            $this->ci->db_wuling->update('wsa_data_test_drive', $updateValidasiTestDrive);

            if ($response->data->validation_status == 'Declined') {
                $updateProofTestDriveValidasi = [
                    'proof_test_drive' => null,
                ];
                $this->ci->db_wuling->where('prospect_id', $post['prospect_id']);
                $this->ci->db_wuling->update('wsa_data_test_drive', $updateProofTestDriveValidasi);
            } else {
                $updateProofTestDriveValidasi = [
                    'proof_test_drive' => '1',
                ];
                $this->ci->db_wuling->where('prospect_id', $post['prospect_id']);
                $this->ci->db_wuling->update('wsa_data_test_drive', $updateProofTestDriveValidasi);
            }
            $return = [
                'status' => true,
                'pesan' => 'Data sukses diupdate ke WSA ' . $response->message,
            ];
            echo json_encode($return);
        } else  if (isset($response->code) && $response->code == 115) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi test drive ke WSA : ' . $this->format_response_messages(json_encode($response->data->messages)),
            ];
            echo json_encode($return);
        } else if (isset($response->error) && $response->error == 403) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi test drive ke WSA : ' . $response->message,
            ];
            echo json_encode($return);
        }
        // }

    }

    public function validasi_spk_wsa($post)
    {
        $request_url       = 'spk/' . $post['id_spk_sgmw'] . '/validate';
        $data_wsa_insert = [
            'test_drive_id' => $post['id_spk_sgmw'],
            'status'        => $post['status_wsa'],
            'reason'        => $post['reson_wsa'],
        ];
        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);

        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        if ($response->success == true && $result->status_code == '200') {
            $updateValidasiTestDrive = [
                'validation_status' => $response->data->validation_status,
            ];
            $this->ci->db_wuling->where('spk_id', $post['id_spk_sgmw']);
            $this->ci->db_wuling->update('wsa_data_spk', $updateValidasiTestDrive);

            if ($response->data->validation_status == 'Declined') {
                $updateProofTestDriveValidasi = [
                    'proof_spk' => null,
                ];
                $this->ci->db_wuling->where('spk_id', $post['id_spk_sgmw']);
                $this->ci->db_wuling->update('wsa_data_spk', $updateProofTestDriveValidasi);
            } else {
                $updateProofTestDriveValidasi = [
                    'proof_spk' => '1',
                ];
                $this->ci->db_wuling->where('spk_id', $post['id_spk_sgmw']);
                $this->ci->db_wuling->update('wsa_data_spk', $updateProofTestDriveValidasi);
            }
            $return = [
                'status' => true,
                'pesan' => 'Data sukses diupdate ke WSA ' . $response->message,
            ];
            echo json_encode($return);
        } else  if (isset($response->code) && $response->code == 115) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi SPK ke WSA : ' . $this->format_response_messages(json_encode($response->data->messages)),
            ];
            echo json_encode($return);
        } else if (isset($response->error) && $response->error == 403) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi SPK ke WSA : ' . $response->message,
            ];
            echo json_encode($return);
        }
        // }
    }

    public function validasi_do_wsa($post)
    {
        $request_url       = 'do/' . $post['id_do_sgmw'] . '/validate';
        $data_wsa_insert = [
            'test_drive_id' => $post['id_do_sgmw'],
            'status'        => $post['status_wsa'],
            'reason'        => $post['reson_wsa'],
        ];
        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);
        // debug($response);
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);

        if (!empty($response->success) == true && $result->status_code == '200') {
            $updateValidasiTestDrive = [
                'validation_status' => $response->data->status,
            ];
            $this->ci->db_wuling->where('id_do_sgmw', $post['id_do_sgmw']);
            $this->ci->db_wuling->update('wsa_do', $updateValidasiTestDrive);

            if ($response->data->status == 'Declined') {
                $updateProofTestDriveValidasi = [
                    'proof_do' => null,
                ];
                $this->ci->db_wuling->where('id_do_sgmw', $post['id_do_sgmw']);
                $this->ci->db_wuling->update('wsa_do', $updateProofTestDriveValidasi);
            } else {
                $updateProofTestDriveValidasi = [
                    'proof_do' => 'Sukes Proof Do',
                ];
                $this->ci->db_wuling->where('id_do_sgmw', $post['id_do_sgmw']);
                $this->ci->db_wuling->update('wsa_do', $updateProofTestDriveValidasi);
            }
            $return = [
                'status' => true,
                'pesan' => 'Data sukses diupdate ke WSA ' . $response->message,
            ];
            echo json_encode($return);
        } else  if (isset($response->code) && $response->code == 115) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi DO ke WSA : ' . $this->format_response_messages(json_encode($response->data->messages)),
            ];
            echo json_encode($return);
        } else if (isset($response->error) && $response->error == 403) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi DO ke WSA : ' . $response->message,
            ];
            echo json_encode($return);
        } else if (isset($response->error) && $response->error == 113) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi DO ke WSA : ' . $response->message,
            ];
            echo json_encode($return);
        } elseif ($response == null) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi DO ke WSA : The api 404 not found ',
            ];
            echo json_encode($return);
        }
    }

    public function folloup_spv($post, $data_wsa, $id_spv_sgmw)
    {
        // debug($post);
        $request_url       = 'followup/' . $data_wsa->prospect_id;
        $data_wsa_insert = [
            'prospect_id'    => $data_wsa->prospect_id,
            'salesman_id'    => $data_wsa->salesman_id,
            'supervisor_id'  => $id_spv_sgmw,
            'status_id'      => $post['status_id_follow'],
            'remarks_id'     => $post['remarks_id_follow'],
            'next_follow_up' => $post['next_followup_id_follow'],
            'notes'          => $post['keterangan_follow'],
            'whatsapp_at'    => date('Y-m-d H:i:s'),
            'input_at'       => date('Y-m-d H:i:s'),
            'buy_plan'       => $post['buy_plan_follow'],
        ];
        $result = $this->request_api($request_url, 'post', null, $data_wsa_insert);
        $response = json_decode($result->response);
        // debug($response);
        $this->log(json_encode($data_wsa_insert),  $result->status_code, $result->response, $request_url);


        if (!empty($response->success) == true && $result->status_code == '200') {
            $insertFuSpv = [
                'id_prospek'       => $post['id_prospek_follow'],
                'followup_id'      => $response->data->id,
                'status_id'        => $post['status_id_follow'],
                'buy_plan'         => $post['buy_plan_follow'],
                'next_followup_id' => $post['next_followup_id_follow'],
                'remarks_id'       => $post['remarks_id_follow'],
                'notes'            => $post['keterangan_follow'],
                'supervisor_id'    => $id_spv_sgmw,
            ];

            $this->ci->db_wuling->insert('wsa_data_followup_spv', $insertFuSpv);

            $return = [
                'status' => true,
                'pesan' => 'Data sukses diupdate ke WSA ' . $response->message,
            ];
            echo json_encode($return);
        } else  if (isset($response->code) && $response->code == 115) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi DO ke WSA : ' . $this->format_response_messages(json_encode($response->data->messages)),
            ];
            echo json_encode($return);
        } else if (isset($response->error) && $response->error == 403) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi DO ke WSA : ' . $response->message,
            ];
            echo json_encode($return);
        } elseif ($response == null) {
            $return = [
                'status' => false,
                'pesan' => 'Gagal input data validasi DO ke WSA : The api 404 not found ',
            ];
            echo json_encode($return);
        }
    }

    private function log($insert_data, $status_code, $response, $endpoint)
    {
        $this->ci->db_wuling->insert('wsa_logs', [
            'insert_data' => $insert_data,
            'status_code' => $status_code,
            'response' => $response,
            'endpoint' => $endpoint
        ]);
    }
}
