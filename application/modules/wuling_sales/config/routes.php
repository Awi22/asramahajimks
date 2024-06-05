<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


//** Sales */
$route['sales_pofil_customer']                                  = "wuling_sales/sales_pofil_customer";
$route['sales_pofil_customer/getDataCustomer']                  = "wuling_sales/sales_pofil_customer/getDataCustomer";
$route['sales_pofil_customer/getDataProvinsi']                  = "wuling_sales/sales_pofil_customer/getDataProvinsi";
$route['sales_pofil_customer/getDataKabupaten']                 = "wuling_sales/sales_pofil_customer/getDataKabupaten";
$route['sales_pofil_customer/getDataKecamatan']                 = "wuling_sales/sales_pofil_customer/getDataKecamatan";
$route['sales_pofil_customer/getDataKelurahan']                 = "wuling_sales/sales_pofil_customer/getDataKelurahan";
$route['sales_pofil_customer/getDataUnit']                      = "wuling_sales/sales_pofil_customer/getDataUnit";
$route['sales_pofil_customer/getDataSumberProspek']             = "wuling_sales/sales_pofil_customer/getDataSumberProspek";
$route['sales_pofil_customer/getDataAktivitas']                 = "wuling_sales/sales_pofil_customer/getDataAktivitas";
$route['sales_pofil_customer/simpanDataCustomer']               = "wuling_sales/sales_pofil_customer/simpanDataCustomer";

//** Sales Suspect */
$route['sales_pofil_customer/getDataSuspect']                     = "wuling_sales/sales_pofil_customer/getDataSuspect";
$route['sales_pofil_customer/simpanDataSuspect']                  = "wuling_sales/sales_pofil_customer/simpanDataSuspect";

//** Data WSA */
$route['sales_pofil_customer/getDataFormWsa']                     = "wuling_sales/sales_pofil_customer/getDataFormWsa";
$route['sales_pofil_customer/getOccupationsWsa']                  = "wuling_sales/sales_pofil_customer/getOccupationsWsa";
$route['sales_pofil_customer/getCannelsWsa']                       = "wuling_sales/sales_pofil_customer/getCannelsWsa";
$route['sales_pofil_customer/getNasonalEventWsa']                  = "wuling_sales/sales_pofil_customer/getNasonalEventWsa";
$route['sales_pofil_customer/getDataDealer']                       = "wuling_sales/sales_pofil_customer/getDataDealer";
$route['sales_pofil_customer/getDataStatusFu']                     = "wuling_sales/sales_pofil_customer/getDataStatusFu";
$route['sales_pofil_customer/getDataRemaksFu']                    = "wuling_sales/sales_pofil_customer/getDataRemaksFu";
$route['sales_pofil_customer/getDataNextFu']                    = "wuling_sales/sales_pofil_customer/getDataNextFu";
$route['sales_pofil_customer/simpanDataWsa']                    = "wuling_sales/sales_pofil_customer/simpanDataWsa";

//** Followup Proses */
$route['sales_pofil_customer/simpanDataFolloup']                = "wuling_sales/sales_pofil_customer/simpanDataFolloup";
$route['sales_pofil_customer/simpanFollowupForWsa']              = "wuling_sales/sales_pofil_customer/simpanFollowupForWsa";

//** Test Drive Proses */
$route['sales_pofil_customer/getCekDataProspekIdWsa']             = "wuling_sales/sales_pofil_customer/getCekDataProspekIdWsa";
$route['sales_pofil_customer/getDataType']                       = "wuling_sales/sales_pofil_customer/getDataType";
$route['sales_pofil_customer/getDataVarian']                    = "wuling_sales/sales_pofil_customer/getDataVarian";
$route['sales_pofil_customer/simpanTestDrive']                    = "wuling_sales/sales_pofil_customer/simpanTestDrive";
$route['sales_pofil_customer/simpanTestDriveWsa']               = "wuling_sales/sales_pofil_customer/simpanTestDriveWsa";


//** Sales Prospek */
$route['sales_pofil_customer/getDataProspek']                    = "wuling_sales/sales_pofil_customer/getDataProspek";
$route['sales_pofil_customer/getDataMediaMotivaor']                = "wuling_sales/sales_pofil_customer/getDataMediaMotivaor";
$route['sales_pofil_customer/getDataStockUnit']                    = "wuling_sales/sales_pofil_customer/getDataStockUnit";
$route['sales_pofil_customer/simpanProspek']                    = "wuling_sales/sales_pofil_customer/simpanProspek";

