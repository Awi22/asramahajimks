<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* Coa Budget */
$route['master_coa_budget']                       				= "ebudget/master_coa_budget";
$route['master_coa_budget/get']                					= "ebudget/master_coa_budget/get";
$route['master_coa_budget/select2_akun']       					= "ebudget/master_coa_budget/select2_akun";
$route['master_coa_budget/tambah_coa']       					= "ebudget/master_coa_budget/tambah_coa";
$route['master_coa_budget/get_pilih_akun']          			= "ebudget/master_coa_budget/get_pilih_akun";
$route['master_coa_budget/set_status']       					= "ebudget/master_coa_budget/set_status";
$route['master_coa_budget/hapus_coa']       					= "ebudget/master_coa_budget/hapus_coa";
$route['master_coa_budget/get_approval_coa_by_id']          	= "ebudget/master_coa_budget/get_approval_coa_by_id";
$route['master_coa_budget/update_approval']          			= "ebudget/master_coa_budget/update_approval";

/* Kategori Budget */
$route['master_kategori_budget']                       			= "ebudget/master_kategori_budget";
$route['master_kategori_budget/get']                			= "ebudget/master_kategori_budget/get";

/* Planning Budget */
$route['tambah_planning_budget']                     			= "ebudget/tambah_planning_budget";
$route['tambah_planning_budget/get']                			= "ebudget/tambah_planning_budget/get";
$route['tambah_planning_budget/select2_kategori']    			= "ebudget/tambah_planning_budget/select2_kategori";
$route['tambah_planning_budget/select2_sub_kategori']			= "ebudget/tambah_planning_budget/select2_sub_kategori";
$route['tambah_planning_budget/select2_coa_budget']				= "ebudget/tambah_planning_budget/select2_coa_budget";
$route['tambah_planning_budget/tambah_planning']				= "ebudget/tambah_planning_budget/tambah_planning";
$route['tambah_planning_budget/get_total_tahun_lalu']			= "ebudget/tambah_planning_budget/get_total_tahun_lalu";

/* Daftar Planning Budget */
$route['daftar_planning_budget']                     			= "ebudget/daftar_planning_budget";
$route['daftar_planning_budget/get']                			= "ebudget/daftar_planning_budget/get";

/* History Planning Budget */
$route['history_planning_budget']                     			= "ebudget/history_planning_budget";
$route['history_planning_budget/get']                			= "ebudget/history_planning_budget/get";

/* Edit Planning Budget */
$route['edit_planning_budget']                     				= "ebudget/edit_planning_budget";
$route['edit_planning_budget/get']                     			= "ebudget/edit_planning_budget/get";
$route['edit_planning_budget/get_data_by_id']          			= "ebudget/edit_planning_budget/get_data_by_id";
$route['edit_planning_budget/update_data_planning']    			= "ebudget/edit_planning_budget/update_data_planning";
$route['edit_planning_budget/hapus_data']    					= "ebudget/edit_planning_budget/hapus_data";
$route['edit_planning_budget/eksport_data']    					= "ebudget/edit_planning_budget/eksport_data";

/* Approve Planning Budget */
$route['approve_planning_budget']                     			= "ebudget/approve_planning_budget";
$route['approve_planning_budget/get']                    		= "ebudget/approve_planning_budget/get";
$route['approve_planning_budget/approve_data']           		= "ebudget/approve_planning_budget/approve_data";
$route['approve_planning_budget/reject_data']           		= "ebudget/approve_planning_budget/reject_data";


/* Final Planning Budget */
$route['final_planning_budget']                     			= "ebudget/final_planning_budget";
$route['final_planning_budget/get']                  			= "ebudget/final_planning_budget/get";
$route['final_planning_budget/eksport_data']    	    		= "ebudget/final_planning_budget/eksport_data";

