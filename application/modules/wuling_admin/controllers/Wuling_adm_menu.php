<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_adm_menu extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_adm_menu');
	}

	public function index()
	{
		$group_id = 1;
        $menu = $this->model_adm_menu->get_menu($group_id);
        $data['menu_ul'] = '<ul id="easymm"></ul>';
        if ($menu) {
            foreach ($menu as $row) {
                $this->add_row(
                    $row->id, $row->parent_id, ' id="menu-' . $row->id . '" class="sortable "', $this->get_label($row)
                );
            }
            $data['menu_ul'] = $this->generate_list('id="easymm" class="p-0"');
        }
        $data['group_id'] = $group_id;
        $data['group_title'] = $this->model_adm_menu->get_menu_group_title($group_id);
        $data['menu_groups'] = $this->model_adm_menu->get_menu_groups();
		
		$this->layout
			->title('Manajemen Menu')
			->data($data)
			->view('adm_menu/index');

	}

    public function menu($group_id)
    {
        $menu = $this->model_adm_menu->get_menu($group_id);

        $data = array(
			'judul' 	=> "Manajemen Menu",
			'class' 	=> "management_menu",			
			'content' 	=> 'adm_menu/index',
		);
        
        $data['menu_ul'] = '<ul id="easymm"></ul>';
        if ($menu) {
            foreach ($menu as $row) {
                $this->add_row(
                    $row->id, $row->parent_id, ' id="menu-' . $row->id . '" class="sortable"', $this->get_label($row)
                );
            }

            $data['menu_ul'] = $this->generate_list('id="easymm"');
        }
        $data['group_id'] = $group_id;
        $data['group_title'] = $this->model_adm_menu->get_menu_group_title($group_id);
        $data['menu_groups'] = $this->model_adm_menu->get_menu_groups();

		$this->layout
			->title('Manajemen Menu')
			->data($data)
			->view('adm_menu/index');
    }

    function generate_list($ul_attr = '')
    {
        return $this->ul(0, $ul_attr);
    }

    function ul($parent = 0, $attr = '')
    {
        static $i = 1;
        $indent = str_repeat("\t\t", $i);
        if (isset($this->data[$parent])) {
            if ($attr) {
                $attr = ' ' . $attr;
            }
            $html = "\n$indent";
            $html .= "<ul$attr>";
            $i++;
            foreach ($this->data[$parent] as $row) {
                $child = $this->ul($row['id']);
                $html .= "\n\t$indent";
                $html .= '<li' . $row['li_attr'] . '>';
                $html .= $row['label'];
                if ($child) {
                    $i--;
                    $html .= $child;
                    $html .= "\n\t$indent";
                }
                $html .= '</li>';
            }
            $html .= "\n$indent</ul>";
            return $html;
        } else {
            return false;
        }
    }

    function add_row($id, $parent, $li_attr, $label)
    {
        $this->data[$parent][] = array('id' => $id, 'li_attr' => $li_attr, 'label' => $label);
    }

    public function add()
    {
        $title = $this->input->post('title');
        if ($title) {
            $data['title'] = $this->input->post('title');
            if (!empty($data['title'])) {
                $data['url'] = $this->input->post('url');
                $data['icon'] = $this->input->post('icon');
                $data['group_id'] = $this->input->post('group_id');
                $data['created_by'] = $this->username;
                if ($this->db_wuling->insert('menu', $data)) {
                    $data['id'] = $this->db_wuling->Insert_ID();
                    $response['status'] = 1;
                    $li_id = 'menu-' . $data['id'];
                    $response['li'] = '<li id="' . $li_id . '" class="sortable">' . $this->get_labels($data) . '</li>';
                    $response['li_id'] = $li_id;
                } else {
                    $response['status'] = 2;
                    $response['msg'] = 'Add menu error.';
                }
            } else {
                $response['status'] = 3;
            }
			responseJson($response);
        }
    }

    public function edit($id)
    {
        $data['row'] = $this->model_adm_menu->get_row($id);
        $data['menu_groups'] = $this->model_adm_menu->get_menu_groups();
        $this->load->view('adm_menu/edit', $data);
    }

    public function save()
    {
        $title = $this->input->post('title');
        if ($title) {
            $data['title'] = trim($_POST['title']);
            if (!empty($data['title'])) {
                $data['id'] = $this->input->post('menu_id');
                $data['url'] = $this->input->post('url');
                $data['icon'] = $this->input->post('icon');
                $data['modified_by'] = $this->username;

                $item_moved = false;
                $group_id = $this->input->post('group_id');
                if ($group_id) {
                    $group_id = $this->input->post('group_id');
                    $old_group_id = $this->input->post('old_group_id');

                    //if group changed
                    if ($group_id != $old_group_id) {
                        $data['group_id'] = $group_id;
                        $data['position'] = $this->model_adm_menu->get_last_position($group_id);
                        $item_moved = true;
                    }
                }

                if ($this->db_wuling->update('menu', $data, 'id' . ' = ' . $data['id'])) {
                    if ($item_moved) {
                        //move sub items
                        $ids = $this->model_adm_menu->get_descendants($data['id']);
                        if (!empty($ids)) {
                            $sql = sprintf('UPDATE %s SET %s = %s WHERE %s IN (%s)', 'menu', 'group_id', $group_id, 'id', $ids);
                            $update_sub = $this->db_wuling->Execute($sql);
                        }
                        $response['status'] = 4;
                    } else {
                        $response['status'] = 1;
                        $d['title'] = $data['title'];
                        $d['url'] = $data['url'];
                        $d['icon'] = $data['icon']; 
                        $response['menu'] = $d;
                    }
                } else {
                    $response['status'] = 2;
                    $response['msg'] = 'Edit menu item error.';
                }
            } else {
                $response['status'] = 3;
            }
			responseJson($response);
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
        if ($id) {
            $this->model_adm_menu->get_descendants($id);
            if (!empty($this->ids)) {
                $ids = implode(', ', $this->ids);
                $id = "$id, $ids";
            }

            $res = $this->model_adm_menu->delete_menu($id);
            if ($res) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
			responseJson($response);
        }
    }

    public function save_position()
    {
        $menu = $this->input->post('menu');
        if (!empty($menu)) {
            //adodb_pr($menu);
            $menu = $this->input->post('menu');
            foreach ($menu as $k => $v) {
                if ($v == 'null') {
                    $menu2[0][] = $k;
                } else {
                    $menu2[$v][] = $k;
                }
            }
            $success = 0;
            if (!empty($menu2)) {
                foreach ($menu2 as $k => $v) {
                    $i = 1;
                    foreach ($v as $v2) {
                        $data['parent_id'] = $k;
                        $data['position'] = $i;
                        $data['modified_by'] = $this->username;
                        if ($this->db_wuling->update('menu', $data, 'id' . ' = ' . $v2)) {
                            $success++;
                        }
                        $i++;
                    }
                }
            }
        }
    }

    public function old_save_position()
    {
        if (isset($_POST['easymm'])) {
            $easymm = $_POST['easymm'];
            $this->update_position(0, $easymm);
        }
    }

    private function update_position($parent, $children)
    {
        $i = 1;
        foreach ($children as $k => $v) {
            $id = (int)$children[$k]['id'];
            $data[MENU_PARENT] = $parent;
            $data[MENU_POSITION] = $i;
            $this->db_wuling->update(MENU_TABLE, $data, MENU_ID . ' = ' . $id);
            if (isset($children[$k]['children'][0])) {
                $this->update_position($id, $children[$k]['children']);
            }
            $i++;
        }
    }

    private function get_label($row)
    {
		$disclose = '';
		if($row->is_parent){
			$disclose = '<span class="disclose ms-3 fas fa-angle-down fs-7"><span></span></span>';
		}
        $label = '<div class="ns-row bg-body">' .
            '<div class="ns-title">' .'<i class="'.$row->icon.'"></i> ' . $row->title . ' '. $disclose .'</div>' .
            '<div class="ns-url">' . $row->url . '</div>' .
            '<div class="actions">' .
            '<a href="#" class="btn btn-icon btn-active-light-primary w-10px h-10px m-2 me-5 edit-menu" title="Edit">' .
            '<i class="bi bi-pencil fs-4"></i>' .
            '</a>' .
            '<a href="#" class="btn btn-icon btn-active-light-danger w-10px h-10px m-2 delete-menu" title="Delete">' .
            '<i class="bi bi-trash fs-4"></i>' .
            '</a>' .
            '<input type="hidden" name="menu_id" value="' . $row->id . '">' .
            '</div>' .
            '</div>';
        return $label;
    }

    private function get_labels($row)
    {
		$disclose = '';
		// if($row->is_parent){
		// 	$disclose = '<span class="disclose ms-3 fas fa-angle-down fs-7"><span></span></span>';
		// }
        $label = '<div class="ns-row bg-body">' .
			'<div class="ns-title">' .'<i class="'.$row['icon'].'"></i> ' . $row['title'] . ' '. $disclose .'</div>' .
            // '<div class="ns-title">' .'<i class="'.$row['icon'].'"></i> '  . $row['title'] . '<span class="disclose ms-3 fas fa-angle-down fs-7"><span></span></span></div>' .
            '<div class="ns-url">' . $row['url'] . '</div>' .
            '<div class="actions">' .
            '<a href="#" class="btn btn-icon btn-active-light-primary w-10px h-10px m-2 me-5 edit-menu" title="Edit">' .
            '<i class="bi bi-pencil fs-4"></i>' .
            '</a>' .
            '<a href="#" class="btn btn-icon btn-active-light-danger w-10px h-10px m-2 delete-menu" title="Delete">' .
            '<i class="bi bi-trash fs-4"></i>' .
            '</a>' .
            '<input type="hidden" name="menu_id" value="' . $row['id'] . '">' .
            '</div>' .
            '</div>';
        return $label;
    }

}

/* End of file Wuling_adm_menu.php */
/* Location: ./wuling_admin/controllers/Wuling_adm_menu.php */
