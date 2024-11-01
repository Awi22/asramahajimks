<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller
{
    public $nama_lengkap;
    public $coverage;
    public $username;
    public $id_user;
    public $level;
    public $nip;
    public $kode_karyawan;

    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        has_access();

        $this->logged_in     = $this->session->userdata('logged_in');
        $this->nama_lengkap  = $this->session->userdata('nama_lengkap');
        $this->coverage      = $this->session->userdata('coverage');
        $this->username      = $this->session->userdata('username');
        $this->id_user       = $this->session->userdata('id_user');
        $this->level         = $this->session->userdata('level');
        $this->nip           = $this->session->userdata('nip');
        $this->kode_karyawan = $this->session->userdata('kode_karyawan');
        $this->role_name     = $this->session->userdata('role_name');
        $this->id_jabatan    = $this->session->userdata('id_jabatan');

        // $this->id_sales             = null;
        // $this->id_jabatan           = null;
        // $this->id_sales             = null;
        // $this->id_leader            = null;
        // $this->id_team_supervisor   = null;
        // $this->id_team_sm           = null;
        // $this->id_team_asm          = null;
        // $this->kode_sales_sgmw      = null;
        // $this->id_leader            = null;
        // $this->id_team_sales_by_spv = null;
        // $this->id_team_sales_by_sm  = null;

        // if (!empty($this->session->userdata('id_sales'))) {
        //     $this->id_sales             = $this->session->userdata('id_sales');
        //     $this->id_jabatan           = $this->session->userdata('id_jabatan');
        //     $this->id_sales             = $this->session->userdata('id_sales');
        //     $this->id_leader            = $this->session->userdata('id_leader');
        //     $this->id_team_supervisor   = $this->session->userdata('id_team_supervisor');
        //     $this->id_team_sm           = $this->session->userdata('id_team_sm');
        //     $this->id_team_asm          = $this->session->userdata('id_team_asm');
        //     $this->kode_sales_sgmw      = $this->session->userdata('kode_sales_sgmw');
        //     $this->id_leader            = $this->session->userdata('id_leader');
        //     $this->id_team_sales_by_spv = $this->session->userdata('id_team_sales_by_spv');
        //     $this->id_team_sales_by_sm  = $this->session->userdata('id_team_sales_by_sm');
        // }

        $this->brand             = explode('_', $this->session->userdata('level'))[0];
    }
}
