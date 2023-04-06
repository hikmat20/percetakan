<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author CokesHome
 * @copyright Copyright (c) 2015, CokesHome
 * 
 * This is controller for Authentication
 */

class Users extends Front_Controller
{

    /**
     * Load the models, library, etc
     *
     * 
     */

    public function __construct()
    {
        parent::__construct();
        // $this->load->model(array('identitas_model'));
        $this->load->library('users/auth');
    }

    public function index()
    {
        redirect('users/setting');
    }

    public function login()
    {
        if ($this->auth->is_login()) {
            redirect('/');
        }

        //$identitas = $this->identitas_model->find(1); => ERROR variable nama_program not define krn ga ada fieldnya di tabel identitas
        // $identitas = $this->identitas_model->find_by(array('ididentitas' => 1)); // By Muhaemin => Di Form Login

        if (isset($_POST['login'])) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->auth->login($username, $password);
        }

        // $this->template->set('idt', $identitas);
        // $this->template->set_theme('default');
        $this->template->set_layout('login');
        $this->template->title('Login');
        // $this->template->render('login_animate');
        $this->load->view('login');
    }

    public function logout()
    {
        $this->auth->logout();
    }

    public function profile()
    {
        $user = $this->db->get_where('users', ['id_user' => $this->auth->user_id()])->row();

        $this->template->set_theme('admin');
        $this->template->set('userData', $user);
        $this->template->page_icon('fa fa-user');
        $this->template->title('Pofile User');
        $this->template->render('profile');
    }

    public function upload()
    {

        $old_picture     = $this->input->post('old_picture');
        $id             = $this->input->post('id');

        $config['upload_path']          = './assets/img/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 500;
        $config['max_width']            = 1000;
        $config['max_height']           = 1000;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('picture')) {
            $error = $this->upload->display_errors();

            $collback = [
                'msg' => $error,
                'status' => 0
            ];
            echo json_encode($collback);
            return FALSE;
        } else {
            if ($old_picture) {
                unlink('./assets/img/' . $old_picture);
            }
            $dataPicture = $this->upload->data();
            $picture = $dataPicture['file_name'];
        }

        $Arr_data = [
            'pictures' => $picture,
        ];
        $this->db->trans_begin();
        $this->db->update('pictures', $Arr_data, ['id' => $id]);

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $collback = [
                'msg' => 'Upload Faild, Please ty again!',
                'status' => 0
            ];
        } else {
            $this->db->trans_commit();
        }
        $collback = [
            'msg' => 'Upload Success!',
            'status' => 1,
            'picture' => $picture
        ];

        echo json_encode($collback);
    }

    function get_perusahaan()
    {
        $users    = $this->db->query("SELECT * FROM perusahaan")->result();
        echo "<select id='nm_perusahaan' name='nm_perusahaan' class='select2'  onchange='get_cabang()'>
				<option value=''>Pilih Perusahaan</option>";
        foreach ($users as $pic) {
            echo "<option value='$pic->id_perusahaan'>$pic->nm_perusahaan</option>";
        }
        echo "</select>";
    }

    function get_cabang()
    {
        $prsh = $this->input->post('perusahaan');


        $users    = $this->db->query("SELECT * FROM perusahaan_cbg WHERE id_perusahaan='$prsh' ")->result();

        echo "<select id='nm_cabang' name='nm_cabang' class='select2'>
				<option value=''>Pilih Cabang</option>";
        foreach ($users as $pic) {
            echo "<option value='$pic->id_cabang'>$pic->nm_cabang</option>";
        }
        echo "</select>";
    }
}
