<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/*--- Master Data ROUTE --- */

/* Status Pegawai */
$route['master_status_pegawai']                             = "master_data/master_status_pegawai";
$route['master_status_pegawai/get']                         = "master_data/master_status_pegawai/get";
$route['master_status_pegawai/get_status_pegawai_by_id']    = "master_data/master_status_pegawai/get_status_pegawai_by_id";
$route['master_status_pegawai/simpan']                      = "master_data/master_status_pegawai/simpan";
$route['master_status_pegawai/update']                      = "master_data/master_status_pegawai/update";
$route['master_status_pegawai/hapus']                       = "master_data/master_status_pegawai/hapus";

/* Jenis ASN */
$route['master_jenis_asn']                             = "master_data/master_jenis_asn";
$route['master_jenis_asn/get']                         = "master_data/master_jenis_asn/get";
$route['master_jenis_asn/get_jenis_asn_by_id']         = "master_data/master_jenis_asn/get_jenis_asn_by_id";
$route['master_jenis_asn/simpan']                      = "master_data/master_jenis_asn/simpan";
$route['master_jenis_asn/update']                      = "master_data/master_jenis_asn/update";
$route['master_jenis_asn/hapus']                       = "master_data/master_jenis_asn/hapus";

/* Agama */
$route['master_agama']                         = "master_data/master_agama";
$route['master_agama/get']                     = "master_data/master_agama/get";
$route['master_agama/get_agama_by_id']         = "master_data/master_agama/get_agama_by_id";
$route['master_agama/simpan']                  = "master_data/master_agama/simpan";
$route['master_agama/update']                  = "master_data/master_agama/update";
$route['master_agama/hapus']                   = "master_data/master_agama/hapus";

/* Jabatan */
$route['master_jabatan']                    = "master_data/master_jabatan";
$route['master_jabatan/get']                = "master_data/master_jabatan/get";
$route['master_jabatan/get_jabatan_by_id']  = "master_data/master_jabatan/get_jabatan_by_id";
$route['master_jabatan/simpan']             = "master_data/master_jabatan/simpan";
$route['master_jabatan/update']             = "master_data/master_jabatan/update";
$route['master_jabatan/hapus']              = "master_data/master_jabatan/hapus";

/* Area Kerja */
$route['master_area_kerja']                         = "master_data/master_area_kerja";
$route['master_area_kerja/get']                     = "master_data/master_area_kerja/get";
$route['master_area_kerja/get_area_kerja_by_id']    = "master_data/master_area_kerja/get_area_kerja_by_id";
$route['master_area_kerja/simpan']                  = "master_data/master_area_kerja/simpan";
$route['master_area_kerja/update']                  = "master_data/master_area_kerja/update";
$route['master_area_kerja/hapus']                   = "master_data/master_area_kerja/hapus";

/* Penempatan tugas */
$route['master_penempatan_tugas']                               = "master_data/master_penempatan_tugas";
$route['master_penempatan_tugas/get']                           = "master_data/master_penempatan_tugas/get";
$route['master_penempatan_tugas/get_penempatan_tugas_by_id']    = "master_data/master_penempatan_tugas/get_penempatan_tugas_by_id";
$route['master_penempatan_tugas/simpan']                        = "master_data/master_penempatan_tugas/simpan";
$route['master_penempatan_tugas/update']                        = "master_data/master_penempatan_tugas/update";
$route['master_penempatan_tugas/hapus']                         = "master_data/master_penempatan_tugas/hapus";

/* Gedung */
$route['master_gedung']                         = "master_data/master_gedung";
$route['master_gedung/get']                     = "master_data/master_gedung/get";
$route['master_gedung/get_gedung_by_id']        = "master_data/master_gedung/get_gedung_by_id";
$route['master_gedung/simpan']                  = "master_data/master_gedung/simpan";
$route['master_gedung/update']                  = "master_data/master_gedung/update";
$route['master_gedung/hapus']                   = "master_data/master_gedung/hapus";

/* Daftar ASN */
$route['master_asn']                    = "master_data/master_asn";
$route['master_asn/get']                = "master_data/master_asn/get";
$route['master_asn/get_asn_by_id']      = "master_data/master_asn/get_asn_by_id";
$route['master_asn/simpan']             = "master_data/master_asn/simpan";
$route['master_asn/update']             = "master_data/master_asn/update";
$route['master_asn/hapus']              = "master_data/master_asn/hapus";
$route['master_asn/select2_jenisASN']   = "master_data/master_asn/select2_jenisASN";
$route['master_asn/select2_jabatan']    = "master_data/master_asn/select2_jabatan";
$route['master_asn/select2_agama']      = "master_data/master_asn/select2_agama";
