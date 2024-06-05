<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_tax')) {
    /** 
     * Mengambil nilai pajak atau dasar pengenaan pajak sesuai tipe pajak, dan tanggal transaksi      
     * @param   string $tipe            Tipe pajak, mis: 'ppn'
     * @param   date $tgl_transaksi     Tanggal transaksi
     * @param   int $total_transaksi    Total transaksi yang akan diambil nilai pajak atau dpp
     * @param   boolean $reverse        Default false, berarti mengambil nilai pajak, true untuk ambil dpp
     * @return  float $result
     */
    function get_tax($tipe, $tgl_transaksi, $total_transaksi, $reverse = false): float
    {
        $ci   = get_instance();
        $get  = $ci->db_holding->query("SELECT trd.rate, trd.rate_dpp FROM tax_rate_detail AS trd LEFT JOIN tax_rate AS tr ON trd.id_tax_rate = tr.id_tax_rate WHERE tr.tipe = '$tipe' AND( start_date <= '$tgl_transaksi' AND end_date >= '$tgl_transaksi')")->row();
        $rate = (float) $get->rate;
        $rate_dpp = (float) $get->rate_dpp;

        if ($reverse === true) {
            $result = ($total_transaksi / $rate_dpp);
        } else {
            $result = ($total_transaksi * $rate);
        }

        return $result;
    }
}

if (!function_exists('get_tax_dpp')) {
    /**
     * untuk ambil persen dpp
     * @param  string $tipe
     * @param  date $tgl_transaksi
     */
    function get_tax_dpp($tipe, $tgl_transaksi): float
    {
        $ci   = get_instance();
        $get  = $ci->db_holding->query("SELECT trd.rate_dpp FROM tax_rate_detail AS trd LEFT JOIN tax_rate AS tr ON trd.id_tax_rate = tr.id_tax_rate WHERE tr.tipe = '$tipe' AND( start_date <= '$tgl_transaksi' AND end_date >= '$tgl_transaksi')")->row();
        $rate = (float) $get->rate_dpp;
        return $rate;
    }
}

if (!function_exists('get_tax_ppn')) {
    /**
     * untuk ambil persen ppn
     * @param  string $tipe
     * @param  date $tgl_transaksi
     */
    function get_tax_ppn($tipe, $tgl_transaksi): float
    {
        $ci   = get_instance();
        $get  = $ci->db_holding->query("SELECT trd.rate FROM tax_rate_detail AS trd LEFT JOIN tax_rate AS tr ON trd.id_tax_rate = tr.id_tax_rate WHERE tr.tipe = '$tipe' AND( start_date <= '$tgl_transaksi' AND end_date >= '$tgl_transaksi')")->row();
        $rate = ($get === null ? 0 : (float) $get->rate);
        return $rate;
    }
}

if (!function_exists('company_bank')) {
    /**
     * untuk ambil persen ppn
     * @param  string $id_perusahaan
     */
    function company_bank($id_perusahaan)
    {
        // Manado 174.00.7070.6007
        // Palu 174.00.7070.9001
        // Tomohon 174.00.7070.9993
        switch ($id_perusahaan) {
            case '45':
                $no_rek = '174.00.7070.6007';
                break;
            case '89':
                $no_rek = '174.00.7070.9993';
                break;
            case '64':
                $no_rek = '174.00.7070.9001';
                break;
        }
        return $no_rek;
    }
}

if (!function_exists('company_bank_wuling')) {
    /**
     * untuk ambil persen ppn
     * @param  string $id_perusahaan
     */
    function company_bank_wuling($id_perusahaan)
    {
        // Manado 174.00.7070.6007
        // Palu 174.00.7070.9001
        // Tomohon 174.00.7070.9993
        $ci   = get_instance();
       
        $get = $ci->db_wuling->query("SELECT no_rekening FROM bank WHERE id_perusahaan = $id_perusahaan AND jenis = 'penr_bengkel'")->row();
        $no_rek = $get->no_rekening ?? '-';
                
        return $no_rek;
    }
}
