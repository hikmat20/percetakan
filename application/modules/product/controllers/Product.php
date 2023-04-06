<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Aktifitas/aktifitas_model'
        ));
        $this->template->set('title', 'Data Produk');
        $this->template->page_icon('fa fa-list-ul');
        date_default_timezone_set("Asia/Bangkok");
        $this->sts = [
            'N' => '<span class="badge rounded-pill bg-danger">Non Aktif</span>',
            'Y' => '<span class="badge rounded-pill bg-success">Aktif</span>',
        ];
    }

    public function index()
    {


        $data       = $this->db->order_by('name', 'ASC')->get_where('products_details', ['deleted_at' => null])->result();
        $users      = $this->db->get_where('users')->result();
        $listUser   = [];

        foreach ($users as $usr) {
            $listUser[$usr->id_user] = $usr->username;
        }

        $Data = [
            'sts'           => $this->sts,
            'data'          => $data,
            'usr'           => $listUser
        ];

        $this->template->set($Data);
        $this->template->render('index');
    }

    private function getId($table, $code)
    {
        $count      = 1;
        $sql        = "SELECT MAX(RIGHT(id,3)) as maxId FROM $table where SUBSTR(id,1,2) = '$code'";
        $maxId      = $this->db->query($sql)->row()->maxId;
        if ($maxId) {
            $count = $maxId + 1;
        }
        $newId      = $code . date('y')  . sprintf("%04s", $count);
        return $newId;
    }

    private function getIdProduct($product)
    {
        $count      = 1;
        $sql        = "SELECT MAX(RIGHT(id,3)) as maxId FROM products_details where product_id = '$product'";
        $maxId      = $this->db->query($sql)->row()->maxId;
        if ($maxId) {
            $count = $maxId + 1;
        }
        $newId      = $product . "-" . sprintf("%03s", $count);

        return $newId;
    }

    private function getIdFin($product)
    {
        $count      = 1;
        $sql        = "SELECT MAX(RIGHT(id,2)) as maxId FROM finishings where product_id = '$product'";
        $maxId      = $this->db->query($sql)->row()->maxId;
        if ($maxId) {
            $count = $maxId + 1;
        }
        $newId      = $product . "-" . sprintf("%02s", $count);
        return $newId;
    }

    private function getIdCost($param)
    {
        $count      = 0;
        $length     = strlen($param) + 2;
        $sql        = "SELECT MAX(SUBSTR(id,$length)) as maxId FROM products_cost where product_detail_id = '$param'";
        $result      = $this->db->query($sql)->row()->maxId;
        if ($result) {
            $count = $result + 1;
        }
        // $newId      = $param . "-" . sprintf("%02s", $count);
        return $count;
    }

    public function load_product()
    {
        $category_id = $this->input->post('category_id');

        $products   = $this->db->get_where('products', ['category_id' => $category_id, 'deleted_at' => null])->result();
        $Data = [
            'products'  => $products
        ];

        echo json_encode($products);
    }
    public function add_product()
    {
        // $products   = $this->db->get_where('products', ['deleted_at' => null])->result();
        $category       = $this->db->get_where('products_category')->result();
        $units          = $this->db->get_where('units')->result();
        $cost_item      = $this->db->get_where('cost_item')->result();

        $Data = [
            // 'products'  => $products,
            'category'  => $category,
            'cost_item'  => $cost_item,
            'units'     => $units,
        ];

        $this->template->set($Data);
        $this->template->render('form');
    }

    public function edit_product($id = '')
    {
        if ($id) {
            $products_details           = $this->db->get_where('view_products_details', ['id' => $id])->row();
            $category                   = $this->db->get_where('products_category')->result();
            $products                   = $this->db->get_where('products', ['category_id' => $products_details->category_id, 'deleted_at' => null])->result();
            $units                      = $this->db->get_where('units')->result();
            $wh_price                   = $this->db->get_where('wholesale_prices', ['product_detail_id' => $id])->result();
            $cost_item                  = $this->db->get_where('cost_item')->result();
            $Data = [
                'products_details'      => $products_details,
                'category'              => $category,
                'products'              => $products,
                'units'                 => $units,
                'wh_price'              => $wh_price,
                'cost_item'             => $cost_item
            ];
            $this->template->set($Data);
        }

        $this->template->render('form');
    }


    public function copy_product($id = '')
    {
        if ($id) {
            $products_details           = $this->db->get_where('view_products_details', ['id' => $id])->row();
            $category                   = $this->db->get_where('products_category')->result();
            $products                   = $this->db->get_where('products', ['category_id' => $products_details->category_id, 'deleted_at' => null])->result();
            $units                      = $this->db->get_where('units')->result();
            $wh_price                   = $this->db->get_where('wholesale_prices', ['product_detail_id' => $id])->result();
            $cost_item                  = $this->db->get_where('cost_item')->result();
            $Data = [
                'products_details'      => $products_details,
                'category'              => $category,
                'products'              => $products,
                'units'                 => $units,
                'wh_price'              => $wh_price,
                'cost_item'             => $cost_item,
                'copy'                  => 'Y'
            ];
            $this->template->set($Data);
        }

        $this->template->render('form');
    }


    public function wholesales()
    {
        $this->load->view('wholesales');
    }

    public function finishing()
    {
        $this->load->view('finishing');
    }

    public function save()
    {
        $Data                       = $this->input->post();
        $product_detail_id          = ((isset($Data['id']) && $Data['id'] != '')) ? $Data['id'] : $this->getIdProduct($Data['product_id']);
        $Data_WH                    = (isset($Data['wh_price'])) ? $Data['wh_price'] : '';
        $Data_cost                   = (isset($Data['cost_item'])) ? $Data['cost_item'] : '';

        if ($Data) {
            $Data['unit_price']             = str_replace(str_split(',.'), "", $Data['unit_price']);

            $this->db->trans_begin();
            unset($Data['wh_price']);
            unset($Data['finishing']);
            unset($Data['category_id']);
            unset($Data['cost_item']);

            if ((isset($Data['id']) && $Data['id'] != '')) {
                $Data['wholesaler']         = (isset($Data['wholesaler'])) ? $Data['wholesaler'] : 'N';
                $Data['flag_custom_size']   = (isset($Data['flag_custom_size'])) ? $Data['flag_custom_size'] : 'N';
                $Data['flag_finishing']     = (isset($Data['flag_finishing'])) ? $Data['flag_finishing'] : 'N';
                $Data['active']             = (isset($Data['active'])) ? $Data['active'] : 'N';
                $Data['created_at']         = date('Y-m-d H:i:s');
                $Data['created_by']         = $this->auth->user_id();
                $this->db->update('products_details', $Data, ['id' => $Data['id']]);
            } else {
                $Data['id']                 = $product_detail_id;
                $Data['created_at']         = date('Y-m-d H:i:s');
                $Data['created_by']         = $this->auth->user_id();

                $this->db->insert('products_details', $Data);
            }

            if ($Data_WH) {
                foreach ($Data_WH as $w => $whp) {
                    $ArrWhp[$w] = [
                        'id'                        => (isset($whp['id'])) ? $whp['id'] : '',
                        'product_detail_id'         => $product_detail_id,
                        'product_id'                => $Data['product_id'],
                        'qty_min'                   => $whp['qty_min'],
                        'price'                     => str_replace(str_split(',.'), "", $whp['price']),
                    ];
                }


                foreach ($ArrWhp as $wh) {
                    if ($wh['id']) {
                        $wh['modified_by']   = $this->auth->user_id();
                        $wh['modified_at']   = date('Y-m-d H:i:s');
                        $this->db->update('wholesale_prices', $wh, ['id' => $wh['id']]);
                    } else {
                        $wh['created_by']   = $this->auth->user_id();
                        $wh['created_at']   = date('Y-m-d H:i:s');
                        $this->db->insert('wholesale_prices', $wh);
                    }
                }
            } else {
                $this->db->delete('wholesale_prices', ['product_detail_id' => $Data['id']]);
            }

            if ($Data_cost) {
                $count = $this->getIdCost($Data['id']);
                foreach ($Data_cost as $c => $cost) {
                    $count++;
                    $idCost      = $Data['id'] . "-" . sprintf("%02s", $count);
                    $idCost      = (isset($cost['id'])) ?: $idCost;
                    $ArrCost[$c] = [
                        'id'                    => $idCost,
                        'cost_id'               => $cost['cost_id'],
                        'product_detail_id'     => $Data['id'],
                        'name'                  => $cost['name'],
                        'cost_value'            => str_replace(",", "", $cost['cost_value']),
                    ];
                }

                foreach ($ArrCost as $cst) {
                    $cek = $this->db->get_where('products_cost', ['id' => $cst['id']])->num_rows();
                    if ($cek > 0) {
                        // $cst['modified_by']     = $this->auth->user_id();
                        // $cst['modified_at']     = date('Y-m-d H:i:s');
                        $this->db->update('products_cost', $cst, ['id' => $cst['id']]);
                    } else {
                        // $cst['id']              = $this->getIdCost($Data['id']);
                        // $cst['created_by']      = $this->auth->user_id();
                        // $cst['created_at']      = date('Y-m-d H:i:s');
                        $this->db->insert('products_cost', $cst);
                    }
                }
            } else {
                $this->db->delete('products_cost', ['product_detail_id' => $Data['id']]);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $Return = [
                    'status'    => 0,
                    'msg'       => 'Produk gagal disimpan!'
                ];
            } else {
                $this->db->trans_commit();
                $Return = [
                    'status'    => 1,
                    'msg'       => 'Produk berhasil disimpan!'
                ];
            }
            $this->db->trans_complete();
        } else {
            $Return = [
                'status'    => 0,
                'msg'       => 'Data tidak valid!'
            ];
        }
        echo json_encode($Return);
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

    public function save_product()
    {
        $name = $this->input->post('name');
        $Return = [
            'status' => 0,
            'msg' => 'Data tidak vaild.'
        ];

        if ($name) {
            $y = date('y');
            $sql = "SELECT MAX(RIGHT(id,4)) as maxId from products where SUBSTR(id,3,2) = $y";
            $cekId = $this->db->query($sql)->row()->maxId;

            if ($cekId) {
                $count = $cekId + 1;
            } else {
                $count = 1;
            }
            $newId = "JS$y" . str_pad($count, 4, "0", STR_PAD_LEFT);
            $Data = [
                'id'                => $newId,
                'name'              => $name,
                'form_type'         => '1',
                'created_at'        => date('Y-m-d H:i:s'),
                'created_by'        => $this->auth->user_id(),
            ];

            $this->db->trans_begin();
            $this->db->insert('products', $Data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $Return = [
                    'status' => 0,
                    'msg' => 'Data Jasa gagal disimpan.'
                ];
            } else {
                $this->db->trans_commit();
                $Return = [
                    'status' => 1,
                    'msg' => 'Data Jasa berhasil disimpan.'
                ];
            }
        }

        echo json_encode($Return);
    }

    public function delete_price()
    {
        $id = $this->input->post('id');
        $Return = [
            'status' => 0,
            'msg' => 'Data tidak valid. Error!'
        ];

        if ($id) {
            $this->db->trans_begin();
            $this->db->delete('wholesaler_prices', ['id' => $id]);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $Return = [
                'status' => 0,
                'msg' => 'Harga gagal dihapus, Server timeout.'
            ];
        } else {
            $Return = [
                'status' => 1,
                'msg' => 'Harga berhasil dihapus.'
            ];
            $this->db->trans_commit();
        }
        echo json_encode($Return);
    }

    public function delete_finishing()
    {
        $id = $this->input->post('id');

        $Return = [
            'status' => 0,
            'msg' => 'Data tidak valid. Error!'
        ];

        if ($id) {
            $this->db->trans_begin();
            $this->db->delete('finishings', ['id' => $id]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $Return = [
                'status' => 0,
                'msg' => 'Harga gagal dihapus, Server timeout.'
            ];
        } else {
            $Return = [
                'status' => 1,
                'msg' => 'Harga berhasil dihapus.'
            ];
            $this->db->trans_commit();
        }

        echo json_encode($Return);
    }


    // category
    public function category()
    {
        $category = $this->db->get_where('products_category')->result();
        $Data = [
            'sts'       => $this->sts,
            'category'  => $category
        ];
        $this->template->set($Data);
        $this->template->render('category');
    }

    public function add_category()
    {
        $this->template->render('form-category');
    }

    public function edit_category($id = '')
    {
        $category = $this->db->get_where('products_category', ['code' => $id])->row();
        $Data = [
            'category' => $category
        ];

        $this->template->set($Data);
        $this->template->render('form-category');
    }

    public function save_category()
    {
        $data = $this->input->post();
        $this->db->trans_begin();
        if ($data) {
            if ($data['type'] == 'update') {
                unset($data['type']);
                $this->db->update('products_category', $data, ['code' => $data['code']]);
            } else {
                $cek = $this->db->get_where('products_category', ['code' => $data['code']])->num_rows();
                if ($cek > 0) {
                    $Return = [
                        'status'    => 2,
                        'msg'       => 'Kode kategori sudah tersedia. Mohon gunakan kode yang lain.'
                    ];
                    echo json_encode($Return);
                    return false;
                } else {
                    unset($data['type']);
                    $this->db->insert('products_category', $data);
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $Return = [
                    'status'    => 0,
                    'msg'       => 'Data Kategori gagal disimpan.'
                ];
            } else {
                $this->db->trans_commit();
                $Return = [
                    'status'    => 1,
                    'msg'       => 'Data Kategori berhasil disimpan.'
                ];
            }
        } else {
            $Return = [
                'status'    => 0,
                'msg'       => 'Data tidak valid. Error!'
            ];
        }

        echo json_encode($Return);
    }

    public function delete_category()
    {
        $data = $this->input->post();
        $this->db->trans_begin();
        if ($data) {
            $this->db->db_debug = FALSE;
            $this->db->delete('products_category', ['code' => $data['code']]);
            $err = $this->db->error();

            if ($err['code'] == '1451') {
                $Return = [
                    'status'    => 2,
                    'msg'       => 'Data tidak bisa dihapus, karena sudah pernah digunakan.'
                ];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $Return = [
                        'status'    => 0,
                        'msg'       => 'Data Kategori gagal dihapus.'
                    ];
                } else {
                    $this->db->trans_commit();
                    $Return = [
                        'status'    => 1,
                        'msg'       => 'Data Kategori berhasil dihapus.'
                    ];
                }
            }
        } else {
            $Return = [
                'status'    => 0,
                'msg'       => 'Data tidak valid. Error!'
            ];
        }

        echo json_encode($Return);
    }

    // Product Types
    public function product_type()
    {
        $product_type = $this->db->get_where('products', ['active' => "Y"])->result();
        $Data = [
            'sts'           => $this->sts,
            'product_type'  => $product_type
        ];
        $this->template->set($Data);
        $this->template->render('product_type');
    }

    public function add_product_type()
    {
        $category = $this->db->get_where('products_category', ['active' => 'Y'])->result();

        $Data = [
            'category' => $category,
        ];

        $this->template->set($Data);
        $this->template->render('form-product-type');
    }

    public function edit_product_type($id = '')
    {
        $category       = $this->db->get_where('products_category', ['active' => 'Y'])->result();
        $product_type   = $this->db->get_where('products', ['id' => $id])->row();
        $finishing      = $this->db->get_where('finishings', ['product_id' => $id])->result();

        $Data = [
            'product_type'  => $product_type,
            'finishing'     => $finishing,
            'category'      => $category
        ];

        $this->template->set($Data);
        $this->template->render('form-product-type');
    }


    public function save_product_type()
    {
        $data           = $this->input->post();
        $old_photo      = $data['old_photo'];
        $data['image']  = $data['old_photo'];
        $photo_name = str_replace(" ", "-", $data['name']);
        $Data_FI                    = (isset($data['finishing'])) ? $data['finishing'] : '';

        if ($_FILES['gambar']['name']) {
            $config['upload_path']          = './assets/products/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 5000;
            $config['max_width']            = 1000;
            $config['max_height']           = 1000;
            $config['file_name']            = date('ymdHis') . "_" . strtolower($photo_name);
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $error = $this->upload->display_errors();
                $return = [
                    'status' => 0,
                    'msg'   =>  $error
                ];
                echo json_encode($return);
                return FALSE;
            } else {
                $dataPhoto = $this->upload->data();
                $gambar = $dataPhoto['file_name'];
                if ($old_photo) {
                    unlink('./assets/products/' . $old_photo);
                }
                $newGambar          = ($gambar) ?: $old_photo;
                $data['image']      = $newGambar;
            }
        }

        if ($Data_FI) {
            foreach ($Data_FI as $f => $fin) {
                $idFin      = (isset($fin['id'])) ? $fin['id'] : '';
                $ArrFin[$f] = [
                    'id'                => $idFin,
                    'product_id'       => $data['id'],
                    'name'              => $fin['finishing_name'],
                ];
            }

            foreach ($ArrFin as $fn) {
                if ($fn['id']) {
                    $fn['modified_by']   = $this->auth->user_id();
                    $fn['modified_at']   = date('Y-m-d H:i:s');
                    $this->db->update('finishings', $fn, ['id' => $fn['id']]);
                } else {
                    $fn['id']           = $this->getIdFin($data['id']);
                    $fn['created_by']   = $this->auth->user_id();
                    $fn['created_at']   = date('Y-m-d H:i:s');
                    $this->db->insert('finishings', $fn);
                }
            }
        } else {
            $this->db->delete('finishings', ['product_id' => $data['id']]);
        }

        $this->db->trans_begin();
        if ($data['id']) {
            unset($data['finishing']);
            unset($data['old_photo']);
            $data['modified_by'] = $this->auth->user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $this->db->update('products', $data, ['id' => $data['id']]);
        } else {
            unset($data['finishing']);
            unset($data['old_photo']);
            $data['id'] = $this->getId('products', substr($data['category_id'], 0, 2));
            $data['created_by'] = $this->auth->user_id();
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('products', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $return = [
                'status' => 0,
                'msg'   =>  'Data Jenis Produk gagal disimpan.'
            ];
        } else {
            $this->db->trans_commit();
            $return = [
                'status' => 1,
                'msg'   =>  'Data Jenis Produk berhasil disimpan.'
            ];
        }
        echo json_encode($return);
    }

    public function delete_product_type($id)
    {
        $this->db->trans_begin();
        if (!$id) {
            $return = [
                'status' => 0,
                'msg'   =>  'Data tidak valid. Error!!'
            ];
        } else {
            $this->db->delete('products', ['id' => $id]);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'   =>  'Data jenis produk gagal dihapus.'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'   =>  'Data jenis produk berhasil dihapus.'
                ];
            }
        }

        echo json_encode($return);
    }

    public function delete_product()
    {
        $id = $this->input->post('id');
        $this->db->trans_begin();
        if (!$id) {
            $return = [
                'status' => 0,
                'msg'   =>  'Data tidak valid. Error!!'
            ];
        } else {
            $this->db->delete('products_details', ['id' => $id]);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'   =>  'Data produk gagal dihapus.'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'   =>  'Data produk berhasil dihapus.'
                ];
            }
        }

        echo json_encode($return);
    }

    public function delete_image()
    {
        $id           = $this->input->post('id');
        $this->db->trans_begin();
        if ($id) {
            $this->db->update('products', ['image' => null], ['id' => $id]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $return = [
                'status' => 0,
                'msg'   =>  'Gambar gagal diahpus.'
            ];
        } else {
            $this->db->trans_commit();
            $return = [
                'status' => 1,
                'msg'   =>  'Gambar berhasil dihapus.'
            ];
        }
        echo json_encode($return);
    }
}
