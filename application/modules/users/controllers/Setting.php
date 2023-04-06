<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author hikmat20
 * @copyright Copyright (c) 2021, hikmat20
 *
 * This is controller for Users Management
 */

class Setting extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('users');
        $this->load->model(array(
            'users/users_model',
            'users/groups_model',
            'users/user_groups_model',
            'users/permissions_model',
            'users/user_permissions_model',
        ));

        $this->template->page_icon('fa fa-users');
    }

    public function index()
    {
        $data = $this->db->get_where("users", ['deleted' => 'N', 'id_user !=' => '1'])->result();
        $position = $this->db->get_where('position')->result();
        $pos = [];
        foreach ($position as $ps) {
            $pos[$ps->id] = $ps->position_name;
        }

        $status = [
            'Y' => "<span class='badge rounded-pill bg-success'>Aktif</span>",
            'N' => "<span class='badge rounded-pill bg-danger'>Tidak Aktif</span>",
        ];


        $this->template->set(
            [
                'results'   => $data,
                'status'    => $status,
                'pos'       => $pos,
            ]
        );
        $this->template->set('title', "Daftar Pengguna");
        $this->template->render('index');
    }

    public function create()
    {
        if (isset($_POST['save'])) {
            if ($this->save_user()) {
                $this->template->set_message(lang('users_create_success'), 'success');
                redirect('users/setting');
            }
        }
        $position = $this->db->get_where('position', ['id !=' => '1'])->result();

        $this->template->set([
            'title'         => lang('users_new_title'),
            'position'      => $position
        ]);

        $this->template->page_icon('fa fa-user');
        $this->template->render('users_form');
    }

    public function edit($id = 0)
    {

        if ($id == 0 || is_numeric($id) == FALSE) {
            $this->template->set_message(lang('users_invalid_id'), 'error');
            redirect('users/setting');
        }

        if (isset($_POST['save'])) {
            if ($this->save_user("update", $id)) {
                $this->template->set_message(lang('users_edit_success'), 'success');
                redirect('users/setting');
            }
        }

        $data = $this->users_model->find($id);

        if ($data) {
            if ($data->deleted == 1) {
                $this->template->set_message(lang('users_already_deleted'), 'error');
                redirect('users/setting');
            }
        }
        $position = $this->db->get_where('position', ['id !=' => '1'])->result();
        $this->template->set([
            'position'      => $position
        ]);
        $this->template->set('data', $data);
        $this->template->set('title', lang('users_edit_title'));
        $this->template->page_icon('fa fa-user');
        $this->template->render('users_form');
    }

    public function permission($id = 0)
    {
        $this->auth->restrict($this->managePermission);

        if ($id == 0 || is_numeric($id) == FALSE || $id == 1) {
            $this->template->set_message(lang('users_invalid_id'), 'error');
            redirect('users/setting');
        }

        if (isset($_POST['save'])) {
            if ($this->save_permission($id)) {
                $this->template->set_message(lang('users_permission_edit_success'), 'success');
            }
        }

        //User data
        $data = $this->users_model->find($id);

        if ($data) {
            if ($data->deleted == 1) {
                $this->template->set_message(lang('users_already_deleted'), 'error');
                redirect('users/setting');
            }
        }
        //All Permission
        $permissions = $this->permissions_model
            ->order_by("nm_permission", "ASC")
            ->find_all();

        $auth_permissions = $this->get_auth_permission($id);

        $rows   = array();
        $header = array();
        $tmp    = array();
        if ($permissions) {
            //table Header
            foreach ($permissions as $key => $pr) {
                $x = explode(".", $pr->nm_permission);
                if (!in_array($x[1], $header)) {
                    $header[] = $x[1];
                    $tmp[$x[1]] = 0;
                }
            }
            //Temporary value
            foreach ($permissions as $key2 => $pr) {
                $x = explode(".", $pr->nm_permission);
                $rows[$x[0]] = $tmp;
            }
            //Actual value
            foreach ($permissions as $key3 => $pr) {
                $x = explode(".", $pr->nm_permission);
                //Rows
                $rows[$x[0]][$x[1]] = array('nm' => $pr->nm_menu, 'perm_id' => $pr->id_permission, 'action_name' => $x[1], 'is_role_permission' => (isset($auth_permissions[$pr->id_permission]->is_role_permission) && $auth_permissions[$pr->id_permission]->is_role_permission == 1) ? 1 : '', 'value' => (isset($auth_permissions[$pr->id_permission]) ? 1 : 0));
            }
        }

        $this->template->set('data', $data);
        $this->template->set('header', $header);
        $this->template->set('permissions', $rows);
        $this->template->set('title', lang('users_edit_perm_title'));
        $this->template->page_icon('fa fa-shield');
        $this->template->render('user_permissions');
    }

    protected function save_permission($id_user = 0)
    {
        if ($id_user == 0 || $id_user == "") {
            $this->template->set_message(lang('users_invalid_id'), 'error');
            return FALSE;
        }

        $id_permissions = $this->input->post('id_permissions');

        $insert_data = array();
        if ($id_permissions) {
            foreach ($id_permissions as $key => $idp) {
                $insert_data[] = array(
                    'id_user' => $id_user,
                    'id_permission' => $idp
                );
            }
        }

        //Delete Fisrt All Previous user permission
        $result = $this->user_permissions_model->delete_where(array('id_user' => $id_user));

        //Insert New one
        if ($insert_data) {
            $result = $this->user_permissions_model->insert_batch($insert_data);
        }

        if ($result === FALSE) {
            $this->template->set_message(lang('users_permission_edit_fail'), 'error');
            return FALSE;
        }
        unset($_POST['save']);
        return $result;
    }

    protected function get_auth_permission($id = 0)
    {
        $role_permissions = $this->users_model->select("permissions.*")
            ->join("user_groups", "users.id_user = user_groups.id_user")
            ->join("group_permissions", "user_groups.id_group = group_permissions.id_group")
            ->join("permissions", "group_permissions.id_permission = permissions.id_permission")
            ->where("users.id_user", $id)
            ->find_all();

        $user_permissions = $this->users_model->select("permissions.*")
            ->join("user_permissions", "users.id_user = user_permissions.id_user")
            ->join("permissions", "user_permissions.id_permission = permissions.id_permission")
            ->where("users.id_user", $id)
            ->find_all();

        $merge = array();
        if ($role_permissions) {
            foreach ($role_permissions as $key => $rp) {
                if (!isset($merge[$rp->id_permission])) {
                    $rp->is_role_permission = 1;
                    $merge[$rp->id_permission] = $rp;
                }
            }
        }

        if ($user_permissions) {
            foreach ($user_permissions as $key => $up) {
                if (!isset($merge[$up->id_permission])) {
                    $up->is_role_permission = 0;
                    $merge[$up->id_permission] = $up;
                }
            }
        }
        return $merge;
    }

    public function save()
    {

        if ($this->input->post('id_user')) {
            $this->save_user("update", $this->input->post('id_user'));
        } else {
            $this->save_user("insert", '');
        }
    }

    protected function save_user($type = '', $id = '')
    {
        if ($type == "insert") {
            $rule_email = "|unique[users.email]";
        } else {
            $rule_email = "|unique[users.email, users.id_user]";
        }

        $this->form_validation->set_rules('email', 'lang:users_email', 'required|valid_email' . $rule_email, [
            'unique' => 'Email sudah terdaftar, Mohon gunakan email yang lain! '
        ]);

        $this->form_validation->set_rules(
            'full_name',
            'lang:users_full_name',
            'required',
            [
                'required' => 'Nama langkap harus di isi!'
            ]
        );

        $this->form_validation->set_rules(
            'phone',
            'lang:users_hp',
            'required',
            [
                'required' => 'Telepon harus di isi!'
            ]
        );

        if ($this->form_validation->run($this) === FALSE) {
            $return = [
                'status' => 0,
                'msg'   => validation_errors()
            ];

            echo json_encode($return);
            return FALSE;
        }

        $full_name                          = $this->input->post('full_name');
        $email                              = $this->input->post('email');
        $phone                              = $this->input->post('phone');
        $active                             = $this->input->post('active');
        $group_id                           = $this->input->post('group_id');
        $company_id                         = $this->input->post('company_id');
        $branch_id                          = $this->input->post('branch_id');
        $old_photo                          = $this->input->post('old_photo');
        $photo = '';

        if ($_FILES['photo']['name']) {
            $config['upload_path']          = './assets/images/avatar/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 500;
            $config['max_width']            = 1000;
            $config['max_height']           = 1000;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('photo')) {
                $error = $this->upload->display_errors();
                $return = [
                    'status' => 0,
                    'msg'   => $this->upload->display_errors()
                ];
                echo json_encode($return);
                return FALSE;
            } else {
                $dataPhoto = $this->upload->data();
                $photo = $dataPhoto['file_name'];
                if ($old_photo) {
                    unlink('./assets/images/avatar/' . $old_photo);
                }
            }
        }

        $newPhoto = ($photo) ? $photo : $old_photo;

        $this->db->trans_begin();

        if ($type == 'insert') {
            $data_insert = array(
                'email'           => $email,
                'full_name'       => $full_name,
                'phone'           => $phone,
                'ip'              => $this->input->ip_address(),
                'active'          => $active,
                'group_id'        => $group_id,
                'photo'           => $newPhoto,
                'company_id'   => $company_id,
                'branch_id'    => $branch_id,
            );

            $result = $this->users_model->insert($data_insert);

            $dt_group = $this->groups_model->find_by(array('st_default' => 1));
            if ($dt_group) {
                $id_group = $dt_group->id_group;

                $insert_group = array(
                    'id_user' => $result,
                    'id_group' => $id_group
                );

                $this->user_groups_model->insert($insert_group);
            }
        } else {
            $data_insert = array(
                // 'username'        => $username,
                'email'           => $email,
                'full_name'       => $full_name,
                'phone'           => $phone,
                'ip'              => $this->input->ip_address(),
                'active'          => $active,
                'group_id'        => $group_id,
                'photo'           => $newPhoto,
                'company_id'      => $company_id,
                'branch_id'       => $branch_id,
            );


            $this->users_model->update($id, $data_insert);
        }

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $return = [
                'status' => 1,
                'msg'   => 'Data user berhasil disimpan.'
            ];
        } else {
            $this->db->trans_rollback();
            $return = [
                'status' => 0,
                'msg'   => 'Data user gagal disimpan.'
            ];
        }

        echo json_encode($return);
    }

    public function save_account()
    {
        $password = $this->input->post('password');

        // $_POST['id_user'] = $id;
        if ($this->input->post('username')) {
            $extra_rule = "|unique[users.username, users.id_user]";
            $this->form_validation->set_rules('username', 'lang:users_username', 'required' . $extra_rule, [
                'required' => 'Username masih kosong, mohon isi terlebih username dahulu',
                'unique'   => 'Username ini telah digunakan, mohon gunakan username yang lain'
            ]);
        }
        $this->form_validation->set_rules('password', 'lang:users_password', 'required', [
            'required' => 'Kata Sandi masih kosong, mohon isi terlebih Kata Sandi dahulu'
        ]);
        $this->form_validation->set_rules(
            're-password',
            'lang:users_repassword',
            'required|matches[password]',
            [
                'required'          => 'Konfirmasi Kata Sandi masih kosong, mohon isi terlebih Konfirmasi Kata Sandi dahulu',
                'matches' => 'Konfirmasi Kata Sandi tidak sama, mohon periksa kembali Konfirmasi Kata Sandi',
            ]
        );

        if ($this->form_validation->run($this) === FALSE) {
            $return = [
                'status' => 0,
                'msg'   => validation_errors()
            ];

            echo json_encode($return);
            return FALSE;
        } else {
            $username = $this->input->post('username');
            $password = password_hash($password, PASSWORD_BCRYPT);
            $data = [
                'username' => $username,
                'password' => $password
            ];
            $this->db->trans_begin();
            $this->db->update('users', $data, ['id_user' => $this->input->post('id_user')]);
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg' => 'Password berhasil disimpan.'
                ];
            } else {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg' => 'Password gagal disimpan.'
                ];
            }
        }
        echo json_encode($return);
    }

    public function default_select($val)
    {
        return $val == "" ? FALSE : TRUE;
    }
}
