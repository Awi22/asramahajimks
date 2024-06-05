<?php
defined('BASEPATH') or exit('No direct script access allowed');

// fungsi untuk melakukan debug
if (!function_exists('debug')) {
    function debug()
    {
        $numArgs = func_num_args();

        echo 'Total Arguments:' . $numArgs . "\n";

        $args = func_get_args();
        echo '<pre>';
        foreach ($args as $index => $arg) {
            echo 'Argument ke-' . $index . ':' . "\n";
            var_dump($arg);
            echo "\n";
            unset($args[$index]);
        }
        echo '</pre>';
        die();
    }
}

if (!function_exists('_monthToWeeks')) {
	function _monthToWeeks($y, $m)
	{
		$start     = date("{$y}-{$m}-01");
		$end       = date("Y-m-t", mktime(0, 0, 0, $m, 1, $y));
		$timeStart = strtotime($start);
		$timeEnd   = strtotime($end);
		$out       = [];

		$milestones[] = $timeStart;
		$timeEndWeek = strtotime('next Sunday', $timeStart);
		while ($timeEndWeek < $timeEnd) {
			$milestones[] = $timeEndWeek;
			$timeEndWeek = strtotime('+1 week', $timeEndWeek);
		}
		$milestones[] = $timeEnd;
		$count = count($milestones);
		for ($i = 1; $i < $count; $i++) {
			if ($i == $count - 1) {
				$out[] = [
					'0' => date("Y-m-d", $milestones[$i - 1]),
					'1' => date("Y-m-d", $milestones[$i])
				];
			} else {
				$out[] = [
					'0' => date("Y-m-d", $milestones[$i - 1]),
					'1' => date("Y-m-d", $milestones[$i] - 1)
				];
			}
		}
		return $out;
	}
}

function GenerateCode($database, $table, $colom, $case)
{
	$ci = &get_instance();
	$ci->$database->select($colom);
	$ci->$database->from($table);
	$number = $ci->$database->get()->num_rows() + 1;
	$case = $case;
	$result = $case . "" . $number;
	return $result;
}

function keyAndRulesFailValidate($validator)
{
	$key = array_keys($validator->errors()->toArray())[0];
	$role = array_keys($validator->errors()->toArray()[$key])[0];
	$result = "{$key}.{$role}";
	return $result;
}

function cek_duplikat($database, $table, $colom, $where, $data)
{
	$ci = &get_instance();
	$ci->$database->select($colom);
	$ci->$database->from($table);
	if (is_array($where)) {
		$hitung = count($where);
		for ($i = 0; $i < $hitung; $i++) {
			$ci->$database->where($where[$i], $data[$i]);
		}
	} else {
		$ci->$database->where($where, $data);
	}
	$cek = $ci->$database->get()->num_rows();
	return $cek;
}

function delete_data($database, $table, $colom, $where)
{
	$ci = &get_instance();
	$ci->$database->where($colom, $where);
	$ci->$database->delete($table);
}

function v_all($database, $select, $table)
{
	$ci = &get_instance();
	$ci->$database->select($select);
	$ci->$database->from($table);
	$data = $ci->$database->get();
	return $data->result();
}

function v_like($database, $select, $table, $c_like, $group_by, $v_like)
{
	$ci = &get_instance();
	$ci->$database->select($select);
	$ci->$database->from($table);
	$ci->$database->like($c_like, $v_like);
	if (empty($group_by)) {
		null;
	} else {
		$ci->$database->group_by($group_by);
	}
	$data = $ci->$database->get();
	return $data->result();
}

function v_where($database, $select, $table, $c_where, $v_where)
{
	$ci = &get_instance();
	$ci->$database->select($select);
	$ci->$database->from($table);
	$ci->$database->where($c_where, $v_where);
	$data = $ci->$database->get();
	foreach ($data->result() as $row) {
		$return = $row->$select;
	}
	if (empty($return)) {
		$return = null;
	}
	return $return;
}

function v_where_2(string $database, string $table, array $where)
{
	$ci = &get_instance();
	$query = $ci->$database->get_where($table, $where);
	return $query;
}

function v_where_all($database, $select, $table, $c_where, $v_where)
{
	$ci = &get_instance();
	$ci->$database->select($select);
	$ci->$database->from($table);
	$ci->$database->where($c_where, $v_where);
	$data = $ci->$database->get();
	return $data->result();
}

