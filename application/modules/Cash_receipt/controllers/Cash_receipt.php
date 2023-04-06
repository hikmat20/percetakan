<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunaz
 * @copyright Copyright (c) 2018, Yunaz
 *
 * This is controller for Cabang
 */

class Cash_receipt extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Aktifitas/aktifitas_model'
        ));
        $this->template->set('title', 'Data Kasbon');
        $this->template->page_icon('fa fa-list-ul');
        date_default_timezone_set("Asia/Bangkok");
    }

    private function _getId($table, $str = null)
    {
        $count  = 0;
        $lstr   = strlen($str);
        $y      = date('Y');
        $m      = date('m');
        $sql    = "SELECT MAX(RIGHT(id,3)) as maxId FROM $table where YEAR(date) = $y and MONTH(created_at)=$m";
        $result = $this->db->query($sql)->row()->maxId;
        if ($result) {
            $count = $result + 1;
        }
        $newId = $str . $y . $m . "-" . str_pad($count, '3', "0", STR_PAD_LEFT);
        return $newId;
    }

    private function _load($id = null)
    {
        $employees       = $this->db->get_where('employees', ['status' => 'ACTIVE'])->result();
        $dataKasbon      = $this->db->get_where('view_cash_receipt', ['id' => $id])->row();
        $Data = [
            'employees' => $employees,
            'cash_receipt' => $dataKasbon,
        ];
        return $Data;
    }

    public function index()
    {
        $sts = [
            'N' => '<span class="badge rounded-pill bg-danger">Non Aktif</span>',
            'Y' => '<span class="badge rounded-pill bg-success">Aktif</span>',
        ];

        $data       = $this->db->order_by('cash_value', 'DESC')->get_where('view_summary_kasbon')->result();
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

    public function add()
    {
        $Data           = $this->_load();
        $Data['title']  = 'Input Kasbon';

        $this->template->set($Data);
        $this->template->render('form');
    }

    public function edit($id)
    {
        $Data           = $this->_load($id);
        $Data['title']  = 'Ubah Kasbon';

        $this->template->set($Data);
        $this->template->render('form');
    }

    public function view()
    {
        $data           = $this->input->post();
        $cashReceipt    = $this->db->get_where('view_summary_kasbon', ['id' => $data['id']])->row();
        $dataKasbon     = $this->db->get_where('view_cash_receipt', ['employee_id' => $data['id']])->result();
        $payment        = $this->db->get_where('payment_debt', ['employee_id' => $data['id']])->result();


        $Data = [
            'modal_title'   => 'Rincian Kasbon',
            'cashReceipt'   => $cashReceipt,
            'dataKasbon'    => $dataKasbon,
            'payment'       => $payment,
        ];

        $this->template->set($Data);
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

    public function save()
    {
        $data               = $this->input->post();
        $data['cash_value'] = str_replace(",", "", $data['cash_value']);

        // $cek = $this->db->get_where('cash_receipt', ['employee_id' => $data['employee_id']])->num_rows();
        // if ($cek > 0) {
        //     $return = [
        //         'status' => 0,
        //         'msg'     => 'Data Kasbon karyawan sudah terdaftar, silahkan lihat ke data kasbon.'
        //     ];
        //     echo json_encode($return);
        //     return false;
        // }

        if ($data) {
            $this->db->trans_begin();
            if ($data['id']) {
                $data['modified_by'] = $this->auth->user_id();
                $data['modified_at'] = date('Y-m-d H:i:s');
                $this->db->update('cash_receipt', $data, ['id' => $data['id']]);
            } else {
                $data['id'] = $this->_getId('cash_receipt', 'C');
                $data['created_by'] = $this->auth->user_id();
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('cash_receipt', $data);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'     => 'Data Kasbon Gagal disimpan. Silahkan coba saat lagi!'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'     => 'Data Kasbon berhasil disimpan!'
                ];
            }
        } else {
            $return = [
                'status' => 0,
                'msg'     => 'Data tidak valid.'
            ];
        }

        echo json_encode($return);
    }

    public function payment_debt()
    {
        $id             = $this->input->post('id');
        $cashReceipt    = $this->db->get_where('view_summary_kasbon', ['id' => $id])->row();
        $this->template->set(['cashReceipt' => $cashReceipt]);
        $this->template->render('payment_debt');
    }

    public function save_payment()
    {
        $data               = $this->input->post();
        $data['payment_value'] = str_replace(",", "", $data['payment_value']);

        // if ($data['type'] == 'OUT') {
        //     $cashflow['in_value'] = str_replace(str_split(',.'), "", $data['cash_value']);
        // } else {
        //     $cashflow['out_value'] = str_replace(str_split(',.'), "", $data['cash_value']);
        // }
        // unset($data['cash_value']);
        // $this->db->trans_begin();
        if ($data) {
            $this->db->trans_begin();
            // $this->db->insert('cashflow', $cashflow);
            if ($data['id']) {
                $data['modified_by'] = $this->auth->user_id();
                $data['modified_at'] = date('Y-m-d H:i:s');
                $this->db->update('payment_debt', $data, ['id' => $data['id']]);
            } else {
                $data['id'] = $this->_getId('payment_debt', 'P');
                $data['created_by'] = $this->auth->user_id();
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('payment_debt', $data);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'     => 'Data Kasbon Gagal disimpan. Silahkan coba saat lagi!'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'     => 'Data Kasbon berhasil disimpan!'
                ];
            }
        } else {
            $return = [
                'status' => 0,
                'msg'     => 'Data tidak valid.'
            ];
        }

        echo json_encode($return);
    }

    public function detail($id = null)
    {
        if ($id) {
            $employee       = $this->db->get_where('view_employees', ['id' => $id])->row();
            $cashReceipt    = $this->db->get_where('view_summary_kasbon', ['id' => $id])->row();
            $dataKasbon     = $this->db->get_where('view_cash_receipt', ['employee_id' => $id])->result();
            $payment        = $this->db->get_where('payment_debt', ['employee_id' => $id])->result();

            $Data = [
                'modal_title'   => 'Rincian Kasbon',
                'employee'    => $employee,
                'position_name' => $employee->position_name,
                'dataKasbon'    => $dataKasbon,
                'payment'       => $payment,
                'cashReceipt'   => $cashReceipt,
            ];
        }

        $this->template->set($Data);
        $this->template->render('detail');
    }


    public function delete_debt()
    {
        $data = $this->input->post();
        if ($data) {

            $this->db->trans_begin();
            $this->db->delete('cash_receipt', ['id' => $data['id']]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'     => 'Data Kasbon Gagal dihapus. Silahkan coba saat lagi!'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'     => 'Data Kasbon berhasil dihapus!'
                ];
            }
        } else {
            $return = [
                'status' => 0,
                'msg'     => 'Data tidak valid.'
            ];
        }
        echo json_encode($return);
    }

    public function del_payment()
    {
        $data = $this->input->post();
        $this->db->trans_begin();
        if ($data) {

            $this->db->delete('payment_debt', ['id' => $data['id']]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'     => 'Data Kasbon Gagal disimpan. Silahkan coba saat lagi!'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'     => 'Data Kasbon berhasil disimpan!'
                ];
            }
        } else {
            $return = [
                'status' => 0,
                'msg'     => 'Data tidak valid.'
            ];
        }
        echo json_encode($return);
    }
}
