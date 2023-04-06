<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunaz
 * @copyright Copyright (c) 2018, Yunaz
 *
 * This is controller for Menus
 */

class Menus extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'Menus/Menus_model',
      'Aktifitas/aktifitas_model'
    ));
    $this->template->title('Manage Data Menus');
    $this->template->page_icon('fa fa-table');

    date_default_timezone_set("Asia/Bangkok");
  }

  public function index()
  {
    $data = $this->Menus_model->where()->order_by('id', 'ASC')->find_all();
    $sts = [
      '0' => '<span class="badge rounded-pill bg-danger">Non Aktif</span>',
      '1' => '<span class="badge rounded-pill bg-success">Aktif</span>'
    ];
    $this->template->set(
      [
        'results' => $data,
        'sts'     => $sts
      ]
    );
    $this->template->set('title', 'Data Menu');
    $this->template->render('index');
  }

  //Create New Customer
  public function create()
  {
    $parentMenu       = $this->db->get_where('menus', ['parent_id' => '0'])->result();
    $Data = [
      'data'    => '',
      'title'   => 'Input Master Menus',
      'parents' => $parentMenu
    ];

    $this->template->set($Data);
    $this->template->render('menus_form');
  }

  //Edit Menus
  public function edit($id)
  {

    $data  = $this->Menus_model->find_by(array('id' => $id));
    if (!$data) {
      $this->template->set_message("Invalid ID", 'error');
      redirect('Menus');
    }
    $parentMenu       = $this->db->get_where('menus', ['parent_id' => '0'])->result();
    $Data = [
      'parents' => $parentMenu,
      'data'    => $data
    ];

    $this->template->set($Data);
    $this->template->title('Edit Master Menu');
    $this->template->render('menus_form');
  }

  //Save ajax
  public function save_data_Menus()
  {
    $data           = $this->input->post();

    $id             = $data['id'];
    $title          = $data['title'];
    $link           = $data['link'];
    $icon           = $data['icon'];
    $target         = $data['target'];
    $parent_id      = $data['parent_id'];
    $status         = $data['status'];
    $order          = $data['order'];

    $ArrData = [
      'title'          => $title,
      'link'           => $link,
      'icon'           => $icon,
      'target'         => $target,
      'group_menu'     => '1',
      'parent_id'      => $parent_id,
      'permission_id'  => NULL,
      'status'         => $status,
      'order'          => $order,
    ];

    $this->db->trans_begin();
    if ($id) {
      $ArrData['id'] = $id;
      $ArrData['modified_on'] = date('Y-m-d H:i:s');
      $ArrData['modified_by'] = $this->auth->user_id();
      $this->db->update('menus', $ArrData, ['id' => $id]);
    } else {
      //Add New
      $ArrData['created_on'] = date('Y-m-d H:i:s');
      $ArrData['created_by'] = $this->auth->user_id();
      $this->db->insert('menus', $ArrData);
      //Add Data
    }
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $save = FALSE;
    } else {
      $this->db->trans_commit();
      $save = TRUE;
    }
    $param = [
      'save' => $save
    ];

    echo json_encode($param);
  }
  function hapus_Menus()
  {
    $this->auth->restrict($this->deletePermission);
    $id = $this->uri->segment(3);
    if ($id != '') {
      $get = $this->db->get_where('menus', array('id' => $id))->row();
      $this->db->where(array('nm_menu' => $get->title))->delete('permissions');
      $result = $this->Menus_model->delete($id);
      $keterangan     = "SUKSES, Delete data Menus " . $id;
      $status         = 1;
      $nm_hak_akses   = $this->addPermission;
      $kode_universal = $id;
      $jumlah         = 1;
      $sql            = $this->db->last_query();
    } else {
      $result = 0;
      $keterangan     = "GAGAL, Delete data Menus " . $id;
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
  function print_request($id)
  {
    $id_customer = $id;
    $mpdf = new mPDF('', '', '', '', '', '', '', '', '', '');
    $mpdf->SetImportUse();
    $mpdf->RestartDocTemplate();

    $cust_toko      =  $this->Toko_model->tampil_toko($id_customer)->result();
    $cust_setpen    =  $this->Penagihan_model->tampil_tagih($id_customer)->result();
    $cust_setpem    =  $this->Pembayaran_model->tampil_bayar($id_customer)->result();
    $cust_pic       =  $this->Pic_model->tampil_pic($id_customer)->result();
    $cust_data      =  $this->Customer_model->find_data('customer', $id_customer, 'id_customer');
    $inisial        =  $this->Customer_model->find_data('data_reff', $id_customer, 'id_customer');


    $this->template->set('cust_data', $cust_data);
    $this->template->set('inisial', $inisial);
    $this->template->set('cust_toko', $cust_toko);
    $this->template->set('cust_setpen', $cust_setpen);
    $this->template->set('cust_setpem', $cust_setpem);
    $this->template->set('cust_pic', $cust_pic);
    $show = $this->template->load_view('print_data', $data);

    $this->mpdf->WriteHTML($show);
    $this->mpdf->Output();
  }

  function downloadExcel()
  {
    $data = $this->Customer_model->select("customer.id_customer,
        customer.nm_customer,
        customer.bidang_usaha,
        customer.produk_jual,
        customer.kredibilitas,
        customer.alamat,
        customer.provinsi,
        customer.kota,
        customer.kode_pos,
        customer.telpon,
        customer.fax,
        customer.npwp,
        customer.alamat_npwp,
        customer.id_marketing,
        customer.referensi,
        customer.website,
        customer.foto
        ")->order_by('customer', 'ASC')->find_all();

    $objPHPExcel    = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(17);
    //$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(17);
    //// $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(17);

    $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

    $header = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'name' => 'Verdana'
      )
    );
    $objPHPExcel->getActiveSheet()->getStyle("A1:P2")
      ->applyFromArray($header)
      ->getFont()->setSize(14);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:P2');
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A1', 'Daftar Mitra')
      ->setCellValue('A3', 'No.')
      ->setCellValue('B3', 'No Anggota')
      ->setCellValue('C3', 'Nama Mitra')
      ->setCellValue('D3', 'Tempat Lahir')
      ->setCellValue('E3', 'Tanggal Lahir')
      ->setCellValue('F3', 'Warga Negara')
      ->setCellValue('G3', 'Jenis Kelamin')
      ->setCellValue('H3', 'Agama')
      ->setCellValue('I3', 'Alamat')
      ->setCellValue('J3', 'No HP')
      ->setCellValue('K3', 'Nama Bank')
      ->setCellValue('L3', 'No Rekening')
      ->setCellValue('M3', 'No KTP')
      ->setCellValue('N3', 'Email')
      ->setCellValue('O3', 'No Polisi')
      ->setCellValue('P3', 'Status');
    //->setCellValue('Q3', 'Hutang');
    //->setCellValue('R3', 'Hutang');

    $ex = $objPHPExcel->setActiveSheetIndex(0);
    $no = 1;
    $counter = 4;
    foreach ($data as $row) :
      $tanggallahir = date('d-m-Y', strtotime($row->tanggallahir));
      $ex->setCellValue('A' . $counter, $no++);
      $ex->setCellValue('B' . $counter, strtoupper($row->nama_mitra));
      $ex->setCellValue('C' . $counter, $row->nim);
      $ex->setCellValue('D' . $counter, $row->tempatlahir);
      $ex->setCellValue('E' . $counter, $tanggallahir);
      $ex->setCellValue('F' . $counter, $row->warganegara);
      $ex->setCellValue('G' . $counter, $row->jeniskelamin);
      $ex->setCellValue('H' . $counter, $row->jeniskagamaelamin);
      $ex->setCellValue('I' . $counter, $row->alamataktif);
      $ex->setCellValue('J' . $counter, $row->nohp);
      $ex->setCellValue('K' . $counter, $row->norekeningbank);
      $ex->setCellValue('L' . $counter, $row->namabank);
      $ex->setCellValue('M' . $counter, $row->noktp);
      $ex->setCellValue('N' . $counter, $row->email);
      $ex->setCellValue('O' . $counter, $row->nopolisi);
      $ex->setCellValue('P' . $counter, $row->status_aktif);

      $counter = $counter + 1;
    endforeach;

    $objPHPExcel->getProperties()->setCreator("Yunaz Fandy")
      ->setLastModifiedBy("Yunaz Fandy")
      ->setTitle("Export Daftar Mitra")
      ->setSubject("Export Daftar Mitra")
      ->setDescription("Daftar Invoice for Office 2007 XLSX, generated by PHPExcel.")
      ->setKeywords("office 2007 openxml php")
      ->setCategory("PHPExcel");
    $objPHPExcel->getActiveSheet()->setTitle('Data Mitra');

    $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
    header('Chace-Control: no-store, no-cache, must-revalation');
    header('Chace-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ExportDataMitra' . date('Ymd') . '.xlsx"');

    $objWriter->save('php://output');
  }
}
