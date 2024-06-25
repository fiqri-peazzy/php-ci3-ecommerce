<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_auth');
        if (!$this->user_auth->check()) {
            $this->session->set_flashdata('fail', 'Kamu harus login terlebih dahulu');

            redirect('auth/login');
        }
        if (!$this->user_auth->is_admin()) {
            redirect('home');
        }

        $this->load->helper('file');
        $this->load->helper('slugify');
        $this->load->library('upload');

        require_once APPPATH . 'third_party/ssp.php';
        $this->db->db_connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin CI3 Store',
            'content' => 'backend/pages/dashboard'
        ];
        $this->load->view('backend/layout/page-layout', $data, FALSE);
    }

    public function profile()
    {
        $data = [
            'title' => 'Pengaturan profile admin',
            'content' => 'backend/pages/profile'
        ];
        $this->load->view('backend/layout/page-layout', $data, FALSE);
    }
    // Fungsi validasi custom untuk username
    public function username_check($new_username, $current_username)
    {
        if ($new_username !== $current_username) {
            $user = $this->db->get_where('users', ['username' => $new_username])->row();
            return !$user;
        }
        return true;
    }

    // Fungsi validasi custom untuk email
    public function email_check($new_email, $current_email)
    {
        if ($new_email !== $current_email) {
            $user = $this->db->get_where('users', ['email' => $new_email])->row();
            return !$user;
        }
        return true;
    }

    public function updatePersonalDetails()
    {

        if ($this->input->is_ajax_request()) {
            $user = $this->db->get_where('users', ['id' => $this->user_auth->id()])->row();
            $this->form_validation->set_rules('name', 'Name', 'required', [
                'required' => 'Nama tidak boleh kosong'
            ]);
            $this->form_validation->set_rules('username', 'Username', [
                'trim',
                'required',
                'min_length[6]',
                ['username_check', function ($username) use ($user) {
                    return $this->username_check($username, $user->username);
                }]
            ], [
                'required' => 'Username Tidak boleh Kosong',
                'min_length' => 'Username minimal 6 karakter',
                'username_check' => 'Username Telah digunakan'
            ]);

            // Aturan validasi untuk email
            $this->form_validation->set_rules('email', 'Email', [
                'trim',
                'required',
                'valid_email',
                ['email_check', function ($email) use ($user) {
                    return $this->email_check($email, $user->email);
                }]
            ], [
                'required' => 'Email Tidak boleh kosong',
                'valid_email' => 'Masukan email yang valid',
                'email_check' => 'Email telah di gunakan'
            ]);
            $this->form_validation->set_rules('phone', '', 'numeric', [
                'numeric' => 'Nomor ponsel harus berupa angka'
            ]);


            if ($this->form_validation->run() == FALSE) {
                $errors = $this->form_validation->error_array();

                echo json_encode(['status' => 0, 'error' => $errors]);
            } else {
                $user_id = $this->user_auth->id();
                $update = $this->db->where('id', $user_id)->set([
                    'name' => $this->input->post('name'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                ])->update('users');

                if ($update) {
                    $user_info = $this->db->get_where('users', ['id' => $this->user_auth->id()], 1)->row();
                    echo json_encode(['status' => 1, 'user_info' => $user_info, 'msg' => 'Sukses, Berhasil update info pribadi']);
                }
            }
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Something went wrong']);
        }
    }
    public function updateProfilePicture()
    {
        $user_id = $this->user_auth->id();
        $user_info = $this->db->get_where('users', ['id' => $user_id], 1)->row();
        $path = FCPATH . '/uploads/users/';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048;  // 2MB
        $config['file_name'] = 'UIMG_' . $user_id . time();
        // print_r($_FILES);

        $this->upload->initialize($config);
        if ($this->upload->do_upload('user_profile_file')) {
            $upload_data = $this->upload->data();
            $new_profile_picture = $upload_data['file_name'];
            if ($user_info->picture != null) {
                $old_picture_path = $path . $user_info->picture;
                if (file_exists($old_picture_path)) {
                    unlink($old_picture_path);
                }
            }
            $this->db->where('id', $user_id)->set(['picture' => $new_profile_picture])->update('users');
            echo json_encode(['status' => 1, 'msg' => 'Berhasil perbarui user profile picture']);
        } else {
            $error = $this->upload->display_errors();
            echo json_encode(['status' => 0, 'msg' => 'Something Went Wrong', 'error' => $error, 'upload_path' => $path, 'upload_config' => $this->upload->data()]);
        }
    }

    // Pengaturan User Aktif
    public function manageUser()
    {
        $all_user = $this->db->get('users')->result();
        $data = array(
            'title' => 'Manajemen Akun Pengguna',
            'content' => 'backend/pages/manage-user',
            'users' => $all_user

        );
        $this->load->view('backend/layout/page-layout', $data, FALSE);
    }

    public function deleteUser()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('user_id');
            $delete = $this->db->where('id', $id)->delete('users');

            if ($delete) {
                echo json_encode(['status' => 1, 'msg' => 'User Berhasil di hapus']);
            } else {
                echo json_encode(['status' => 0, 'msg' => 'Something went wrong']);
            }
        }
    }

    public function Category()
    {
        $ctx = array(
            'title' => 'Pengaturan Kategori',
            'content' => 'backend/pages/category'
        );
        $this->load->view('backend/layout/page-layout', $ctx, FALSE);
    }

    public function addCategory()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('name', 'Nama Kategori', 'required|is_unique[categories.name]', [
                'required' => '%s Tidak boleh kosong',
                'is_unique' => '%s telah ada'
            ]);

            if ($this->form_validation->run() == FALSE) {
                # code...
                $error = $this->form_validation->error_array();
                echo json_encode(['status' => 0, 'error' => $error['name']]);
            } else {
                # code...
                $category_name = $this->input->post('name');
                $category_slug = slugify($category_name);
                $save =  $this->db->insert('categories', ['name' => $category_name, 'slug' => $category_slug]);

                if ($save) {
                    echo json_encode(['status' => 1, 'msg' => 'Berhasil tambah kategori']);
                } else {
                    echo json_encode(['status' => 0, 'msg' => 'Something went wrong']);
                }
            }
        }
    }
    public function getCategories()

    {
        $dbDetails = [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'db' => 'ci3-e-commerce'
        ];

        $table = 'categories';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 0
            ],
            [
                'db' => 'name',
                'dt' => 1
            ],
            [
                'db' => 'id',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    $product = $this->db->get_where('product', ['category' => $row['id']])->result();
                    return count($product) . ' Produk';
                }
            ],
            [
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    return "<div class='btn-group'>
                                <button class='btn btn-sm btn-link p-0 mx-1 editCategoryBtn' data-id='" . $row['id'] . "'>Edit</button>
                                <button class='btn btn-sm btn-link p-0 mx-1 deleteCategoryBtn' data-id='" . $row['id'] . "'>Delete</button>
                    ";
                }
            ],

            [
                'db' => 'ordering',
                'dt' => 4,
            ]
        ];

        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }
    public function getCategory()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('category_id');
            $data = $this->db->get_where('categories', ['id' => $id], 1)->row_array();
            echo json_encode(['data' => $data]);
        }
    }

    public function category_check($new_category, $current_category)
    {
        if ($new_category !== $current_category) {
            $category = $this->db->get_where('categories', ['name' => $new_category])->row();
            return !$category;
        }
        return true;
    }
    public function updateCategory()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('category_id');
            $current_category = $this->input->post('name');
            $this->form_validation->set_rules(
                'name',
                'Nama Kategori',
                'required|callback_category_check[' . $current_category . ']',
                [
                    'required' => '%s tidak boleh kosong',
                    'category_check' => '%s telah ada'
                ]
            );

            if ($this->form_validation->run() == FALSE) {
                # code...
                $error = $this->form_validation->error_array();
                echo json_encode(['status' => 0, 'error' => $error['name']]);
            } else {
                # code...
                $update = $this->db->where('id', $id)->set(['name' => $this->input->post('name')])->update('categories');
                if ($update) {
                    echo json_encode(['status' => 1, 'msg' => 'Berhasil Update Nama Kategori']);
                } else {
                    echo json_encode(['status' => 0, 'msg' => 'Something went wrong']);
                }
            }
        }
    }
    public function deleteCategory()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('category_id');
            $delete = $this->db->where('id', $id)->delete('categories');
            if ($delete) {
                echo json_encode(['status' => 1, 'msg' => 'Berhasil Hapus Kategori']);
            } else {
                echo json_encode(['status' => 0, 'msg' => 'Something Went Wrong']);
            }
        }
    }

    public function reorderCategory()
    {
        if ($this->input->is_ajax_request()) {
            $positions = $this->input->get('position');

            foreach ($positions as $p) {
                $index = $p[0];
                $new_position = $p[1];
                $this->db->where('id', $index)->set(['ordering' => $new_position])->update('categories');
            }

            echo json_encode(['status' => 1, 'msg' => 'urutan kategori berhasil di perbarui']);
        }
    }

    public function addProduct()
    {
        $data = [
            'content' => 'backend/pages/product',
            'title' => 'Manajemen Produk',
            'categories' => $this->db->get('categories')->result()
        ];

        $this->load->view('backend/layout/page-layout', $data, FALSE);
    }
    public function addProductHandler()
    {
        $errors = [];
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('name', 'Nama Produk', 'required|is_unique[product.name]', [
                'required' => '%s tidak boleh kosong',
                'is_unique' => '%s Telah ada'
            ]);

            $this->form_validation->set_rules('stok', 'Stok', 'numeric', ['numeric' => '%s Harus berupa angka']);
            $this->form_validation->set_rules('price', 'Harga', 'numeric|required', ['numeric' => '%s Harus berupa angka', 'required' => 'Inputkan Harga']);
            $this->form_validation->set_rules('category', 'Kategori', 'required', ['required' => 'Pilih Salah satu kategori']);
            $this->form_validation->set_rules('image', 'Gambar Produk', 'callback_file_check[image]');

            $path = FCPATH . '/uploads/produk/';

            if (!is_dir($path)) {
                mkdir($path, 0777, false);
            }
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;  // 2MB
            // $config['file_name'] = 'P_' . time() . $config['file_name'];
            $this->upload->initialize($config);

            if ($this->form_validation->run() == FALSE) {
                # code...
                $errors = $this->form_validation->error_array();
                echo json_encode(['status' => 0, 'error' => $errors, 'value' => $this->input->post('stok')]);
            } else {
                # code...
                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $new_product_name = $upload_data['file_name'];
                }
                $product_name = $this->input->post('name');
                $slug = slugify($product_name);
                $data = [
                    'name' => $product_name,
                    'slug' => $slug,
                    'image' => $new_product_name,
                    'description' => $this->input->post('description'),
                    'stock' => $this->input->post('stok'),
                    'is_available' => $this->input->post('stok') > 0 ? '1' : '0',
                    'category' => $this->input->post('category'),
                    'price' => $this->input->post('price')
                ];

                if ($this->db->insert('product', $data)) {
                    echo json_encode(['status' => 1, 'msg' => 'Berhasil tambah produk baru']);
                } else {
                    echo json_encode(['status' => 0, 'msg' => 'Something went wrong']);
                }
            }
        }
    }
    public function file_check($str, $field)
    {
        $allowed_mime_type_arr = array('image/jpeg', 'image/png', 'image/gif');
        $mime = get_mime_by_extension($_FILES[$field]['name']);
        if (isset($_FILES[$field]['name']) && $_FILES[$field]['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                return TRUE;
            } else {
                $this->form_validation->set_message('file_check', "Pilih hanya jpg/png/gif file");
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('file_check', "Pilih Gambar produk");
            return FALSE;
        }
    }
    public function getAllProduct()
    {
        $data = [
            'title' => 'Semua Produk',
            'products' => $this->db->get('product'),
            'content' => 'backend/pages/get_produk'
        ];
        $this->load->view('backend/layout/page-layout', $data, FALSE);
    }
    public function getProducts()
    {
        $dbDetails = [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'db' => 'ci3-e-commerce'
        ];

        $table = 'product';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 0
            ],
            [
                'db' => 'name',
                'dt' => 1
            ],
            [
                'db' => 'stock',
                'dt' => 2,

            ],
            [
                'db' => 'price',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    return $d != null ? formatRupiah($d) : '0';
                }
            ],

            [
                'db' => 'category',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    $category = $this->db->get_where('categories', ['id' => $row['category']])->row();
                    return $category->name != null || $category->name != '' ? $category->name : 'Uncategorized';
                }
            ],

            [
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    $product = $this->db->get_where('product', ['id' => $d])->row();
                    return "<div class='btn-group'>
                                <a href='" . base_url('admin/updateProduct/' . urlencode($product->slug)) . "' class='btn btn-sm btn-link p-0 mx-1 editProductBtn' data-id='" . $row['id'] . "'>Edit</a>
                                <button class='btn btn-sm btn-link p-0 mx-1 deleteProductBtn' data-id='" . $row['id'] . "'>Delete</button>
                    ";
                }
            ],
        ];
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }
    public function updateProduct($product_slug)
    {
        if (!$product_slug) {
            echo '405';
        } else {
            $product_data = $this->db->get_where('product', ['slug' => $product_slug])->row();
            $categories = $this->db->get('categories')->result();
            $data = [
                'title' => 'Update Produk',
                'content' => 'backend/pages/update_product',
                'data' => $product_data,
                'categories' => $categories
            ];
            $this->load->view('backend/layout/page-layout', $data, FALSE);
        }
    }
    public function updateProductHandler()
    {

        $product_data = $this->db->get_where('product', ['id' => $this->input->post('id')])->row();
        // $categories = $this->db->get('categories')->result();
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('name') != $product_data->name) {
                $this->form_validation->set_rules('name', 'Nama Produk', 'required|is_unique[product.name]', [
                    'required' => '%s Tidak boleh kosong',

                    'is_unique' => '%s telah ada'
                ]);
            } else {
                $this->form_validation->set_rules('name', 'Nama Produk', 'required', [
                    'required' => '%s Tidak boleh kosong'
                ]);
            }
            $this->form_validation->set_rules('price', 'Harga', 'required|numeric', [
                'required' => 'inputkan %s',
                'numeric' => 'Hanya angka'
            ]);

            $this->form_validation->set_rules('category', 'Nama Kategori', 'required', ['Pilih satu %s']);

            $this->form_validation->set_rules('stok', '', 'numeric', ['numeric' => 'Hanya Angka']);

            if ($product_data->image == null) {
                $this->form_validation->set_rules('image', 'Gambar Produk', 'callback_file_check[image]');
            } elseif ($_FILES['image']['name'] != '' && $_FILES['image']['name'] != $product_data->image) {
                $this->form_validation->set_rules('image', 'Gambar Produk', 'callback_file_check[image]');
            }

            $path = FCPATH . '/uploads/produk/';

            if (!is_dir($path)) {
                mkdir($path, 0777, false);
            }
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;  // 2MB
            // $config['file_name'] = 'P_' . time() . $config['file_name'];
            $this->upload->initialize($config);
            if ($this->form_validation->run() == FALSE) {
                # code...
                $errors = $this->form_validation->error_array();
                echo json_encode(['status' => 0, 'error' => $errors]);
            } else {
                if ($_FILES['image']['name'] != '') {
                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $update_file_name = $upload_data['file_name'];

                        if ($product_data->image != null) {
                            $old_picture_path = $path . $product_data->image;
                            if (file_exists($old_picture_path)) {
                                unlink($old_picture_path);
                            }
                        }
                    }
                } else {
                    $update_file_name = $product_data->image;
                }

                $product_name = $this->input->post('name');
                $slug = slugify($product_name);
                $data = [
                    'name' => $product_name,
                    'slug' => $slug,
                    'image' => $update_file_name,
                    'description' => $this->input->post('description'),
                    'stock' => $this->input->post('stok'),
                    'is_available' => $this->input->post('stok') > 0 ? '1' : '0',
                    'category' => $this->input->post('category'),
                    'price' => $this->input->post('price')
                ];


                if ($this->db->where('id', $this->input->post('id'))->set($data)->update('product')) {
                    $this->session->set_flashdata('updateproduct', 'Nice Data Produk Berhasil di update');

                    echo json_encode(['status' => 1, 'msg' => 'sukses update data produk', 'url' => base_url('admin/getAllProduct')]);
                } else {
                    echo json_encode(['status' => 0, 'msg' => 'something went wrong']);
                }
            }
        }
    }

    public function deleteProduct()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('product_id');
            $product_data = $this->db->get_where('product', ['id' => $id])->row();
            $path = FCPATH . '/uploads/produk/';
            if ($product_data->image != null) {
                $old_picture_path = $path . $product_data->image;
                if (file_exists($old_picture_path)) {
                    unlink($old_picture_path);
                }
            }
            $product_variations = $this->db->get_where('product_variations', ['product_id' => $id])->result();
            $delete = $this->db->where('id', $id)->delete('product');
            if ($delete) {
                if ($product_variations) {
                    $this->db->where('product_id', $id)->delete('product_variations');
                }

                echo json_encode(['status' => 1, 'msg' => 'Berhasil Hapus Produk']);
            } else {
                echo json_encode(['status' => 0, 'msg' => 'Something Went Wrong']);
            }
        }
    }

    public function productVariations()
    {
        $product = $this->db->get('product')->result();

        $data = [
            'title' => 'Manage Produk Variations',
            'product' => $product,
            'content' => 'backend/pages/product_variations'
        ];

        $this->load->view('backend/layout/page-layout', $data, FALSE);;
    }

    public function getVariationKey()
    {
        if ($this->input->is_ajax_request()) {
            $product_id = $this->input->get('product_id');

            $variations = $this->db->get_where('product_variations', ['id' => $product_id])->row_array();
            if (!$variations) {
                echo json_encode(['status' => 1, 'msg' => 'is null']);
            } else {
                print_r($variations);
                foreach ($variations as $i) {
                }
                echo json_encode(['status' => 0, 'msg' => 'is not null']);
            }
        }
    }
    // public function addNewVariationKey(){
    //     if($this->input->is_ajax_request()
    //     ){
    //         $variation_key = $this->input->post('variation_key');

    //     }
    // }

    public function getProductVariations()
    {
        $dbDetails = [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'db' => 'ci3-e-commerce'
        ];

        $table = 'product_variations';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'id',
                'dt' => 0
            ],
            [
                'db' => 'product_id',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    $product = $this->db->get_where('product', ['id' => $row['product_id']])->row();
                    if ($product) {
                        return substr($product->name, 0, 30);
                    } else {
                        return 'Produk is Null';
                    }
                }
            ],
            [
                'db' => 'variations_key',
                'dt' => 2,

            ],
            [
                'db' => 'variations_value',
                'dt' => 3,

            ],
            [
                'db' => 'variations_price',
                'dt' => 4,

            ],
            [
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return "<div class='btn-group'>
                                <button class='btn btn-sm btn-link p-0 mx-1 editVariationsBtn' data-id='" . $row['id'] . "'>Edit</button>
                                <button class='btn btn-sm btn-link p-0 mx-1 deleteVariationsBtn' data-id='" . $row['id'] . "'>Delete</button>
                    ";
                }
            ]
        ];

        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function addProductVariations()
    {
        if ($this->input->is_ajax_request()) {
            $product_id  = $this->input->post('product');
            $variation_key = $this->input->post('variation_key');
            $variation_value = $this->input->post('variation_value');
            $variation_price = $this->input->post('variation_price');
            $is_active = $this->input->post('is_active');
            $this->form_validation->set_rules('product', 'Id Produk', 'required', ['required' => 'Pilih Produk']);
            $this->form_validation->set_rules('variation_key', '', 'required', ['required' => 'Input Key Variasi']);
            $this->form_validation->set_rules('variation_value', '', 'required', ['required' => 'Input Value']);
            $this->form_validation->set_rules('variation_price', '', 'numeric', ['numeric' => 'Input Value Angka']);

            if ($this->form_validation->run() == FALSE) {
                # code...
                $errors = $this->form_validation->error_array();
                echo json_encode(['status' => 0, 'error' => $errors]);
            } else {
                # code...
                $is_active = $is_active === null ? false : true;
                $exists = $this->db->get_where('product_variations', [
                    'product_id' => $product_id,
                    'variations_key' => $variation_key,
                    'variations_value' => $variation_value
                ])->num_rows() > 0;

                if ($exists) {
                    echo json_encode(['status' => 0, 'msg' => 'Variasi dengan kombinasi ini sudah ada.']);
                } else {
                    $variations = [
                        'product_id' => $product_id,
                        'variations_key' => $variation_key,
                        'variations_value' => $variation_value,
                        'variations_price' => $variation_price != '' ? $variation_price : 0,
                        'is_active' => $is_active
                    ];

                    $insert = $this->db->insert('product_variations', $variations);

                    if ($insert) {
                        echo json_encode(['status' => 1, 'msg' => 'Produk Variasi ditambahkan', 'variations' => $variations]);
                    } else {
                        echo json_encode(['status' => 0, 'msg' => 'Something went wrong']);
                    }
                }
            }
        }
    }

    public function getVariation()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('v_id');
            $data = $this->db->get_where('product_variations', ['id' => $id], 1)->row();
            echo json_encode(['variation' => $data]);
        }
    }

    public function updateProductVariations()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('v_id');
            $product_id  = $this->input->post('product');
            $variation_key = $this->input->post('variation_key');
            $variation_value = $this->input->post('variation_value');
            $variation_price = $this->input->post('variation_price');
            $is_active = $this->input->post('is_active');
            $this->form_validation->set_rules('product', 'Id Produk', 'required', ['required' => 'Pilih Produk']);
            $this->form_validation->set_rules('variation_key', '', 'required', ['required' => 'Input Key Variasi']);
            $this->form_validation->set_rules('variation_value', '', 'required', ['required' => 'Input Value']);
            $this->form_validation->set_rules('variation_price', '', 'numeric', ['numeric' => 'Input Value Angka']);

            if ($this->form_validation->run() == FALSE) {
                # code...
                $errors = $this->form_validation->error_array();
                echo json_encode(['status' => 0, 'error' => $errors]);
            } else {
                # code...
                $is_active = $is_active === null ? false : true;
                $exists = $this->db->get_where('product_variations', [
                    'product_id' => $product_id,
                    'variations_key' => $variation_key,
                    'variations_value' => $variation_value
                ])->num_rows() > 0;

                if ($exists) {
                    echo json_encode(['status' => 0, 'msg' => 'Variasi dengan kombinasi ini sudah ada.']);
                } else {
                    $variations = [
                        'product_id' => $product_id,
                        'variations_key' => $variation_key,
                        'variations_value' => $variation_value,
                        'variations_price' => $variation_price != '' ? $variation_price : 0,
                        'is_active' => $is_active
                    ];

                    $update = $this->db->where('id', $id)->set($variations)->update('product_variations');
                    if ($update) {
                        echo json_encode(['status' => 1, 'msg' => 'Produk Variasi di update', 'variations' => $variations]);
                    } else {
                        echo json_encode(['status' => 0, 'msg' => 'Something went wrong']);
                    }
                }
            }
        }
    }

    public function deleteProductVariations()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('v_id');
            $delete = $this->db->where('id', $id)->delete('product_variations');
            if ($delete) {
                echo json_encode(['status' => 1, 'msg' => 'Berhasil Hapus Produk Variasi']);
            } else {
                echo json_encode(['status' => 0, 'msg' => 'Something Went Wrong']);
            }
        }
    }
}