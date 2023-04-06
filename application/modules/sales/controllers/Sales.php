<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunaz
 * @copyright Copyright (c) 2018, Yunaz
 *
 * This is controller for Customer
 */

class Sales extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('upload', 'Image_lib'));
		$this->load->model(array(
			'Sales_Model',
			'Aktifitas/aktifitas_model'
		));
		$this->template->set_theme('default');

		date_default_timezone_set("Asia/Bangkok");
	}

	private function _autoNumber($table, $code)
	{
		$length_code 	= strlen($code) + 1;
		$init   		= date('ym');
		$sql    		= "SELECT MAX(RIGHT(id,4)) as maxId FROM $table WHERE SUBSTR(id,$length_code,4) = $init";
		$max    		= $this->db->query($sql)->row();

		if ($max->maxId) {
			$counter = $max->maxId + 1;
		} else {
			$counter = 1;
		}

		$number = $code . date('ym') . str_pad($counter, 4, "0", STR_PAD_LEFT);
		return $number;
	}

	public function index()
	{
		$id_user 		= $this->session['User']['id_user'];
		$transaction 	= $this->db->get_where('transactions', ['status' => 'ORD', 'created_by' => $id_user])->row();
		$services 		= $this->db->get_where('services', ['active' => 'Y', 'deleted' => 'N'])->result();
		$stationery 	= $this->db->get_where('stationery_categories')->result();
		$trans_details 	= $this->db->get_where('view_trans_details', ['trans_id' => ($transaction) ? $transaction->id : ''])->result();

		$this->template->set(
			[
				'title' 		=> 'Kasir',
				'services' 		=> $services,
				'stationery' 	=> $stationery,
				'transactions' 	=> $transaction,
				'trans_details' => $trans_details
			]
		);

		$this->template->render('index');
	}

	public function search()
	{
		$string = $this->input->post('string');
		$result = $this->db->get_where('services', ['name LIKE' => '%' . $string . '%'])->result();
		echo json_encode($result);
	}

	public function load()
	{
		$id 		= $this->input->post('val');
		$services   = $this->db->get_where('services', ['id' => $id])->row();
		$form_type  = $services->form_type;
		$form 		= $this->db->get_where('form_type', ['id' => $form_type])->row();
		$materials  = $this->db->get_where('materials', ['services_id' => $id, 'active' => 'Y', 'deleted' => 'N'])->result();
		$finishing  = $this->db->get_where('finishing', ['services_id' => $id])->result();

		$this->template->set([
			'services' 		=> $services,
			'materials' 	=> $materials,
			'finishing' 	=> $finishing,
		]);

		if ($form) {
			$this->template->render($form->name);
		}
	}

	public function load_stationery()
	{
		$categories = $stationery = '';
		$id 		= $this->input->post('val');
		// $categories = $this->db->get_where('stationery_categories')->result();
		$stationery = $this->db->get_where('stationery', ['category_id' => $id])->result();
		$ArrStt = [];
		$this->template->set([
			'categories'	=> $categories,
			'stationery'	=> $stationery,

		]);

		$this->template->render('form-atk');
	}

	public function load_price()
	{
		$id 			= $this->input->post('id');
		$materials 		= $this->db->get_where('materials', ['id' => $id])->row();
		$whPrice  		= $this->db->get_where('wholesaler_prices', ['materials_id' => $id])->result();

		$data = [
			'materials' => $materials,
			'whPrice' => $whPrice,
		];

		echo json_encode($data);
	}

	// LOAD PRICE STATIONERY
	public function load_price_stationery()
	{
		$id 			= $this->input->post('id');
		$stationery 	= $this->db->get_where('stationery', ['id' => $id])->row();
		$whPrice  		= $this->db->get_where('wholesaler_prices_stationery', ['stationery_id' => $id])->result();
		$data = [
			'stationery' 	=> $stationery,
			'whPrice' 		=> $whPrice,
		];

		echo json_encode($data);
	}

	function wholesale_price()
	{
		$price 			= '';
		$whPrice 		= '';
		$id_mat 		= $this->input->post('material');
		$qty 			= $this->input->post('qty');
		$size 			= $this->input->post('size');
		$material		= $this->db->get_where('materials', ['id' => $id_mat])->row();
		$price 			= $material->unit_price;

		if ($material->flag_custom_size == 'Y' && $material->wholesaler == 'Y' && $material->based_price == 'UNIT' && $qty > 0) {
			$whPrice = $this->db->query("SELECT * FROM `wholesaler_prices` WHERE `materials_id` = '$id_mat' AND
			CASE WHEN `qty_until` IS NOT NULL THEN
			`qty_from` <= '$size' AND `qty_until` >= '$size' ELSE 
			`qty_from` <= '$size' AND `qty_until` IS NULL END")->row();
		} else if ($material->wholesaler == 'Y' && $qty > 0) {
			$whPrice = $this->db->query("SELECT * FROM `wholesaler_prices` WHERE `materials_id` = '$id_mat' AND
			CASE WHEN `qty_until` IS NOT NULL THEN
			`qty_from` <= '$qty' AND `qty_until` >= '$qty' ELSE 
			`qty_from` <= '$qty' AND `qty_until` IS NULL END")->row();
		}

		if ($whPrice) {
			$price = $whPrice->price;
		}

		$data = [
			'price' 	=> $price,
			'material' 	=> $material,
			'qty' 		=> $qty,
			'size' 		=> $size,
		];

		echo json_encode($data);
	}

	function wholesale_price_stationery()
	{
		$price 			= '';
		$whPrice 		= '';
		$id 			= $this->input->post('id');
		$qty 			= $this->input->post('qty');
		$stationery		= $this->db->get_where('stationery', ['id' => $id])->row();
		$price 			= $stationery->unit_price;

		if ($stationery->wholesaler == 'Y' && $qty > 0) {
			$whPrice 	= $this->db->query("SELECT * FROM `wholesaler_prices_stationery` WHERE `stationery_id` = '$id' AND `qty_from` <= '$qty' order by id desc limit 1")->row();
			$price 		= $whPrice->price;
		}

		$data = [
			'price' 	=> $price,
			'qty' 		=> $qty,
		];

		echo json_encode($data);
	}

	function priceLaminaiting()
	{
		$id 			= $this->input->post('id');
		$qty 			= $this->input->post('qty');

		if ($id) {
			$price = $this->db->query("SELECT * FROM `laminating_price` WHERE `laminating_id` = '$id' AND
			CASE WHEN `qty_until` IS NOT NULL THEN
			`qty_from` <= '$qty' AND `qty_until` >= '$qty' ELSE 
			`qty_from` <= '$qty' AND `qty_until` IS NULL END")->row();
			if ($price) {
				$price = $price->price;
			}
		}
		echo $price;
	}

	function priceCutting()
	{
		$id 			= $this->input->post('id');
		$qty 			= $this->input->post('qty');

		if ($id) {
			$price = $this->db->query("SELECT * FROM `cutting_price` WHERE `cutting_id` = '$id' AND
			CASE WHEN `qty_until` IS NOT NULL THEN
			`qty_from` <= '$qty' AND `qty_until` >= '$qty' ELSE 
			`qty_from` <= '$qty' AND `qty_until` IS NULL END")->row();

			if ($price) {
				$price = $price->price;
			}
		}
		echo $price;
	}

	private function _check_wholesale_price($id)
	{
		$material = $this->db->get_where('materials', ['id' => $id, 'active' => 'Y'])->row();

		if ($material->wholesaler == 'Y') {
			return true;
		} else {
			return false;
		}
	}

	public function save_trans()
	{
		$id = $this->input->post('id');

		if ($id) {
			$this->db->trans_begin();
			$this->db->update('transactions', ['status' => 'PND'], ['id' => $id]);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$return = [
					'status' => 0,
					'msg'	 => 'Transaksi Gagal disimpan. Mohon coba beberapa saat lagi'
				];
			} else {
				$this->db->trans_commit();
				$return = [
					'status' => 1,
					'msg'	 => 'Trnsaksi berhasil di simpan.'
				];
			}
		} else {
			$return = [
				'status' => 0,
				'msg'	 => 'Data Transaksi tidak valid.'
			];
		}

		echo json_encode($return);
	}

	public function save_customer()
	{
		$data 			= $this->input->post();
		$autoNumber 	= $this->_autoNumber('transactions', 'TR');
		if ($data) {
			$data['id'] 	= ($data['id']) ? $data['id'] : $autoNumber;
			$data['date']   = date('Y-m-d H:i:s');
			$this->db->trans_begin();
			if ($this->input->post('id')) {
				$data['modified_by'] 	= $this->session['User']['id_user'];
				$data['modified_at'] 	= date('Y-m-d H:i:s');
				$this->db->update('transactions', $data, ['id' => $data['id']]);
			} else {
				$data['created_by'] 	= $this->session['User']['id_user'];
				$data['created_at'] 	= date('Y-m-d H:i:s');
				$this->db->insert('transactions', $data);
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$return = [
					'status' => 0,
					'msg' 	=> 'Data pelanggan gagal di simpan.',
				];
			} else {
				$this->db->trans_commit();
				$return = [
					'status' 	=> 1,
					'msg' 		=> 'Data pelanggan berhasil di simpan.',
					'id' 		=> $data['id'],
					'date' 		=> $data['date'],
					'customer'	=> $data['customer_name'],
					'phone'		=> $data['phone']
				];
			}
		} else {
			$return = [
				'status' 	=> 0,
				'msg' 		=> 'Data tidak valid.'
			];
		}

		echo json_encode($return);
	}

	public function save_services()
	{
		$data = $this->input->post();
		$this->save_detail($data);
	}

	public function save_detail()
	{
		try {
			$data 							= $this->input->post();

			if (isset($data['category_id'])) {
				$data['material'] = $data['category_id'];
				$data['service'] = $data['item'];
				unset($data['category_id']);
				unset($data['item']);
			}

			$data['id'] 					= $this->_autoNumber('transactions_details', 'D');
			if ($data) {
				$data['created_by']			= $this->session['User']['id_user'];
				$data['created_at']			= date('Y-m-d H:i:s');
				$data['unit_price']			= str_replace(str_split(',.'), "", (($data['unit_price']) ? $data['unit_price'] : $data['price']));
				$data['price']				= str_replace(str_split(',.'), "", $data['price']);
				$data['total_price']		= str_replace(str_split(',.'), "", $data['total_price']);
				$data['subtotal']			= str_replace(str_split(',.'), "", $data['total_price']);
				$data['discount']			= str_replace(str_split(',.'), "", (($data['discount']) ? $data['discount'] : 0));
				$data['grand_total']		= str_replace(str_split(',.'), "", $data['total_price'] - (($data['discount']) ? $data['discount'] : 0));

				$this->db->trans_begin();
				$this->db->insert('transactions_details', $data);

				$summary = $this->db->select('sum(subtotal) as subtotal, sum(finishing_price) as finishing,sum(grand_total) as grand_total,sum(discount) as discount')
					->from('transactions_details')->where('trans_id', $data['trans_id'])->get()->row();

				$total_payment = $this->db->select('sum(payment_value) as payment')
					->from('payment_transactions')->where('trans_id', $data['trans_id'])->get()->row()->payment;

				$total_down_payment = $this->db->select('sum(payment_value) as payment')
					->from('payment_transactions')->where(['trans_id' => $data['trans_id'], 'payment_type' => 1])->get()->row()->payment;

				$paid_off = $this->db->select('sum(payment_value) as payment')
					->from('payment_transactions')->where(['trans_id' => $data['trans_id'], 'payment_type' => 2])->get()->row()->payment;

				$summary->total_down_payment 	= $total_down_payment;
				$summary->paid_off 				= $paid_off;
				$summary->total_payment 		= $total_payment;

				$balance 						= $summary->grand_total - $total_payment;
				if ($balance > 0) {
					$summary->balance 			= $balance;
					$summary->return 			= 0;
				} else {
					$summary->balance 			= 0;
					$summary->return 			= str_replace("-", "", $balance);
				}

				$this->db->update('transactions', $summary, ['id' => $data['trans_id']]);
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$Return		= array(
						'status'		=> 0,
						'msg'			=> 'Data gagal disimpan. Terjadi kesalahan data.'
					);
				} else {
					$this->db->trans_commit();
					$Return		= array(
						'status'		=> 1,
						'msg'			=> 'Data Berhasil Disimpan.'
					);
				}
			} else {
				throw new Exception("Data gagal disimpan. Tidak ada data dikirim.", 1);
				$Return		= array(
					'status'		=> 0,
					'msg'			=> 'Data gagal disimpan. Tidak ada data dikirim.'
				);
			}

			echo json_encode($Return);
		} catch (Exception $e) {
			$Return		= array(
				'status'		=> 0,
				'msg'			=> 'Data gagal disimpan. Tidak ada data dikirim.'
			);
			echo json_encode($Return);
		}
	}

	public function save_stationary()
	{
		$data 	= $this->input->post();

		$data['material_id'] = $data['category_id'];
		$data['service'] 	= $data['item'];

		unset($data['category_id']);
		unset($data['item']);

		$this->save_detail($data);
	}

	public function checkout()
	{
		$id 				= $this->input->post('trans_id');
		$trans 				= $this->db->get_where('transactions', ['id' => $id])->row();
		$detail 			= $this->db->get_where('view_checkout', ['trans_id' => $id])->row();
		$payment 			= $this->db->get_where('view_payment_trans', ['trans_id' => $id])->result();
		$payment_type 		= $this->db->get_where('payment_type', ['active' => 'Y'])->result();
		$payment_methode 	= $this->db->get_where('payment_methode', ['active' => 'Y'])->result();
		$data = [
			'id' 				=> $id,
			'trans' 			=> $trans,
			'detail' 			=> $detail,
			'payment' 			=> $payment,
			'payment_type' 		=> $payment_type,
			'payment_methode' 	=> $payment_methode,
		];

		$this->template->set($data);
		$this->template->render('/sales/form-payment');
	}

	public function save_payment()
	{
		$data 						= $this->input->post();
		$document 					= '';

		if ($_FILES && $_FILES['doc']['name']) {
			$config['upload_path']          = './assets/documents/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['max_size']             = 2000;
			$config['max_width']            = 2000;
			$config['max_height']           = 2000;
			$config['file_name']            = $data['trans_id'] . "_" . date('YmdHis');
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('doc')) {
				$return = [
					'status' => 0,
					'msg'   => $this->upload->display_errors()
				];
				echo json_encode($return);
				return FALSE;
			} else {
				$doc = $this->upload->data();
				$document = $data['trans_id'] . "_" . date('YmdHis');
				// if ($old_photo) {
				// 	unlink('./assets/images/avatar/' . $old_photo);
				// }
			}
		}

		// $newPhoto = ($photo) ? $photo : $old_photo;

		$dataPayment = [
			'trans_id' 				=> $data['trans_id'],
			'payment_type' 			=> $data['payment_type'],
			'payment_methode' 		=> $data['payment_methode'],
			'payment_value' 		=> str_replace(str_split(',.'), '', $data['payment_value']),
			'payment_date' 			=> date('Y-m-d H:i:s'),
			'receive_by'			=> $this->session['User']['id_user'],
			'document'				=> $document,
		];

		$detail = $this->db->get_where('view_checkout', ['trans_id' => $data['trans_id']])->row_array();

		if (!$detail) {
			$return = [
				'status' => 0,
				'msg'   => 'Data detail transkaski belum ada.'
			];
			echo json_encode($return);
			return FALSE;
		}

		$dataTrans = [
			'subtotal' 				=> $detail['subtotal'],
			'discount' 				=> $detail['discount'],
			'grand_total' 			=> $detail['grand_total'],
			'status' 				=> 'OPN',
			'cashier'				=> $this->session['User']['id_user'],
			'modified_by' 			=> $this->session['User']['id_user'],
			'modified_at' 			=> date('Y-m-d H:i:s')

		];

		$this->db->trans_begin();
		$this->db->insert("payment_transactions", $dataPayment);
		$total_payment 				= $this->db->select('sum(payment_value) as payment')->from('payment_transactions')->where('trans_id', $data['trans_id'])->get()->row()->payment;
		$total_down_payment 		= $this->db->select('sum(payment_value) as payment')->from('payment_transactions')->where(['trans_id' => $data['trans_id'], 'payment_type' => 1])->get()->row()->payment;
		$paid_off 					= $this->db->select('sum(payment_value) as payment')->from('payment_transactions')->where(['trans_id' => $data['trans_id'], 'payment_type' => 2])->get()->row()->payment;

		// if ($data['payment_type'] == 2) {
		// 	$dataTrans['status'] = 'DNE';
		// }

		$balance 								= $detail['grand_total'] - $total_payment;

		if ($balance > 0) {
			$dataTrans['balance '] 				= $balance;
			$dataTrans['return'] 				= 0;
		} else {
			$dataTrans['balance '] 				= 0;
			$dataTrans['return'] 				= str_replace("-", "", $balance);
			$dataTrans['status'] 				= 'DNE';
			$data['return'] 					= $dataTrans['return'];
			$dataPayment['payment_type'] 		= '2';
		}

		$dataTrans['total_down_payment'] 		= $total_down_payment;
		$dataTrans['paid_off'] 					= $paid_off;
		$dataTrans['total_payment'] 			= $total_payment;


		$this->db->where('id', $detail['trans_id'])->update('transactions', $dataTrans);
		$this->Sales_Model->Cashflow($data);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$return		= array(
				'status'		=> 0,
				'msg'			=> 'Pembayaran gagal disimpan',
				'kembalian'		=> '0'
			);
		} else {
			$this->db->trans_commit();
			$return		= array(
				'status'		=> 1,
				'msg'			=> 'Pembayaran berhasil disimpan.',
				'kembalian'		=> $dataTrans['return'],
			);
		}
		echo json_encode($return);
	}

	public function Cetak()
	{
		$id_trans = $this->input->post('id');

		try {
			$this->load->library('PrinterCetak');
			$this->printercetak->print_receipt_bill($id_trans);
			$return = [
				'status'	 => 1,
				'msg' => 'Sedang mencetak'
			];
		} catch (Exception $e) {
			log_message("error", "Error: Could not print. Message " . $e->getMessage());
			$return = [
				'status'	 => 0,
				'msg' => $e->getMessage()
			];
			$this->printercetak->close_after_exception();
		}
		echo json_encode($return);
	}

	public function edit($id = "")
	{
		$data = $this->db->get_where('transactions', ['id' => $id])->row();
		$services 		= $this->db->order_by('name', 'asc')->get_where('services', ['active' => 'Y', 'deleted' => 'N'])->result();
		$trans_details 	= $this->db->get_where('view_trans_details', ['trans_id' => (isset($id)) ? $id : ''])->result();

		$this->template->set(
			[
				'title' => 'Kasir',
				'services' => $services,
				'transactions' => $data,
				'trans_details' => $trans_details
			]
		);

		$this->template->render('index');
	}

	public function delete_item()
	{
		$data 		= $this->input->post();

		if ($data) {
			$this->db->trans_begin();
			$this->db->delete('transactions_details', ['id' => $data['id']]);

			$summary = $this->db->select('sum(subtotal) as subtotal, sum(finishing_price) as finishing,sum(grand_total) as grand_total,sum(discount) as discount')
				->from('transactions_details')->where('trans_id', $data['trans_id'])->get()->row();

			$total_payment = $this->db->select('sum(payment_value) as payment')
				->from('payment_transactions')->where('trans_id', $data['trans_id'])->get()->row()->payment;

			$total_down_payment = $this->db->select('sum(payment_value) as payment')
				->from('payment_transactions')->where(['trans_id' => $data['trans_id'], 'payment_type' => 1])->get()->row()->payment;

			$paid_off = $this->db->select('sum(payment_value) as payment')
				->from('payment_transactions')->where(['trans_id' => $data['trans_id'], 'payment_type' => 2])->get()->row()->payment;

			$summary->total_down_payment 	= $total_down_payment;
			$summary->paid_off 				= $paid_off;
			$summary->total_payment 		= $total_payment;

			$balance 						= $summary->subtotal - $total_payment;
			if ($balance > 0) {
				$summary->balance 			= $balance;
				$summary->return 			= 0;
			} else {
				$summary->balance 			= 0;
				$summary->return 			= str_replace("-", "", $balance);
			}

			$this->db->update('transactions', $summary, ['id' => $data['trans_id']]);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$return = [
					'status' 	=> 0,
					'msg' 		=> 'Data gagal dihapus.',
				];
			} else {
				$this->db->trans_commit();
				$return = [
					'status' 	=> 1,
					'msg' 		=> 'Data berhasil dihapus.',
				];
			}
		} else {
			$return = [
				'status' 		=> 0,
				'msg' 			=> 'Data tidak valid',
			];
		}

		echo json_encode($return);
	}

	public function input_customer()
	{
		$this->template->set(['data' => '']);
		$this->template->render('/sales/form-customer');
	}

	public function edit_customer()
	{
		$id 	= $this->input->post('id');
		$data 	= $this->db->get_where('view_transactions', ['id' => $id])->row();

		$this->template->set(['data' => $data]);
		$this->template->render('/sales/form-customer');
	}

	public function view_transaction()
	{
		$sts = [
			'OPN' => '<span class="badge rounded-pill bg-light-primary text-primary">Baru</span>',
			'PND' => '<span class="badge rounded-pill bg-light-warning text-warning">Menunggu</span>',
			'DNE' => '<span class="badge rounded-pill bg-light-success text-success">Selesai</span>',
			'CNL' => '<span class="badge rounded-pill bg-light-danger text-danger">Batal</span>',
		];

		$data           = $this->db->where(['deleted' => 'N', 'status !=' => 'ORD'])->order_by('FIELD(status, "PND","OPN","DNE","CNL")')->order_by('created_at', 'DESC')->get('transactions')->result();
		$this->template->set(
			[
				'sts'           => $sts,
				'data'          => $data
			]
		);

		$this->template->render('/sales/view_transaction');
	}

	public function upload_document()
	{
		$this->template->render('/sales/upload_document');
	}

	public function deleteTrans()
	{
		$id = $this->input->post('id');
		$Return = [
			'status' => 0,
			'msg' => 'Data tidak valid, error!!'
		];

		echo '<pre>';
		print_r($id);
		echo '<pre>';
		exit;

		echo json_encode($Return);
	}
}
