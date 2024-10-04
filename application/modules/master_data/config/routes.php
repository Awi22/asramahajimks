<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/*--- Master Data ROUTE --- */

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
