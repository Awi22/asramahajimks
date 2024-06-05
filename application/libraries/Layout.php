<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Layout templating untuk view CodeIgniter
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          zdienos
 * @license         MIT
 * @link            https://github.com/kumala-group/dms-wuling
 */


class Layout
{
	/**
	 * @var string        	$template     			Folder root template yang digunakan, default: '_template/'
	 * @var array 			$layout_data 			Array penampungan untuk menyimpan setting layout variabel yang akan diparsing ke view
	 * @var string       	$role_id          		Role ID user yang diperoleh dari session data
	 * @var string       	$role_name              Role Name user yang diperoleh dari session data
	 * @var string     		$nama_cabang          	Role Cabang user yang diperoleh dari session data
	 * 
	 * @var string        	$title                	Judul halaman, defaultnya ''
	 * @var string        	$data               	Data yang akan diparsing ke view, default []
	 * 
	 **/


	private $template = '_template/';
	private $layout_data = array();
	private $role_id;
	private $role_name;
	private $nama_cabang;
	private $title;
	private $data;

	function __construct()
	{
		$this->role_id 		= $this->session->userdata('role_id');
		$this->role_name 	= $this->session->userdata('role_name');
		$this->nama_cabang 	= $this->session->userdata('nama_cabang');

		$this->title = '';
		$this->data  = [];
	}

	/**
	 * Magic method untuk mengambil property CI yang invisible
	 * @param string 	$var		
	 * @return object
	 */
	public function __get($var) 
	{
		return get_instance()->$var;
	}

	/**
	 * Fungsi untuk menentukan judul halaman
	 * @param string 	$title		judulnya
	 * @return object
	 */
	public function title($the_title)
	{
		$this->title = $the_title;
		return $this;
	}

	/**
	 * Fungsi untuk menentukan data yang akan diparsing ke view
	 * @param array  	$the_data	data yang akan diparsing
	 * @return object
	 */
	public function data($the_data)
	{
		$this->data = $the_data;
		return $this;
	}

	/**
	 * Fungsi untuk menentukan template yang akan digunakan
	 * @param string 	$template	folder template
	 * @return object
	 */
	public function template($template) {
		$this->template = $template;
		return $this;
	}

	/**
	 * Fungsi untuk menentukan nama variable yang akan diterapkan ke view
	 * @param string 	$name 		nama variablenya
	 * @param value 	$value 		nilainya
	 * @return object
	 */
	private function set($name, $value)
	{
		$this->layout_data[$name] = $value;
	}

	/**
	 * Load view 
	 * @param string  	$view   	file halaman view
	 * @param array   	$data  		data-datanya
	 * @return html
	 */
	public function view($view = '', $return = FALSE)
	{
		$view_data = $this->data;
		$view_data['judul'] = $this->title;
		$view_data['role_name'] = $this->role_name;
		$view_data['nama_cabang'] = $this->nama_cabang;

		if (empty($this->role_id)) {
			redirect(base_url('auth/logout'), 'refresh');
		}

		//set template yang akan digunakan
		// if(!isset($this->template)){
		// 	$this->template = ''
		// }

		$menus['menu_items'] = $this->generate_menu($this->role_id);

		if ($this->_view_exists($view . '_css')) {
			$this->set('css', $this->load->view($view . '_css', $view_data, TRUE));
		} else {
			$this->set('css', '', TRUE);
		}

		$this->set('sidebar', $this->load->view($this->template . 'sidebar', $menus, TRUE));
		$this->set('notifications', $this->load->view($this->template . 'notification', $view_data, TRUE));
		$this->set('contents', $this->load->view($view, $view_data, TRUE));

		if ($this->_view_exists($view . '_js')) {
			$this->set('javascript', $this->load->view($view . '_js', $view_data, TRUE));
		} else {
			$this->set('javascript', '', TRUE);
		}

		$this->load->view($this->template . 'index', $this->layout_data, $return);
		return $this;
	}

	/**
	 * Untuk mengecek apakah view file ada atau tidak
	 * @param string  	$view    	file halaman view
	 * @return boolean
	 */
	private function _view_exists($view)
	{
		$module_name = $this->router->fetch_module();
		// $mod_dir = 'modules/' . $this->uri->rsegment(1) . '/';
		$mod_dir = 'modules/' . $module_name . '/';
		return (
			(file_exists(APPPATH . 'views/' . $view . EXT) or file_exists(APPPATH . 'views/' . $view))
			or
			(file_exists(APPPATH . $mod_dir . 'views/' . $view . EXT) or file_exists(APPPATH . $mod_dir . 'views/' . $view))
		);
	}

	/**
	 * Fungsi untuk menggenerate menu ke halaman view berdasarkan role_id user yang sedang login
	 * @param string  	$role_id   	role_id user 
	 * @return boolean
	 */
	private function generate_menu($role_id)
	{
		$query_menu = $this->db_wuling->select('menu_id')->from('menu_role_group')->where('role_id', $role_id)->get();
		$menu_ids = [];

		foreach ($query_menu->result() as $menu_id) {
			$menu_ids[] = $menu_id->menu_id;
		};
		
		$arr_menu = array(
			'items' => array(),
			'parents' => array()
		);

		if($query_menu->num_rows()>0){
			$query = $this->db_wuling->select("*")->from('menu')->where_in('id', $menu_ids)->where('is_enabled',1)->order_by('group_id, parent_id, position')->get();
			
			foreach ($query->result() as $menu) {
				$arr_menu['items'][$menu->id] = $menu;
				$arr_menu['parents'][$menu->parent_id][] = $menu->id;
			}
		}

		
		if ($arr_menu) {
			$result = $this->build_menu(0, $arr_menu);
			return $result;
		} else {
			return FALSE;
		}
	}

