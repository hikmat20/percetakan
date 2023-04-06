<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
	/*
 * @author Yunaz
 * @copyright Copyright (c) 2016, Yunaz
 * 
 * This is controller for Penerimaan
 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('dashboard/dashboard_model');
		$this->template->page_icon('fa fa-dashboard');
	}

	public function index()
	{
		$date 			= date('Y-m-d');
		$yw = 'YEARWEEK(CURDATE(),1)';
		$current 		= $this->db->get_where('transactions', ['status !=' => 'CNL', 'date(date)' => $date])->num_rows();
		$curr_done 		= $this->db->get_where('transactions', ['status' => 'DNE', 'date(date)' => $date])->num_rows();
		$week 			= $this->db->get_where('transactions', ['status !=' => 'CNL', 'YEARWEEK(date)' => date("YW", strtotime($date))])->num_rows();
		$week_done 		= $this->db->get_where('transactions', ['status' => 'DNE', 'YEARWEEK(date)' => date("YW", strtotime($date))])->num_rows();
		$month 			= $this->db->get_where('transactions', ['status !=' => 'CNL', 'MONTH(date)' => date('m')])->num_rows();
		$month_done 	= $this->db->get_where('transactions', ['status' => 'DNE', 'MONTH(date)' => date('m')])->num_rows();
		$year 			= $this->db->get_where('transactions', ['status !=' => 'CNL', 'YEAR(date)' => date('Y')])->num_rows();
		$year_done 		= $this->db->get_where('transactions', ['status' => 'DNE', 'YEAR(date)' => date('Y')])->num_rows();

		$this->template->set(
			[
				'current' 			=> $current,
				'curr_done' 		=> $curr_done,
				'current_week' 		=> $week,
				'current_month' 	=> $month,
				'current_year' 		=> $year,
			]
		);
		$this->template->render('index');
	}

	public function create_documents()
	{
		$this->template->set('title', 'Create Document');
		$doc = $this->db->get('master_gambar')->num_rows();
		$cor1 = $this->db->get_where('gambar', ['status_approve' => 0])->num_rows();
		$cor2 = $this->db->get_where('gambar1', ['status_approve' => 0])->num_rows();
		$cor3 = $this->db->get_where('gambar2', ['status_approve' => 0])->num_rows();
		$apv1 = $this->db->get_where('gambar', ['status_approve' => 1])->num_rows();
		$apv2 = $this->db->get_where('gambar1', ['status_approve' => 1])->num_rows();
		$apv3 = $this->db->get_where('gambar2', ['status_approve' => 1])->num_rows();
		$allCorr = $cor1 + $cor2 + $cor3;
		$allApv = $apv1 + $apv2 + $apv3;
		$pictures = $this->db->get('pictures')->result();
		$this->template->set('pictures', $pictures);
		$this->template->set('doc', $doc);
		$this->template->set('docCor', $allCorr);
		$this->template->set('docApv', $allApv);
		$this->template->render('create-document');
	}

	public function picture()
	{
		$id 		= $this->input->post('id');
		$picture 	= $this->db->get_where('pictures', ['id' => $id])->row();

		$this->template->set('picture', $picture);
		$this->template->render('change-picture');
	}

	public function upload()
	{
		$old_picture 	= $this->input->post('old_picture');
		$id 			= $this->input->post('id');

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
}