function profil_karyawan(int $nik): object
{
	$CI = &get_instance();
	$query = $CI->db->get_where('karyawan', array('nik' => $nik));
	return $query->row();
}

function hash_encode($string)
{
	error_reporting(0);
	$key = "ITDepartmentOfKumalaGroup";
	$encrypted = bin2hex(openssl_encrypt($string, 'AES-128-CBC', $key));
	return $encrypted;
}

function hash_decode($string)
{
	error_reporting(0);
	$key = "ITDepartmentOfKumalaGroup";
	$decrypted = openssl_decrypt(hex2bin($string), 'AES-128-CBC', $key);
	return $decrypted;
}

function cek_closing($db, $tanggal, $id_perusahaan)
{
	$arr = explode("-", $tanggal);
	$closing = q_data("bln,thn", "$db.closing_ltb", "id_perusahaan=$id_perusahaan", "id_closing", null, 1)->row();
	if (isset($closing)) {
		if ($arr[1] <= $closing->bln && $arr[0] < $closing->thn) {
			die("Maaf, Transaksi dibulan yang anda pilih telah diclose.");
		} else {
			return true;
		}
	}
	return true;
}


function jsonResponseFormFail($message, $inputRef)
{
	header('Content-Type: application/json');
	$err["status"] = "fail";
	$err["message"] = $message;
	$err["inputRef"] = $inputRef;
	die(json_encode($err));
}

function jsonResponse($status, $message, $ket)
{
	header('Content-Type: application/json');
	$result["status"] = $status;
	$result["message"] = $message;
	$result["ket"] = $ket;
	die(json_encode($result));
}

function encrypt_decrypt($action, $string)
{
	$output = false;
	$encrypt_method = "AES-256-CBC";
	$secret_key = 'KMG168secretkey!';
	$secret_iv = 'KMG168secretiv!';
	// hash
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	switch ($action) {
		case 'encrypt':
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
			break;
		case 'decrypt':
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			break;
		default:
			die('wrong action!');
			break;
	}
	return $output;
}

function id_perusahaan_to_brand($id_perusahaan)
{
	$CI = get_instance();
	$brand = '';

	$query = $CI->db
		->select('b.nama_brand')
		->from('brand AS b')
		->join('perusahaan AS p', 'p.id_brand=b.id_brand')
		->where('p.id_perusahaan', $id_perusahaan)
		->get()
		->row();
	if (isset($query)) {
		$brand = strtok($query->nama_brand, ' ');
	}

	return $brand;
}

function id_perusahaan_to_lokasi($id_perusahaan)
{
	$CI = get_instance();
	$brand = '';

	$query = $CI->db
		->select('p.lokasi')
		->from('perusahaan AS p')
		->where('p.id_perusahaan', $id_perusahaan)
		->get()
		->row();
	if (isset($query)) {
		$brand = $query->lokasi;
	}

	return $brand;
}

class SimpleResponse
{
	private $outp = array('status' => false, 'message' => '', 'data' => array());
	public function __construct($status = false)
	{
		header('Content-Type: application/json, charset=utf-8');
		$this->outp['status'] = $status;
	}
	function true()
	{
		$this->outp['status'] = true;
	}
	function false()
	{
		$this->outp['status'] = false;
	}
	function message($message)
	{
		$this->outp['message'] = $message;
	}
	function process($data)
	{
		$this->data($data);
		if ($this->outp['data'] == null) {
			$this->false();
		} else {
			$this->true();
		}
	}
	function data($data)
	{
		$this->outp['data'] = $data;
	}
	function success($data = [], $message = '')
	{
		$this->outp['status'] = true;
		$this->outp['message'] = $message == '' ? $this->outp['message'] : $message;
		$this->outp['data'] = $data == [] ? $this->outp['data'] : $data;
		http_response_code(200);
		die(json_encode($this->outp));
	}
	function failed($data = [], $message = 'Failed on SimpleResponse')
	{
		$this->outp['status'] = false;
		$this->outp['message'] = $message == '' ? $this->outp['message'] : $message;
		$this->outp['data'] = $data == [] ? $this->outp['data'] : $data;
		http_response_code(200);
		die(json_encode($this->outp));
	}
	function end()
	{
		if ($this->outp['status']) {
			$this->success();
		} else {
			$this->failed();
		}
	}
}
