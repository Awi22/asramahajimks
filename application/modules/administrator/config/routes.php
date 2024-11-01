<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/*--- Administrator ROUTE --- */

/* Home */
$route['adm_home']                        = "administrator/adm_home";

/* Adm_profil */
// $route['adm_profil']                      = "administrator/adm_profil";
// $route['adm_profil/simpan_profil']        = "administrator/adm_profil/simpan_profil";
// $route['adm_profil/simpan_foto']          = "administrator/adm_profil/simpan_foto";
// $route['adm_profil/simpan_pwd']           = "administrator/adm_profil/simpan_pwd";
// $route['adm_profil/simpan_open_username'] = "administrator/adm_profil/simpan_open_username";

/* User */
$route['adm_user']                        = "administrator/adm_user";
$route['adm_user/get']                    = "administrator/adm_user/get";
$route['adm_user/get_user_by_id']         = "administrator/adm_user/get_user_by_id";
$route['adm_user/set_status']             = "administrator/adm_user/set_status";
$route['adm_user/tambah_user']            = "administrator/adm_user/tambah_user";
$route['adm_user/copy_user']              = "administrator/adm_user/copy_user";
$route['adm_user/update_user']            = "administrator/adm_user/update_user";
$route['adm_user/reset_user']             = "administrator/adm_user/reset_user";
$route['adm_user/hapus_user']             = "administrator/adm_user/hapus_user";

/* Pustaka Level */
// $route['adm_p_level']                     = "administrator/adm_p_level";
// $route['adm_p_level/get']                 = "administrator/adm_p_level/get";
// $route['adm_p_level/get_level_by_id']     = "administrator/adm_p_level/get_level_by_id";
// $route['adm_p_level/tambah_level']        = "administrator/adm_p_level/tambah_level";
// $route['adm_p_level/update_level']        = "administrator/adm_p_level/update_level";
// $route['adm_p_level/hapus_level']         = "administrator/adm_p_level/hapus_level";

/* Pustaka URL */
// $route['adm_p_url']                       = "administrator/adm_p_url";
// $route['adm_p_url/get']                   = "administrator/adm_p_url/get";
// $route['adm_p_url/get_url_by_id']         = "administrator/adm_p_url/get_url_by_id";
// $route['adm_p_url/tambah_url']            = "administrator/adm_p_url/tambah_url";
// $route['adm_p_url/update_url']            = "administrator/adm_p_url/update_url";
// $route['adm_p_url/hapus_url']             = "administrator/adm_p_url/hapus_url";

/* Pustaka Region */
// $route['adm_p_region']                    = "administrator/adm_p_region";
// $route['adm_p_region/cari']               = "administrator/adm_p_region/cari";
// $route['adm_p_region/simpan']             = "administrator/adm_p_region/simpan";
// $route['adm_p_region/hapus/(:any)']       = "administrator/adm_p_region/hapus";


/* Global */
$route['adm_user_global/select2_status_pegawai']    = "administrator/adm_user_global/select2_status_pegawai";
$route['adm_user_global/select2_role']              = "administrator/adm_user_global/select2_role";
$route['adm_user_global/get_coverage']              = "administrator/adm_user_global/get_coverage";
$route['adm_user_global/get_data_asn']              = "administrator/adm_user_global/get_data_asn";
$route['adm_user_global/get_data_karyawan']         = "administrator/adm_user_global/get_data_karyawan";
$route['adm_user_global/select2_group_menu']        = "administrator/adm_user_global/select2_group_menu";

// $route['adm_user_global/select2_url']         = "administrator/adm_user_global/select2_url";
// $route['adm_user_global/select2_level']       = "administrator/adm_user_global/select2_level";
// $route['adm_user_global/select2_cabang']      = "administrator/adm_user_global/select2_cabang";
// $route['adm_user_global/select2_jabatan']     = "administrator/adm_user_global/select2_jabatan";
// $route['adm_user_global/get_data_pegawai']    = "administrator/adm_user_global/get_data_pegawai";

/* Menu */
$route['adm_menu']                       = "administrator/adm_menu";
$route['adm_menu/add']                   = "administrator/adm_menu/add";
$route['adm_menu/save']                  = "administrator/adm_menu/save";
$route['adm_menu/edit/(:num)']           = 'administrator/adm_menu/edit/$1';
$route['adm_menu/delete']                = "administrator/adm_menu/delete";
$route['adm_menu/save_position']         = "administrator/adm_menu/save_position";
$route['adm_menu/submenu']               = "administrator/adm_menu/submenu";
$route['adm_menu/menu/(:num)']           = 'administrator/adm_menu/menu/$1';

$route['adm_menugroup/add']              = "administrator/adm_menugroup/add";
$route['adm_menugroup/edit']             = "administrator/adm_menugroup/edit";
$route['adm_menugroup/delete']           = "administrator/adm_menugroup/delete";

$route['adm_menu_role']                  = "administrator/adm_menu_role";
$route['adm_menu_role/simpan']           = "administrator/adm_menu_role/simpan";
$route['adm_menu_role/get']              = "administrator/adm_menu_role/get";
$route['adm_menu_role/get_role_by_id']   = "administrator/adm_menu_role/get_role_by_id";
$route['adm_menu_role/update']           = "administrator/adm_menu_role/update";
$route['adm_menu_role/hapus']            = "administrator/adm_menu_role/hapus";

$route['adm_menu_role/get_tree_by_group_menu']       = "administrator/adm_menu_role/get_tree_by_group_menu";
$route['adm_menu_role/get_checked_tree_by_role_id']  = "administrator/adm_menu_role/get_checked_tree_by_role_id";
$route['adm_menu_role/assign_menu_ke_role']          = "administrator/adm_menu_role/assign_menu_ke_role";

$route['adm_setting']                       = "administrator/adm_setting";
$route['adm_setting/upload_background']     = "administrator/adm_setting/upload_background";
