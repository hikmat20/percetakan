<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2021, Syamsudin
 *
 * This is controller for Folders
 */

class Folders extends Admin_Controller
{

	//Permission
	protected $viewPermission   = "Folders.View";
	protected $addPermission    = "Folders.Add";
	protected $managePermission = "Folders.Manage";
	protected $deletePermission = "Folders.Delete";
	protected $approvalPermission = "Folders.Approval";

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('download');
		$this->load->library(array('upload', 'Image_lib'));
		$this->load->model(array(
			'Folders/Folders_model',
			'Aktifitas/aktifitas_model'
		));

		$this->template->set('title', 'Manage Data Folder');
		$this->template->page_icon('fa fa-folder');

		date_default_timezone_set("Asia/Bangkok");
	}

	public function index()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$this->template->page_icon('fa fa-folder-open');
		$get_Data		= $this->Folders_model->getData('master_gambar');
		$this->template->set('row', $get_Data);
		// $this->template->title('Index Of Folders');
		$this->template->render('index');
	}

	public function add()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		if ($this->input->post()) {

			$Arr_Kembali			= array();
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username'];
			$data['created']		= date('Y-m-d H:i:s');
			$data['nama_master']	= $this->input->post('nama_master');
			$data['id_perusahaan']  = $prsh;
			$data['id_cabang']		= $cbg;

			if ($this->Folders_model->simpan('master_gambar', $data)) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add gambar Success. Thank you & have a nice day.......'
				);

				$keterangan = 'Berhasil Simpan Folder';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('nama_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {



			$this->template->page_icon('fa fa-folder-open');
			$this->template->title('Create Folder ');
			$this->template->render('add');
		}
	}


	function delete_master($id)
	{
		$this->db->delete("master_gambar", array('id_master' => $id));
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			$keterangan = 'Berhasil Hapus Folder';
			$status = 1;
			$nm_hak_akses = $this->addPermission;
			$kode_universal = $id;
			$jumlah = 1;
			$sql = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			redirect(site_url('folders'));
		}
	}

	public function detail()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_master 			= $this->input->get('id_master');
		$get_Data		= $this->Folders_model->getData('gambar', 'id_master', $id_master);
		$get_Detail		= $this->Folders_model->getData('master_gambar', 'id_master', $id_master);
		foreach ($get_Detail as $folder);


		$this->template->page_icon('fa fa-folder-open');
		$this->template->set('mtr', $id_master);
		$this->template->set('row', $get_Data);
		$this->template->title($folder->nama_master . '/');
		$this->template->render('detail');
	}


	public function add_detail()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip|vsd'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			// echo"<pre>";
			// print_r($this->input->post());
			// exit;	        


			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id_approval']	= $this->input->post('id_approval');
			$data['id_perusahaan']  = $prsh;
			$data['id_cabang']		= $cbg;

			if ($this->input->post('id_review') != '') {
				$data['status_approve']	= 3;
				$data['id_review']	= $this->input->post('id_review');
			} else {
				$data['status_approve']	= 1;
			}



			if ($this->Folders_model->simpan('gambar', $data)) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add gambar Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Simpan Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$id_master 	= $this->input->get('id_master');
			$this->template->page_icon('fa fa-folder');
			$users	= $this->db->query("SELECT * FROM users WHERE nm_lengkap != 'Administrator' AND id_perusahaan='$prsh' AND id_cabang='$cbg' ORDER BY nm_lengkap ASC")->result_array();

			$option = '';
			foreach ($users as $key => $value) {
				$option .= "<option value='" . $value['id_user'] . "'>" . $value['nm_lengkap'] . "</option>";
			}

			$data = [
				'users' => $option
			];
			$this->template->set('results', $data);
			$this->template->set('idmaster', $id_master);
			$this->template->set('action', 'add');
			$this->template->title('Add Documents');
			$this->template->render('add_detail');
		}
	}


	public function edit($id = '')
	{

		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			// echo"<pre>";print_r($id_master);exit;

			$Arr_Kembali			= array();

			if ($ukuran > 0) {
				$data					= $this->input->post();
				$data['nama_file']	    = $gambar;
				$data['ukuran_file']	= $ukuran;
				$data['tipe_file']		= $ext;
				$data['lokasi_file']	= $lokasi;
				$data_session			= $this->session->userdata;
				$data['created_by']		= $this->auth->user_id();
				$data['created']		= date('Y-m-d H:i:s');
				$data['id_master']		= $id_master;
			} else {
				$data					= $this->input->post();
				$data_session			= $this->session->userdata;
				$data['created_by']		= $this->auth->user_id();
				$data['created']		= date('Y-m-d H:i:s');
				$data['id_master']		= $id_master;
			}



			$update = $this->Folders_model->getUpdate('gambar', $data, 'id', $this->input->post('id'));


			if ($update) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Update Document Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Update Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {


			$detail				= $this->Folders_model->getData('gambar', 'id', $id);



			$this->template->page_icon('fa fa-folder-open');
			$this->template->set('id', $id);
			$this->template->set('row', $detail);
			$this->template->set('action', 'edit');
			$this->template->title('Edit Documents');
			$this->template->render('edit_detail');
		}
	}

	public function download($id)
	{
		//echo"<pre>";print_r($id);exit;
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_master = $this->db->query("SELECT id_master FROM gambar WHERE id='$id'")->row();
		$idmaster = $id_master->id_master;
		$pth    =   file_get_contents(base_url() . "./assets/files/" . $id);
		$nme    =   $id;
		force_download($nme, $pth);

		redirect(site_url('folders/detail?id_master=$id_master'));
	}




	function delete_detail($id)
	{

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_master = $this->db->query("SELECT id_master FROM gambar WHERE id='$id'")->row();
		$idmaster  = $id_master->id_master;
		// print_r($idmaster);
		// exit;
		$this->db->where('id', $id);
		$query = $this->db->get('gambar');
		$path = $query->row();
		unlink("./assets/files/$path->nama_file");
		$this->db->delete("gambar", array('id' => $id));
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			$keterangan = 'Berhasil Hapus Dokumen';
			$status = 1;
			$nm_hak_akses = $this->addPermission;
			$kode_universal = $id;
			$jumlah = 1;
			$sql = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			redirect(site_url('Folders/detail?id_master=' . $idmaster));
		}
	}


	public function add_subdetail1()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			$id_detail 	= $this->input->post('id_detail');
			// echo"<pre>";print_r($id_master);exit;	        


			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id_detail']		= $id_detail;
			$data['id_perusahaan']  = $prsh;
			$data['id_cabang']		= $cbg;
			$data['id_approval']	= $this->input->post('id_approval');
			$data['status_approve']	= 1;

			if ($this->Folders_model->simpan('gambar1', $data)) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add gambar Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Simpan Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$id_master 	= $this->uri->segment('4');
			$id_detail 	= $this->uri->segment('3');
			$this->template->page_icon('fa fa-folder-open');

			$users	= $this->db->query("SELECT * FROM users WHERE nm_lengkap != 'Administrator' AND id_perusahaan='$prsh' AND id_cabang='$cbg' ORDER BY nm_lengkap ASC")->result_array();

			$option = '';
			foreach ($users as $key => $value) {
				$option .= "<option value='" . $value['id_user'] . "'>" . $value['nm_lengkap'] . "</option>";
			}

			$data = [
				'users' => $option
			];
			$this->template->set('results', $data);

			$this->template->set('idmaster', $id_master);
			$this->template->set('iddetail', $id_detail);
			$this->template->set('action', 'add');
			$this->template->title('Add Sub Dokumen');
			$this->template->render('add_subdetail1');
		}
	}

	//SUB DOKUMEN 1

	public function detail1()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_detail			= $this->input->get('id_detail');
		$get_Data		= $this->Folders_model->getData('gambar1', 'id_detail', $id_detail);
		$get_Detail		= $this->Folders_model->getData('gambar', 'id', $id_detail);

		foreach ($get_Detail as $detail);
		$id_master      = $detail->id_master;
		$get_Master		= $this->Folders_model->getData('master_gambar', 'id_master', $id_master);
		foreach ($get_Master as $folder);

		$this->template->page_icon('fa fa-folder-open');
		$this->template->set('mtr', $id_master);
		$this->template->set('dtl', $id_detail);
		$this->template->set('row', $get_Data);
		$this->template->title($folder->nama_master . '/' . $detail->deskripsi . '/');
		$this->template->render('detail1');
	}

	public function add_detail1()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			$id_detail 	= $this->input->post('id_detail');
			// echo"<pre>";print_r($this->input->post());exit;	        


			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id_detail']		= $id_detail;
			$data['id_perusahaan']  = $prsh;
			$data['id_cabang']		= $cbg;
			$data['id_approval']	= $this->input->post('id_approval');

			if ($this->input->post('id_review') != '') {
				$data['status_approve']	= 3;
				$data['id_review']	= $this->input->post('id_review');
			} else {
				$data['status_approve']	= 1;
			}


			if ($this->Folders_model->simpan('gambar', $data)) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add gambar Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Simpan Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$id_detail 	= $this->input->get('id_detail');
			$id_master  = $this->db->query("SELECT id_master FROM gambar WHERE id='$id_detail'")->row();
			$this->template->page_icon('fa fa-folder-open');

			$users	= $this->db->query("SELECT * FROM users WHERE nm_lengkap != 'Administrator' AND id_perusahaan='$prsh' AND id_cabang='$cbg' ORDER BY nm_lengkap ASC")->result_array();

			$option = '';
			foreach ($users as $key => $value) {
				$option .= "<option value='" . $value['id_user'] . "'>" . $value['nm_lengkap'] . "</option>";
			}

			$data = [
				'users' => $option
			];
			$this->template->set('results', $data);

			$this->template->set('iddetail', $id_detail);
			$this->template->set('idmaster', $id_master->id_master);
			$this->template->set('action', 'add');
			$this->template->title('Add Sub Documents I');
			$this->template->render('add_subdetail1');
		}
	}

	public function edit_detail1($id = '')
	{

		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			$id_detail 	= $this->input->post('id_detail');
			// echo"<pre>";print_r($id_master);exit;

			$Arr_Kembali			= array();

			if ($ukuran > 0) {
				$data					= $this->input->post();
				$data['nama_file']	    = $gambar;
				$data['ukuran_file']	= $ukuran;
				$data['tipe_file']		= $ext;
				$data['lokasi_file']	= $lokasi;
				$data_session			= $this->session->userdata;
				$data['created_by']		= $this->auth->user_id();
				$data['created']		= date('Y-m-d H:i:s');
				$data['id_master']		= $id_master;
				$data['id_detail']		= $id_detail;
			} else {
				$data					= $this->input->post();
				$data_session			= $this->session->userdata;
				$data['created_by']		= $this->auth->user_id();
				$data['created']		= date('Y-m-d H:i:s');
				$data['id_master']		= $id_master;
				$data['id_detail']		= $id_detail;
			}



			$update = $this->Folders_model->getUpdate('gambar1', $data, 'id', $this->input->post('id'));


			if ($update) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Update Document Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Update Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {


			$detail				= $this->Folders_model->getData('gambar1', 'id', $id);



			$this->template->page_icon('fa fa-folder-open');
			$this->template->set('id', $id);
			$this->template->set('row', $detail);
			$this->template->set('action', 'edit');
			$this->template->title('Edit Sub Documents I');
			$this->template->render('edit_detail1');
		}
	}

	public function download_detail1($id)
	{
		//echo"<pre>";print_r($id);exit;
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_master = $this->db->query("SELECT * FROM gambar1 WHERE id='$id'")->row();
		$iddetail = $id_master->id_detail;
		$nme    =   $id_master->nama_file;
		$pth    =   file_get_contents(base_url() . "./assets/files/" . $nme);

		force_download($nme, $pth);

		redirect(site_url('folders/detail1?id_detail=' . $iddetail));
	}



	function delete_detail1($id)
	{
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_master = $this->db->query("SELECT id_detail FROM gambar1 WHERE id='$id'")->row();
		$iddetail  = $id_master->id_detail;
		// print_r($idmaster);
		// exit;
		$this->db->where('id', $id);
		$query = $this->db->get('gambar1');
		$path = $query->row();
		unlink("./assets/files/$path->nama_file");
		$this->db->delete("gambar1", array('id' => $id));
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			$keterangan = 'Berhasil Hapus Dokumen';
			$status = 1;
			$nm_hak_akses = $this->addPermission;
			$kode_universal = $id;
			$jumlah = 1;
			$sql = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			redirect(site_url('folders/detail1?id_detail=' . $iddetail));
		}
	}


	public function add_subdetail2()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			$id_detail 	= $this->input->post('id_detail');
			// echo"<pre>";print_r($id_master);exit;	        


			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id_detail']		= $id_detail;
			$data['id_perusahaan']  = $prsh;
			$data['id_cabang']		= $cbg;
			$data['id_approval']	= $this->input->post('id_approval');
			$data['status_approve']	= 1;

			if ($this->Folders_model->simpan('gambar1', $data)) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add gambar Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Simpan Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$id_master 	= $this->uri->segment('4');
			$id_detail 	= $this->uri->segment('3');
			$this->template->page_icon('fa fa-folder-open');

			$users	= $this->db->query("SELECT * FROM users WHERE nm_lengkap != 'Administrator' AND id_perusahaan='$prsh' AND id_cabang='$cbg' ORDER BY nm_lengkap ASC")->result_array();

			$option = '';
			foreach ($users as $key => $value) {
				$option .= "<option value='" . $value['id_user'] . "'>" . $value['nm_lengkap'] . "</option>";
			}

			$data = [
				'users' => $option
			];
			$this->template->set('results', $data);

			$this->template->set('idmaster', $id_master);
			$this->template->set('iddetail', $id_detail);
			$this->template->set('action', 'add');
			$this->template->title('Add Sub Dokumen');
			$this->template->render('add_subdetail1');
		}
	}

	//END SUB DOKUMEN 1



	//SUB DOKUMEN 2

	public function detail2()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_detail1			= $this->input->get('id_detail1');
		$get_Data		= $this->Folders_model->getData('gambar2', 'id_detail1', $id_detail1);
		$get_Detail		= $this->Folders_model->getData('gambar1', 'id', $id_detail1);

		foreach ($get_Detail as $detail);
		$id_master      = $detail->id_master;
		$id_detail      = $detail->id_detail;

		$get_Master		= $this->Folders_model->getData('master_gambar', 'id_master', $id_master);
		foreach ($get_Master as $folder);

		$get_1		= $this->Folders_model->getData('gambar', 'id', $id_detail);
		foreach ($get_1 as $dt);

		$this->template->page_icon('fa fa-folder-open');
		$this->template->set('mtr', $id_master);
		$this->template->set('dtl1', $id_detail1);
		$this->template->set('dtl', $id_detail);
		$this->template->set('row', $get_Data);
		$this->template->title($folder->nama_master . '/' . $dt->deskripsi . '/' . $detail->deskripsi . '/');
		$this->template->render('detail2');
	}

	public function add_detail2()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			$id_detail 	= $this->input->post('id_detail');
			$id_detail1 	= $this->input->post('id_detail1');
			// echo"<pre>";print_r($this->input->post());exit;	        


			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id_detail']		= $id_detail;
			$data['id_detail1']		= $id_detail1;
			$data['id_perusahaan']  = $prsh;
			$data['id_cabang']		= $cbg;
			$data['id_approval']	= $this->input->post('id_approval');

			if ($this->input->post('id_review') != '') {
				$data['status_approve']	= 3;
				$data['id_review']	= $this->input->post('id_review');
			} else {
				$data['status_approve']	= 1;
			}


			if ($this->Folders_model->simpan('gambar2', $data)) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add gambar Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Simpan Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$id_detail1 	= $this->input->get('id_detail1');
			$id_detail      = $this->db->query("SELECT id_detail FROM gambar1 WHERE id='$id_detail1'")->row();
			$id_master      = $this->db->query("SELECT id_master FROM gambar1 WHERE id='$id_detail1'")->row();
			$this->template->page_icon('fa fa-folder-open');
			$users	= $this->db->query("SELECT * FROM users WHERE nm_lengkap != 'Administrator' AND id_perusahaan='$prsh' AND id_cabang='$cbg' ORDER BY nm_lengkap ASC")->result_array();

			$option = '';
			foreach ($users as $key => $value) {
				$option .= "<option value='" . $value['id_user'] . "'>" . $value['nm_lengkap'] . "</option>";
			}

			$data = [
				'users' => $option
			];
			$this->template->set('results', $data);
			$this->template->set('iddetail1', $id_detail1);
			$this->template->set('iddetail', $id_detail->id_detail);
			$this->template->set('idmaster', $id_master->id_master);
			$this->template->set('action', 'add');
			$this->template->title('Add Sub Documents II');
			$this->template->render('add_subdetail2');
		}
	}

	public function edit_detail2($id = '')
	{

		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			$id_detail 	= $this->input->post('id_detail');
			$id_detail1 	= $this->input->post('id_detail1');
			// echo"<pre>";print_r($id_master);exit;

			$Arr_Kembali			= array();

			if ($ukuran > 0) {
				$data					= $this->input->post();
				$data['nama_file']	    = $gambar;
				$data['ukuran_file']	= $ukuran;
				$data['tipe_file']		= $ext;
				$data['lokasi_file']	= $lokasi;
				$data_session			= $this->session->userdata;
				$data['created_by']		= $this->auth->user_id();
				$data['created']		= date('Y-m-d H:i:s');
				$data['id_master']		= $id_master;
				$data['id_detail']		= $id_detail;
				$data['id_detail1']		= $id_detail1;
			} else {
				$data					= $this->input->post();
				$data_session			= $this->session->userdata;
				$data['created_by']		= $this->auth->user_id();
				$data['created']		= date('Y-m-d H:i:s');
				$data['id_master']		= $id_master;
				$data['id_detail']		= $id_detail;
				$data['id_detail1']		= $id_detail1;
			}



			$update = $this->Folders_model->getUpdate('gambar2', $data, 'id', $this->input->post('id'));


			if ($update) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Update Document Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Update Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {


			$detail				= $this->Folders_model->getData('gambar2', 'id', $id);



			$this->template->page_icon('fa fa-folder-open');
			$this->template->set('id', $id);
			$this->template->set('row', $detail);
			$this->template->set('action', 'edit');
			$this->template->title('Edit Sub Documents II');
			$this->template->render('edit_detail2');
		}
	}

	public function download_detail2($id)
	{
		//echo"<pre>";print_r($id);exit;
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_master = $this->db->query("SELECT * FROM gambar1 WHERE id='$id'")->row();
		$iddetail = $id_master->id_detail;
		$nme    =   $id_master->nama_file;
		$pth    =   file_get_contents(base_url() . "./assets/files/" . $nme);

		force_download($nme, $pth);

		redirect(site_url('folders/detail1?id_detail=' . $iddetail));
	}



	function delete_detail2($id)
	{

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$id_master = $this->db->query("SELECT * FROM gambar2 WHERE id='$id'")->row();
		$iddetail   = $id_master->id_detail;
		$iddetail1  = $id_master->id_detail1;
		// print_r($idmaster);
		// exit;
		$this->db->where('id', $id);
		$query = $this->db->get('gambar2');
		$path = $query->row();
		unlink("./assets/files/$path->nama_file");
		$this->db->delete("gambar2", array('id' => $id));
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			$keterangan = 'Berhasil Hapus Dokumen';
			$status = 1;
			$nm_hak_akses = $this->addPermission;
			$kode_universal = $id;
			$jumlah = 1;
			$sql = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			redirect(site_url('folders/detail2?id_detail1=' . $iddetail1));
		}
	}


	public function add_subdetail3()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}
		if ($this->input->post()) {
			$id_master 	= $this->input->post('id_master');
			$id_detail 	= $this->input->post('id_detail');
			// echo"<pre>";print_r($this->input->post());exit;	        


			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id_detail']		= $id_detail;
			$data['id_perusahaan']  = $prsh;
			$data['id_cabang']		= $cbg;
			$data['id_approval']	= $this->input->post('id_approval');

			if ($this->input->post('id_approval') != '') {
				$data['status_approve']	= 3;
				$data['id_review']	= $this->input->post('id_review');
			}


			if ($this->Folders_model->simpan('gambar1', $data)) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add gambar Success. Thank you & have a nice day.......'
				);
				$keterangan = 'Berhasil Simpan Dokumen';
				$status = 1;
				$nm_hak_akses = $this->addPermission;
				$kode_universal = $this->input->post('id_master');
				$jumlah = 1;
				$sql = $this->db->last_query();
				simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add gambar failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$id_master 	= $this->uri->segment('4');
			$id_detail 	= $this->uri->segment('3');
			$this->template->page_icon('fa fa-folder-open');
			$users	= $this->db->query("SELECT * FROM users WHERE nm_lengkap != 'Administrator' AND id_perusahaan='$prsh' AND id_cabang='$cbg' ORDER BY nm_lengkap ASC")->result_array();

			$option = '';
			foreach ($users as $key => $value) {
				$option .= "<option value='" . $value['id_user'] . "'>" . $value['nm_lengkap'] . "</option>";
			}

			$data = [
				'users' => $option
			];
			$this->template->set('results', $data);
			$this->template->set('idmaster', $id_master);
			$this->template->set('iddetail', $id_detail);
			$this->template->set('action', 'add');
			$this->template->title('Add Sub Dokumen');
			$this->template->render('add_subdetail1');
		}
	}

	//END SUB DOKUMEN 2

	function get_approval()
	{
		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$users	= $this->db->query("SELECT * FROM tbl_jabatan WHERE id_perusahaan='$prsh' AND id_cabang='$cbg'")->result();
		echo "<span class='input-group-addon'><i class='fa fa-check'></i></span>   
		<select id='id_approval' name='id_approval' class='form-control input-sm select2'>
				<option value=''>Pilih Approval</option>";
		foreach ($users as $pic) {
			echo "<option value='$pic->id'>$pic->nm_jabatan</option>";
		}
		echo "</select>";
	}


	function get_review()
	{

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];

		$users	= $this->db->query("SELECT * FROM tbl_jabatan WHERE id_perusahaan='$prsh' AND id_cabang='$cbg'")->result();
		echo "<span class='input-group-addon'><i class='fa fa-check'></i></span>   
		<select id='id_review' name='id_review' class='form-control input-sm select2'>
				<option value=''>Pilih Review</option>";
		foreach ($users as $pic) {
			echo "<option value='$pic->id'>$pic->nm_jabatan</option>";
		}
		echo "</select>";
	}



	public function revisi()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$jabatan = $session['id_jabatan'];

		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$id    = $this->input->post('id');
		$table    = $this->input->post('table');
		$nama_file = $this->input->post('file');
		// print_r($nama_file);
		// exit;

		//$data = $this->db->query("SELECT * FROM $table WHERE id='$id'")->result();

		if ($table == 'gambar') {
			$detail				= $this->Folders_model->getData('gambar', 'id', $id);
		} else if ($table == 'gambar1') {
			$detail				= $this->Folders_model->getData('gambar1', 'id', $id);
		} else if ($table == 'gambar2') {
			$detail				= $this->Folders_model->getData('gambar2', 'id', $id);
		}

		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$uri6 = $this->uri->segment(4);

		$this->template->set('uri3', $uri3);
		$this->template->set('uri4', $uri4);
		$this->template->set('uri5', $uri5);
		$this->template->set('uri6', $uri6);


		$this->template->set('jabatan', $jabatan);
		$this->template->set('id', $id);
		$this->template->set('table', $table);
		$this->template->set('nama_file', $nama_file);
		$this->template->set('row', $detail);
		$this->template->render('revisi');
	}


	public function simpan_koreksi()
	{

		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}

		$id_master 	= $this->input->post('id_master');
		$id_detail 	= $this->input->post('id');
		$table      = $this->input->post('table');
		// echo"<pre>";print_r($this->input->post());exit;
		$insert = $this->db->query("SELECT * FROM $table WHERE id='$id_detail' ")->row();

		if ($insert->id_review != '0') {
			$approve = '3';
		} else {
			$approve = '1';
		}




		$Arr_Kembali			= array();

		if ($ukuran > 0) {
			//$data					= $this->input->post();

			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data['status_approve']	= $approve;
			$data['status_revisi']	= '1';
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');



			$norev  = $insert->revisi + 1;
			$norev1  = $insert->revisi;
			$data_insert = array(

				'deskripsi'	        => $insert->deskripsi,
				'keterangan_rev'	=> $this->input->post('keterangan'),
				'nama_file'        	=> $insert->nama_file,
				'ukuran_file'       => $insert->ukuran_file,
				'tipe_file'         => $insert->tipe_file,
				'lokasi_file'	    => $insert->lokasi_file,
				'created_by'		=> $insert->created_by,
				'created'	    	=> $insert->created,
				'id_master'	    	=> $insert->id_master,
				'id_approval'	    => $insert->id_approval,
				'status_approve'	=> $insert->status_approve,
				'revisi'	        => $norev,
				'revisi_dokumen'	=> $norev1,
				'id_dokumen'	    => $insert->id,
				'nm_table'	        => $table

			);

			$update = $this->Folders_model->getUpdate('gambar', $data, 'id', $this->input->post('id'));
			if ($update) {
				$this->db->insert("tbl_replace", $data_insert);
			}
		} else {
			//$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['status_approve']	= '3';
			$data['status_revisi']	= '1';
			$data['id']		        = $id_detail;
			$update = $this->Folders_model->getUpdate('gambar', $data, 'id', $this->input->post('id'));
		}

		if ($update) {
			$Arr_Kembali		= array(
				'status'		=> 1,
				'pesan'			=> 'Update Document Success. Thank you & have a nice day.......'
			);
			$keterangan = 'Berhasil Update Dokumen';
			$status = 1;
			$nm_hak_akses = $this->addPermission;
			$kode_universal = $this->input->post('id_master');
			$jumlah = 1;
			$sql = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
		} else {
			$Arr_Kembali		= array(
				'status'		=> 2,
				'pesan'			=> 'Add gambar failed. Please try again later......'
			);
		}
		echo json_encode($Arr_Kembali);
	}

	public function simpan_koreksi1()
	{

		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}

		$id_master 	= $this->input->post('id_master');
		$id_detail 	= $this->input->post('id');
		$table      = $this->input->post('table');
		// echo"<pre>";print_r($this->input->post());exit;
		$insert = $this->db->query("SELECT * FROM $table  WHERE id='$id_detail'")->row();

		if ($insert->id_review != '0') {
			$approve = '3';
		} else {
			$approve = '1';
		}

		$Arr_Kembali			= array();

		if ($ukuran > 0) {
			//$data					= $this->input->post();

			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data['status_approve']	= $approve;
			$data['status_revisi']	= '1';
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');



			$norev  = $insert->revisi + 1;
			$norev1 = $insert->revisi;

			$data_insert = array(

				'deskripsi'	        => $insert->deskripsi,
				'keterangan_rev'	=> $this->input->post('keterangan'),
				'nama_file'        	=> $insert->nama_file,
				'ukuran_file'       => $insert->ukuran_file,
				'tipe_file'         => $insert->tipe_file,
				'lokasi_file'	    => $insert->lokasi_file,
				'created_by'		=> $insert->created_by,
				'created'	    	=> $insert->created,
				'id_master'	    	=> $insert->id_master,
				'id_detail'	    	=> $insert->id_detail,
				'id_approval'	    => $insert->id_approval,
				'status_approve'	=> $insert->status_approve,
				'revisi'	        => $norev,
				'revisi_dokumen'	=> $norev1,
				'id_dokumen'	    => $insert->id,
				'nm_table'	        => $table

			);

			$update = $this->Folders_model->getUpdate('gambar1', $data, 'id', $this->input->post('id'));
			if ($update) {
				$this->db->insert("tbl_replace", $data_insert);
			}
		} else {
			//$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			if ($insert->id_review != '0') {
				$data['status_approve']	= 3;
			} else {
				$data['status_approve']	= 1;
			}
			$data['status_revisi']	= '1';
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_detail']		= $id_detail;
			$update = $this->Folders_model->getUpdate('gambar1', $data, 'id', $this->input->post('id'));
		}

		if ($update) {
			$Arr_Kembali		= array(
				'status'		=> 1,
				'pesan'			=> 'Update Document Success. Thank you & have a nice day.......'
			);
			$keterangan = 'Berhasil Update Dokumen';
			$status = 1;
			$nm_hak_akses = $this->addPermission;
			$kode_universal = $this->input->post('id_master');
			$jumlah = 1;
			$sql = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
		} else {
			$Arr_Kembali		= array(
				'status'		=> 2,
				'pesan'			=> 'Add gambar failed. Please try again later......'
			);
		}
		echo json_encode($Arr_Kembali);
	}

	public function simpan_koreksi2()
	{

		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload

		$session = $this->session->userdata('app_session');
		$prsh    = $session['id_perusahaan'];
		$cbg     = $session['id_cabang'];


		$this->upload->initialize($config);
		if ($this->upload->do_upload('image')) {
			$gbr = $this->upload->data();
			//Compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/files/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['umum'] = '50%';
			$config['width'] = 260;
			$config['height'] = 350;
			$config['new_image'] = './assets/files/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$gambar  = $gbr['file_name'];
			$type    = $gbr['file_type'];
			$ukuran  = $gbr['file_size'];
			$ext1    = explode('.', $gambar);
			$ext     = $ext1[1];
			$lokasi = './assets/files/' . $gbr['file_name'] . '.' . $ext;
		}

		$id_master 	= $this->input->post('id_master');
		$id_detail 	= $this->input->post('id');
		$table      = $this->input->post('table');
		// echo"<pre>";print_r($this->input->post());exit;
		$insert = $this->db->query("SELECT * FROM $table WHERE id='$id_detail' ")->row();

		if ($insert->id_review != '0') {
			$approve = '3';
		} else {
			$approve = '1';
		}

		$Arr_Kembali			= array();

		if ($ukuran > 0) {
			//$data					= $this->input->post();

			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			if ($insert->id_review != '0') {
				$data['status_approve']	= 3;
			} else {
				$data['status_approve']	= 1;
			}
			$data['status_revisi']	= '1';
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');



			$norev  = $insert->revisi + 1;
			$norev1 = $insert->revisi;
			$data_insert = array(

				'deskripsi'	        => $insert->deskripsi,
				'keterangan_rev'	=> $this->input->post('keterangan'),
				'nama_file'        	=> $insert->nama_file,
				'ukuran_file'       => $insert->ukuran_file,
				'tipe_file'         => $insert->tipe_file,
				'lokasi_file'	    => $insert->lokasi_file,
				'created_by'		=> $insert->created_by,
				'created'	    	=> $insert->created,
				'id_master'	    	=> $insert->id_master,
				'id_detail'	    	=> $insert->id_detail,
				'id_detail1'	    => $insert->id_detail1,
				'id_approval'	    => $insert->id_approval,
				'status_approve'	=> $insert->status_approve,
				'revisi'	        => $norev,
				'revisi_dokumen'	=> $norev1,
				'id_dokumen'	    => $insert->id,
				'nm_table'	        => $table

			);

			$update = $this->Folders_model->getUpdate('gambar2', $data, 'id', $this->input->post('id'));
			if ($update) {
				$this->db->insert("tbl_replace", $data_insert);
			}
		} else {
			//$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			if ($insert->id_review != '0') {
				$data['status_approve']	= 3;
			} else {
				$data['status_approve']	= 1;
			}
			$data['status_revisi']	= '1';
			$data['id_detail']		= $id_detail;
			$update = $this->Folders_model->getUpdate('gambar2', $data, 'id', $this->input->post('id'));
		}

		if ($update) {
			$Arr_Kembali		= array(
				'status'		=> 1,
				'pesan'			=> 'Update Document Success. Thank you & have a nice day.......'
			);
			$keterangan = 'Berhasil Update Dokumen';
			$status = 1;
			$nm_hak_akses = $this->addPermission;
			$kode_universal = $this->input->post('id_master');
			$jumlah = 1;
			$sql = $this->db->last_query();
			simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
		} else {
			$Arr_Kembali		= array(
				'status'		=> 2,
				'pesan'			=> 'Add gambar failed. Please try again later......'
			);
		}
		echo json_encode($Arr_Kembali);
	}
}
