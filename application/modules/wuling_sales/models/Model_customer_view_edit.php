<?php

use app\models\elo\sales\ModelCustomer;
use app\models\elo\sales\ModelKabupaten;
use app\models\elo\sales\ModelKecamatan;
use app\models\elo\sales\ModelKelurahan;
use app\models\elo\sales\ModelProvinsi;
use app\models\elo\sales\ModelPustakaMedia;
use app\models\elo\sales\ModelPustakaSumberProspek;
use app\models\elo\sales\ModelUnit;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_customer_view_edit extends CI_Model
{


    public function getDataCustomerProses($id_prospek)
    {
        $customerProses = [];
        $data = ModelCustomer::with(['toSuspect', 'toProspek', 'toHotProspek'])->whereId_prospek($id_prospek)->first();

        $customerProses = [
            'nama_customer'       => $data->nama,
            'alamat_customer'     => $data->alamat,
            'id_provinsi'   => $data->id_provinsi,
            'id_kabupaten'  => $data->id_kabupaten,
            'id_kecamatan'  => $data->id_kecamatan,
            'id_kelurahan' => $data->id_kelurahan,
            'kode_pos'  => $data->kode_pos,
            'telepone'   => $data->telepone,
            'id_sumber_prospek'   => $data->id_sumber_prospek,
            'cara_bayar'          => $data->cara_bayar,
            'id_cus_digital'          => $data->id_cus_digital,
            'tgl_suspect'         => $data->toSuspect['tgl_suspect'],
            'tgl_prospek'         => $data->toProspek['tgl_prospek'],
            'id_media'            => $data->toProspek['id_media'],
            'kode_unit'           => $data->toProspek['kode_unit'],
            'kebutuhan'           => $data->toProspek['kebutuhan'],
            'bln'                 => $data->toProspek['bln'],
            'dipakai'             => $data->toProspek['dipakai'],
            'rute'                => $data->toProspek['rute'],
            'jml_keluarga'        => $data->toProspek['jml_keluarga'],
            'decision'            => $data->toProspek['decision'],
            'tgl_hot_prospek'     => $data->toHotProspek['tgl_h_prospek'],
            'tdp'                 => $data->toHotProspek['tdp'],
            'cicilan'             => $data->toHotProspek['cicilan'],

        ];
        return $customerProses;
    }


    public function getDataProvinsi($id_provinsi)
    {

        $data = ModelProvinsi::all();
        $provinsi = [];
        foreach ($data as $row) {
            $provinsi[] = [
                'id'       => $row->id_provinsi,
                'text'     => $row->nama,
                'selected' => $id_provinsi == $row->id_provinsi ? true : false,
            ];
        }
        return $provinsi;
    }

    public function getDataKabupaten($id_provinsi, $id_kabupaten)
    {
        $data = ModelKabupaten::whereId_provinsi($id_provinsi)->get();
        $kabupaten = [];
        foreach ($data as $row) {
            $kabupaten[] = [
                'id'       => $row->id_kabupaten,
                'text'     => $row->nama,
                'selected' => $id_kabupaten ==  $row->id_kabupaten ? true : false,
            ];
        }
        return  $kabupaten;
    }

    public function getDataKecamatan($id_kabupaten, $id_kecamatan)
    {
        $data = ModelKecamatan::whereId_kabupaten($id_kabupaten)->get();
        $kecamatan = [];
        foreach ($data as $row) {
            $kecamatan[] = [
                'id'       => $row->id_kecamatan,
                'text'     => $row->nama,
                'selected' => $id_kecamatan ==  $row->id_kecamatan ? true : false,
            ];
        }
        return $kecamatan;
    }

    public function getDataKelurahan($id_kecamatan, $id_kelurahan)
    {
        $data = ModelKelurahan::whereId_kecamatan($id_kecamatan)->get();
        $kelurahaan = [];
        foreach ($data as $row) {
            $kelurahaan[] = [
                'id'       => $row->id_kelurahan,
                'text'     => $row->nama,
                'selected' => $id_kelurahan ==  $row->id_kelurahan ? true : false,
            ];
        }
        return $kelurahaan;
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

    public function getDataSumberProspek($id_sumber_prospek)
    {
        $sumberProspek = [];
        $data = ModelPustakaSumberProspek::all();

        foreach ($data as $row) {
            $sumberProspek[] = [
                'id'       => $row->id_sumber_prospek,
                'text'     => $row->sumber_prospek,
                'selected' => $id_sumber_prospek == $row->id_sumber_prospek ? true : false,
            ];
        }
        return $sumberProspek;
    }

    public function getDataMediaMotivaor($id_media)
    {
        $media = [];
        $data = ModelPustakaMedia::all();

        foreach ($data as $key => $value) {
            $media[] = [
                'id'       => $value->id_media,
                'text'     => $value->media,
                'selected' => $id_media == $value->id_media ? true : false,
            ];
        }

        return $media;
    }

    public function getDataDetailFuPerHistory($id_prospek)
    {
        $data = ModelCustomer::with(['toHistoryFollowupSales', 'toTestDrive.toPVarian'])->whereId_prospek($id_prospek)->select('id_prospek', 'nama', 'alamat', 'telepone', 'status')->get();

        // dd($data->toArray());
        return $data;
    }
}