/* Tambah Pengajuan Biaya */
$route['tambah_pengajuan_biaya']                     			= "ebudget/tambah_pengajuan_biaya";
$route['tambah_pengajuan_biaya/get']                			= "ebudget/tambah_pengajuan_biaya/get";
$route['tambah_pengajuan_biaya/select2_cabang']            		= "ebudget/tambah_pengajuan_biaya/select2_cabang";
$route['tambah_pengajuan_biaya/select2_coa_budget']            	= "ebudget/tambah_pengajuan_biaya/select2_coa_budget";
$route['tambah_pengajuan_biaya/get_planning_budget_from_coa'] 	= "ebudget/tambah_pengajuan_biaya/get_planning_budget_from_coa";
$route['tambah_pengajuan_biaya/simpan'] 						= "ebudget/tambah_pengajuan_biaya/simpan";
$route['tambah_pengajuan_biaya/get_pengajuan_biaya_by_id'] 		= "ebudget/tambah_pengajuan_biaya/get_pengajuan_biaya_by_id";
$route['tambah_pengajuan_biaya/simpan_po_budget'] 				= "ebudget/tambah_pengajuan_biaya/simpan_po_budget";
$route['tambah_pengajuan_biaya/hapus'] 							= "ebudget/tambah_pengajuan_biaya/hapus";

/* Daftar Pengajuan Biaya */
$route['daftar_pengajuan_biaya']                     			= "ebudget/daftar_pengajuan_biaya";
$route['daftar_pengajuan_biaya/(:num)']							= "ebudget/daftar_pengajuan_biaya/edit/(:num)";
$route['daftar_pengajuan_biaya/get']                			= "ebudget/daftar_pengajuan_biaya/get";
$route['daftar_pengajuan_biaya/get_budget_po_by_id']         	= "ebudget/daftar_pengajuan_biaya/get_budget_po_by_id";
$route['daftar_pengajuan_biaya/update_po_budget']         		= "ebudget/daftar_pengajuan_biaya/update_po_budget";
$route['daftar_pengajuan_biaya/reset_status_by_id']         	= "ebudget/daftar_pengajuan_biaya/reset_status_by_id";
$route['daftar_pengajuan_biaya/hapus_by_id']         			= "ebudget/daftar_pengajuan_biaya/hapus_by_id";

/* Approval Pengajuan Biaya */
$route['approval_pengajuan_biaya_sm']                     		= "ebudget/approval_pengajuan_biaya_sm";
$route['approval_pengajuan_biaya_sm/get']                		= "ebudget/approval_pengajuan_biaya_sm/get";
$route['approval_pengajuan_biaya_sm/approve']                	= "ebudget/approval_pengajuan_biaya_sm/approve";
$route['approval_pengajuan_biaya_sm/reject']                	= "ebudget/approval_pengajuan_biaya_sm/reject";

$route['approval_pengajuan_biaya_asm']                     		= "ebudget/approval_pengajuan_biaya_asm";
$route['approval_pengajuan_biaya_asm/get']                		= "ebudget/approval_pengajuan_biaya_asm/get";
$route['approval_pengajuan_biaya_asm/approve']                	= "ebudget/approval_pengajuan_biaya_asm/approve";
$route['approval_pengajuan_biaya_asm/reject']                	= "ebudget/approval_pengajuan_biaya_asm/reject";

$route['approval_pengajuan_biaya_gm']                     		= "ebudget/approval_pengajuan_biaya_gm";
$route['approval_pengajuan_biaya_gm/get']                		= "ebudget/approval_pengajuan_biaya_gm/get";
$route['approval_pengajuan_biaya_gm/approve']                	= "ebudget/approval_pengajuan_biaya_gm/approve";
$route['approval_pengajuan_biaya_gm/reject']                	= "ebudget/approval_pengajuan_biaya_gm/reject";


/* Realisasi Pengajuan Biaya */
$route['realisasi_pengajuan_biaya']                     		= "ebudget/realisasi_pengajuan_biaya";
$route['realisasi_pengajuan_biaya/(:num)']						= "ebudget/realisasi_pengajuan_biaya/edit/(:num)";
$route['realisasi_pengajuan_biaya/get']                			= "ebudget/realisasi_pengajuan_biaya/get";
$route['realisasi_pengajuan_biaya/get_budget_po_by_id']         = "ebudget/realisasi_pengajuan_biaya/get_budget_po_by_id";
$route['realisasi_pengajuan_biaya/update_po_budget']         	= "ebudget/realisasi_pengajuan_biaya/update_po_budget";
$route['realisasi_pengajuan_biaya/reset_status_by_id']         	= "ebudget/realisasi_pengajuan_biaya/reset_status_by_id";
$route['realisasi_pengajuan_biaya/cetak']         				= "ebudget/realisasi_pengajuan_biaya/cetak";