//** Sales Hot Prospek */ 
$route['sales_pofil_customer/getDataHotProspek']                = "wuling_sales/sales_pofil_customer/getDataHotProspek";
$route['sales_pofil_customer/simpanHotProspek']                    = "wuling_sales/sales_pofil_customer/simpanHotProspek";

//** Sales SPK */
$route['sales_pofil_customer/getDataSpk']                = "wuling_sales/sales_pofil_customer/getDataSpk";
$route['sales_pofil_customer/getDataNoSpk']                = "wuling_sales/sales_pofil_customer/getDataNoSpk";
$route['sales_pofil_customer/getDataLeasing']                = "wuling_sales/sales_pofil_customer/getDataLeasing";
$route['sales_pofil_customer/simpanFotoPayment']                = "wuling_sales/sales_pofil_customer/simpanFotoPayment";
$route['sales_pofil_customer/simpanSpk']                = "wuling_sales/sales_pofil_customer/simpanSpk";

//** Sales Proses Lanjut Tahapan */
$route['sales_pofil_customer/simpanProsesLanjutTahapan']                = "wuling_sales/sales_pofil_customer/simpanProsesLanjutTahapan";

//** Daftar Pricelist Unit */
$route['sales_pricelist_unit']                                  = "wuling_sales/sales_pricelist_unit";
$route['sales_pricelist_unit/getDataVarian']                    = "wuling_sales/sales_pricelist_unit/getDataVarian";
$route['sales_pricelist_unit/getDataPricelistUnit']             = "wuling_sales/sales_pricelist_unit/getDataPricelistUnit";

//** Daftar Customer Digital */
$route['sales_customer_dgital']                                   = "wuling_sales/sales_customer_dgital";
$route['sales_customer_dgital/getDataCsutomerDigital']             = "wuling_sales/sales_customer_dgital/getDataCsutomerDigital";

//** Pengajuan Diskon */
$route['sales_pengajuan_diskon']                                = "wuling_sales/sales_pengajuan_diskon";
$route['sales_pengajuan_diskon/getDataPengajuanDiskon']         = "wuling_sales/sales_pengajuan_diskon/getDataPengajuanDiskon";

//** Jadwal Kunjungan */ 
$route['sales_jadwal_kunjungan']                                = "wuling_sales/sales_jadwal_kunjungan";
$route['sales_jadwal_kunjungan/getDataJadwalKunjungan']         = "wuling_sales/sales_jadwal_kunjungan/getDataJadwalKunjungan";
$route['sales_jadwal_kunjungan/getDataProvinsi']                  = "wuling_sales/sales_jadwal_kunjungan/getDataProvinsi";
$route['sales_jadwal_kunjungan/getDataKabupaten']                 = "wuling_sales/sales_jadwal_kunjungan/getDataKabupaten";
$route['sales_jadwal_kunjungan/getDataKecamatan']                 = "wuling_sales/sales_jadwal_kunjungan/getDataKecamatan";
$route['sales_jadwal_kunjungan/getDataKelurahan']                 = "wuling_sales/sales_jadwal_kunjungan/getDataKelurahan";
$route['sales_jadwal_kunjungan/getDataUnit']                      = "wuling_sales/sales_jadwal_kunjungan/getDataUnit";
$route['sales_jadwal_kunjungan/getDataSumberProspek']             = "wuling_sales/sales_jadwal_kunjungan/getDataSumberProspek";
$route['sales_jadwal_kunjungan/getDataAktivitas']                 = "wuling_sales/sales_jadwal_kunjungan/getDataAktivitas";
$route['sales_jadwal_kunjungan/simpanDataCustomer']               = "wuling_sales/sales_jadwal_kunjungan/simpanDataCustomer";

//** Sales Suspect */
$route['sales_jadwal_kunjungan/getDataSuspect']                     = "wuling_sales/sales_jadwal_kunjungan/getDataSuspect";
$route['sales_jadwal_kunjungan/simpanDataSuspect']                  = "wuling_sales/sales_jadwal_kunjungan/simpanDataSuspect";

