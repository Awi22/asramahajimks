<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_kpi_part_staff extends CI_Model
{

    public function get()
    {
        $data = array();
        $kategori = 10;

        if (!empty($kategori)) {
            $this->db_holding->where('kki.id_sub_kategori', $kategori);
        }

        $query = $this->db_holding
            ->select('kki.*, kk.name AS kategori_name, kk.bobot')
            ->from('kpi_kategori_item kki')
            ->join('kpi_kategori kk', 'kk.id=kki.id_kategori')
            // ->where()
            ->order_by('kki.id')
            ->get();

        foreach ($query->result() as $kpi) {
            $data[] = [
                'id'        => $kpi->id,
                'kategori'  => $kpi->kategori_name,
                'name'      => $kpi->name,
                'bobot'     => $kpi->bobot4,
                'target'    => 200,
                'actual'    => 150,
                'score'     => 21,
                'method'    => $kpi->method
            ];
        }

        return $data;
    }
}
