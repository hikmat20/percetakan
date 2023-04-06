<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2021, Syamsudin
 *
 * This is controller for Perusahaan
 */

class Reports extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'Reports/Perusahaan_model',
            'Aktifitas/aktifitas_model'
        ));
        require_once 'vendor/autoload.php';
        $this->template->set('title', 'Laporan');
        $this->template->page_icon('fa fa-table');
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

        $data = $this->db->get_where('menus', ['parent_id' => 10])->result();
        $this->template->set('results', $data);

        // $this->template->render();
        redirect('/');
    }


    public function keuangan()
    {
        $this->db->get_where('cashflow', ['status' => 'CLOSE'])->result();
        $this->template->set('title', 'Laporan Keuangan');
        $this->template->render('keuangan');
    }

    public function shift($sDate = null, $eDate = null)
    {
        $shift = $this->db->get_where('view_shift', ["MONTH(date)" => date('m'), 'status' => 'CLS'])->result();
        if ($sDate && $eDate) {
            $sDate = str_replace('-', '/', $sDate);
            $eDate = str_replace('-', '/', $eDate);
            $sDate_formated = date("Y-m-d", strtotime($sDate));
            $eDate_formated = date("Y-m-d", strtotime($eDate));
            $shift = $this->db->get_where('view_shift', ['date >=' => $sDate_formated, 'date <=' => $eDate_formated, 'status' => 'CLS'])->result();
            $html = "";
            $n = 0;
            if ($shift) {
                foreach ($shift as $r) : $n++;
                    $html .= '
                    <tr>
                        <th scope="row">' . $n . '</th>
                        <td>' . $r->date . '</td>
                        <td class="text-center">' . $r->full_name . '</td>
                        <td class="text-center">' . $r->start_shift . '</td>
                        <td class="text-center">' . $r->end_shift . '</td>
                        <td class="text-center">' . $r->ending_by . '</td>
                        <td class="text-end">' . number_format($r->expected_ending_balance) . '</td>
                        <td class="text-end">' . number_format($r->ending_balance) . '</td>
                        <td class="text-end">' . number_format($r->actual_ending_balance) . '</td>
                        <td class="text-center"><button type="button" data-id="' . $r->id . '" class="btn btn-light-secondary btn-icon btn-xs show_data"><i class="fa fa-eye"></i></button></td>
                    </tr>';
                endforeach;
            } else {
                $html = "<tr>
                <td colspan='10' class='text-center'>Data tidak tersedia</td>
                </tr>";
            }
            echo $html;
            return false;
        }

        $data = [
            'records' => $shift,
        ];

        $this->template->set($data);
        $this->template->render('report_shift');
    }

    public function closing_report()
    {
        $date = $this->input->post('date');

        $data = $this->db->group_by('closing_date')->get_where('view_cashflow', ['date' => $date, 'status' => 'CLOSE'])->result();
        $this->template->set([
            'date' => $date,
            'data' => $data
        ]);
        $this->template->render('report_closing');
    }

    public function show_data_shift($id)
    {
        $data_shift = $this->db->get_where('view_shift', ['id' => $id])->row();
        $this->template->set(['shift' => $data_shift]);
        $this->template->render('show_report_shift');
    }

    //Save customer ajax
    public function report_transactions($sDate = null, $eDate = null)
    {
        $trans          = $this->db->get_where('view_transactions', ['MONTH(date)' => date('m')])->result();
        $countTrans     = $this->db->get_where('view_transactions', ['MONTH(date)' => date('m')])->num_rows();
        $sumTrans       = $this->db->select('sum(grand_total) as sumTrans')->get_where('view_transactions', ['MONTH(date)' => date('m')])->row()->sumTrans;
        $countProduct   = $this->db->select('count(id) as countProduct')->get_where('view_trans_details', ['MONTH(date)' => date('m')])->row()->countProduct;

        foreach ($trans as $key => $value) {
            $transdata[$value->date][$key] = $value;
        }

        if ($sDate && $eDate) {
            $sDate          = str_replace('-', '/', $sDate);
            $eDate          = str_replace('-', '/', $eDate);
            $sDate_formated = date("Y-m-d", strtotime($sDate));
            $eDate_formated = date("Y-m-d", strtotime($eDate));
            $trans          = $this->db->get_where('view_transactions', ['date >=' => $sDate_formated, 'date <=' => $eDate_formated])->result();
            $countTrans     = $this->db->get_where('view_transactions', ['date >=' => $sDate_formated, 'date <=' => $eDate_formated])->num_rows();
            $sumTrans       = $this->db->select('sum(grand_total) as sumTrans')->get_where('view_transactions', ['date >=' => $sDate_formated, 'date <=' => $eDate_formated])->row()->sumTrans;
            $countProduct   = $this->db->select('count(id) as countProduct')->get_where('view_trans_details', ['date >=' => $sDate_formated, 'date <=' => $eDate_formated])->row()->countProduct;
            $Data = [
                'trans'         => $trans,
                'countTrans'    => $countTrans,
                'sumTrans'      => $sumTrans,
                'countProduct'  => $countProduct,
            ];

            $this->template->set($Data);
            $this->template->render('load_report_transactions');
            return false;
        }

        $Data = [
            'trans'         => $trans,
            'countTrans'    => $countTrans,
            'sumTrans'      => $sumTrans,
            'countProduct'  => $countProduct,
        ];

        $this->template->set($Data);
        $this->template->render('report_transactions');
    }

    function dtl_trans($id = null)
    {
        $header = $this->db->get_where('view_transactions', ['id' => $id])->row();
        $detail = $this->db->get_where('view_trans_details', ['trans_id' => $id])->result();

        $Data = [
            'sts' => $this->sts,
            'header' => $header,
            'detail' => $detail,
        ];

        $this->template->set($Data);
        $this->template->render('dtl_trans');
    }

    function report_sales($sDate = null, $eDate = null)
    {
        // summary sales
        $total_sum  = 0;

        $where_date = [
            'MONTH(date)' => date('m')
        ];
        $where_pay_date = [
            'MONTH(payment_date)' => date('m')
        ];

        if ($sDate && $eDate) {

            $sDate          = str_replace('-', '/', $sDate);
            $eDate          = str_replace('-', '/', $eDate);
            $sDate_formated = date("Y-m-d", strtotime($sDate));
            $eDate_formated = date("Y-m-d", strtotime($eDate));

            $where_date = [
                'date >=' => $sDate_formated,
                'date <=' => $eDate_formated
            ];
            $where_pay_date = [
                'payment_date >=' => $sDate_formated,
                'payment_date <=' => $eDate_formated
            ];
        }

        $sum_sales  = $this->db->select('SUM(grand_total) as total')->get_where('view_transactions', $where_date)->row()->total;
        $discount   = $this->db->select('SUM(discount) as discount')->get_where('view_transactions', $where_date)->row()->discount;
        $cash_in    = $this->db->select('SUM(in_value) as in_value')->get_where('cashflow', $where_date)->row()->in_value;
        $cash_out   = $this->db->select('SUM(out_value) as out_value')->get_where('cashflow', $where_date)->row()->out_value;
        $total_sum  = ($sum_sales - $discount) + ($cash_in - $cash_out);
        $sum_pay_cash   = $this->db->select('SUM(payment_value) as payment')->where(['payment_methode' => 'CSH'])->get_where('payment_transactions', $where_pay_date)->row()->payment;
        $sum_pay_trf    = $this->db->select('SUM(payment_value) as payment')->where(['payment_methode' => 'TRF'])->get_where('payment_transactions', $where_pay_date)->row()->payment;
        $total_payment  = $sum_pay_cash + $sum_pay_trf;

        $sales_product    = $this->db->select('product_detail_name,SUM(qty) as qty,unit,COUNT(product_detail_id) as count_product,SUM(discount) as discount,SUM(grand_total) as grand_total,date')
            ->from('view_detail_transactions')
            ->where($where_date)
            ->order_by('qty', 'DESC')
            ->group_by('product_detail_id')->get()->result();

        $discount_product    = $this->db->select('product_detail_id,product_detail_name,COUNT(product_detail_id) as count_product,SUM(discount) as discount')
            ->from('view_detail_transactions')
            ->where($where_date)
            ->where(['discount >' => 0])
            ->order_by('count_product', 'DESC')
            ->group_by('product_detail_id')->get()->result();

        $Data = [
            'sts'       => $this->sts,
            'sum_sales' => $sum_sales,
            'discount'  => $discount,
            'cash_in'   => $cash_in,
            'cash_out'  => $cash_out,
            'total_sum'  => $total_sum,

            'sum_pay_cash'      => $sum_pay_cash,
            'sum_pay_trf'       => $sum_pay_trf,
            'total_payment'     => $total_payment,

            'sales_product'     => $sales_product,
            'discount_product'     => $discount_product,


        ];

        $this->template->set($Data);
        $this->template->render('report_sales');
    }

    public function printSummary($sDate = null, $eDate = null, $type = null)
    {
        $mpdf = new \Mpdf\Mpdf();

        $total_sum  = 0;
        $periode = date('F Y');
        $where_date = [
            'MONTH(date)' => date('m')
        ];
        $where_pay_date = [
            'MONTH(payment_date)' => date('m')
        ];

        if ($sDate && $eDate) {
            $periode        = $sDate . " s/d " . $eDate;
            $sDate          = str_replace('-', '/', $sDate);
            $eDate          = str_replace('-', '/', $eDate);
            $sDate_formated = date("Y-m-d", strtotime($sDate));
            $eDate_formated = date("Y-m-d", strtotime($eDate));

            $where_date = [
                'date >=' => $sDate_formated,
                'date <=' => $eDate_formated
            ];
            $where_pay_date = [
                'payment_date >=' => $sDate_formated,
                'payment_date <=' => $eDate_formated
            ];
        }

        $sum_sales  = $this->db->select('SUM(grand_total) as total')->get_where('view_transactions', $where_date)->row()->total;
        $discount   = $this->db->select('SUM(discount) as discount')->get_where('view_transactions', $where_date)->row()->discount;
        $cash_in    = $this->db->select('SUM(in_value) as in_value')->get_where('cashflow', $where_date)->row()->in_value;
        $cash_out   = $this->db->select('SUM(out_value) as out_value')->get_where('cashflow', $where_date)->row()->out_value;
        $total_sum  = ($sum_sales - $discount) + ($cash_in - $cash_out);
        $sum_pay_cash   = $this->db->select('SUM(payment_value) as payment')->where(['payment_methode' => 'CSH'])->get_where('payment_transactions', $where_pay_date)->row()->payment;
        $sum_pay_trf    = $this->db->select('SUM(payment_value) as payment')->where(['payment_methode' => 'TRF'])->get_where('payment_transactions', $where_pay_date)->row()->payment;
        $total_payment  = $sum_pay_cash + $sum_pay_trf;

        $sales_product    = $this->db->select('product_detail_name,SUM(qty) as qty,unit,COUNT(product_detail_id) as count_product,SUM(discount) as discount,SUM(grand_total) as grand_total,date')
            ->from('view_detail_transactions')
            ->where($where_date)
            ->order_by('qty', 'DESC')
            ->group_by('product_detail_id')->get()->result();

        $discount_product    = $this->db->select('product_detail_id,product_detail_name,COUNT(product_detail_id) as count_product,SUM(discount) as discount')
            ->from('view_detail_transactions')
            ->where($where_date)
            ->where(['discount >' => 0])
            ->order_by('count_product', 'DESC')
            ->group_by('product_detail_id')->get()->result();

        $Data = [
            'sts'       => $this->sts,
            'periode'   => $periode,
            'sum_sales' => $sum_sales,
            'discount'  => $discount,
            'cash_in'   => $cash_in,
            'cash_out'  => $cash_out,
            'total_sum'  => $total_sum,

            'sum_pay_cash'      => $sum_pay_cash,
            'sum_pay_trf'       => $sum_pay_trf,
            'total_payment'     => $total_payment,

            'sales_product'     => $sales_product,
            'discount_product'     => $discount_product,
        ];


        $this->template->set($Data);
        $show =  $this->template->load_view('print_reports');

        $mpdf->WriteHTML($show);
        $mpdf->Output();
    }

    public function report_sales_employee()
    {
        $users  = $this->db->get_where('users', ['active' => 'Y', 'id_user !=' => '1', 'id_user !=' => '2'])->result();
        $this->template->set(['users' => $users]);
        $this->template->render('report_sales_employee');
    }

    public function printReport($sDate = null, $eDate = null, $user = null)
    {
        $mpdf = new \Mpdf\Mpdf();

        if ($sDate && $eDate) {
            $periode        = $sDate . " s/d " . $eDate;
            $sDate          = str_replace('-', '/', $sDate);
            $eDate          = str_replace('-', '/', $eDate);
            $sDate_formated = date("Y-m-d", strtotime($sDate));
            $eDate_formated = date("Y-m-d", strtotime($eDate));

            $condition = [
                'date >=' => $sDate_formated,
                'date <=' => $eDate_formated,
            ];

            if ($user) {
                $condition['created_by'] = $user;
            }
        }
        $userCondition = [
            'active' => 'Y'
        ];

        if ($user) {
            $userCondition['id_user'] = $user;
        }

        $users = $this->db->get_where('users', $userCondition)->result();
        $users = array_values($users);

        $transaction  = $this->db->get_where('view_transactions', $condition)->result();
        $full_name = $this->db->get_where('users', ['id_user' => $user])->row()->full_name;
        $Data = [
            'sts'           => $this->sts,
            'full_name'     => $full_name,
            'periode'       => $periode,
            'transactions'  => $transaction,
        ];

        $this->template->set($Data);
        $show =  $this->template->load_view('print_reports_employee');

        $mpdf->WriteHTML($show);
        $mpdf->Output();
    }
}