//** Data WSA */
$route['sales_jadwal_kunjungan/getDataFormWsa']                     = "wuling_sales/sales_jadwal_kunjungan/getDataFormWsa";
$route['sales_jadwal_kunjungan/getOccupationsWsa']                  = "wuling_sales/sales_jadwal_kunjungan/getOccupationsWsa";
$route['sales_jadwal_kunjungan/getCannelsWsa']                       = "wuling_sales/sales_jadwal_kunjungan/getCannelsWsa";
$route['sales_jadwal_kunjungan/getNasonalEventWsa']                  = "wuling_sales/sales_jadwal_kunjungan/getNasonalEventWsa";
$route['sales_jadwal_kunjungan/getDataDealer']                       = "wuling_sales/sales_jadwal_kunjungan/getDataDealer";
$route['sales_jadwal_kunjungan/getDataStatusFu']                     = "wuling_sales/sales_jadwal_kunjungan/getDataStatusFu";
$route['sales_jadwal_kunjungan/getDataRemaksFu']                    = "wuling_sales/sales_jadwal_kunjungan/getDataRemaksFu";
$route['sales_jadwal_kunjungan/getDataNextFu']                    = "wuling_sales/sales_jadwal_kunjungan/getDataNextFu";
$route['sales_jadwal_kunjungan/simpanDataWsa']                    = "wuling_sales/sales_jadwal_kunjungan/simpanDataWsa";

//** Followup Proses */
$route['sales_jadwal_kunjungan/simpanDataFolloup']                = "wuling_sales/sales_jadwal_kunjungan/simpanDataFolloup";
$route['sales_jadwal_kunjungan/simpanFollowupForWsa']              = "wuling_sales/sales_jadwal_kunjungan/simpanFollowupForWsa";

//** Test Drive Proses */
$route['sales_jadwal_kunjungan/getCekDataProspekIdWsa']             = "wuling_sales/sales_jadwal_kunjungan/getCekDataProspekIdWsa";
$route['sales_jadwal_kunjungan/getDataType']                       = "wuling_sales/sales_jadwal_kunjungan/getDataType";
$route['sales_jadwal_kunjungan/getDataVarian']                    = "wuling_sales/sales_jadwal_kunjungan/getDataVarian";
$route['sales_jadwal_kunjungan/simpanTestDrive']                    = "wuling_sales/sales_jadwal_kunjungan/simpanTestDrive";
$route['sales_jadwal_kunjungan/simpanTestDriveWsa']               = "wuling_sales/sales_jadwal_kunjungan/simpanTestDriveWsa";


//** Sales Prospek */
$route['sales_jadwal_kunjungan/getDataProspek']                    = "wuling_sales/sales_jadwal_kunjungan/getDataProspek";
$route['sales_jadwal_kunjungan/getDataMediaMotivaor']                = "wuling_sales/sales_jadwal_kunjungan/getDataMediaMotivaor";
$route['sales_jadwal_kunjungan/getDataStockUnit']                    = "wuling_sales/sales_jadwal_kunjungan/getDataStockUnit";
$route['sales_jadwal_kunjungan/simpanProspek']                    = "wuling_sales/sales_jadwal_kunjungan/simpanProspek";

//** Sales Hot Prospek */ 
$route['sales_jadwal_kunjungan/getDataHotProspek']                = "wuling_sales/sales_jadwal_kunjungan/getDataHotProspek";
$route['sales_jadwal_kunjungan/simpanHotProspek']                    = "wuling_sales/sales_jadwal_kunjungan/simpanHotProspek";

//** Sales SPK */
$route['sales_jadwal_kunjungan/getDataSpk']                = "wuling_sales/sales_jadwal_kunjungan/getDataSpk";
$route['sales_jadwal_kunjungan/getDataNoSpk']                = "wuling_sales/sales_jadwal_kunjungan/getDataNoSpk";
$route['sales_jadwal_kunjungan/getDataLeasing']                = "wuling_sales/sales_jadwal_kunjungan/getDataLeasing";
$route['sales_jadwal_kunjungan/simpanFotoPayment']                = "wuling_sales/sales_jadwal_kunjungan/simpanFotoPayment";
$route['sales_jadwal_kunjungan/simpanSpk']                = "wuling_sales/sales_jadwal_kunjungan/simpanSpk";

//** Sales Proses Lanjut Tahapan */
$route['sales_jadwal_kunjungan/simpanProsesLanjutTahapan']                = "wuling_sales/sales_jadwal_kunjungan/simpanProsesLanjutTahapan";

//** Survai DO */
$route['sales_survai_do']                                          = "wuling_sales/sales_survai_do";
$route['sales_survai_do/getDataSurvaiDO']                          = "wuling_sales/sales_survai_do/getDataSurvaiDO";

