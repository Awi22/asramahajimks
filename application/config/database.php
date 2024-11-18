<?php
defined('BASEPATH') or exit('No direct script access allowed');


$active_group = 'default';
$active_record = TRUE;

/* ASRAMA HAJI */
$db['default']['hostname'] = $_ENV['DB_HOSTNAME'];
$db['default']['username'] = $_ENV['DB_USERNAME'];
$db['default']['password'] = $_ENV['DB_PASSWORD'];
$db['default']['database'] = $_ENV['DB_ASHAJ'];
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = (ENVIRONMENT !== 'production');
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

/* KMG */
// $db['default']['hostname'] = $_ENV['DB_HOSTNAME'];
// $db['default']['username'] = $_ENV['DB_USERNAME'];
// $db['default']['password'] = $_ENV['DB_PASSWORD'];
// $db['default']['database'] = $_ENV['DB_KMG'];
// $db['default']['dbdriver'] = 'mysqli';
// $db['default']['dbprefix'] = '';
// $db['default']['pconnect'] = FALSE;
// $db['default']['db_debug'] = (ENVIRONMENT !== 'production');
// $db['default']['cache_on'] = FALSE;
// $db['default']['cachedir'] = '';
// $db['default']['char_set'] = 'utf8';
// $db['default']['dbcollat'] = 'utf8_general_ci';
// $db['default']['swap_pre'] = '';
// $db['default']['autoinit'] = TRUE;
// $db['default']['stricton'] = FALSE;

// /* KumalaGroup */
$db['kumalagroup']['hostname'] = $_ENV['DB_HOSTNAME'];
$db['kumalagroup']['username'] = $_ENV['DB_USERNAME'];
$db['kumalagroup']['password'] = $_ENV['DB_PASSWORD'];
$db['kumalagroup']['database'] = $_ENV['DB_KUMALAGROUP'];
$db['kumalagroup']['dbdriver'] = 'mysqli';
$db['kumalagroup']['dbprefix'] = '';
$db['kumalagroup']['pconnect'] = FALSE;
$db['kumalagroup']['db_debug'] = (ENVIRONMENT !== 'production');
$db['kumalagroup']['cache_on'] = FALSE;
$db['kumalagroup']['cachedir'] = '';
$db['kumalagroup']['char_set'] = 'utf8';
$db['kumalagroup']['dbcollat'] = 'utf8_general_ci';
$db['kumalagroup']['swap_pre'] = '';
$db['kumalagroup']['autoinit'] = TRUE;
$db['kumalagroup']['stricton'] = FALSE;

// /* Database HelpDesk */
$db['db_holding']['hostname'] = $_ENV['DB_HOSTNAME'];
$db['db_holding']['username'] = $_ENV['DB_USERNAME'];
$db['db_holding']['password'] = $_ENV['DB_PASSWORD'];
$db['db_holding']['database'] = $_ENV['DB_HOLDING'];
$db['db_holding']['dbdriver'] = 'mysqli';
$db['db_holding']['dbprefix'] = '';
$db['db_holding']['pconnect'] = FALSE;
$db['db_holding']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_holding']['cache_on'] = FALSE;
$db['db_holding']['cachedir'] = '';
$db['db_holding']['char_set'] = 'utf8';
$db['db_holding']['dbcollat'] = 'utf8_general_ci';
$db['db_holding']['swap_pre'] = '';
$db['db_holding']['autoinit'] = TRUE;
$db['db_holding']['stricton'] = FALSE;


/* Database Wuling */
$db['db_wuling']['hostname'] = $_ENV['DB_HOSTNAME'];
$db['db_wuling']['username'] = $_ENV['DB_USERNAME'];
$db['db_wuling']['password'] = $_ENV['DB_PASSWORD'];
$db['db_wuling']['database'] = $_ENV['DB_WULING'];
$db['db_wuling']['dbdriver'] = 'mysqli';
$db['db_wuling']['dbprefix'] = '';
$db['db_wuling']['pconnect'] = FALSE;
$db['db_wuling']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_wuling']['cache_on'] = FALSE;
$db['db_wuling']['cachedir'] = '';
$db['db_wuling']['char_set'] = 'utf8';
$db['db_wuling']['dbcollat'] = 'utf8_general_ci';
$db['db_wuling']['swap_pre'] = '';
$db['db_wuling']['autoinit'] = TRUE;
$db['db_wuling']['stricton'] = FALSE;

/* Database Wuling SP */
$db['db_wuling_sp']['hostname'] = $_ENV['DB_HOSTNAME'];
$db['db_wuling_sp']['username'] = $_ENV['DB_USERNAME'];
$db['db_wuling_sp']['password'] = $_ENV['DB_PASSWORD'];
$db['db_wuling_sp']['database'] = $_ENV['DB_WULING_SP'];
$db['db_wuling_sp']['dbdriver'] = 'mysqli';
$db['db_wuling_sp']['dbprefix'] = '';
$db['db_wuling_sp']['pconnect'] = FALSE;
$db['db_wuling_sp']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_wuling_sp']['cache_on'] = FALSE;
$db['db_wuling_sp']['cachedir'] = '';
$db['db_wuling_sp']['char_set'] = 'utf8';
$db['db_wuling_sp']['dbcollat'] = 'utf8_general_ci';
$db['db_wuling_sp']['swap_pre'] = '';
$db['db_wuling_sp']['autoinit'] = TRUE;
$db['db_wuling_sp']['stricton'] = FALSE;

/* Database Wuling AS*/
$db['db_wuling_as']['hostname'] = $_ENV['DB_HOSTNAME'];
$db['db_wuling_as']['username'] = $_ENV['DB_USERNAME'];
$db['db_wuling_as']['password'] = $_ENV['DB_PASSWORD'];
$db['db_wuling_as']['database'] = $_ENV['DB_WULING_AS'];
$db['db_wuling_as']['dbdriver'] = 'mysqli';
$db['db_wuling_as']['dbprefix'] = '';
$db['db_wuling_as']['pconnect'] = FALSE;
$db['db_wuling_as']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_wuling_as']['cache_on'] = FALSE;
$db['db_wuling_as']['cachedir'] = '';
$db['db_wuling_as']['char_set'] = 'utf8';
$db['db_wuling_as']['dbcollat'] = 'utf8_general_ci';
$db['db_wuling_as']['swap_pre'] = '';
$db['db_wuling_as']['autoinit'] = TRUE;
$db['db_wuling_as']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */
