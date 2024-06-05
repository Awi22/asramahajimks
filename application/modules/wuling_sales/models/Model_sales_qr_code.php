<?php


if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_sales_qr_code extends CI_Model
{

	public function get($id)
	{
		$data = [];
		$query_karyawan = $this->db
			->select("k.*, p.lokasi,p.nama_perusahaan,j.nama_jabatan")
			->from("karyawan k")
			->join("perusahaan p","p.id_perusahaan=k.id_perusahaan")
			->join("jabatan j","j.id_jabatan=k.id_jabatan")
			->where("k.id_karyawan", $id)
			->get();
		$row = $query_karyawan->row();
		if(isset($row)){
			$data = [
				'nama_karyawan' => $row->nama_karyawan,
				'cabang' => $row->lokasi,
				'nama_perusahaan' => $row->nama_perusahaan,
				'handphone' => $row->handphone,
				'jabatan' => $row->nama_jabatan
			];
		}
		return $data;
	}

	public function simpan($posts)
	{
		$status = FALSE;
		$pesan = 'Gagal menyimpan data';
		if(!empty($posts)){
			if(!empty($posts['token']) && !empty($posts['ref']) && !empty($posts['txt_name']) && !empty($posts['txt_alamat']) && !empty($posts['txt_handphone'])){
				$token = $posts['token'];
				$ref = $posts['ref'];
				$id_sales = encrypt_decrypt('decrypt', $ref);
				if(password_verify($id_sales, $token)){
					$data_insert = [
						'id' => $this->create_id_customer_qr($id_sales),
						'id_sales' => $id_sales,
						'nama' => htmlspecialchars(str_replace("'","",$posts['txt_name'])),
						'alamat' => htmlspecialchars(str_replace("'","",$posts['txt_alamat'])),
						'handphone' => htmlspecialchars(str_replace("'","",$posts['txt_handphone'])),
						'waktu_dihubungi' => htmlspecialchars(str_replace("'","",$posts['txt_waktu_dihubungi'])),
						'test_drive' => $posts['opt_test_drive'],
						'model_diminati' => $posts['opt_model'],
					];
					$this->db_wuling->trans_start();
					$this->db_wuling->insert('s_customer_qrcode', $data_insert);
					$this->db_wuling->trans_complete();

					if ($this->db_wuling->trans_status() === TRUE) {
						$status = TRUE; 
						$pesan = 'Berhasil menyimpan data';
					}
				}
			}
		}
		$data = ['status'=>$status, 'pesan'=>$pesan];
		return $data;
	}

	private function create_id_customer_qr($id_sales)
	{
		$last_id = 0;
		$id_customer = "QR-".$id_sales."00001";

        $query_last_id = $this->db_wuling
			->select("MAX(right(id,5)) AS id")
			->from("s_customer_qrcode")
			->where("id_sales", $id_sales)
			->get();

		$row = $query_last_id->row();
		if(isset($row)){
			$last_id = $row->id;
			$no_akhir = $last_id + 1;;
			$id_customer = "QR-". $id_sales . '-' . sprintf("%05s", $no_akhir);
		}

        return $id_customer;
	}
}
