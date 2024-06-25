<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    public function product_detail($product_slug)
    {
        if ($product_slug) {
            $product_data  = $this->db->get_where('product', ['slug' => $product_slug], 1)->row();

            $product_variations = $this->db->get_where('product_variations', ['product_id' => $product_data->id])->result_array();
            $grouped_variations = [];
            // print_r($product_variations);
            if ($product_variations) {
                foreach ($product_variations as $variation) {

                    $key = $variation['variations_key'];
                    $value = ['value' => $variation['variations_value'], 'is_active' => $variation['is_active']];
                    if (!isset($grouped_variations[$key])) {
                        $grouped_variations[$key] = [];
                    }
                    $grouped_variations[$key][] = $value;
                }
            }
            // print_r($grouped_variations);
            $data = array(
                'title' => 'Jual ' . $product_data->name,
                'content' => 'frontend/pages/product_detail',
                'product' => $product_data,
                'variations' => !empty($grouped_variations) ? $grouped_variations : null

            );
            $this->load->view('frontend/layout/pages-layout', $data, FALSE);
        } else {
            echo "404 Page Not Found <a class='btn btn-md btn-primary' href='" . base_url() . "'>Home </a>";
        }
    }
}

/* End of file Product.php */