<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Hikmat Aolia Robani ig:@hikmat20
 * @copyright Copyright (c) 2021, Hikmat
 */

class Finance extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'kas/Kas_model',
			'Aktifitas/aktifitas_model'
		));

		$this->template->set('title', 'Keuangan');
		$this->template->page_icon('fa fa-folder');

		date_default_timezone_set("Asia/Bangkok");
	}

	private function _generate_id()
	{
		$result = $this->db
			->select('MAX(RIGHT(id,4)) maxId')
			->from('cashflow')
			->where(['SUBSTR(id,3,4)' => date('ym')])
			->get()->row();

		if (!$result->maxId) {
			$count = 1;
		} else {
			$count = $result->maxId + 1;
		}

		$Id = 'CF' . date('ym') . str_pad($count, 4, "0", STR_PAD_LEFT);
		return $Id;
	}


	public function index()
	{
		$date = date('Y-m-d');
		$transaction 	= $this->db->select('sum(grand_total) as total_trans')->get_where('transactions', ['status !=' => 'CNL', 'date' => $date])->row()->total_trans;
		$cash 			= $this->db->select('sum(payment_value) as payment')->get_where('view_payment_trans', ['payment_methode' => 'CSH', 'payment_date' => $date])->row();
		$transfer 		= $this->db->select('sum(payment_value) as payment')->get_where('view_payment_trans', ['payment_methode' => 'TRF', 'payment_date' => $date])->row();
		$kasbon 		= $this->db->select('sum(cash_value) as kasbon')->get_where('cash_receipt', ['date' => $date])->row()->kasbon;
		$uang_makan 	= $this->db->select('sum(total_value) as uang_makan')->get_where('meal_allowance', ['date' => $date])->row()->uang_makan;


		$this->template->set(
			[
				'transaction'	=> $transaction,
				'cash'			=> $cash,
				'transfer'		=> $transfer,
				'kasbon'		=> $kasbon,
				'uang_makan'	=> $uang_makan,
			]
		);

		$this->template->set('title', 'Rekap Pendapatan');
		$this->template->render('income');
	}

	public function income()
	{
		$date 	= $this->input->post('date');
		$check 	= $this->db->order_by('date', 'ASC')->get_where('cashflow', ['status' => 'OPEN', 'date !=' => $date])->result();

		$cek = [];
		foreach ($check as $ck) {
			$cek[] = $ck->date;
		}

		if ($cek) {
			$return = [
				'status' => 0,
				'msg' => 'Data transaksi belum di tutup sejak/pada tanggal ' . implode(", ", $cek)
			];
		} else {
			$return = [
				'status' => 1,
			];
		}

		$this->template->set('title', 'Rekap Pendapatan');
		$this->template->render('income');
	}

	public function close_by_date()
	{

		$id_user 	= $this->session['User']['id_user'];
		$date 		= $this->input->post('date');
		$this->db->trans_begin();
		$summary 	= $this->Kas_model->CloseingTrans($id_user, $date, $date);
		$return = [
			'data' => $summary
		];
		echo json_encode($return);
	}

	public function closing_book()
	{

		$id_user 	= $this->session['User']['id_user'];
		$date 		= $this->input->post('date');
		$summary 	= $this->Kas_model->CloseingTrans($id_user, $date, $date);

		$insertClosing = [
			'date'                => date('d', strtotime($date)),
			'month'               => date('m', strtotime($date)),
			'year'                => date('Y', strtotime($date)),
			'closing_date'        => $date,
			'user'                => $id_user,
			'in_value'            => $summary->in_value,
			'out_value'           => $summary->out_value,
			'process_date'        => date('Y-m-d H:i:s'),
		];

		$this->db->trans_begin();
		$this->db->insert('closing_transaction', $insertClosing);
		$this->db->update('cashflow', ['status' => 'CLOSE', 'closing_date' => date('Y-m-d H:i:s')], ['created_by' => $id_user, 'status' => 'OPEN', 'date' => $date]);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$return = [
				'status'  => 0,
				'msg' => 'Proses tutup buku gagal. Coba beberapa saat lagi.'
			];
		} else {
			$this->db->trans_commit();
			$return = [
				'status'  => 1,
				'msg' => 'Proses tutup buku berhasil.'
			];
		}

		echo json_encode($return);
	}

	public function save_cash()
	{
		$data 		= $this->input->post();
		$data['id'] = $this->_generate_id();
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = $this->session['User']['id_user'];

		if ($data['type'] == 'IN') {
			$data['in_value'] = str_replace(str_split(',.'), "", $data['cash_value']);
		} else {
			$data['out_value'] = str_replace(str_split(',.'), "", $data['cash_value']);
		}
		unset($data['cash_value']);

		$this->db->trans_begin();
		$this->db->insert('cashflow', $data);
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$Arr_Kembali		= array(
				'status'		=> 1,
				'msg'			=> 'Input Kas berhasil.'
			);
		} else {
			$this->db->trans_rollback()();
			$Arr_Kembali		= array(
				'status'		=> 0,
				'msg'			=> 'Input Kas gagal, mohon coba beberapa saat lagi.'
			);
		}

		echo json_encode($Arr_Kembali);
	}



	public function detail()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');

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
			$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;


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
		$id_master = $this->db->query("SELECT * FROM gambar WHERE id='$id'")->row();
		$iddetail = $id_master->id_detail;
		$nme    =   $id_master->nama_file;
		$pth    =   file_get_contents(base_url() . "./assets/files/" . $nme);

		force_download($nme, $pth);

		redirect(site_url('dokumen'));
	}



	function delete_detail($id)
	{
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
		$id_master = $this->db->query("SELECT * FROM gambar1 WHERE id='$id'")->row();
		$iddetail = $id_master->id_detail;
		$nme    =   $id_master->nama_file;
		$pth    =   file_get_contents(base_url() . "./assets/files/" . $nme);

		force_download($nme, $pth);

		redirect(site_url('dokumen'));
	}



	function delete_detail1($id)
	{
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
			redirect(site_url('Folders/detail1?id_detail=' . $iddetail));
		}
	}


	public function add_subdetail2()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload


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
		$id_master = $this->db->query("SELECT * FROM gambar2 WHERE id='$id'")->row();
		$iddetail = $id_master->id_detail;
		$nme    =   $id_master->nama_file;
		$pth    =   file_get_contents(base_url() . "./assets/files/" . $nme);

		force_download($nme, $pth);

		redirect(site_url('dokumen'));
	}



	function delete_detail2($id)
	{
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
			redirect(site_url('Folders/detail2?id_detail1=' . $iddetail1));
		}
	}


	public function add_subdetail3()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload


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
			$this->template->set('idmaster', $id_master);
			$this->template->set('iddetail', $id_detail);
			$this->template->set('action', 'add');
			$this->template->title('Add Sub Dokumen');
			$this->template->render('add_subdetail1');
		}
	}

	//END SUB DOKUMEN 2

	//APPROVE
	public function approve()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$jabatan = $session['id_jabatan'];
		$user    = $session['id_user'];
		$this->template->page_icon('fa fa-folder-open');
		$get_Data		= $this->Folders_model->getData('master_gambar');
		$this->template->set('row', $get_Data);
		$this->template->set('title', 'Index Of Dokumen');
		$this->template->set('jabatan', $jabatan);
		$this->template->set('user', $user);
		$this->template->render('index_approve');
	}

	public function approval_subfolder()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-folder-open');
		$idmaster       = $this->uri->segment(3);
		$get_Data		= $this->Folders_model->getData('master_gambar', 'id_master', $idmaster);
		$this->template->set('row', $get_Data);
		$this->template->title('Index Of Folders');
		$this->template->render('index_approve_subfolder');
	}

	public function approval()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$jabatan = $session['id_jabatan'];


		$id    = $this->input->post('id');
		$table    = $this->input->post('table');
		$nama_file = $this->input->post('file');
		// print_r($nama_file);
		// exit;

		$data = $this->db->query("SELECT * FROM tbl_approval WHERE nm_table='$table' AND id_dokumen='$id'")->result();
		$data1 = $this->db->query("SELECT * FROM tbl_replace WHERE nm_table='$table' AND id_dokumen='$id'")->result();
		$data2 = $this->db->query("SELECT * FROM tbl_replace WHERE nm_table='$table' AND id_dokumen='$id'")->result();

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
		$this->template->set('row', $data);
		$this->template->set('row1', $data1);
		$this->template->set('row2', $data2);
		$this->template->render('approval');
	}


	public function saveApproval()
	{


		$status = $this->input->post('status');
		$id = $this->input->post('id');
		$table = $this->input->post('table');

		// print_r($table);
		// exit;

		//$this->db->trans_begin();

		if ($status == 'approve') {

			$getRevisi = $this->db->query("SELECT * FROM $table WHERE id='$id' ")->row();
			if ($getRevisi->status_revisi == '1') {
				$revisi    = $getRevisi->revisi + 1;
				$statusrev = '0';
			} else {
				$revisi    = $getRevisi->revisi;
				$statusrev = $getRevisi->status_revisi;
			}

			$data_update = array(
				'revisi'           => $revisi,
				'status_approve'    => 2,
				'status_revisi'     => $statusrev,
				'approval_on'	    => date('Y-m-d H:i:s'),
				'approval_by'		=> $this->auth->user_id()
			);
			$where      = array(
				'id' => $this->input->post('id'),
			);

			$data_approval = $this->db->query("SELECT * FROM  tbl_approval WHERE id_dokumen ='$id' AND nm_table='$table' ")->result();

			foreach ($data_approval as $val) {

				$data_insert = array(

					'id'                => $val->id,
					'keterangan'        => $val->keterangan,
					'id_dokumen'        => $val->id_dokumen,
					'nm_table'          => $val->nm_table,
					'revisi'            => $val->revisi,
					'approval_on'	    => $val->approval_on,
					'approval_by'		=> $val->approval_by
				);

				$this->db->insert("tbl_approval_history", $data_insert);
			}

			$this->Folders_model->getUpdateData($table, $data_update, $where);

			$this->db->delete("tbl_approval", array('id_dokumen' => $id, 'nm_table' => $table));
		} elseif ($status == 'revisi') {

			$getRevisi = $this->db->query("SELECT revisi FROM $table WHERE id='$id' ")->row();
			$revisi    = $getRevisi->revisi;

			// print_r($revisi);
			// exit;

			$data_update = array(
				'status_approve'    => 0,
				'approval_on'	    => date('Y-m-d H:i:s'),
				'approval_by'		=> $this->auth->user_id()
			);
			$where      = array(
				'id' => $this->input->post('id'),
			);

			$data_insert = array(
				'keterangan'        => $this->input->post('keterangan'),
				'id_dokumen'        => $this->input->post('id'),
				'nm_table'          => $this->input->post('table'),
				'revisi'            => $revisi,
				'approval_on'	    => date('Y-m-d H:i:s'),
				'approval_by'		=> $this->auth->user_id()
			);

			$this->Folders_model->getUpdateData($table, $data_update, $where);
			$this->db->insert("tbl_approval", $data_insert);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$Arr_Return		= array(
				'status'		=> 2,
				'pesan'			=> 'Save Process Failed. Please Try Again...'
			);
		} else {
			$this->db->trans_commit();
			$Arr_Return		= array(
				'status'		=> 1,
				'pesan'			=> 'Save Process Success. ',
				// 'kode'			=> $kode
			);
		}
		echo json_encode($Arr_Return);
	}

	public function history_revisi()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$jabatan = $session['id_jabatan'];


		$id    = $this->input->post('id');
		$table    = $this->input->post('table');
		$nama_file = $this->input->post('file');
		// print_r($id);
		// print_r($table);
		// exit;

		$data = $this->db->query("SELECT * FROM tbl_replace WHERE nm_table='$table' AND id_dokumen='$id'")->result();
		$data1 = $this->db->query("SELECT * FROM tbl_replace WHERE nm_table='$table' AND id_dokumen='$id'")->result();

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
		$this->template->set('row', $data);
		$this->template->set('row1', $data1);
		$this->template->render('history_revisi');
	}


	//APPROVE
	public function koreksi()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$jabatan = $session['id_jabatan'];
		$this->template->page_icon('fa fa-folder-open');
		$get_Data		= $this->Folders_model->getData('master_gambar');
		$this->template->set('row', $get_Data);
		$this->template->set('title', 'Index Of Dokumen');
		$this->template->set('jabatan', $jabatan);
		$this->template->render('index_koreksi');
	}

	public function addkoreksi()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$jabatan = $session['id_jabatan'];


		$id    = $this->input->post('id');
		$table    = $this->input->post('table');
		$nama_file = $this->input->post('file');
		// print_r($nama_file);
		// exit;

		$data = $this->db->query("SELECT * FROM tbl_approval WHERE nm_table='$table' AND id_dokumen='$id'")->result();

		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$uri6 = $this->uri->segment(4);

		$this->template->set('uri3', $uri3);
		$this->template->set('uri4', $uri4);
		$this->template->set('uri5', $uri5);
		$this->template->set('uri6', $uri6);

		$id    = $this->input->post('id');
		$table    = $this->input->post('table');
		$nama_file = $this->input->post('file');

		if ($table == 'gambar') {
			$detail				= $this->Folders_model->getData('gambar', 'id', $id);
		} else if ($table == 'gambar1') {
			$detail				= $this->Folders_model->getData('gambar1', 'id', $id);
		} else if ($table == 'gambar2') {
			$detail				= $this->Folders_model->getData('gambar2', 'id', $id);
		}
		// print_r($detail);
		// exit;	

		$this->template->set('jabatan', $jabatan);
		$this->template->set('id', $id);
		$this->template->set('table', $table);
		$this->template->set('data', $detail);
		$this->template->set('nama_file', $nama_file);
		$this->template->set('row', $data);
		$this->template->render('input_koreksi');
	}

	public function saveKoreksi()
	{
		$status = $this->input->post('status');
		$id = $this->input->post('id');
		$table = $this->input->post('table');

		// print_r($table);
		// exit;

		//$this->db->trans_begin();



		$getRevisi = $this->db->query("SELECT revisi FROM $table WHERE id='$id' ")->row();
		$revisi    = $getRevisi->revisi + 1;

		// print_r($revisi);
		// exit;

		$data_update = array(

			'status_approve'    => 1,
			'modified_on'	    => date('Y-m-d H:i:s'),
			'modified_by'		=> $this->auth->user_id()
		);
		$where      = array(
			'id' => $this->input->post('id'),
		);

		$this->Folders_model->getUpdateData($table, $data_update, $where);
	}

	public function simpan_koreksi()
	{
		$config['upload_path'] = './assets/files/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|doc|docx|xls|xlsx|ppt|pptx|pdf|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = false; //Enkripsi nama yang terupload


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

		$Arr_Kembali			= array();
		$insert = $this->db->query("SELECT * FROM $table WHERE id='$id_detail' ")->row();
		$norev  = $insert->revisi;

		if ($insert->id_review != '0') {
			$approve	= '3';
		} else {
			$approve	= '1';
		}

		if ($ukuran > 0) {
			//$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['status_approve']	= $approve;

			$data_insert = array(

				'deskripsi'	        => $insert->deskripsi,
				'nama_file'        	=> $insert->nama_file,
				'ukuran_file'       => $insert->ukuran_file,
				'tipe_file'         => $insert->tipe_file,
				'lokasi_file'	    => $insert->lokasi_file,
				'created_by'		=> $insert->created_by,
				'created'	    	=> $insert->created,
				'id_master'	    	=> $insert->id_master,
				'id_approval'	    => $insert->id_approval,
				'status_approve'	=> $approve,
				'revisi'	        => $norev,
				'id_dokumen'	    => $insert->id,
				'nm_table'	        => $table

			);

			$update = $this->Folders_model->getUpdate('gambar', $data, 'id', $this->input->post('id'));
			if ($update) {
				$this->db->insert("tbl_history", $data_insert);
			}
		} else {
			//$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id']		        = $id_detail;
			if ($insert->id_review != '0') {
				$data['status_approve']	= 3;
			} else {
				$data['status_approve']	= 1;
			}
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
		$norev  = $insert->revisi;
		if ($insert->id_review != '0') {
			$approve	= '3';
		} else {
			$approve	= '1';
		}


		$insert = $this->db->query("SELECT * FROM $table  WHERE id='$id_detail'")->row();
		$norev  = $insert->revisi;

		$Arr_Kembali			= array();

		if ($ukuran > 0) {
			//$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['status_approve']	= $approve;

			$data_insert = array(

				'deskripsi'	        => $insert->deskripsi,
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
				'id_dokumen'	    => $insert->id,
				'nm_table'	        => $table

			);

			$update = $this->Folders_model->getUpdate('gambar1', $data, 'id', $this->input->post('id'));
			if ($update) {
				$this->db->insert("tbl_history", $data_insert);
			}
		} else {
			//$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id_detail']		= $id_detail;
			$data['status_approve']	= $approve;

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
		$norev  = $insert->revisi;
		if ($insert->id_review != '0') {
			$approve	= '3';
		} else {
			$approve	= '1';
		}

		$insert = $this->db->query("SELECT * FROM $table WHERE id='$id_detail' ")->row();
		$norev  = $insert->revisi;

		$Arr_Kembali			= array();

		if ($ukuran > 0) {
			//$data					= $this->input->post();
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['nama_file']	    = $gambar;
			$data['ukuran_file']	= $ukuran;
			$data['tipe_file']		= $ext;
			$data['lokasi_file']	= $lokasi;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');

			$data_insert = array(

				'deskripsi'	        => $insert->deskripsi,
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
				'status_approve'	=> $approve,
				'revisi'	        => $norev,
				'id_dokumen'	    => $insert->id,
				'nm_table'	        => $table

			);

			$update = $this->Folders_model->getUpdate('gambar2', $data, 'id', $this->input->post('id'));
			if ($update) {
				$this->db->insert("tbl_history", $data_insert);
			}
		} else {
			//$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['created_by']		= $this->auth->user_id();
			$data['created']		= date('Y-m-d H:i:s');
			$data['id_master']		= $id_master;
			$data['id_detail']		= $id_detail;
			$data['status_approve']	= $approve;
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

	public function review()
	{
		$this->auth->restrict($this->viewPermission);
		$session = $this->session->userdata('app_session');
		$jabatan = $session['id_jabatan'];


		$id    = $this->input->post('id');
		$table    = $this->input->post('table');
		$nama_file = $this->input->post('file');
		// print_r($nama_file);
		// exit;

		$data = $this->db->query("SELECT * FROM tbl_approval WHERE nm_table='$table' AND id_dokumen='$id'")->result();
		$data1 = $this->db->query("SELECT * FROM tbl_replace WHERE nm_table='$table' AND id_dokumen='$id'")->result();
		$data2 = $this->db->query("SELECT * FROM tbl_replace WHERE nm_table='$table' AND id_dokumen='$id'")->result();

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
		$this->template->set('row', $data);
		$this->template->set('row1', $data1);
		$this->template->set('row2', $data2);
		$this->template->render('review');
	}

	public function saveReview()
	{


		$status = $this->input->post('status');
		$id = $this->input->post('id');
		$table = $this->input->post('table');

		// print_r($this->input->post());
		// exit;

		//$this->db->trans_begin();

		if ($status == 'approve') {

			$getRevisi = $this->db->query("SELECT revisi FROM $table WHERE id='$id' ")->row();
			$revisi    = $getRevisi->revisi;

			$data_update = array(

				'status_approve'    => 1,
				'approval_on'	    => date('Y-m-d H:i:s'),
				'approval_by'		=> $this->auth->user_id()
			);
			$where      = array(
				'id' => $this->input->post('id'),
			);

			$this->Folders_model->getUpdateData($table, $data_update, $where);

			if ($this->input->post('keterangan') != '') {
				$data_insert = array(

					'keterangan'        => $this->input->post('keterangan'),
					'id_dokumen'        => $this->input->post('id'),
					'nm_table'          => $this->input->post('table'),
					'revisi'           => $revisi,
					'approval_on'	    => date('Y-m-d H:i:s'),
					'approval_by'		=> $this->auth->user_id()
				);

				$this->db->insert("tbl_approval", $data_insert);
			}
		} elseif ($status == 'revisi') {

			$getRevisi = $this->db->query("SELECT revisi FROM $table WHERE id='$id' ")->row();
			$revisi    = $getRevisi->revisi;

			// print_r($revisi);
			// exit;

			$data_update = array(
				'status_approve'    => 0,
				'approval_on'	    => date('Y-m-d H:i:s'),
				'approval_by'		=> $this->auth->user_id()
			);
			$where      = array(
				'id' => $this->input->post('id'),
			);

			$data_insert = array(
				'keterangan'        => $this->input->post('keterangan'),
				'id_dokumen'        => $this->input->post('id'),
				'nm_table'          => $this->input->post('table'),
				'revisi'            => $revisi,
				'approval_on'	    => date('Y-m-d H:i:s'),
				'approval_by'		=> $this->auth->user_id()
			);

			$this->Folders_model->getUpdateData($table, $data_update, $where);
			$this->db->insert("tbl_approval", $data_insert);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$Arr_Return		= array(
				'status'		=> 2,
				'pesan'			=> 'Save Process Failed. Please Try Again...'
			);
		} else {
			$this->db->trans_commit();
			$Arr_Return		= array(
				'status'		=> 1,
				'pesan'			=> 'Save Process Success. ',
				// 'kode'			=> $kode
			);
		}
		echo json_encode($Arr_Return);
	}
}
