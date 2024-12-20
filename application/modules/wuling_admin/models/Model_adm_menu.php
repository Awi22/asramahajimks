<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_adm_menu extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_menu($group_id)
	{
		$this->db_wuling->select('*');
		$this->db_wuling->from('menu');
		$this->db_wuling->where('group_id', $group_id);
		$this->db_wuling->order_by('parent_id , position');
		$query = $this->db_wuling->get();
		$res = $query->result();
		$parents = [];
		foreach ($res as $parent) {
			$parents[] = $parent->parent_id;
		}
		// debug($parents);

		if ($res) {
			foreach ($res as $r) {
				$is_parent = false;
				$is_parent = (in_array($r->id, $parents)) ? true : false;
				foreach ($res as $s) {
					if ($s->parent_id == $s->id) {
						$is_parent = true;
					}
				}
				$menu[] = (object) [
					'id' => $r->id,
					'parent_id' => $r->parent_id,
					'title' => $r->title,
					'icon' => $r->icon,
					'url' => $r->url,
					'position' => $r->position,
					'group_id' => $r->group_id,
					'is_parent' => $is_parent,
				];
			}
			return $menu;
		} else {
			return false;
		}
	}

	/**
	 * Get group title
	 *
	 * @param int $group_id
	 * @return string
	 */
	public function get_menu_group_title($group_id)
	{
		$this->db_wuling->select('*');
		$this->db_wuling->from('menu_group');
		$this->db_wuling->where('id', $group_id);
		$query = $this->db_wuling->get();
		return $query->row();
	}

	/**
	 * Get all items in menu group table
	 *
	 * @return array
	 */
	public function get_menu_groups()
	{
		$this->db_wuling->select('*');
		$this->db_wuling->from('menu_group');
		$this->db_wuling->order_by('id', 'ASC');
		$query = $this->db_wuling->get();
		return $query->result();
	}

	public function add_menu_group($data)
	{
		if ($this->db_wuling->insert('menu_group', $data)) {
			$response['status'] = 1;
			$response['id'] = $this->db_wuling->Insert_ID();
			return $response;
		} else {
			$response['status'] = 2;
			$response['msg'] = 'Add group error.';
			return $response;
		}
	}

	public function get_row($id)
	{
		$this->db_wuling->select('*');
		$this->db_wuling->from('menu');
		$this->db_wuling->where('id', $id);
		$query = $this->db_wuling->get();
		return $query->row();
	}

	/**
	 * Get the highest position number
	 *
	 * @param int $group_id
	 * @return string
	 */
	public function get_last_position($group_id)
	{
		$pos = 0;
		$this->db_wuling->select_max('position');
		$this->db_wuling->from('menu');
		$this->db_wuling->where('group_id', $group_id);
		$this->db_wuling->where('parent_id', '0');
		$query = $this->db_wuling->get();
		$data = $query->row();
		$pos = $data->position + 1;
		return $pos;
	}

	public function get_descendants($id)
	{
		$this->db_wuling->select('id');
		$this->db_wuling->from('menu');
		$this->db_wuling->where('parent_id', $id);
		$query = $this->db_wuling->get();
		$data = $query->row();

		$ids = array();
		if (!empty($data)) {
			foreach ($data as $v) {
				$ids[] = $v;
				$this->get_descendants($v);
			}
		}
	}

	//Delete the menu
	public function delete_menu($id)
	{
		//cek dulu apa sudah diassign atau belum
		$cek = $this->db_wuling->select('menu_id')->from('menu_role_group')->where('menu_id', $id)->get();
		if ($cek->num_rows() > 0) {
			return false;
		}
		$this->db_wuling->where('id', $id);
		return $this->db_wuling->delete('menu');
	}

	//Update MenuController Group
	public function update_menu_group($data, $id)
	{
		if ($this->db_wuling->update('menu_group', $data, 'id' . ' = ' . $id)) {
			return true;
		}
	}

	//Delete MenuController Group
	public function delete_menu_group($id)
	{
		$this->db_wuling->where('id', $id);
		return $this->db_wuling->delete('menu_group');
	}

	public function delete_menus($id)
	{
		$this->db_wuling->where('group_id', $id);
		return $this->db_wuling->delete('menu');
	}
}

/* End of file Model_adm_menu.php */
/* Location: ./wuling_admin/models/Model_adm_menu.php */
