<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Hikmat
 * @copyright Copyright (c) 2022, Hikmat
 *
 * This is controller for Salary
 */

class Salary extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        // $this->load->model(array(
        //     'Aktifitas/aktifitas_model'
        // ));
        require_once 'vendor/autoload.php';
        $this->template->set('title', 'Data Gaji Karyawan');
        $this->template->page_icon('fa fa-table');

        date_default_timezone_set("Asia/Bangkok");
        $this->month_name = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    public function index()
    {
        $data       = $this->db->get_where('view_salary')->result();
        $avl_month  = $this->db->select('DISTINCT MONTH(date) as date')->group_by('date')->get_where('salary')->result();

        $this->template->set('avl_month', $avl_month);
        $this->template->set('data', $data);
        $this->template->set('month', $this->month_name);
        $this->template->render('index');
    }

    public function loadData($month = null)
    {
        if ($month) {
            $loadData = $this->db->get_where('view_salary', ['month' => str_pad($month, 2, '0', STR_PAD_LEFT), 'status !=' => 'DEL'])->result();
        } else {
            $loadData = $this->db->get_where('view_salary', ['status !=' => 'DEL'])->result();
        }

        $this->template->set(['loadData' => $loadData]);
        $this->template->render('loadData');
    }

    //Create New Customer
    public function add_new_salary()
    {
        $employees  = $this->db->get_where('employees', ['status' => 'ACTIVE'])->result();

        $Data = [
            'employees' => $employees
        ];
        $this->template->set($Data);
        $this->template->render('form');
    }

    public function load_employee($id_emp = null)
    {
        $Data = [];
        if ($id_emp) {
            $employee   = $this->db->get_where('view_employees', ['id' => $id_emp])->row();
            $kasbon     = $this->db->get_where('summary_kasbon', ['employee_id' => $id_emp])->row();
            $dt_kasbon  = $this->db->select('*, SUM(cash_value) as total_value')->group_by('MONTH(date)')->get_where('view_cash_receipt', ['employee_id' => $id_emp])->result();
            $days_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $Data = [
                'days_month'   => $days_month,
                'month_name'      => $this->month_name,
                'employee'  => $employee,
                'dt_kasbon' => $dt_kasbon,
                'kasbon'    => $kasbon,
            ];
        }

        $this->template->set($Data);
        $this->template->render('detail_salary');
    }

    public function edit($id = null)
    {
        $Data = [];

        if ($id) {
            $salary     = $this->db->get_where('salary', ['id' => $id])->row();
            $employee   = $this->db->get_where('view_employees', ['id' => $salary->employee_id])->row();
            $dt_kasbon  = $this->db->select('*, SUM(cash_value) as total_value')->group_by('MONTH(date)')->get_where('view_cash_receipt', ['employee_id' => $salary->employee_id])->result();
            $days_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $pay_debt = $this->db->get_where('payment_debt', ['reference' => $id])->row();

            $Data = [
                'salary'        => $salary,
                'days_month'    => $days_month,
                'month_name'    => $this->month_name,
                'employee'      => $employee,
                'dt_kasbon'     => $dt_kasbon,
                'pay_debt'      => $pay_debt,
            ];
        }

        $this->template->set($Data);
        $this->template->render('edit');
    }

    private function _getId()
    {
        $y      = date('Y');
        $count  = 1;
        $sql    = "SELECT MAX(RIGHT(id,4)) as max_id from salary where YEAR(date) = '$y'";
        $max    = $this->db->query($sql)->row();

        if ($max->max_id) {
            $count = $max->max_id + 1;
        }
        $new_id = 'SAL-' . $y . str_pad($count, 4, '0', STR_PAD_LEFT);

        return $new_id;
    }

    private function _getIdPayDebt($table, $str = null)
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

    public function save_salary()
    {
        $data = $this->input->post();
        $this->db->trans_begin();
        $ArrData = [
            'employee_id'        => $data['employee_id'],
            'date'               => $data['date'],
            'month'              => date('m'),
            'sdate'              => $data['sdate'],
            'edate'              => $data['edate'],
            'month_name'         => $this->month_name[date('m')],
            'year'               => date_format(date_create($data['date']), "Y"),
            'days_month'         => $data['days_month'],
            'leave_allowance'    => $data['leave_allowance'],
            'actual_leave'       => $data['actual_leave'],
            'not_pay_day'        => $data['not_pay_day'],
            'monthly_salary'     => str_replace(',', '', $data['monthly_salary']),
            'dayli_salary'       => str_replace(',', '', $data['dayli_salary']),
            'work_days'          => $data['work_days'],
            'cut_salary'         => str_replace(',', '', $data['cut_salary']),
            'total_salary'       => str_replace(',', '', $data['total_salary']),
            'last_month_kasbon'  => str_replace(',', '', $data['total_ksb']),
            'pay_debt'           => str_replace(',', '', $data['pay_bon']),
            'remain_kasbon'      => str_replace(',', '', $data['total_ksb']) - (($data['pay_bon']) ? str_replace(',', '', $data['pay_bon']) : 0),
            'bonus'              => str_replace(',', '', $data['bonus']),
            'take_home_pay'      => str_replace(',', '', $data['thp_salary']),
        ];

        $pay_debt = [
            'id'                 => isset($data['debt_id']) ? $data['debt_id'] : '',
            'employee_id'        => $data['employee_id'],
            'date'               => date('Y-m-d :H:i:s'),
            'pay_debt'           => str_replace(',', '', $data['pay_bon']),
        ];


        if (isset($data['id'])) {
            $ArrData['id']      = $data['id'];
            $ArrData['modified_by'] = $this->auth->user_id();
            $ArrData['modified_at'] = date('Y-m-d H:i:s');
            $this->db->update('salary', $ArrData, ['id' => $data['id']]);
            if ($data['pay_bon']) {
                $pay_debt['reference'] = $ArrData['id'];
                $this->_payment_debt($pay_debt);
            }
        } else {
            $ArrData['id'] = $this->_getId();
            $ArrData['created_by'] = $this->auth->user_id();
            $ArrData['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('salary', $ArrData);

            if ($data['pay_bon']) {
                $pay_debt['reference'] = $ArrData['id'];
                $this->_payment_debt($pay_debt);
            }
        }


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $Arr_Return        = array(
                'status'        => 0,
                'pesan'            => 'Save Process Failed. Please Try Again...'
            );
        } else {
            $this->db->trans_commit();
            $Arr_Return        = array(
                'status'        => 1,
                'pesan'         => 'Save Process Success.',
                'salary_id'     => $ArrData['id']
            );
        }
        $this->db->trans_complete();
        echo json_encode($Arr_Return);
    }

    //Edit Perusahaan
    public function salary_detail($id)
    {
        $m = date("m"); // Month value
        $de = date("d"); // Today's date
        $y = date("Y"); // Year value

        $last_month =  date('n', mktime(0, 0, 0, ($m - 1), ($de), $y));

        $mpdf = new \Mpdf\Mpdf();
        $salary = $this->db->get_where('view_salary', ['id' => $id])->row();
        $kasbon     = $this->db->get_where('summary_kasbon', ['employee_id' => $salary->employee_id])->row();
        $dt_kasbon  = $this->db->select('*, SUM(cash_value) as total_value')->get_where('view_cash_receipt', ['employee_id' => $salary->employee_id, 'MONTH(date)' => $last_month])->row();
        $current_kasbon  = $this->db->select('*, SUM(cash_value) as total_value')->get_where('view_cash_receipt', ['employee_id' => $salary->employee_id, 'MONTH(date)' => date('n')])->row();
        $pay_debt = $this->db->get_where('payment_debt', ['reference' => $id])->row();

        $Data = [
            'salary' => $salary,
            'kasbon' => $kasbon,
            'current_kasbon' => $current_kasbon,
            'dt_kasbon' => $dt_kasbon,
            'pay_debt' => $pay_debt,

        ];

        $this->template->set($Data);
        $show =  $this->template->load_view('print');

        $mpdf->WriteHTML($show);
        $mpdf->Output();
    }


    public function detail($id)
    {
        $salary = $this->db->get_where('view_salary', ['id' => $id])->row();
        $kasbon     = $this->db->get_where('summary_kasbon', ['employee_id' => $salary->employee_id])->row();
        $dt_kasbon  = $this->db->select('*, SUM(cash_value) as total_value')->group_by('MONTH(date)')->get_where('view_cash_receipt', ['employee_id' => $salary->employee_id])->row();
        $pay_debt = $this->db->get_where('payment_debt', ['reference' => $id])->row();

        $Data = [
            'salary' => $salary,
            'kasbon' => $kasbon,
            'dt_kasbon' => $dt_kasbon,
            'pay_debt' => $pay_debt,
        ];

        $this->template->set($Data);
        $this->template->render('detail');
    }


    private function _payment_debt($data)
    {
        $data['payment_value'] = str_replace(",", "", $data['pay_debt']);
        unset($data['pay_debt']);

        if ($data) {
            $this->db->trans_begin();
            if ($data['id']) {
                $data['modified_by'] = $this->auth->user_id();
                $data['modified_at'] = date('Y-m-d H:i:s');
                $this->db->update('payment_debt', $data, ['id' => $data['id']]);
            } else {
                $data['id'] = $this->_getIdPayDebt('payment_debt', 'P');
                $data['created_by'] = $this->auth->user_id();
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('payment_debt', $data);
            }
        }
    }

    public function receive_salary()
    {
        $data = $this->input->post();
        if ($data) {

            $this->db->trans_begin();
            $this->db->update('salary', ['status' => 'PAY'], ['id' => $data['id']]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'     => 'Data Gaji Gagal diupdate. Silahkan coba saat lagi!'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'     => 'Data Gaji berhasil diupdate!'
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
