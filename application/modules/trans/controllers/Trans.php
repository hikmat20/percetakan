<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunaz
 * @copyright Copyright (c) 2018, Yunaz
 *
 * This is controller for Cabang
 */

class Trans extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'Aktifitas/aktifitas_model'
        ));
        $this->template->set('title', 'Data Transaksi');
        $this->template->page_icon('fa fa-table');

        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $sts = [
            'OPN' => '<span class="badge rounded-pill bg-primary">Belum Lunas</span>',
            'PND' => '<span class="badge rounded-pill bg-info">Belum Dibayar</span>',
            'DNE' => '<span class="badge rounded-pill bg-success">Selesai</span>',
            'CNL' => '<span class="badge rounded-pill bg-danger">Batal</span>',
        ];
        $data           = $this->db->where(['deleted_at' => null, 'status !=' => 'ORD'])->order_by('FIELD(status, "PND","OPN","DNE","CNL")')->get('transactions')->result();
        $users      = $this->db->get_where('users')->result();
        $listUser   = [];
        foreach ($users as $usr) {
            $listUser[$usr->id_user] = $usr->username;
        }

        $this->template->set(
            [
                'sts'           => $sts,
                'data'          => $data,
                'usr'           => $listUser
            ]
        );

        $this->template->render('index');
    }

    public function view()
    {
        $id                 = $this->input->post('id');
        $data               = $this->db->get_where('transactions', ['id' => $id])->row();
        $trans_details      = $this->db->get_where('view_trans_details', ['trans_id' => (isset($id)) ? $id : ''])->result();
        $payment            = $this->db->get_where('view_payment_trans', ['trans_id' => (isset($id)) ? $id : ''])->result();

        $this->template->set(
            [
                'title'         => 'Kasir',
                'transactions'  => $data,
                'payment'       => $payment,
                'trans_details' => $trans_details
            ]
        );

        $this->template->render('view');
    }

    public function cancel()
    {
        $id                 = $this->input->post('id');
        if ($id) {
            $this->db->trans_begin();
            $this->db->update('transactions', ['status' => 'CNL'], ['id' => $id]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg' => 'Transaksi Gagal dibatalkan.'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg' => 'Transaksi Berhasil dibatalkan.'
                ];
            }
        }
        echo json_encode($return);
    }

    public function print_spk($id = null)
    {
        if ($id) {
            $data               = $this->db->get_where('view_transactions', ['id' => $id])->row();
            $trans_details      = $this->db->get_where('view_trans_details', ['trans_id' => $id, 'product_name like' => '%spanduk%'])->result();
            $payment            = $this->db->get_where('view_payment_trans', ['trans_id' => $id])->result();

            $data =                 [
                'title'         => 'Kasir',
                'transactions'  => $data,
                'payment'       => $payment,
                'trans_details' => $trans_details
            ];

            $this->load->view('spk', $data);
        } else {
            echo "Data transaksi tidak ditemukan";
        }
    }
}
