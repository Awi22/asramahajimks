<?php

use app\models\elo\sales\ModelNJadwalSales;
use app\models\elo\sales\ModelCustomer;
use app\models\elo\sales\ModelEvent;
use app\models\elo\sales\ModelHotProspek;
use app\models\elo\sales\ModelKabupaten;
use app\models\elo\sales\ModelKecamatan;
use app\models\elo\sales\ModelKelurahan;
use app\models\elo\sales\ModelLeasing;
use app\models\elo\sales\ModelNoSpk;
use app\models\elo\sales\ModelProspek;
use app\models\elo\sales\ModelProvinsi;
use app\models\elo\sales\ModelPustakaMedia;
use app\models\elo\sales\ModelPustakaSumberProspek;
use app\models\elo\sales\ModelSspk;
use app\models\elo\sales\ModelStockUnit;
use app\models\elo\sales\ModelSuspect;
use app\models\elo\sales\ModelTypeUnit;
use app\models\elo\sales\ModelUnit;
use app\models\elo\sales\ModelVarian;
use app\models\elo\sales\ModelWsaDataSuspect;
use app\models\elo\sales\ModelWsaDataXylo;
use app\models\elo\sales\ModelWsaDealer;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_jadwal_kunjungan extends CI_Model
{

    public function getDataJadwalKunjungan($tgl_awal, $tgl_akhir, $id_sales)
    {
        $jadwalKunjungan = [];
        $data = ModelNJadwalSales::with(['toCustomer'])->whereSales($id_sales)->where(function ($query) use ($tgl_akhir) {
            $query->where('last_update', null)
                ->orWhere('last_update', '<=', $tgl_akhir);
        });
        $data = $data->whereHas('toCustomer', function ($query) {
            $query->where('status', '!=', 'lost');
        })->where('tgl_selanjutnya', '>=', $tgl_awal)->where('tgl_selanjutnya', '<=', $tgl_akhir)->get()->sortBy('tgl_selanjutnya');

        foreach ($data as $key => $value) {
            $jadwalKunjungan[] = [
                'id_prospek' => $value->id_prospek,
                'jadwal'     => $value->tgl_selanjutnya,
                'customer'   => $value->toCustomer['nama'],
                'phone'      => $value->toCustomer['telepone'],
                'status'     => ucfirst($value->toCustomer['status']),
            ];
        }

        return $jadwalKunjungan;
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


    public function getDataAktivitas($id_sumber_prospek, $id_perusahaan, $tgl_aktivitas, $id_aktivitas)
    {

        if ($id_sumber_prospek == "1") {
            $id_event_jenis = "2";
        } elseif ($id_sumber_prospek == "2") {
            $id_event_jenis = "1";
        } elseif ($id_sumber_prospek == "3") {
            $id_event_jenis = "1";
        } elseif ($id_sumber_prospek == "11") {
            $id_event_jenis = "3";
        } elseif ($id_sumber_prospek == "13") {
            $id_event_jenis = "10";
        } elseif ($id_sumber_prospek == "14") {
            $id_event_jenis = "11";
        } elseif ($id_sumber_prospek == "16") {
            $id_event_jenis = "20";
        } elseif ($id_sumber_prospek == "17") {
            $id_event_jenis = "22";
        } elseif ($id_sumber_prospek == "5") {
            $id_event_jenis = "3";
        } elseif ($id_sumber_prospek == "6") {
            $id_event_jenis = "8";
        } else {
            $id_event_jenis = "";
        }

        $event = [];
        // debug($id_event_jenis, $id_sumber_prospek);
        $data = ModelEvent::with(['toEventLokasi', 'toEventLokasi.toEventArea'])
            ->whereId_event_jenis($id_event_jenis)
            ->whereApproved_plan('y')
            ->whereReview_plan('bj')
            ->whereId_perusahaan($id_perusahaan);

        if ($tgl_aktivitas) {
            $data = $data->where('tgl_mulai', '<=', $tgl_aktivitas)->where('tgl_selesai', '>=', $tgl_aktivitas);
        }

        foreach ($data->get() as $row) {
            $area_event = $row->toEventLokasi->toEventArea['event_area'] ?? '';
            $lokasi = $row->toEventLokasi['lokasi'] ?? '';
            $event[] = [
                'id'       => $row->id_event,
                'text'     => $area_event . ' - ' . $lokasi,
                'selected' => $id_aktivitas == $row->id_event ? true : false,
            ];
        }
        return $event;
    }



    //** Get Data Suspect */ 

    public function getDataSuspect($id_prospek)
    {

        $suspect = [];
        $data = ModelSuspect::with(['toCustomer', 'toProspek', 'toWsaSuspect', 'toSurvaiProses'])->whereId_prospek($id_prospek)->first();
        $suspect = [
            'id_prospek'             => $data->id_prospek,
            'tgl_suspect'            => $data->tgl_suspect,
            'nama_customer'          => $data->toCustomer['nama'],
            'status_suspect'         => $data->toCustomer['status'],
            'alamat_customer'        => $data->toCustomer['alamat'],
            'id_provinsi'            => $data->toCustomer['id_provinsi'],
            'id_kabupaten'           => $data->toCustomer['id_kabupaten'],
            'id_kecamatan'           => $data->toCustomer['id_kecamatan'],
            'id_kelurahan'           => $data->toCustomer['id_kelurahan'],
            'kode_pos'               => $data->toCustomer['kode_pos'],
            'telepone'               => $data->toCustomer['telepone'],
            'id_sumber_prospek'      => $data->toCustomer['id_sumber_prospek'],
            'tgl_kunjungan'          => $data->toCustomer['tgl_kunjungan'],
            'keterangan'             => $data->toCustomer['keterangan'],
            'email'                  => $data->toCustomer['email'],
            'jenis_kelamin'          => $data->toCustomer['jenis_kelamin'],
            'keterangan'             => $data->toCustomer['keterangan'],
            'cara_bayar'             => $data->toCustomer['cara_bayar'],
            'id_event'               => $data->toCustomer['id_event'],
            'tgl_event'              => $data->toCustomer['tgl_event'],
            'tgl_telpon_masuk'       => $data->toCustomer['tgl_telpon_masuk'],
            'nama_stnk'              => $data->toCustomer['nama_stnk'],
            'no_rangka_repeat_order' => $data->toCustomer['no_rangka_repeat_order'],
            'tgl_pembelian'          => $data->toCustomer['tgl_pembelian'],
            'tgl_walk_in'            => $data->toCustomer['tgl_walk_in'],
            'nama_agent'             => $data->toCustomer['nama_agent'],
            'telepon_agent'          => $data->toCustomer['telepon_agent'],
            'id_sales_digital'       => $data->toCustomer['id_sales_digital'],
            'nama_refrensi'          => $data->toCustomer['nama_refrensi'],
            'tlpn_refrensi'          => $data->toCustomer['tlpn_refrensi'],
            'kode_unit'              => $data->toProspek['kode_unit'],
            'kode_unit_alt'          => $data->toWsaSuspect['kode_unit_alt'],
            'form_id'                => $data->toWsaSuspect['form_id'],
            'occupation_id'          => $data->toWsaSuspect['occupation_id'],
            'channel_id'             => $data->toWsaSuspect['channel_id'],
            'national_event_id'      => $data->toWsaSuspect['national_event_id'],
            'price_offering'         => $data->toWsaSuspect['price_offering'],
            'plan_to_buy'            => $data->toWsaSuspect['plan_to_buy'],
            'dealer_id'              => $data->toWsaSuspect['dealer_id'],
            'respon_fu'              => $data->toSurvaiProses['respon_fu'],
            'test_drive'             => $data->toSurvaiProses['test_drive'],
            'fitur'                  => $data->toSurvaiProses['fitur'],
            'estimasi'               => $data->toSurvaiProses['estimasi'],


        ];

        return $suspect;
    }

    //** Get Data Master WSA */

    public function getDataFormWsa($id)
    {
        $formsWsa = [];
        $data = $this->wsa_api->get_master('forms');

        foreach ($data as $key => $value) {
            $formsWsa[] = [
                'id'       => $value->id,
                'text'     => $value->name,
                'selected' => $id == $value->id ? true : false,
            ];
        }

        return $formsWsa;
    }

    public function getOccupationsWsa($id)
    {
        $occupations = [];
        $data = $this->wsa_api->get_master('occupations');

        foreach ($data as $key => $value) {
            $occupations[] = [
                'id'       => $value->id,
                'text'     => $value->name,
                'selected' => $id == $value->id ? true : false,
            ];
        }

        return $occupations;
    }

    public function getCannelsWsa($id)
    {
        $channel = [];
        $data = $this->wsa_api->get_master('channels');

        foreach ($data as $key => $value) {
            $channel[] = [
                'id'       => $value->id,
                'text'     => $value->name,
                'selected' => $id == $value->id ? true : false,
            ];
        }

        return $channel;
    }

    public function getNasonalEventWsa($id)
    {
        $nasonalEvent = [];
        $data = $this->wsa_api->get_master('national-events');

        foreach ($data as $key => $value) {
            $nasonalEvent[] = [
                'id'       => $value->id,
                'text'     => $value->event_name,
                'selected' => $id == $value->id ? true : false,
            ];
        }

        return $nasonalEvent;
    }

    public function getDataDealer($id, $id_perusahaan)
    {
        $dealer = [];
        $data = ModelWsaDealer::whereId_perusahaan($id_perusahaan)->get();

        foreach ($data as $key => $value) {
            $dealer[] = [
                'id'       => $value->id,
                'text'     => $value->outlet,
                'selected' => $id == $value->id ? true : false,
            ];
        }

        return $dealer;
    }

    //** Followup WSA */

    public function getDataStatusFu()
    {
        $statusFu = [];
        $data = $this->wsa_api->get_master('followup-status');
        foreach ($data as $key => $value) {
            $statusFu[] = [
                'id'       => $value->id,
                'text'     => $value->name,
            ];
        }

        return $statusFu;
    }

    public function getDataRemaksFu()
    {
        $remaksFu = [];
        $data = $this->wsa_api->get_master('followup-remarks');
        foreach ($data as $key => $value) {
            $remaksFu[] = [
                'id'       => $value->id,
                'text'     => $value->name,
            ];
        }

        return $remaksFu;
    }

    public function getDataNextFu()
    {
        $nextFu = [];
        $data = $this->wsa_api->get_master('next-followup');
        foreach ($data as $key => $value) {
            $nextFu[] = [
                'id'       => $value->id,
                'text'     => $value->name,
            ];
        }

        return $nextFu;
    }


    public function getDataXyloWsa($id_customer_digital)
    {
        $data = ModelWsaDataXylo::whereId_customer_digital('DLC-WUL-033732')->first();
        return $data;
    }

    public function cekDataProsepkIdWsa($id_prospek)
    {
        $data = ModelWsaDataSuspect::whereId_prospek($id_prospek)->first();
        return $data;
    }

    //** Get Data Test Drive */

    public function getDataTypeUnit()
    {
        $typeUnit = [];
        $data = ModelTypeUnit::all()->sortBy(function ($query) {
            return $query->type;
        });;

        foreach ($data as $key => $value) {
            $typeUnit[] = [
                'id'       => $value->id_type,
                'text'     => $value->type,
                // 'selected' => $id == $value->id ? true : false,
            ];
        }

        return $typeUnit;
    }

    public function getDataVarian($id_type)
    {
        $varianUnit = [];
        $data = ModelVarian::whereId_type($id_type)->whereShow('1')->get()->sortBy(function ($query) {
            return $query->varian;
        });;

        foreach ($data as $key => $value) {
            $varianUnit[] = [
                'id'       => $value->id_varian,
                'text'     => $value->varian,
                // 'selected' => $id_type == $value->id_type ? true : false,
            ];
        }

        return $varianUnit;
    }


    //** Get Data Prospek */

    public function getDataProspek($id_prospek)
    {
        $prospek = [];
        $data = ModelProspek::with(['toCustomer'])->whereId_prospek($id_prospek)->first();
        $prospek = [
            'id_prospek'      => $data->id_prospek,
            'tgl_prospek'     => $data->tgl_prospek,
            'id_media'        => $data->id_media,
            'kode_unit'       => $data->kode_unit,
            'kebutuhan'       => $data->kebutuhan,
            'bln'             => $data->bln,
            'dipakai'         => $data->dipakai,
            'rute'            => $data->rute,
            'jml_keluarga'    => $data->jml_keluarga,
            'decision'        => $data->decision,
            'test_drive'      => $data->test_drive,
            'keterangan'      => $data->keterangan,
            'nama_customer'   => $data->toCustomer['nama'],
            'status_customer' => $data->toCustomer['status'],
            'tgl_kunjungan'   => $data->toCustomer['tgl_kunjungan'],
        ];

        // debug($prospek);
        return $prospek;
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

    public function getDataStockUnit($kode_unit)
    {
        $data = ModelStockUnit::with(['toDetailUnitMasuk'])
            ->whereStatus_request('1')->where('dipakai', 'n')->whereRequested('n')
            ->whereHas('toDetailUnitMasuk', function ($query) use ($kode_unit) {
                $query->whereKode_unit($kode_unit);
            })->get()->count();
        return $data;
    }


    //** Get Data Hot Prospek */

    public function getDataHotProspek($id_prospek)
    {
        $hotProspek = [];
        $data = ModelHotProspek::with(['toCustomer'])->whereId_prospek($id_prospek)->first();
        $hotProspek = [
            'id_prospek'      => $data->id_prospek,
            'tgl_hot_prospek' => $data->tgl_hot_prospek,
            'nama_customer'   => $data->toCustomer['nama'],
            'status_customer' => $data->toCustomer['status'],
            'email'           => $data->toCustomer['email'],
            'jenis_kelamin'   => $data->toCustomer['jenis_kelamin'],
            'cara_bayar'      => $data->toCustomer['cara_bayar'],
            'tgl_kunjungan'   => $data->toCustomer['tgl_kunjungan'],
        ];

        // debug($hotProspek);
        return $hotProspek;
    }

    //** Get Data SPK */

    public function getDataSpk($id_prospek)
    {
        $spk = [];
        $data = ModelSspk::with(['toCustomer', 'toSettingTandaJadi'])->whereId_prospek($id_prospek)->first();
        $form_spk   = explode(',', $data->form_spk);
        $motif_beli = explode(',', $data->motif_beli);
        $spk = [
            'id_prospek'         => $data->id_prospek,
            'tgl_spk'            => $data->tgl_spk,
            'no_spk'             => $data->no_spk,
            'form_spk'           => $form_spk,
            'nama_stnk'          => $data->nama_stnk,
            'motif_beli'         => $motif_beli,
            'diskon'             => separator_harga($data->diskon),
            'jenis_bayar'        => $data->jenis_bayar,
            'leasing'            => $data->id_leasing,
            'uang_muka'          => separator_harga($data->uang_muka),
            'nama_customer'      => $data->toCustomer['nama'],
            'telepone'           => $data->toCustomer['telepone'],
            'test_drive'         => $data->toCustomer['test_drive'],
            'cara_bayar'         => $data->toCustomer['cara_bayar'],
            'payment_foto'       => $data->toCustomer['payment_foto'],
            'setting_tanda_jadi' => 'Standar tanda jadi Rp ' . separator_harga($data->toSettingTandaJadi['value']),
        ];

        // debug($spk);
        return $spk;
    }


    public function getDataNoSpk($no_spk, $id_sales)
    {
        if ($no_spk == '') {
            $status = '0';
        } else {
            $status = '1';
        }
        $noSpk = [];
        $data = ModelNoSpk::whereSales($id_sales)->whereStatus($status)->get();

        foreach ($data as $key => $value) {
            $noSpk[] = [
                'id'       => $value->no_spk,
                'text'     => $value->no_spk,
                'selected' => $no_spk == $value->no_spk ? true : false,
            ];
        }
        return $noSpk;
    }

    public function getDataLeasing($id_leasing)
    {
        $leasing = [];
        $data = ModelLeasing::all();
        foreach ($data as $key => $value) {
            $leasing[] = [
                'id'       => $value->id_leasing,
                'text'     => $value->leasing,
                'selected' => $id_leasing == $value->id_leasing ? true : false,
            ];
        }

        return $leasing;
    }
}
