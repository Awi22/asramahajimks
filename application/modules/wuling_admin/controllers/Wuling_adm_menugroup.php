<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wuling_adm_menugroup extends CI_Controller
{

    function __construct() {
        parent::__construct();
		is_logged_in();
        $this->username      	= $this->session->userdata('username');
        $this->load->model('model_adm_menu');
    }

    public function index() {
    }

    public function add() {
        if (isset($_POST['title'])) {
            $data['title'] = $this->input->post('title');
            $data['created_by'] = $this->username;
            if (!empty($data['title'])) {
                if ($this->db_wuling->insert('menu_group', $data)) {
                    $response['status'] = 1;
                    $response['id'] = $this->db_wuling->Insert_ID();
                } else {
                    $response['status'] = 2;
                    $response['msg'] = 'Add group error.';
                }
            } else {
                $response['status'] = 3;
            }
            responseJson($response);
        } else {
            $this->load->view('adm_menu/menugroup_add');
        }
    }

    public function edit() {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        if ($title) {
            $data['title'] = $title;
            $data['modified_by'] = $this->username;
            $response['success'] = false;
            $res = $this->model_adm_menu->update_menu_group($data, $id);
            if ($res) {
                $response['success'] = true;
            }
            header('Content-type: application/json');
            echo json_encode($response);
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        if ($id) {
            if ($id == 1) {
                $response['success'] = false;
                $response['msg'] = 'Cannot delete Group ID = 1';
            } else {
                $delete = $this->model_adm_menu->delete_menu_group($id);
                if ($delete) {
                    $del = $this->model_adm_menu->delete_menus($id);
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                }
            }
			responseJson($response);
        }
    }

}
