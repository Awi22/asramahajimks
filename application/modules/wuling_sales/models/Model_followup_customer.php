<?php

use app\models\elo\sales\ModelAdmSales;
use app\models\elo\sales\ModelCustomer;
use app\models\elo\sales\ModelHistoryFollowupSales;
use app\models\elo\sales\ModelHotProspek;
use app\models\elo\sales\ModelJadwalSales;
use app\models\elo\sales\ModelProspek;
use app\models\elo\sales\ModelSdo;
use app\models\elo\sales\ModelSspk;
use app\models\elo\sales\ModelSuspect;
use app\models\elo\sales\ModelTestDrive;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_followup_customer extends CI_Model
{

    public function getDataFuSales($tgl_awal, $tgl_akhir, $id_sales)
    {
        $followUp = [];
        $data = ModelAdmSales::with(['toKaryawan'  => function ($query) {
            $query->select('id_karyawan', 'nama_karyawan');
        }])->whereId_sales($id_sales)->get();

        foreach ($data as $key => $value) {
            $followUp[] = [
                'id_sales'       => $id_sales,
                'sales'          => $value->toKaryawan['nama_karyawan'],
                'tot_customer'   => $this->getTotCusDiFu($tgl_awal, $tgl_akhir, $id_sales)->count() . ' Customer',
                'tot_fu'         => $this->getTotFU($tgl_awal, $tgl_akhir, $id_sales)->count() . ' Detail Follow Up dari ' . $this->getTotFUCus($tgl_awal, $tgl_akhir, $id_sales)->count() . ' Customer',
                'tot_suspect'    => $this->getTotSuspect($tgl_awal, $tgl_akhir, $id_sales)->count(),
                'tot_prospek'    => $this->getTotProspek($tgl_awal, $tgl_akhir, $id_sales)->count(),
                'tot_h_prospek'  => $this->getTotHotProspek($tgl_awal, $tgl_akhir, $id_sales)->count(),
                'tot_spk'        => $this->getTotSpk($tgl_awal, $tgl_akhir, $id_sales)->count(),
                'tot_do'         => $this->getTotDo($tgl_awal, $tgl_akhir, $id_sales)->count(),
                'tot_test_drive' => $this->getTotTestDrive($tgl_awal, $tgl_akhir, $id_sales)->count(),

            ];
        }

        // dd($followUp);
        return $followUp;
    }

    private function getTotCusDiFu($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelJadwalSales::whereSales($id_sales)->where('tgl_selanjutnya', '>=', $tgl_awal)->where('tgl_selanjutnya', '<=', $tgl_akhir)->get();
        return $data;
    }

    private function getTotFU($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelHistoryFollowupSales::whereSales($id_sales)->where('tgl_followup', '>=', $tgl_awal)->where('tgl_followup', '<=', $tgl_akhir)->get();
        return $data;
    }

    private function getTotFUCus($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelHistoryFollowupSales::whereSales($id_sales)->where('tgl_followup', '>=', $tgl_awal)->where('tgl_followup', '<=', $tgl_akhir)->groupBy('id_prospek')->get();
        return $data;
    }

    private function getTotSuspect($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelSuspect::whereId_sales($id_sales)->where('tgl_suspect', '>=', $tgl_awal)->where('tgl_suspect', '<=', $tgl_akhir)->get();
        return $data;
    }

    private function getTotProspek($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelProspek::whereId_sales($id_sales)->where('tgl_prospek', '>=', $tgl_awal)->where('tgl_prospek', '<=', $tgl_akhir)->get();
        return $data;
    }

    private function getTotHotProspek($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelHotProspek::whereId_sales($id_sales)->where('tgl_h_prospek', '>=', $tgl_awal)->where('tgl_h_prospek', '<=', $tgl_akhir)->get();
        return $data;
    }

    private function getTotSpk($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelSspk::whereId_sales($id_sales)->where('tgl_spk', '>=', $tgl_awal)->where('tgl_spk', '<=', $tgl_akhir)->get();
        return $data;
    }

    private function getTotDo($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelSdo::whereId_sales($id_sales)->where('tgl_do', '>=', $tgl_awal)->where('tgl_do', '<=', $tgl_akhir)->get();
        return $data;
    }
    private function getTotTestDrive($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelTestDrive::with('toCustomer')->whereHas('toCustomer', function ($query) use ($id_sales) {
            $query->whereSales($id_sales);
        })->where('tgl_jam', '>=', $tgl_awal)->where('tgl_jam', '<=', $tgl_akhir)->get();
        return $data;
    }


    public function getDataDetailFuPerHistory($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelCustomer::with(['toHistoryFollowupSales', 'toTestDrive.toPVarian'])
            ->whereHas('toHistoryFollowupSales', function ($query) use ($tgl_awal, $tgl_akhir) {
                $query->where('tgl_followup', '>=', $tgl_awal)->where('tgl_followup', '<=', $tgl_akhir);
            })->whereSales($id_sales)->select('id_prospek', 'nama', 'alamat', 'telepone', 'status')->get();
        // dd($data->toArray());
        return $data;
    }

    public function getDataDetailFuPerJadwal($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelCustomer::with(['toJadwalSales', 'toHistoryFollowupSales'])
            ->whereHas('toJadwalSales', function ($query) use ($tgl_awal, $tgl_akhir, $id_sales) {
                $query->whereSales($id_sales)->where('tgl_selanjutnya', '>=', $tgl_awal)->where('tgl_selanjutnya', '<=', $tgl_akhir);
            })->select('id_prospek', 'nama', 'alamat', 'telepone', 'status')->get();
        // dd($data->toArray());
        return $data;
    }

    public function getDataDetailFuNewProspek($tgl_awal, $tgl_akhir, $id_sales)
    {
        $data = ModelCustomer::with(['toSuspect'])
            ->whereHas('toSuspect', function ($query) use ($tgl_awal, $tgl_akhir, $id_sales) {
                $query->whereSales($id_sales)->where('tgl_suspect', '>=', $tgl_awal)->where('tgl_suspect', '<=', $tgl_akhir);
            })->select('id_prospek', 'nama', 'alamat', 'telepone', 'status')->get();
        // dd($data->toArray());
        return $data;
    }
}
