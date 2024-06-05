<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/*--- Administrator ROUTE --- */

/* Home */
$route['wuling_adm_home']                       = "wuling_admin/wuling_adm_home";

/* Adm_profil */
$route['wuling_adm_profil']                     = "wuling_admin/wuling_adm_profil";
$route['wuling_adm_profil/simpan_profil']       = "wuling_admin/wuling_adm_profil/simpan_profil";
$route['wuling_adm_profil/simpan_foto']         = "wuling_admin/wuling_adm_profil/simpan_foto";
$route['wuling_adm_profil/simpan_pwd']          = "wuling_admin/wuling_adm_profil/simpan_pwd";
$route['wuling_adm_profil/simpan_open_username']= "wuling_admin/wuling_adm_profil/simpan_open_username";

/* User */
$route['wuling_adm_user']                       = "wuling_admin/wuling_adm_user";
$route['wuling_adm_user/get']                 	= "wuling_admin/wuling_adm_user/get";
$route['wuling_adm_user/get_user_by_id']        = "wuling_admin/wuling_adm_user/get_user_by_id";
$route['wuling_adm_user/set_status']           	= "wuling_admin/wuling_adm_user/set_status";
$route['wuling_adm_user/tambah_user']           = "wuling_admin/wuling_adm_user/tambah_user";
$route['wuling_adm_user/copy_user']             = "wuling_admin/wuling_adm_user/copy_user";
$route['wuling_adm_user/update_user']           = "wuling_admin/wuling_adm_user/update_user";
$route['wuling_adm_user/reset_user']            = "wuling_admin/wuling_adm_user/reset_user";
$route['wuling_adm_user/hapus_user']            = "wuling_admin/wuling_adm_user/hapus_user";

/* Pustaka Level */
$route['wuling_adm_p_level']                    = "wuling_admin/wuling_adm_p_level";
$route['wuling_adm_p_level/get']                = "wuling_admin/wuling_adm_p_level/get";
$route['wuling_adm_p_level/get_level_by_id']    = "wuling_admin/wuling_adm_p_level/get_level_by_id";
$route['wuling_adm_p_level/tambah_level']       = "wuling_admin/wuling_adm_p_level/tambah_level";
$route['wuling_adm_p_level/update_level']       = "wuling_admin/wuling_adm_p_level/update_level";
$route['wuling_adm_p_level/hapus_level']        = "wuling_admin/wuling_adm_p_level/hapus_level";

/* Pustaka URL */
$route['wuling_adm_p_url']                      = "wuling_admin/wuling_adm_p_url";
$route['wuling_adm_p_url/get']                  = "wuling_admin/wuling_adm_p_url/get";
$route['wuling_adm_p_url/get_url_by_id']        = "wuling_admin/wuling_adm_p_url/get_url_by_id";
$route['wuling_adm_p_url/tambah_url']           = "wuling_admin/wuling_adm_p_url/tambah_url";
$route['wuling_adm_p_url/update_url']           = "wuling_admin/wuling_adm_p_url/update_url";
$route['wuling_adm_p_url/hapus_url']            = "wuling_admin/wuling_adm_p_url/hapus_url";

/* Pustaka Region */
$route['wuling_adm_p_region']                   = "wuling_admin/wuling_adm_p_region";
$route['wuling_adm_p_region/cari']              = "wuling_admin/wuling_adm_p_region/cari";
$route['wuling_adm_p_region/simpan']            = "wuling_admin/wuling_adm_p_region/simpan";
$route['wuling_adm_p_region/hapus/(:any)']      = "wuling_admin/wuling_adm_p_region/hapus";


/* Global */
$route['wuling_adm_user_global/select2_url']        = "wuling_admin/wuling_adm_user_global/select2_url";
$route['wuling_adm_user_global/select2_role']      	= "wuling_admin/wuling_adm_user_global/select2_role";
$route['wuling_adm_user_global/select2_level']      = "wuling_admin/wuling_adm_user_global/select2_level";
$route['wuling_adm_user_global/select2_cabang']     = "wuling_admin/wuling_adm_user_global/select2_cabang";
$route['wuling_adm_user_global/select2_jabatan']    = "wuling_admin/wuling_adm_user_global/select2_jabatan";
$route['wuling_adm_user_global/get_data_pegawai']   = "wuling_admin/wuling_adm_user_global/get_data_pegawai";
$route['wuling_adm_user_global/get_coverage']       = "wuling_admin/wuling_adm_user_global/get_coverage";
$route['wuling_adm_user_global/select2_group_menu']     = "wuling_admin/wuling_adm_user_global/select2_group_menu";



/* Menu */
$route['wuling_adm_menu']                       = "wuling_admin/wuling_adm_menu";
$route['wuling_adm_menu/add']                	= "wuling_admin/wuling_adm_menu/add";
$route['wuling_adm_menu/save']                	= "wuling_admin/wuling_adm_menu/save";
$route['wuling_adm_menu/edit/(:num)'] 			= 'wuling_admin/wuling_adm_menu/edit/$1';
$route['wuling_adm_menu/delete']               	= "wuling_admin/wuling_adm_menu/delete";
$route['wuling_adm_menu/save_position']        	= "wuling_admin/wuling_adm_menu/save_position";
$route['wuling_adm_menu/submenu']               = "wuling_admin/wuling_adm_menu/submenu";
$route['wuling_adm_menu/menu/(:num)'] 			= 'wuling_admin/wuling_adm_menu/menu/$1';

$route['wuling_adm_menugroup/add']         		= "wuling_admin/wuling_adm_menugroup/add";
$route['wuling_adm_menugroup/edit']         	= "wuling_admin/wuling_adm_menugroup/edit";
$route['wuling_adm_menugroup/delete']         	= "wuling_admin/wuling_adm_menugroup/delete";


$route['wuling_adm_menu_role']                  = "wuling_admin/wuling_adm_menu_role";
$route['wuling_adm_menu_role/simpan']           = "wuling_admin/wuling_adm_menu_role/simpan";
$route['wuling_adm_menu_role/get']              = "wuling_admin/wuling_adm_menu_role/get";
$route['wuling_adm_menu_role/get_role_by_id']   = "wuling_admin/wuling_adm_menu_role/get_role_by_id";
$route['wuling_adm_menu_role/update']           = "wuling_admin/wuling_adm_menu_role/update";
$route['wuling_adm_menu_role/hapus']            = "wuling_admin/wuling_adm_menu_role/hapus";

$route['wuling_adm_menu_role/get_tree_by_group_menu']       = "wuling_admin/wuling_adm_menu_role/get_tree_by_group_menu";
$route['wuling_adm_menu_role/get_checked_tree_by_role_id']  = "wuling_admin/wuling_adm_menu_role/get_checked_tree_by_role_id";
$route['wuling_adm_menu_role/assign_menu_ke_role']          = "wuling_admin/wuling_adm_menu_role/assign_menu_ke_role";



$route['wuling_adm_setting']                   	= "wuling_admin/wuling_adm_setting";
$route['wuling_adm_setting/upload_background'] 	= "wuling_admin/wuling_adm_setting/upload_background";



