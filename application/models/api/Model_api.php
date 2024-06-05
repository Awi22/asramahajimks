<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_api extends CI_Model
{
    public function get_token($id_user_api)
    {
        $token = '';

        $data_user = $this->db_wuling_as->where('id', $id_user_api)
            ->get('api_users')->row();

        // if less than 24 hr
        if (!empty($data_user->token) && strtotime($data_user->token_last_update) > time() - 86400) {
            // get token from db
            $token = $data_user->token;
        } else {
            /* Endpoint */
            $url = 'https://dms.wuling.co.id/dmsext/token';

            /* Data (body) */
            $data = [
                'user_name'     => $data_user->username,
                'password'      => $data_user->password,
                'group_code'    => $data_user->group_code
            ];

            $curl = curl_init();

            $options = [
                CURLOPT_URL                => $url,
                CURLOPT_POST               => 1,
                CURLOPT_POSTFIELDS         => json_encode($data),
                CURLOPT_RETURNTRANSFER     => 1,
                CURLOPT_HTTPHEADER         => ['Content-Type:application/json', 'Accept:application/json'],
                CURLOPT_SSL_VERIFYHOST     => false, // ! This option disables SSL verification
                CURLOPT_SSL_VERIFYPEER     => false  // ! This option disables SSL verification
            ];

            curl_setopt_array($curl, $options);

            /* make request */
            $result = curl_exec($curl);

            if (curl_error($curl)) {
                die(curl_error($curl));
            }

            $result_data = json_decode($result);
            $insert_data = [
                'token'                => $result_data->token,
                'token_last_update'    => date('Y-m-d H:i:s')
            ];
            $this->db_wuling_as->where('id', $id_user_api)->update('api_users', $insert_data);

            $token = $result_data->token;

            curl_close($curl);
        }

        return $token;
    }

    public function request_api($id_user_api, $endpoint, $request_type, $params = null, $data = null)
    {
        if (empty($id_user_api) || $id_user_api == null) {
            $this->output->set_status_header(500);
            if (ENVIRONMENT === 'production') {
                show_error('Ada masalah ketika mengambil data ke SGMW.', 500);
                return;
            }
        }
        $token = $this->get_token($id_user_api);
        $url = 'https://dms.wuling.co.id/dmsext/' . $endpoint . '?';

        $headers = [
            'X-Token: ' . $token,
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
                CURLOPT_POSTFIELDS         => json_encode($data),
                CURLOPT_SSL_VERIFYHOST     => false, // ! This option disables SSL verification
                CURLOPT_SSL_VERIFYPEER     => false  // ! This option disables SSL verification
            ];
        }

        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        if (curl_error($curl)) {
            die(curl_error($curl));
        }

        curl_close($curl);

        return $result;
    }

    public function create_table($nama_table, $fields, $primary_key)
    {
        $this->wulingforge = $this->load->dbforge($this->db_wuling_as, TRUE);
        $this->wulingforge->add_field($fields);
        $this->wulingforge->add_key($primary_key, TRUE);
        $this->wulingforge->create_table($nama_table, TRUE);
    }
}
