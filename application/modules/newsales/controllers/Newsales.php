<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunaz
 * @copyright Copyright (c) 2018, Yunaz
 *
 * This is controller for Customer
 */

class Newsales extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library(['upload', 'Image_lib']);
		$this->load->model('Sales_Model', 'Sales');
		$this->template->set_theme('default');
		date_default_timezone_set("Asia/Bangkok");
		$this->sts = [
			'OPN' => '<span class="badge rounded-pill bg-primary">Belum Lunas</span>',
			'PND' => '<span class="badge rounded-pill bg-info">Belum Dibayar</span>',
			'DNE' => '<span class="badge rounded-pill bg-success ">Selesai</span>',
			'CNL' => '<span class="badge rounded-pill bg-danger">Batal</span>',
			'ORD' => '<span class="badge rounded-pill bg-secondary">Order</span>',
		];
	}

	public function index()
	{
		$id_user 			= $this->session['User']['id_user'];
		$category 			= $this->Sales->order_by('order', 'asc')->getWhere('products_category', ['active' => 'Y'])->result();
		$transaction 		= $this->Sales->getWhere('transactions', ['status' => 'ORD', 'created_by' => $id_user])->row();
		$trans_details 		= $this->Sales->getWhere('view_trans_details', ['trans_id' => ($transaction) ? $transaction->id : ''])->result();
		$products 			= $this->db->order_by('name', 'ASC')->get_where('products', ['active' => 'Y', 'deleted_at' => null])->result();
		$product_details 	= $this->db->select('product_detail_id,products_detail_name,COUNT(product_detail_id) as counter')->from('view_trans_details')->group_by('product_detail_id')->order_by('counter', 'DESC')->limit(50)->get()->result();
		$this->template->set(
			[
				'title' 			=> 'Kasir',
				'products' 			=> $products,
				'category' 			=> $category,
				'product_details' 	=> $product_details,
				'transactions' 		=> $transaction,
				'trans_details' 	=> $trans_details,
				'status' 			=> $this->sts
			]
		);
		$this->template->render('index');
	}

	public function search()
	{
		$string 	= $this->input->post('string');
		// $code 		= $this->input->post('code');
		// $category_id = $this->Sales->getWhere('products_category', ['code' => $code])->row()->code;
		$result 	= $this->Sales->order_by('name', 'ASC')->getWhere('products_details', ['name LIKE' => '%' . $string . '%', 'active' => 'Y', 'deleted_at' => null])->result();
		echo json_encode($result);
	}

	public function list_product()
	{
		$where = [
			'active' => 'Y',
			'deleted_at' => null
		];

		if ($this->input->post('code')) {
			$code = $this->input->post('code');
			$where = [
				'category_id' => $code,
				'active' => 'Y',
				'deleted_at' => null
			];
		}
		$result 	= $this->Sales->order_by('name', 'ASC')->getWhere('products', $where)->result();
		echo json_encode($result);
	}

	public function load()
	{
		$id 				= $this->input->post('val');
		$type 				= $this->input->post('type');
		$dtlId = $id;
		if ($type == 'DTL') {
			$prodDtl = $this->db->get_where('products_details', ['id' => $id])->row();
			$id = $prodDtl->product_id;
		}

		$products   		= $this->Sales->getWhere('products', ['id' => $id])->row();
		$products_details  	= $this->Sales->getWhere('products_details', ['product_id' => $id, 'active' => 'Y', 'deleted_at' => null])->result();
		$finishing  		= $this->Sales->getWhere('finishings', ['product_id' => $id])->result();

		$this->template->set([
			'products' 			=> $products,
			'products_details' 	=> $products_details,
			'finishing' 		=> $finishing,
			'type' 				=> $type,
			'dtlId' 			=> $dtlId,
		]);

		$this->template->render('form1');
	}

	public function load_price()
	{
		$id 				= $this->input->post('id');
		$products_details 	= $this->Sales->getWhere('products_details', ['id' => $id])->row();
		$whPrice  			= $this->Sales->getWhere('wholesale_prices', ['product_detail_id' => $id])->result();

		$data = [
			'products_details' 	=> $products_details,
			'whPrice' 			=> $whPrice,
		];

		echo json_encode($data);
	}

	function wholesale_price()
	{
		$price 					= '';
		$whPrice 				= '';
		$product_id 			= $this->input->post('id');
		$qty 					= $this->input->post('qty');
		$size 					= $this->input->post('size');
		$products_details		= $this->Sales->getWhere('products_details', ['id' => $product_id])->row();
		$price 					= $products_details->unit_price;

		if ($products_details->flag_custom_size == 'Y' && $products_details->wholesaler == 'Y' && $products_details->based_price == 'UNIT' && $qty > 0) {
			$whPrice = $this->db->query("SELECT * FROM `wholesale_prices` WHERE `product_detail_id` = '$product_id' AND `qty_min` <= '$size' order by id desc limit 1")->row();
		} else if ($products_details->wholesaler == 'Y' && $qty > 0) {
			$whPrice = $this->db->query("SELECT * FROM `wholesale_prices` WHERE `product_detail_id` = '$product_id' AND `qty_min` <= '$qty' order by id desc limit 1")->row();
		}

		if ($whPrice) {
			$price = $whPrice->price;
		}

		$data = [
			'price' 			=> $price,
			'qty' 				=> $qty,
			'size' 				=> $size,
			'products_details' 	=> $products_details,
		];

		echo json_encode($data);
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
		if (!$this->shift) {
			$return = [
				'status' => 0,
				'msg' 	=> 'Shift belum aktif.',
			];
			echo json_encode($return);
			return false;
		}

		$data['shift'] 			= $this->shift->id;
		$data 			= $this->input->post();
		$autoNumber 	= $this->Sales->_autoNumber('transactions', 'TR');
		if ($data) {
			$data['id'] 	= ($data['id']) ? $data['id'] : $autoNumber;
			$data['date']   = date('Y-m-d H:i:s');
			$this->db->trans_begin();
			if ($this->input->post('id')) {
				$data['modified_by'] 	= $this->session['User']['id_user'];
				$data['modified_at'] 	= date('Y-m-d H:i:s');
				$this->db->update('transactions', $data, ['id' => $data['id']]);
			} else {
				$data['shift'] 			= $this->shift->id;
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

	public function save_products()
	{
		$data = $this->input->post();
		$this->save_detail($data);
	}

	public function save_detail()
	{
		try {
			$data 							= $this->input->post();
			$data['id'] 					= $this->Sales->_autoNumber('transactions_details', 'D');
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

				$summary = $this->db->select('sum(subtotal) as subtotal,sum(grand_total) as grand_total,sum(discount) as discount')
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
				$update_shift = $this->Sales->UpdateShift();
				if ($update_shift) {
					echo json_encode($update_shift);
					return false;
				}
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
			'shift'					=> $this->shift->id,
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
		$total_down_payment 		= $this->db->select('sum(payment_value) as payment')->from('payment_transactions')->where(['trans_id' => $data['trans_id'], 'payment_type' => 'DPE'])->get()->row()->payment;
		$paid_off 					= $this->db->select('sum(payment_value) as payment')->from('payment_transactions')->where(['trans_id' => $data['trans_id'], 'payment_type' => 'LNS'])->get()->row()->payment;
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
		$this->Sales->Cashflow($data);
		$this->Sales->UpdateShift();

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
		$data 			= $this->db->get_where('transactions', ['id' => $id])->row();
		$products 		= $this->db->order_by('name', 'asc')->get_where('products', ['active' => 'Y', 'deleted_at' => null])->result();
		$trans_details 	= $this->db->get_where('view_trans_details', ['trans_id' => (isset($id)) ? $id : ''])->result();
		$category 		= $this->Sales->order_by('order', 'asc')->getWhere('products_category', ['active' => 'Y'])->result();
		$id_user 		= $this->session['User']['id_user'];



		$this->template->set(
			[
				'title' 		=> 'Kasir',
				'products' 		=> $products,
				'transactions' 	=> $data,
				'category' 		=> $category,
				'status' 		=> $this->sts,
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

			$summary = $this->db->select('sum(subtotal) as subtotal,sum(grand_total) as grand_total,sum(discount) as discount')
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
			$this->Sales->UpdateShift();

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
			'OPN' => '<span class="badge rounded-pill bg-primary">Belum Lunas</span>',
			'PND' => '<span class="badge rounded-pill bg-info">Belum Dibayar</span>',
			'DNE' => '<span class="badge rounded-pill bg-success ">Selesai</span>',
			'CNL' => '<span class="badge rounded-pill bg-danger">Batal</span>',
		];

		$data           = $this->db->where(['deleted_at' => null, 'status !=' => 'ORD'])->order_by('FIELD(status, "PND","OPN","DNE","CNL")')->order_by('created_at', 'DESC')->get('transactions')->result();
		$users           = $this->Sales->getWhere('users', ['active' => 'Y'])->result();
		$dataUser = [];
		foreach ($users as $usr) {
			$dataUser[$usr->id_user] = $usr->username;
		}

		$this->template->set(
			[
				'sts'     => $sts,
				'users'   => $dataUser,
				'data'    => $data
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

		if ($id) {
			$detail = $this->db->get_where('transactions_details', ['trans_id' => $id])->num_rows();
			if ($detail > 0) {
				$Return = [
					'status' => 0,
					'msg' => 'Transaksi tidak bisa dihapus. Pastikan semua item sudah dihapus terlebih dahulu!!'
				];
			} else {
				$this->db->trans_begin();
				$this->db->delete('transactions', ['id' => $id]);

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$Return = [
						'status' 	=> 0,
						'msg' 		=> 'Transaksi gagal dihapus.',
					];
				} else {
					$this->db->trans_commit();
					$Return = [
						'status' 	=> 1,
						'msg' 		=> 'Transaksi berhasil dihapus.',
					];
				}
			}
		}

		echo json_encode($Return);
	}


	/* 03-30-2023 */

	public function print_bill($id = null)
	{
		if ($id) {
			$trans      =  $this->db->get_where('view_transactions', ['id' => $id])->row();
			$details    =  $this->db->get_where('view_trans_details', ['trans_id' => $id])->result();
			$payment    =  $this->db->get_where('view_payment_trans', ['trans_id' => $id])->result();

			$data = [
				'trans' 	=> $trans,
				'details' 	=> $details,
				'payment' 	=> $payment,
			];

			$this->load->view('print_bill', $data);
		} else {
			echo "Data tidak valid.";
			echo `<button type="button" class="btn btn-primary"></button>`;
		}
	}
}
