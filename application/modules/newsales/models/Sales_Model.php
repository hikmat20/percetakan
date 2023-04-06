<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunas Handra
 * @copyright Copyright (c) 2018, Yunas Handra
 *
 * This is model class for table "Customer"
 */

class Sales_Model extends BF_Model
{

    /**
     * @var string  User Table Name
     */
    protected $table_name = 'transactions';
    protected $key        = 'id';

    /**
     * @var string Field name to use for the created time column in the DB table
     * if $set_created is enabled.
     */
    protected $created_field = 'create_on';

    /**
     * @var string Field name to use for the modified time column in the DB
     * table if $set_modified is enabled.
     */
    protected $modified_field = 'modified_on';

    /**
     * @var bool Set the created time automatically on a new record (if true)
     */
    protected $set_created = true;

    /**
     * @var bool Set the modified time automatically on editing a record (if true)
     */
    protected $set_modified = true;
    /**
     * @var string The type of date/time field used for $created_field and $modified_field.
     * Valid values are 'int', 'datetime', 'date'.
     */
    /**
     * @var bool Enable/Disable soft deletes.
     * If false, the delete() method will perform a delete of that row.
     * If true, the value in $deleted_field will be set to 1.
     */
    protected $soft_deletes = false;

    protected $date_format = 'datetime';

    /**
     * @var bool If true, will log user id in $created_by_field, $modified_by_field,
     * and $deleted_by_field.
     */
    protected $log_user = true;

    /**
     * Function construct used to load some library, do some actions, etc.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function _autoNumber($table, $code)
    {
        $length_code     = strlen($code) + 1;
        $init           = date('ym');
        $sql            = "SELECT MAX(RIGHT(id,4)) as maxId FROM $table WHERE SUBSTR(id,$length_code,4) = $init";
        $max            = $this->db->query($sql)->row();

        if ($max->maxId) {
            $counter = $max->maxId + 1;
        } else {
            $counter = 1;
        }

        $number = $code . date('ym') . str_pad($counter, 4, "0", STR_PAD_LEFT);
        return $number;
    }

    public function getWhere($table, $array = [])
    {
        $result = $this->db->get_where($table, $array);
        return $result;
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

    public function Cashflow($data = '')
    {
        $dataInsert = [
            'id'                => $this->_generate_id(),
            'date'              => date('Y-m-d H:i:s'),
            'no_reff'           => $data['trans_id'],
            'type'              => 'IN',
            'category'          => '1',
            'payment_methode'   => $data['payment_methode'],
            'description'       => 'Penerimaan Pembayaran',
            'in_value'          => str_replace(",", "", $data['payment_value']),
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => $this->session->User['id_user'],
        ];

        $this->db->insert('cashflow', $dataInsert);
    }

    public function UpdateShift($data = '')
    {
        $current_shift  = $this->db->get_where('shift', ['status' => 'OPN'])->row();

        if ($current_shift) {
            $id             = $current_shift->id;
            $query =
                "SELECT
                    ( SELECT count( transactions.id ) FROM transactions where shift = '$current_shift->id' ) AS qty_transaction,
                    ( SELECT sum( transactions.grand_total ) FROM transactions where shift = '$current_shift->id' ) AS cash_sales,
                    ( SELECT count( view_trans_details.id ) FROM view_trans_details where shift = '$current_shift->id') AS qty_product,
                    ( SELECT sum( view_payment_trans.payment_value ) FROM view_payment_trans where shift = '$current_shift->id') AS cash_payment,
                    ( SELECT sum( cashflow.in_value ) FROM cashflow where shift = '$current_shift->id') AS income,
                    ( SELECT sum( cashflow.out_value ) FROM cashflow where shift = '$current_shift->id') AS expenses,
                    ( SELECT count( cashflow.in_value ) FROM cashflow where shift = '$current_shift->id') AS qty_income,
                    ( SELECT count( cashflow.out_value ) FROM cashflow where shift = '$current_shift->id') AS qty_expenses";

            $summary_shift  = $this->db->query($query)->row();
            $exp_ending     = ($current_shift->beginning_balance + $summary_shift->cash_sales +
                $summary_shift->income) - $summary_shift->expenses;
            $ending         = ($current_shift->beginning_balance + $summary_shift->cash_payment +
                $summary_shift->income) - $summary_shift->expenses;

            $Data = [
                'id'                           => $id,
                // 'user_id'                      => $this->auth->user_id(),
                'start_shift'                  => $current_shift->start_shift,
                'end_shift'                    => $current_shift->end_shift,
                'qty_transactions'             => $summary_shift->qty_transaction,
                'qty_income'                   => $summary_shift->qty_income,
                'qty_expense'                  => $summary_shift->qty_expenses,
                'qty_sales_product'            => $summary_shift->qty_product,
                'beginning_balance'            => $current_shift->beginning_balance,
                'cash_sales'                   => $summary_shift->cash_sales,
                'expected_ending_balance'      => $exp_ending,
                'cash_payment'                 => $summary_shift->cash_payment,
                'income'                       => $summary_shift->income,
                'expenses'                     => $summary_shift->expenses,
                'ending_balance'               => $ending,
            ];

            $this->db->where(['status' => 'OPN'])->update('shift', $Data);
        } else {
            $Retrun = [
                'status' => '0',
                'msg'    => 'Server Error, coba beberapa saat lagi.'
            ];
            return $Retrun;
        }
    }
}
