<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2021, Syamsudin
 *
 * This is controller for Perusahaan
 */

class Shift extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Shift_model', 'Shift');
        $this->template->set('title', 'Shift');
        $this->template->page_icon('fa fa-table');

        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $shift      = $this->db->get_where('view_shift', ['status' => 'OPN'])->row();
        $history    = $this->db->get_where('view_shift', ['status' => 'CLS'])->result();

        $Data = [
            'shift'     => $shift,
            'history'   => $history
        ];

        $this->template->set($Data);
        $this->template->render('index');
    }

    //Create New Customer
    public function save_beginning_balance()
    {
        $post = $this->input->post();
        $this->db->trans_begin();
        $count = 1;
        $sql = "SELECT MAX(RIGHT(id,2))as id FROM shift limit 1";
        $maxId = $this->db->query($sql)->row();
        if ($maxId->id) {
            $count = $maxId->id + 1;
        }
        $id = "SHF-" . str_pad($count, "2", "0", STR_PAD_LEFT);
        $data = [
            'id'                    => $id,
            'user_id'               => $this->auth->user_id(),
            'beginning_balance'     => str_replace(",", "", $post['beginning']),
            'date'                  => date('Y-m-d'),
            'start_shift'           => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('shift', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $Arr_Return        = array(
                'status'        => 0,
                'pesan'         => 'Saldo awal gagal di input.'
            );
        } else {
            $this->db->trans_commit();
            $Arr_Return        = array(
                'status'        => 1,
                'pesan'         => 'Saldo awal berhasil di input.'
            );
        }
        echo json_encode($Arr_Return);
    }

    public function summary_shift()
    {
        $shift = $this->db->get_where('view_shift', ['status' => 'OPN'])->row();
        $Data = [
            'shift' => $shift
        ];
        $this->template->set($Data);
        $this->template->render('form-ending-shift');
    }

    public function ending_shift()
    {
        $post = $this->input->post();
        $this->db->trans_begin();
        $data = [
            'actual_ending_balance'    => $post['actual'],
            'end_shift'         => date('Y-m-d H:i:s'),
            'note'              => $post['note'],
            'difference'        => $post['difference'],
            'status'            => 'CLS',
            'ending_by'         => $this->auth->user_id(),
        ];

        $this->db->where(['status' => 'OPN'])->update("shift", $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $Arr_Return        = array(
                'status'        => 2,
                'pesan'            => 'Save Process Failed. Please Try Again...'
            );
        } else {
            $this->db->trans_commit();
            $Arr_Return        = array(
                'status'        => 1,
                'pesan'            => 'Save Process Success. '
            );
        }
        echo json_encode($Arr_Return);
    }

    public function report_ending_shift()
    {
        $shift = $this->db->order_by('end_shift', 'DESC')->get_where('view_shift', ['status' => 'CLS'])->row();
        $Data = [
            'shift' => $shift
        ];
        $this->template->set($Data);
        $this->template->render('report_ending');
    }
    public function report_shift($id)
    {
        $shift = $this->db->order_by('end_shift', 'DESC')->get_where('view_shift', ['id' => $id])->row();
        $Data = [
            'shift' => $shift
        ];
        $this->template->set($Data);
        $this->template->render('report_shift');
    }

    public function saveEditCabang()
    {
        $this->auth->restrict($this->addPermission);
        $session = $this->session->userdata('app_session');

        $post = $this->input->post();
        $id         = $this->input->post('id_cabang');
        $perusahaan = $this->input->post('nm_perusahaan');
        $cabang     = $this->input->post('nm_cabang');
        $inisial    = $this->input->post('inisial');
        $alamat     = $this->input->post('alamat_cabang');
        $tgl = date("Y-m-d H:i:s");

        $this->db->trans_begin();
        $data = [
            'nm_cabang'            => $cabang,
            'id_perusahaan'        => $perusahaan,
            'alamat'            => $alamat,
            'modified_on'        => date('Y-m-d H:i:s'),
            'modified_by'        => $this->auth->user_id(),
            'inisial'            => $inisial,

        ];

        $this->db->where('id_cabang', $id);
        $this->db->update('perusahaan_cbg', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $Arr_Return        = array(
                'status'        => 2,
                'pesan'            => 'Update Process Failed. Please Try Again...'
            );

            $keterangan     = "Gagal, Update data Cabang " . $cabang . ", atas Nama : " . $perusahaan;
            $status         = 0;
            $nm_hak_akses   = $this->addPermission;
            $kode_universal = $cabang;
            $jumlah         = 1;
            $sql            = $this->db->last_query();
        } else {
            $this->db->trans_commit();
            $Arr_Return        = array(
                'status'        => 1,
                'pesan'            => 'Save Process Success. '
            );

            $keterangan     = "Sukses, Update data Cabang " . $cabang . ", atas Nama : " . $perusahaan;
            $status         = 1;
            $nm_hak_akses   = $this->addPermission;
            $kode_universal = $cabang;
            $jumlah         = 1;
            $sql            = $this->db->last_query();
        }
        echo json_encode($Arr_Return);

        simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
    }

    //Save customer ajax
    public function save_data_cabang()
    {

        $type           = $this->input->post("type");
        $id             = $this->input->post("id");
        $kdcab          = $this->input->post("kdcab");
        $namacabang     = $this->input->post("namacabang");
        $alamat         = $this->input->post('alamat');
        $kepalacabang   = $this->input->post('kepalacabang');
        $kabagjualan    = $this->input->post('kabagjualan');
        $admcabang      = $this->input->post('admcabang');
        $gudang         = $this->input->post('gudang');
        $kota           = $this->input->post('kota');
        $no_so          = $this->input->post('no_so');
        $no_suratjalan  = $this->input->post('no_suratjalan');
        $no_picking_list = $this->input->post('no_picking_list');
        $no_invoice     = $this->input->post('no_invoice');
        $no_pr          = $this->input->post('no_pr');
        $no_po          = $this->input->post('no_po');
        $no_receive     = $this->input->post('no_receive');
        $th_picking_list = $this->input->post('th_picking_list');
        $biaya_logistik_lokal          = $this->input->post('biaya_logistik_lokal');
        $sts_aktif      = $this->input->post('sts_aktif');

        if ($type == "edit") {
            $this->auth->restrict($this->managePermission);

            if ($id != "") {
                $data = array(
                    array(
                        'id' => $id,
                        'kdcab' => $kdcab,
                        'namacabang' => $namacabang,
                        'alamat' => $alamat,
                        'kepalacabang' => $kepalacabang,
                        'kabagjualan' => $kabagjualan,
                        'admcabang' => $admcabang,
                        'gudang' => $gudang,
                        'kota' => $kota,
                        'no_so' => $no_so,
                        'no_suratjalan' => $no_suratjalan,
                        'no_invoice' => $no_invoice,
                        'no_picking_list' => $no_picking_list,
                        'no_pr' => $no_pr,
                        'no_po' => $no_po,
                        'no_receive' => $no_receive,
                        'th_picking_list' => $th_picking_list,
                        'biaya_logistik_lokal' => $biaya_logistik_lokal,
                        'sts_aktif' => $sts_aktif,
                    )
                );

                //Update data
                $result = $this->Cabang_model->update_batch($data, 'id');

                $keterangan     = "SUKSES, Edit data Cabang " . $id . ", atas Nama : " . $namacabang;
                $status         = 1;
                $nm_hak_akses   = $this->addPermission;
                $kode_universal = $kdcab;
                $jumlah         = 1;
                $sql            = $this->db->last_query();
            } else {
                $result = FALSE;

                $keterangan     = "GAGAL, Edit data Cabang " . $id . ", atas Nama : " . $namacabang;
                $status         = 1;
                $nm_hak_akses   = $this->addPermission;
                $kode_universal = $kdcab;
                $jumlah         = 1;
                $sql            = $this->db->last_query();
            }

            simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
        } else //Add New
        {
            $this->auth->restrict($this->addPermission);

            $data = array(
                'id' => $id,
                'kdcab' => $kdcab,
                'namacabang' => $namacabang,
                'alamat' => $alamat,
                'kepalacabang' => $kepalacabang,
                'kabagjualan' => $kabagjualan,
                'admcabang' => $admcabang,
                'gudang' => $gudang,
                'kota' => $kota,
                'no_so' => $no_so,
                'no_suratjalan' => $no_suratjalan,
                'no_invoice' => $no_invoice,
                'no_picking_list' => $no_picking_list,
                'no_pr' => $no_pr,
                'no_po' => $no_po,
                'no_receive' => $no_receive,
                'th_picking_list' => $th_picking_list,
                'biaya_logistik_lokal' => $biaya_logistik_lokal,
                'sts_aktif' => $sts_aktif,
            );

            //Add Data
            $id = $this->Cabang_model->insert($data);

            if (is_numeric($id)) {
                $keterangan     = "SUKSES, tambah data Cabang " . $id . ", atas Nama : " . $namacabang;
                $status         = 1;
                $nm_hak_akses   = $this->addPermission;
                $kode_universal = 'NewData';
                $jumlah         = 1;
                $sql            = $this->db->last_query();

                $result         = TRUE;
            } else {
                $keterangan     = "GAGAL, tambah data Cabang " . $id . ", atas Nama : " . $namacabang;
                $status         = 0;
                $nm_hak_akses   = $this->addPermission;
                $kode_universal = 'NewData';
                $jumlah         = 1;
                $sql            = $this->db->last_query();
                $result = FALSE;
            }
            //Save Log
            simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);
        }

        $param = array(
            'save' => $result
        );

        echo json_encode($param);
    }

    function hapus_cabang()
    {
        $this->auth->restrict($this->deletePermission);
        $id = $this->uri->segment(3);

        if ($id != '') {

            $result = $this->Cabang_model->delete($id);

            $keterangan     = "SUKSES, Delete data Cabang " . $id;
            $status         = 1;
            $nm_hak_akses   = $this->addPermission;
            $kode_universal = $id;
            $jumlah         = 1;
            $sql            = $this->db->last_query();
        } else {
            $result = 0;
            $keterangan     = "GAGAL, Delete data Cabang " . $id;
            $status         = 0;
            $nm_hak_akses   = $this->addPermission;
            $kode_universal = $id;
            $jumlah         = 1;
            $sql            = $this->db->last_query();
        }

        //Save Log
        simpan_aktifitas($nm_hak_akses, $kode_universal, $keterangan, $jumlah, $sql, $status);

        $param = array(
            'delete' => $result,
            'idx' => $id
        );

        echo json_encode($param);
    }


    function get_perusahaan()
    {
        $users    = $this->db->query("SELECT * FROM perusahaan")->result();
        echo "<select id='nm_perusahaan' name='nm_perusahaan' class='select2'>
				<option value=''>Pilih Perusahaan</option>";
        foreach ($users as $pic) {
            echo "<option value='$pic->id_perusahaan'>$pic->nm_perusahaan</option>";
        }
        echo "</select>";
    }
}