	/**
	 * Membuat menu dari array menu 
	 * @param string  	$parent   	0 berarti menu utama
	 * @param array  	$menu   	data array menu 
	 * @return html
	 */
	private function build_menu($parent, $menu)
	{
		$html = "";
		if (isset($menu['parents'][$parent])) {
			if ($parent != '0') {
				$html .= "<div class=\"menu-sub menu-sub-accordion\">\n";
			} else {
				$html .= "\n";
			}
			$counter = 1;
			$current_group = 1;
			$old_group = 1;

			foreach ($menu['parents'][$parent] as $itemId) {
				//membuat header menu
				$current_group = $menu['items'][$itemId]->group_id;
				if ($current_group != $old_group) {
					$old_group = $current_group;
					$counter = 1;
				} else {
				}
				if ($counter == 1) {
					//bc343f
					if ($menu['items'][$itemId]->parent_id == "0") {
						$html .= "<div class=\"menu-item pt-5\">
									<div class=\"menu-content\">
										<span class=\"menu-heading fw-bold text-uppercase fs-7\">" . $this->_group_id_to_title($current_group) . "</span>
									</div>
								</div>\n";
					}
				}
				$counter++;
				//end of membuat header menu

				//kalau tidak ada parentnya, berarti single menu
				if (!isset($menu['parents'][$itemId])) {
					if ($menu['items'][$itemId]->parent_id == "0") {
						$html .= "<div class=\"menu-item\">
										<a class=\"menu-link\" href=\"" . base_url() . $menu['items'][$itemId]->url . "\">
											<span class=\"menu-icon\">
												<i class=\"fs-8 " . $menu['items'][$itemId]->icon . "\"></i>
											</span>
											<span class=\"menu-title\">" . $menu['items'][$itemId]->title . "</span>
										</a>
									</div>\n";
					} else {
						$html .= "<div class=\"menu-item\">
									<a class=\"menu-link\"  href=\"" . base_url() . $menu['items'][$itemId]->url . "\">
										<span class=\"menu-bullet\">
											<span class=\"bullet bullet-dot\"></span>
										</span>
										<span class=\"menu-title\">" . $menu['items'][$itemId]->title . "</span>
									</a>
								</div>\n";
					}
				}

				//kalau ada parentnya, berarti submenu menu
				if (isset($menu['parents'][$itemId])) {
					$html .= "<div data-kt-menu-trigger=\"click\" class=\"menu-item menu-accordion\">
								<span class=\"menu-link\">
									<span class=\"menu-icon\">
										<i class=\"" . $menu['items'][$itemId]->icon . "\"></i>
									</span>
									<span class=\"menu-title\">" . $menu['items'][$itemId]->title . "</span>
									<span class=\"menu-arrow\"></span>
								</span>\n";
					$html .= $this->build_menu($itemId, $menu);
					$html .= "</div></div>";
				}
			}
			$html .= "\n";
		}
		return $html;
	}

	/**
	 * Fungsi untuk mengambil title dari group_id suatu menu 
	 * @param string  	$group_id   group_id menu
	 * @return string
	 */
	private function _group_id_to_title($group_id)
	{
		$title = "";
		$query = $this->db_wuling->get_where('menu_group', ['id' => $group_id]);
		$row = $query->row();
		if (isset($row)) {
			$title = strtoupper($row->title);
		}
		return $title;
	}



	/* Fungsi gak kepake, buat catatan saja, nanti kalo sudah smooth, hapus sajaaaaa
	*/
	// public function good_view($title = '', $view = '', $view_data = array(), $return = FALSE)
	// {
	// 	$view_data['judul'] = $title;
	// 	$view_data['role_name'] = $this->role_name;
	// 	$view_data['nama_cabang'] = $this->nama_cabang;
	// 	if (empty($this->role_id)) {
	// 		redirect(base_url('auth/logout'), 'refresh');
	// 	}
	// 	$menus['menu_items'] = $this->generate_menu($this->role_id);

	// 	if ($this->_view_exists($view . '_css')) {
	// 		$this->set('css', $this->load->view($view . '_css', $view_data, TRUE));
	// 	} else {
	// 		$this->set('css', '', TRUE);
	// 	}

	// 	$this->set('sidebar', $this->load->view($this->template . 'sidebar', $menus, TRUE));
	// 	$this->set('contents', $this->load->view($view, $view_data, TRUE));

	// 	if ($this->_view_exists($view . '_js')) {
	// 		$this->set('javascript', $this->load->view($view . '_js', $view_data, TRUE));
	// 	} else {
	// 		$this->set('javascript', '', TRUE);
	// 	}
	// 	return $this->load->view($this->template . 'index', $this->layout_data, $return);
	// }

}

/* End of file Layout.php */
/* Location: ./system/application/libraries/Layout.php */
