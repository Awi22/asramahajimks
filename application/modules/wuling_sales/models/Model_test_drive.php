<?php

use app\models\elo\sales\ModelTestDrive;
use app\models\elo\sales\ModelUnit;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_test_drive extends CI_Model
{

    public function getDataTestDrive($tahun, $bulan, $id_sales)
    {
        $testDrive = [];
        $data = ModelTestDrive::with(['toTestDriveDetail', 'toCustomer', 'toWsaDataSuspect', 'toWsaDataTestDrive', 'toPVarian', 'toProspek.toUnit.toPVarian'])
            ->whereHas('toCustomer', function ($query) use ($id_sales) {
                $query->whereSales($id_sales);
            })->whereYear('tgl_jam', $tahun)->whereMonth('tgl_jam', $bulan)->groupBy('id_test_drive')->get()->sortBy(function ($query) {
                return $query->toCustomer->id_prospek;
            });

        // debug($data->toArray());

        foreach ($data as $key => $value) {
            switch ($value->tempat) {
                case 'd':
                    $tempat = 'Dealer';
                    break;
                case 'r':
                    $tempat = 'Rumah Customer';
                    break;
                case 'k':
                    $tempat = 'Kantor';
                    break;
                case 'p':
                    $tempat = 'Area Publik';
                    break;
                default:
                    $tempat = '';
                    break;
            }

            $v_jam = date("H:i", strtotime($value->tgl_jam));
            $v_tgl = tgl_sql(date("Y-m-d", strtotime($value->tgl_jam)));

            $testDrive[] = array(
                'id_test_drive'          => $value->id_test_drive,
                'id_prospek'             => $value->id_prospek,
                'waktu'                  => $v_tgl . ' Pukul ' . $v_jam,
                'tempat'                 => $tempat,
                'tahapan'                => ucfirst($value->tahapan),
                'id'                     => $value->toTestDriveDetail['id'],
                'customer'               => $value->toCustomer['nama'],
                'telepone'               => $value->toCustomer['telepone'],
                'alamat'                 => $value->toCustomer['alamat'],
                'model'                  => $value->toPVarian['varian'],
                'status'                 => $value->status == '0' ? 'Waiting' : 'Approved',
                'foto_test_drive'        => $value->toTestDriveDetail['foto_test_drive'],
                'foto_sim'               => $value->toTestDriveDetail['foto_sim'],
                'alamat'                 => $value->toCustomer['alamat'],
                'pekerjaan'              => $value->toCustomer['pekerjaan'],
                'email'                  => $value->toCustomer['email'],
                'prospect_id'            => $value->toWsaDataSuspect['prospect_id'],
                'prospect_id_test_drive' => $value->toWsaDataTestDrive['prospect_id'],
                'schedule_id'            => $value->toWsaDataTestDrive['schedule_id'],
                'id_test_drive_wsa'      => $value->toWsaDataTestDrive['id'],
                'model_diminati'         => $value->toProspek->toUnit->toPVarian['varian'],
            );
        }
        return $testDrive;
    }


    public function getDataDetailTestDrive($id_prospek)
    {
        $testDrive = [];
        $data = ModelTestDrive::with(['toTestDriveDetail', 'toCustomer', 'toWsaDataSuspect', 'toWsaDataTestDrive', 'toPVarian', 'toProspek.toUnit.toPVarian'])
            ->whereId_prospek($id_prospek)->first();

        $testDrive = [
            'id_test_drive'       => $data->id_test_drive,
            'id_prospek'          => $data->id_prospek,
            'tempat'              => $data->tempat,
            'foto_sim'            => $data->toTestDriveDetail['foto_sim'],
            'pekerjaan_sampingan' => $data->toTestDriveDetail['foto_test_drive'],
            'cabin'               => $data->toTestDriveDetail['pekerjaan_sampingan'],
            'customer'            => $data->toCustomer['nama'],
            'telepone'            => $data->toCustomer['telepone'],
            'alamat'              => $data->toCustomer['alamat'],
            'alamat'              => $data->toCustomer['alamat'],
            'pekerjaan'           => $data->toCustomer['pekerjaan'],
            'email'               => $data->toCustomer['email'],
            'kode_unit'           => $data->toProspek['kode_unit'],
        ];
        return $testDrive;
    }

    public function getDataUnit($kode_unit)
    {

        $unit = [];
        $data = ModelUnit::with(['toPVarian', 'toPWarna']);
        $data = $data->whereHas('toPVarian', function ($query) {
            $query->whereShow('1');
        })->get()->sortBy(function ($query) {
            return $query->toPVarian->varian;
        });
        foreach ($data as $key => $row) {
            $unit[] = [
                'id'       => $row->kode_unit,
                'text'     => $row->toPVarian['varian'] . ' - ' . $row->toPWarna['warna'],
                'selected' => $kode_unit == $row->kode_unit ? true : false,
            ];
        }

        return $unit;
    }

    public function getDataPekerjaan($pekerjaan)
    {
        $value = [];
        $data[] = ["PNS", "PEGAWAI BUMN", "TNI/POLRI", "DOKTER/TENAGA MEDIS", "WIRASWASTA", "KONTRAKTOR", "PEGAWAI SWASTA", "PEDAGANG", "PETANI/PEKEBUN", "YANG LAIN"];

        foreach ($data as $key => $value) {
            $pekerjaanUtama[] = [
                'id'   => $value,
                'text' => $value,
                'selected' => $pekerjaan == $key ? true : false,
            ];
        }

        return $value;
    }
}
