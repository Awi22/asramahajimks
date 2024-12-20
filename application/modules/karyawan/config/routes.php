<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/*--- Karyawan ROUTE --- */

/* Daftar Kinerja */
$route['karyawan_daftar_kinerja']                       = 'karyawan/karyawan_daftar_kinerja';
$route['karyawan_daftar_kinerja/get']                   = 'karyawan/karyawan_daftar_kinerja/get';
$route['karyawan_daftar_kinerja/get_by_id']             = 'karyawan/karyawan_daftar_kinerja/get_by_id';
$route['karyawan_daftar_kinerja/simpan']                = 'karyawan/karyawan_daftar_kinerja/simpan';
$route['karyawan_daftar_kinerja/update']                = 'karyawan/karyawan_daftar_kinerja/update';
$route['karyawan_daftar_kinerja/hapus']                 = 'karyawan/karyawan_daftar_kinerja/hapus';
$route['karyawan_daftar_kinerja/get_KodeKaryawan']      = 'karyawan/karyawan_daftar_kinerja/get_KodeKaryawan';
$route['karyawan_daftar_kinerja/get_NamaKaryawan']      = 'karyawan/karyawan_daftar_kinerja/get_NamaKaryawan';

/* Laporan Kinerja */
$route['karyawan_laporan_kinerja']                      = 'karyawan/karyawan_laporan_kinerja';
$route['karyawan_laporan_kinerja/get']                  = 'karyawan/karyawan_laporan_kinerja/get';
$route['karyawan_laporan_kinerja/export']               = 'karyawan/karyawan_laporan_kinerja/export';
$route['karyawan_laporan_kinerja/select2_area_kerja']   = 'karyawan/karyawan_laporan_kinerja/select2_area_kerja';
