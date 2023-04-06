<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Hikmat
 * @copyright Copyright (c) 2022, Hikmat AR
 *
 * This is controller for Meal_allowance
 */

class Employees extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Aktifitas/aktifitas_model'
        ));
        $this->template->set('title', 'Data Karyawan');
        $this->template->page_icon('fa fa-list-ul');
        date_default_timezone_set("Asia/Bangkok");
    }

    private function _getId($table, $str = null)
    {
        $count  = 0;
        $lstr   = strlen($str);
        $sql    = "SELECT MAX(RIGHT(id,3)) as maxId FROM $table";
        $result = $this->db->query($sql)->row()->maxId;
        if ($result) {
            $count = $result + 1;
        }
        $newId = $str . str_pad($count, '3', "0", STR_PAD_LEFT);
        return $newId;
    }

    private function _load($id = null)
    {
        $positions       = $this->db->get_where('position')->result();
        $Data = [
            'positions' => $positions
        ];
        if ($id) {
            $Data['employee']       = $this->db->get_where('view_employees', ['id' => $id])->row();
        }
        return $Data;
    }

    public function index()
    {
        $sts = [
            'RESIGN' => '<span class="badge rounded-pill bg-danger">Resign</span>',
            'ACTIVE' => '<span class="badge rounded-pill bg-success">Aktif</span>',
        ];

        $data       = $this->db->order_by('status', 'ASC')->get_where('view_employees')->result();

        $this->template->set(
            [
                'sts'           => $sts,
                'data'          => $data,
            ]
        );

        $this->template->render('index');
    }

    public function add()
    {
        $Data           = $this->_load();
        $Data['title']  = 'Input Karyawan';

        $this->template->set($Data);
        $this->template->render('form');
    }

    public function edit($id)
    {
        $Data           = $this->_load($id);
        $Data['title']  = 'Edit Karyawan';

        $this->template->set($Data);;
        $this->template->render('form');
    }

    public function show()
    {
        $date           = $this->input->post('date');
        $data    = $this->db->get_where('view_meal_allowance', ['date' => $date])->result();
        $n = 0;
        $html = '';

        $html .= '<table class="table table- datatable table-sm" id="meal_allowance">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal</th>
                        <th class="text-end">Jumlah Uang Makan</th>
                        <th width="150" class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($data as $cr) :
            $n++;
            $html .= '<tr>
                    <td>' . $n . '</td>
                    <td>' . $cr->employee_name . '</td>
                    <td>' . ($cr->date) . '</td>
                    <td class="text-end text-primary">' . number_format($cr->total_value) . '</td>
                    <td class="text-center">
                        <a href="' . base_url('meal_allowance/edit/') . $cr->id . '" class="btn btn-light text-warning btn-icon btn-sm"><i class="fa fa-edit"></i></a>
                        <button type="button" title="Hapus" class="btn btn-light text-danger btn-icon btn-sm delete" onclick="del(<?= $cr->id; ?>)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>';
        endforeach;
        $html .= '<tbody>
        </table>';

        echo $html;
    }

    public function delete()
    {
        $id                 = $this->input->post('id');
        if ($id) {
            $this->db->trans_begin();
            $this->db->delete('meal_allowance', ['id' => $id]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg' => 'Data Uang Makan Gagal dihapus.'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg' => 'Data Uang Makan Berhasil dihapus.'
                ];
            }
        } else {
            $return = [
                'status' => 0,
                'msg' => 'Data Uang Makan tidak valid.'
            ];
        }
        echo json_encode($return);
    }

    public function resign()
    {
        $id                 = $this->input->post('id');
        if ($id) {
            $this->db->trans_begin();
            $this->db->update('employees', ['status' => 'RESIGN'], ['id' => $id]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg' => 'Data Karyawan Gagal resign.'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg' => 'Data Karyawan Berhasil resign.'
                ];
            }
        } else {
            $return = [
                'status' => 0,
                'msg' => 'Data Karyawan tidak valid.'
            ];
        }
        echo json_encode($return);
    }

    public function save()
    {
        $data                   = $this->input->post();
        if ($data) {
            $this->db->trans_begin();
            if ($data['id']) {
                $data['monthly_salary'] = str_replace(',', '', $data['monthly_salary']);
                $data['modified_by'] = $this->auth->user_id();
                $data['modified_at'] = date('Y-m-d H:i:s');
                $this->db->update('employees', $data, ['id' => $data['id']]);
            } else {
                $data['monthly_salary'] = str_replace(',', '', $data['monthly_salary']);
                $data['id'] = $this->_getId('employees', 'EMP');
                $data['created_by'] = $this->auth->user_id();
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('employees', $data);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'     => 'Data Karyawan Gagal disimpan. Silahkan coba lagi!'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'     => 'Data Karyawan berhasil disimpan!'
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
