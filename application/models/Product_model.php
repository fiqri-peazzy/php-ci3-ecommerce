<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public function varitionsPriceCart($product_variations)
    {
        $variations_price = 0;
        if ($product_variations) {
            foreach ($product_variations as $key => $val) {
                $variations = $this->db->get_where('product_variations', ['variations_key' => $key, 'variations_value' => $val])->result();
                if ($variations) {
                    foreach ($variations as $v) {
                        if ($v->variations_price > 0) {
                            $variations_price += $v->variations_price;
                            break;
                        }
                    }
                }
            }
        }
        return $variations_price;
    }
}

/* End of file Product_model.php */