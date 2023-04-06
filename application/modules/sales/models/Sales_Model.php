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
            'in_value'          => $data['payment_value'],
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => $this->session->User['id_user'],
        ];

        // if (isset($data['return'])) {
        //     $dataInsert = [
        //         'id'                => $this->_generate_id(),
        //         'date'              => date('Y-m-d H:i:s'),
        //         'no_reff'           => $data['trans_id'],
        //         'type'              => 'OUT',
        //         'category'          => '1',
        //         'payment_methode'   => '1',
        //         'description'       => 'Kembalian',
        //         'in_value'          => '0',
        //         'out_value'         => $data['return'],
        //         'created_at'        => date('Y-m-d H:i:s'),
        //         'created_by'        => $this->session->User['id_user'],
        //     ];
        // }

        $this->db->insert('cashflow', $dataInsert);
    }
}
