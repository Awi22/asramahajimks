<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$route['wuling_as_kpi_scoring']     = "wuling_as_kpi/wuling_as_kpi_scoring";
$route['wuling_as_kpi_scoring/get'] = "wuling_as_kpi/wuling_as_kpi_scoring/get";

$route['wuling_as_kpi_bobot']                    = "wuling_as_kpi/wuling_as_kpi_bobot";
$route['wuling_as_kpi_bobot/simpan']             = "wuling_as_kpi/wuling_as_kpi_bobot/simpan";
$route['wuling_as_kpi_bobot/hapus']              = "wuling_as_kpi/wuling_as_kpi_bobot/hapus";
$route['wuling_as_kpi_bobot/get']                = "wuling_as_kpi/wuling_as_kpi_bobot/get";
$route['wuling_as_kpi_bobot/get_kategori_by_id'] = "wuling_as_kpi/wuling_as_kpi_bobot/get_kategori_by_id";
$route['wuling_as_kpi_bobot/select2_kategori']   = "wuling_as_kpi/wuling_as_kpi_bobot/select2_kategori";

$route['wuling_as_kpi_scoring_by_mom']     = "wuling_as_kpi/wuling_as_kpi_scoring_by_mom";
$route['wuling_as_kpi_scoring_by_mom/get'] = "wuling_as_kpi/wuling_as_kpi_scoring_by_mom/get";

$route['wuling_as_kpi_scoring_by_kpi']                = "wuling_as_kpi/wuling_as_kpi_scoring_by_kpi";
$route['wuling_as_kpi_scoring_by_kpi/get_view_table'] = "wuling_as_kpi/wuling_as_kpi_scoring_by_kpi/get_view_table";
$route['wuling_as_kpi_scoring_by_kpi/get']            = "wuling_as_kpi/wuling_as_kpi_scoring_by_kpi/get";

$route['wuling_as_kpi_target']                      = "wuling_as_kpi/wuling_as_kpi_target";
$route['wuling_as_kpi_target/get']                  = "wuling_as_kpi/wuling_as_kpi_target/get";
$route['wuling_as_kpi_target/select2_key_kategori'] = "wuling_as_kpi/wuling_as_kpi_target/select2_key_kategori";
$route['wuling_as_kpi_target/import_excel']         = "wuling_as_kpi/wuling_as_kpi_target/import_excel";

$route['wuling_as_kpi_actual']                              = "wuling_as_kpi/wuling_as_kpi_actual";
$route['wuling_as_kpi_actual/get']                          = "wuling_as_kpi/wuling_as_kpi_actual/get";
$route['wuling_as_kpi_actual/import_excel']                 = "wuling_as_kpi/wuling_as_kpi_actual/import_excel";
$route['wuling_as_kpi_actual/sinkron_data']                 = "wuling_as_kpi/wuling_as_kpi_actual/sinkron_data";

$route['wuling_as_kpi_cco']              = "wuling_as_kpi/wuling_as_kpi_cco";
$route['wuling_as_kpi_cco/get']          = "wuling_as_kpi/wuling_as_kpi_cco/get";
$route['wuling_as_kpi_cco/import_excel'] = "wuling_as_kpi/wuling_as_kpi_cco/import_excel";

// Part Staff
$route['wuling_as_kpi_part_staff']              = "wuling_as_kpi/wuling_as_kpi_part_staff";
$route['wuling_as_kpi_part_staff/get']          = "wuling_as_kpi/wuling_as_kpi_part_staff/get";
$route['wuling_as_kpi_part_staff/import_excel'] = "wuling_as_kpi/wuling_as_kpi_part_staff/import_excel";

// Part Sales Advisor
$route['wuling_as_kpi_sa']              = "wuling_as_kpi/wuling_as_kpi_sa";
$route['wuling_as_kpi_sa/get']          = "wuling_as_kpi/wuling_as_kpi_sa/get";
$route['wuling_as_kpi_sa/import_excel'] = "wuling_as_kpi/wuling_as_kpi_sa/import_excel";
