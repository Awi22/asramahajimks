<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_menu_role extends CI_Model
{

	public function get()
	{
		$data 	= array();
		$query 	= $this->db_wuling
			->select('*')
			->from('menu_role')
			->order_by('role_name ASC')
			->get();

		foreach ($query->result() as $role) {
			$data[] = array(
				'role_id' 		=> $role->id,
				'role_name'		=> $role->role_name,
			);
		}

		return $data;
	}

	public function simpan_role($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menyimpan role';

		if (!empty($posts)) {
			$role_name 		= $posts['role_name'];

			//cek existing
			$query_cek_role = $this->db_wuling->select('*')->from('menu_role')->where('role_name', $role_name)->get();
			if ($query_cek_role->num_rows() > 0) {
				return ['status' => false, 'pesan' => 'Role Name sudah ada!'];
			}

			$this->db_wuling->trans_start();
			$data = [
				'created_by' 	=> $this->username,
				'role_name' 	=> $role_name
			];
			$this->db_wuling->insert("menu_role", $data);
			$this->db_wuling->trans_complete();

			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil menyimpan role';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function get_role_by_id($id)
	{
		$data_role	= NULL;

		if (!empty($id)) {
			$query_role 	= $this->db_wuling
				->select('*')
				->from('menu_role')
				->where('id', $id)
				->get();

			$level = $query_role->row();
			if ($query_role->num_rows() > 0) {
				$data_role = array(
					'role_id' 		=> $level->id,
					'role_name'		=> $level->role_name,
				);
			}
		}

		return $data_role;
	}


	public function update_role($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal mengupdate role';

		if (!empty($posts)) {
			$role_id 	= $posts['role_id'];
			$role_name  = $posts['role_name'];

			$data 	= [
				'role_name'		=> $role_name,
				'modified_by'	=> $this->username,
			];

			$this->db_wuling->trans_start();
			$this->db_wuling->update("menu_role", $data, ['id' => $role_id]);
			$this->db_wuling->trans_complete();

			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil mengupdate role';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}


	public function hapus_role($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menghapus role';

		if (!empty($posts)) {
			$role_id = $posts['id'];
			$this->db_wuling->trans_start();
			//tambah cek apakah terpakai atau tidak
			$this->db_wuling->delete("menu_role", ['id' => $role_id]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil menghapus user';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	//**** untuk kebutuhan jsTree *****//
	public function role_menu($group_id)
	{
		// Select all entries from the menu table
		// $query = $this->db_wuling->query("SELECT category_id, category_name, category_link,parent_id FROM " . $this->category . " order by parent_id, category_link");
		$query = $this->db_wuling->query("SELECT * FROM menu WHERE group_id='{$group_id}' ORDER BY group_id, parent_id, position");
		// $query_group = $this->db_wuling->query("SELECT * FROM menu_group ORDER BY id");

		// $zed = array(
		//     'items' => array(),
		// 	'groups' => array()
		// );
		// foreach ($query_group->result() as $groups){
		//     // $zed['items'][$groups->id] = $groups;
		//     $zed['groups'][$groups->id] = $groups->id;
		// }

		// echo "<pre>";
		// print_r ($zed);
		// die('xxx');

		// Create a multidimensional array to contain a list of items and parents
		$cat = array(
			'items' => array(),
			'parents' => array(),
			'groups' => array()
		);
		// Builds the array lists with data from the menu table
		foreach ($query->result() as $cats) {
			// Creates entry into items array with current menu item id ie. $menu['items'][1]
			$cat['items'][$cats->id] = $cats;
			// Creates entry into parents array. Parents array contains a list of all items with children
			$cat['parents'][$cats->parent_id][] = $cats->id;
			$cat['groups'][$cats->group_id][] = $cats->group_id;
		}

		if ($cat) {
			$result = $this->build_role_menu(0, $cat);
			return $result;
		} else {
			return FALSE;
		}
	}

	// Menu builder function, parentId 0 is the root
	function build_role_menu($parent, $menu)
	{
		$html = "";
		if (isset($menu['parents'][$parent])) {
			if ($parent != '0') {
				$html .= "<ul class='submenu'>\n";
			} else {
				$html .= "<ul class='nav nav-list'>\n";
			}

			foreach ($menu['parents'][$parent] as $itemId) {
				if (!isset($menu['parents'][$itemId])) {
					$html .= "<li id='node" . $menu['items'][$itemId]->id . "'>\n
                        <a href='" . base_url() . $menu['items'][$itemId]->url . "'>
                        <span>" . $menu['items'][$itemId]->title . "</span>
                        </a>\n
                        </li>\n";
				}
				if (isset($menu['parents'][$itemId])) {
					$html .= "<li id='node" . $menu['items'][$itemId]->id . "'>\n
                        <a class='dropdown-toggle' href='" . base_url() .  $menu['items'][$itemId]->url . "'>
                        <span class='menu-text'>" . $menu['items'][$itemId]->title . "</span>
                        </a>\n";
					$html .= $this->build_role_menu($itemId, $menu);
					$html .= "</li>\n";
				}
			}
			$html .= "</ul>\n";
		}
		return $html;
	}

	function get_tree_by_group_menu($group_id)
	{
		$tree = [];

		$query = $this->db_wuling->query("SELECT * FROM menu WHERE group_id='{$group_id}' ORDER BY group_id, parent_id, position");
		if($query->num_rows()>0 ){
			foreach ($query->result() as $q) {
				$tree[] = [
					"id" => $q->id,
					"parent" => ($q->parent_id)=="0"?"#":$q->parent_id,
					"text" => $q->title,
					// "state"      => [
					// 	"selected" => true
					// ], 
				];
			}
		} else {
			$tree = [
				"id" => "0",
				"parent" => "#",
				"text" => "Data Menu Kosong...",
				"state"      => [
					"disabled" => true
				], 
			];
		}
		return $tree;
	}

	function get_checked_tree_by_role_id($role_id)
	{
		$checked = [];
		$arr = [];
		$query = $this->db_wuling->get_where('menu_role_group', ['role_id' => $role_id]);
		foreach($query->result() as $q){
			$arr = explode(',',$q->menu_id);
			foreach($arr as $a){
				$checked[] = $a;
			}
		}		
		return $checked;
	}

	function assign_menu_ke_role($group_id, $role_id, $menu_id)
	{
		$status 	= false;
		$pesan 		= 'Gagal menyimpan role';
		$v_menu_id 	= NULL;
		
		if (!empty($group_id) && !empty($role_id)) {			
			$this->db_wuling->trans_start();

			//hapus role yang lama
			$hapus_role_lama = $this->db_wuling->delete('menu_role_group', [
				'role_id' => $role_id,
				'group_id' => $group_id
			]);
			
			if(!empty($menu_id)){
				foreach ($menu_id as $id) {
					$data[] = [
						'group_id' 		=> $group_id,
						'role_id' 		=> $role_id,
						'created_by' 	=> $this->username,
						'menu_id' 		=> $id
					];
				}
				$this->db_wuling->insert_batch("menu_role_group", $data);
			}
			

			$this->db_wuling->trans_complete();

			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil menyimpan role';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}
}

/* End of file Model_menu_role.php */
/* Location: ./wuling_admin/models/Model_menu_role.php */