//** Test Drive */
$route['sales_test_drive']                                      = "wuling_sales/sales_test_drive";
$route['sales_test_drive/getDataTestDrive']                     = "wuling_sales/sales_test_drive/getDataTestDrive";
$route['sales_test_drive/getDataDetailTestDrive']                     = "wuling_sales/sales_test_drive/getDataDetailTestDrive";
$route['sales_test_drive/getDataUnit']                     = "wuling_sales/sales_test_drive/getDataUnit";
$route['sales_test_drive/getDataPekerjaan']                     = "wuling_sales/sales_test_drive/getDataPekerjaan";

//** Pengajuan Ar Sales */
$route['sales_pengajuan_ar']                                     = "wuling_sales/sales_pengajuan_ar";
$route['sales_pengajuan_ar/getDataCustomerRequestAr']            = "wuling_sales/sales_pengajuan_ar/getDataCustomerRequestAr";
$route['sales_pengajuan_ar/simpanPengajuanAr']                   = "wuling_sales/sales_pengajuan_ar/simpanPengajuanAr";

//** Spk Progress */
$route['sales_spk_progress']                                      = "wuling_sales/sales_spk_progress";
$route['sales_spk_progress/getDataSpk']                            = "wuling_sales/sales_spk_progress/getDataSpk";

//** Followup Customer */
$route['sales_followup_customer']                                  = "wuling_sales/sales_followup_customer";
$route['sales_followup_customer/getDataFuSales']                   = "wuling_sales/sales_followup_customer/getDataFuSales";
$route['sales_followup_customer/detail']                           = "wuling_sales/sales_followup_customer/detail";


//** Sales QR Code */
$route['sales_qr_code']                                          = "wuling_sales/sales_qr_code";
$route['sales_qr_code/get']                                      = "wuling_sales/sales_qr_code/get";


//** Sales QR for Customer */
$route['sales_qr_customer_add']                                    = "wuling_sales/sales_qr_customer_add";
$route['sales_qr_customer_add/select2_unit']                       = "wuling_sales/sales_qr_customer_add/select2_unit";
$route['sales_qr_customer_add/simpan']                            = "wuling_sales/sales_qr_customer_add/simpan";


//** Sales QR Customer */
$route['sales_qr_customer']                                        = "wuling_sales/sales_qr_customer";
$route['sales_qr_customer/get']                                    = "wuling_sales/sales_qr_customer/get";
$route['sales_qr_customer/select2_unit']                         = "wuling_sales/sales_qr_customer/select2_unit";
$route['sales_qr_customer/simpan']                                 = "wuling_sales/sales_qr_customer/simpan";
$route['sales_qr_customer/hapus']                                 = "wuling_sales/sales_qr_customer/hapus";
$route['sales_qr_customer/get_customer_by_id']                     = "wuling_sales/sales_qr_customer/get_customer_by_id";

//** Sales View dan Edit Proses */
$route['sales_profil_customer_view_edit/(:any)']                                        = "wuling_sales/sales_profil_customer_view_edit";
$route['sales_profil_customer_view_edit_getDataCustomerProses']                         = "wuling_sales/sales_profil_customer_view_edit/getDataCustomerProses";
$route['sales_profil_customer_view_edit_getDataProvinsi']                  = "wuling_sales/sales_profil_customer_view_edit/getDataProvinsi";
$route['sales_profil_customer_view_edit_getDataKabupaten']                 = "wuling_sales/sales_profil_customer_view_edit/getDataKabupaten";
$route['sales_profil_customer_view_edit_getDataKecamatan']                 = "wuling_sales/sales_profil_customer_view_edit/getDataKecamatan";
$route['sales_profil_customer_view_edit_getDataKelurahan']                 = "wuling_sales/sales_profil_customer_view_edit/getDataKelurahan";
$route['sales_profil_customer_view_edit_getDataUnit']                      = "wuling_sales/sales_profil_customer_view_edit/getDataUnit";
$route['sales_profil_customer_view_edit_getDataSumberProspek']             = "wuling_sales/sales_profil_customer_view_edit/getDataSumberProspek";
$route['sales_profil_customer_view_edit_getDataMediaMotivaor']                 = "wuling_sales/sales_profil_customer_view_edit/getDataMediaMotivaor";
$route['sales_profil_customer_view_edit_editCustomerProspek']                 = "wuling_sales/sales_profil_customer_view_edit/editCustomerProspek";
$route['sales_profil_customer_view_edit_view/(:any)']                 = "wuling_sales/sales_profil_customer_view_edit/view";
