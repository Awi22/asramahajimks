<?php

use app\models\elo\sales\ModelCustomer;


if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_customer_qr extends CI_Model
{

	public function createId()
    {
        $id_sales = $this->id_sales;
        $last_id = $this->lastCode($id_sales);
        if ($last_id > 0) {
            $no_akhir = $last_id + 1;
            $id =  $id_sales . '-' . sprintf("%04s", $no_akhir);
        } else {
            $id =  $id_sales . '-0001';
        }
        return $id;
    }

	public function lastCode($id_sales)
    {
        $data = ModelCustomer::selectRaw("max(RIGHT(id_prospek, 4)) as id")->whereRaw("SUBSTRING_INDEX(id_prospek, '-', 1)='$id_sales'")->first();
        $row = $data->count();
        if ($row > 0) {
            $rows = $data;
            $hasil = (int) $rows['id'];
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

	public function get()
	{
		$id_sales = $this->id_sales;
		$data = [];
		$query_customer = $this->db_wuling
			->select("c.*, v.varian, w.warna")
			->from("s_customer_qrcode c")
			->join("unit u", "u.kode_unit=c.model_diminati")
			->join("p_varian v","v.id_varian=u.id_varian")
			->join("p_warna w","w.id_warna=u.id_warna")
			->where("c.status", 0)
			->where("c.id_sales", $id_sales)
			->where("u.show", 1)
			->order_by("c.created_at", "DESC")
			->get();
		foreach ($query_customer->result() as $customer) {
			$data[] = [
				'id' => $customer->id,
				'nama' => $customer->nama,
				'alamat' => $customer->alamat,
				'handphone' => $customer->handphone,
				'model' => $customer->varian.' - '.$customer->warna,
				'testdrive' => $customer->test_drive=='y' ? 'Ya': 'Tidak',
				'waktu_dihubungi' => $customer->waktu_dihubungi,
				'tgl_input' => date('Y-m-d', strtotime($customer->created_at)),
				'status' => $customer->status,
			];
		}
		return $data;
	}

	public function get_customer_by_id($gets)
	{
		$id_sales = $this->id_sales;
		$data = [];
		if(!empty($gets['id'])){
			$id = $gets['id'];
			$query_customer = $this->db_wuling
				->select("c.*")
				->from("s_customer_qrcode c")
				->where("c.status", 0)
				->where("c.id", $id)
				->get();
			$row = $query_customer->row();
			if(isset($row)){
				$data = [
					'id' => $row->id,
					'id_prospek' => $this->createId(),
					'nama' => $row->nama,
					'alamat' => $row->alamat,
					'handphone' => $row->handphone,
					'model' => $row->model_diminati,
				];
			}
		}
		
		return $data;
	}

	public function simpan($posts)
	{
		$status = FALSE;
		$pesan = 'Gagal menyimpan data';
		
		if(!empty($posts)){
			if(!empty($posts['id']) && !empty($posts['ref']) && !empty($posts['txt_name']) && !empty($posts['txt_alamat']) && !empty($posts['txt_handphone'])){
				$id_sales = $posts['id'];
				$ref = $posts['ref'];
				if(password_verify($id_sales, $ref)){
					$data_insert = [
						'id_sales' => $id_sales,
						'nama' => $posts['txt_name'],
						'alamat' => $posts['txt_alamat'],
						'handphone' => $posts['txt_handphone'],
						'waktu_dihubungi' => $posts['txt_waktu_dihubungi'],
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

	public function hapus($post)
	{
		$status = FALSE;
		$pesan = 'Gagal menghapus customer';
		
		if(isset($post)){
			if(!empty($post['id'])){
				$id = $post['id'];
				$this->db_wuling->trans_start();
				$this->db_wuling->delete("s_customer_qrcode", ['id' => $id]);
				$this->db_wuling->trans_complete();

				if ($this->db_wuling->trans_status() === TRUE) {
					$status = TRUE; 
					$pesan = 'Berhasil menghapus customer';
				}
			}
		}
		$data = ['status'=>$status, 'pesan'=>$pesan];
		return $data;
	}

}
