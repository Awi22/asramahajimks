<?php
defined('BASEPATH') or exit('No direct script access allowed');

$autoload['packages']   = array();

$autoload['libraries']  = array('database', 'session', 'form_validation', 'multidatabase', 'datatables', 'layout', 'router');

$autoload['drivers']    = array();

// $autoload['helper']     = array('file', 'html', 'url', 'form', 'security', 'date', 'name', 'download', 'captcha', 'text_helper', 'tanggal', 'rupiah', 'dev_helper', 'otoritas_menu_helper', 'debug', 'curl', 'auth', 'menu_active', 'stok_part', 'excel_array', 'tax_rate', 'stok_part_global');
$autoload['helper']     = array('file', 'html', 'url', 'form', 'security', 'date', 'name', 'download', 'captcha', 'text_helper', 'tanggal', 'rupiah', 'dev_helper', 'curl', 'auth', 'tax_rate', 'menu', 'stok_part');

$autoload['config']     = array();

$autoload['language']   = array();

$autoload['model']      = array('model_data', 'api/model_api');
