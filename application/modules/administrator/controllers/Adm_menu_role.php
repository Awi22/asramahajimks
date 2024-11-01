<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adm_menu_role extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_menu_role', 'role');
	}

	public function index()
	{
		$this->layout
			->title('Role Menu')
			->view('adm_menu_role/index');
	}

	public function get()
	{
		$data 	= $this->role->get();
		responseJson(['aaData' => $data]);
	}

	public function simpan()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->role->simpan_role($posts);
		responseJson($result);
	}

	public function get_role_by_id()
	{
		$id		= $this->input->get("id");
		$result	= $this->role->get_role_by_id($id);
		responseJson($result);
	}

	public function update()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->role->update_role($posts);
		responseJson($result);
	}

	public function hapus()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->role->hapus_role($posts);
		responseJson($result);
	}

	///*** fungsi untuk generate jstree **//
	public function get_tree_by_group_menu()
	{
		$id       = $this->input->get('group_id');
		$result   = $this->role->get_tree_by_group_menu($id);
		// $result = $this->role->role_menu($id);
		// debug($result);
		// echo(json_encode($result));
		responseJson($result);
	}

	// fungsi ambil checked tree by role id
	public function get_checked_tree_by_role_id()
	{
		$role_id    = $this->input->get('role_id');
		$result     = $this->role->get_checked_tree_by_role_id($role_id);
		responseJson($result);
	}

	//fungsi untuk menyimpan menu-menu ke role 
	public function assign_menu_ke_role()
	{
		$group_id 		= $this->input->post('group_id');
		$role_id 		= $this->input->post('role_id');
		$child_id 		= $this->input->post('menu_id');
		$v_parent_id 	= $this->input->post('parent_id');
		$parent_id 		= [];
		$menu_id 		= [];
		//filter parent_id
		if (!empty($v_parent_id)) {
			$unique 		= array_unique($v_parent_id); //remove duplicate value
			$parent_id 		= array_diff($unique, ['#']); //hilangkan #
			$menu_id 		= array_merge($child_id, $parent_id);
		}

		$result 	= $this->role->assign_menu_ke_role($group_id, $role_id, $menu_id);
		responseJson($result);
	}
}

/* End of file Adm_menu_role.php */
/* Location: ./application/controllers/Adm_menu_role.php */
