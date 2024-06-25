<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_auth');
        if (!$this->user_auth->check()) {
            $this->session->set_flashdata('fail', 'Kamu harus login terlebih dahulu');

            redirect('auth/login');
        }
        $this->load->model('product_model');
    }

    public function index()
    {

        $cart_item = $this->db->select('cart.id as cart_id, product.id as product_id, cart.*, product.*')
            ->from('cart')
            ->join('product', 'product.id=cart.product_id')
            ->where('cart.user_id', $this->user_auth->id())
            ->get()
            ->result();
        foreach ($cart_item as $item) {
            if ($item->variations != null) {
                foreach (json_decode($item->variations) as $k => $v) {
                    $product_variations[$k] = $v;

                    $item->variations_price = $this->product_model->varitionsPriceCart($product_variations);
                }
            }
        }


        $cart_totals = get_cart_amount($this->user_auth->id());

        $grand_total = $cart_totals['grand_total'];
        $subtotals = $cart_totals['subtotals'];
        $data = array(
            'title' => 'Keranjang Belanja',
            'content' => 'frontend/pages/cart',
            'cart_item' => $cart_item,
            'subtotal' => $subtotals,
            'grand_total' => $grand_total
        );
        $this->load->view('frontend/layout/pages-layout', $data, FALSE);
    }

    public function getVariationPrice()
    {
        if ($this->input->is_ajax_request()) {
            $variationsPrice = 0;
            $selectedOptions = $this->input->get('data');
            foreach ($selectedOptions as $key => $val) {
                $variationsObj = $this->db->get_where('product_variations', ['variations_key' => $key, 'variations_value' => $val])->result();
                if ($variationsObj) {
                    foreach ($variationsObj as $var) {
                        if ($var->variations_price != 0) {
                            $variationsPrice += $var->variations_price;
                            if ($variationsPrice > 0) {
                                echo json_encode(['variations_price' => formatRupiah($variationsPrice)]);
                            }
                        }
                    }
                }
            }
        }
    }
    public function addtocart()
    {
        if ($this->input->is_ajax_request()) {
            // Ambil data variasi produk
            $product_variations = [];
            $product = $this->db->get_where('product', ['id' => $this->input->post('product_id')])->row();
            $variations_cart = $this->input->post('variations');
            if ($variations_cart) {
                foreach ($variations_cart as $key => $val) {
                    $variations = $this->db->get_where('product_variations', ['product_id' => $this->input->post('product_id'), 'variations_key' => $key, 'variations_value' => $val])->row();
                    if ($variations) {
                        $product_variations[$key] = $val;
                    }
                }
            }
            $is_cart_item_exist = $this->db->get_where('cart', ['user_id' => $this->user_auth->id(), 'product_id' => $this->input->post('product_id')])->num_rows();
            if ($is_cart_item_exist > 0) {
                $cart_item = $this->db->get_where('cart', ['user_id' => $this->user_auth->id(), 'product_id' => $this->input->post('product_id')])->result();
                if (!empty($this->input->post('variations'))) {
                    $exist_variations_list = [];
                    $id = [];
                    foreach ($cart_item as $item) {
                        if ($item->variations != null) {
                            $exist_variations = json_decode($item->variations);
                            $exist_variations_list[] = $exist_variations;
                            $id[] = $item->id;
                        }
                    }
                    $is_exist = false;
                    $index = false;
                    foreach ($exist_variations_list as $i => $var) {
                        if ((array) $var == $product_variations) {
                            $is_exist = true;
                            $index = $i;
                            break;
                        }
                    }
                    if ($is_exist) {
                        $item_id = $id[$index];
                        $item = $this->db->get_where('cart', ['product_id' => $product->id, 'id' => $item_id])->row();

                        if ($item) {
                            $new_quantity = $item->quantity + $this->input->post('quantity');
                            $this->db->where('id', $item_id)
                                ->where('product_id', $product->id)
                                ->set(['quantity' => $new_quantity])->update('cart');
                            echo json_encode(['cart_count' => get_cart_count(), 'msg' => 'success grouping cart item based on variations ']);
                        }
                    } else {
                        $new_cart_item = array(
                            'user_id' => $this->user_auth->id(),
                            'product_id' => $this->input->post('product_id'),
                            'quantity' => $this->input->post('quantity'),
                        );
                        if (!empty($product_variations) > 0) {
                            $new_cart_item['variations'] = json_encode($product_variations);
                        }

                        $item = $this->db->insert('cart', $new_cart_item);
                        if ($item) {
                            $cart_totals = get_cart_amount($this->user_auth->id());

                            echo json_encode(['cart_count' => get_cart_count(), 'status' => 1, 'cart_item_new' => $new_cart_item, 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
                        } else {
                            $cart_totals = get_cart_amount($this->user_auth->id());

                            echo json_encode(['cart_count' => get_cart_count(), 'status' => 0, 'error' => 'something went wrong', 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
                        }
                    }
                } else {
                    $cart_item = $this->db->get_where('cart', ['user_id' => $this->user_auth->id(), 'product_id' => $this->input->post('product_id')])->row();
                    $item = $this->db->get_where('cart', ['product_id' => $product->id, 'id' => $cart_item->id])->row();

                    if ($item) {
                        $new_quantity = $item->quantity + $this->input->post('quantity');
                        $this->db->where('id', $cart_item->id)
                            ->where('product_id', $product->id)
                            ->set(['quantity' => $new_quantity])->update('cart');
                        $cart_totals = get_cart_amount($this->user_auth->id());

                        echo json_encode(['cart_count' => get_cart_count(), 'msg' => 'success grouping cart item based on product id', 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
                    }
                }
            } else {
                $new_cart_item = array(
                    'user_id' => $this->user_auth->id(),
                    'product_id' => $this->input->post('product_id'),
                    'quantity' => $this->input->post('quantity'),
                );

                if (!empty($product_variations)) {
                    $new_cart_item['variations'] = json_encode($product_variations);
                }
                $insert = $this->db->insert('cart', $new_cart_item);
                if ($insert) {
                    $cart_totals = get_cart_amount($this->user_auth->id());

                    echo json_encode(['cart_count' => get_cart_count(), 'status' => 1, 'cart_item_new' => $new_cart_item, 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
                } else {
                    $cart_totals = get_cart_amount($this->user_auth->id());

                    echo json_encode(['cart_count' => get_cart_count(), 'status' => 0, 'error' => 'something went wrong', 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
                }
            }
        }
    }
    public function decrease_qty()
    {
        if ($this->input->is_ajax_request()) {
            $cart_id = $this->input->post('cart_id');
            $cart_item = $this->db->get_where('cart', ['id' => $cart_id, 'user_id' => $this->user_auth->id()])->row();
            if (!empty($cart_item)) {
                $qty = $cart_item->quantity;
                if ($qty > 1) {
                    $qty -= 1;
                    $this->db->where('id', $cart_id)
                        ->where('user_id', $this->user_auth->id())
                        ->set(['quantity' => $qty])->update('cart');
                } else {
                    $qty = 0;
                    $this->db->where('id', $cart_id)
                        ->where('user_id', $this->user_auth->id())
                        ->set(['quantity' => $qty])->delete('cart');
                }

                $cart_totals = get_cart_amount($this->user_auth->id());
                echo json_encode(['status' => 1, 'cart_count' => get_cart_count(), 'qty' => $qty, 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals'], 'msg' => 'Berhasil Hapus Item dari keranjang']);
            } else {
                $cart_totals = get_cart_amount($this->user_auth->id());

                echo json_encode(['status' => 0, 'cart_count' => get_cart_count(), 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
            }
        }
    }

    public function increase_qty()
    {
        if ($this->input->is_ajax_request()) {
            $cart_id = $this->input->post('cart_id');
            $cart_item = $this->db->get_where('cart', ['id' => $cart_id, 'user_id' => $this->user_auth->id()])->row();
            $product = $this->db->get_where('product', ['id' => $cart_item->product_id])->row();

            if (!empty($cart_item)) {
                $qty = $cart_item->quantity;
                $qty += 1;

                if ($qty == $product->stock) {
                    $cart_totals = get_cart_amount($this->user_auth->id());

                    echo json_encode(['status' => 0, 'cart_count' => get_cart_count(), 'qty' => $qty, 'error' => 'Kuantitas Telah Mencapai Maks Stock Produk', 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
                } else {
                    $this->db->where('id', $cart_id)
                        ->where('user_id', $this->user_auth->id())
                        ->set(['quantity' => $qty])->update('cart');
                    $cart_totals = get_cart_amount($this->user_auth->id());

                    echo json_encode(['status' => 1, 'cart_count' => get_cart_count(), 'qty' => $qty, 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
                }
            }
        }
    }
    public function remove_cart()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('cart_id');
            $delete = $this->db->where('id', $id)->where('user_id', $this->user_auth->id())->delete('cart');
            if ($delete) {
                $cart_totals = get_cart_amount($this->user_auth->id());

                echo json_encode(['status' => 1, 'msg' => 'berhasil hapus item dari keranjang belanja', 'cart_count' => get_cart_count(), 'grand_total' => $cart_totals['grand_total'], 'subtotals' => $cart_totals['subtotals']]);
            } else {
                echo json_encode(['status' => 0, 'msg' => 'Something Went Wrong']);
            }
        }
    }

    public function checkout()
    {
        $cart_item = $this->db->select('cart.id as cart_id, product.id as product_id, cart.*, product.*')
            ->from('cart')
            ->join('product', 'product.id=cart.product_id')
            ->where('cart.user_id', $this->user_auth->id())
            ->get()
            ->result();
        foreach ($cart_item as $item) {
            if ($item->variations != null) {
                foreach (json_decode($item->variations) as $k => $v) {
                    $product_variations[$k] = $v;

                    $item->variations_price = $this->product_model->varitionsPriceCart($product_variations);
                }
            }
        }
        $cart_totals = get_cart_amount($this->user_auth->id());
        $w_provinsi = $this->db->select('kode,nama')
            ->from('wilayah')
            ->where('CHAR_LENGTH(kode)', 2)
            ->order_by('nama', 'ASC')
            ->get()->result();
        if (!empty($cart_item)) {
            $data = [
                'title' => 'Checkout',
                'content' => 'frontend/pages/checkout',
                'cart_item' => $cart_item,
                'subtotal' => $cart_totals['subtotals'],
                'grand_total' => $cart_totals['grand_total'],
                'w_provinsi' => $w_provinsi
            ];
            $this->load->view('frontend/layout/pages-layout', $data, FALSE);
        } else {
            $this->session->set_flashdata('fail', 'Opss, Keranjang belanja anda masih kosong');
            redirect('cart');
        }
    }
    public function get_daerah()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id') != '') {
                $id = $this->input->post('id');
                $data = $this->input->post('data');
                $n = strlen($id);
                $m = ($n == 2 ? 5 : ($n == 5 ? 8 : 13));

                if ($data == 'kabupaten') {
                    $w_kabupaten = $this->db->select('kode,nama')
                        ->from('wilayah')
                        ->where('LEFT(kode,' . $n . ')', $id)
                        ->where('CHAR_LENGTH(kode)', $m)
                        ->order_by('nama', 'ASC')
                        ->get()->result();
                    $output = '<option value="" selected>--Pilih Kota</option>';
                    foreach ($w_kabupaten as $kab) {
                        $output .= '<option value="' . $kab->kode . '">' . $kab->nama . '</option>';
                    }
                    echo $output;
                } else if ($data == 'kecamatan') {
                    $w_kecamatan = $this->db->select('kode,nama')
                        ->from('wilayah')
                        ->where('LEFT(kode,' . $n . ')', $id)
                        ->where('CHAR_LENGTH(kode)', $m)
                        ->order_by('nama', 'ASC')
                        ->get()->result();
                    $output = '<option value="" selected>--Pilih Kecamatan</option>';
                    foreach ($w_kecamatan as $kec) {
                        $output .= '<option value="' . $kec->kode . '">' . $kec->nama . '</option>';
                    }
                    echo $output;
                }
            }
        }
    }

    public function reverse_geocode()
    {
        if ($this->input->is_ajax_request()) {
            $lat = $this->input->get('lat');
            $lon = $this->input->get('lon');

            if ($lat && $lon) {
                $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" . $lat . "&lon=" . $lon;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: my-application']);

                $response = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($response, true);

                if (!empty($data)) {
                    $address = isset($data['display_name']) ? $data['display_name'] : "Address not available";
                    echo $address;
                } else {
                    echo "null response";
                }
            } else {
                echo "Invalid coordinates";
            }
        } else {
            echo "Invalid request";
        }
    }
}

/* End of file Cart.php */