<?php




if (!function_exists('get_user')) {
    function get_user()
    {

        $CI = &get_instance();
        $CI->load->database();
        $CI->load->library('user_auth');
        $user_id = $CI->user_auth->id();
        $user = $CI->db->get_where('users', ['id' => $user_id], 1)->row();
        return $user;
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($number)
    {
        return "Rp " . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('getProductVariations')) {
    function getVariationsPrice($product_id)
    {
        $CI = &get_instance();
        $CI->load->database();
        $id = $product_id;
        $variations = $CI->db->get_where('product_variations', ['product_id' => $id])->result();
        $product = $CI->db->get_where('product', ['id' => $id], 1)->row();
        $variations_price = [];
        if ($variations) {
            foreach ($variations as $v) {
                if ($v->variations_price > 0) {
                    $variations_price[] = $v->variations_price;
                }
            }
        }
        if (count($variations_price) > 0) {
            return formatRupiah(min($variations_price)) . " - " . formatRupiah(max($variations_price));
        } else {
            return formatRupiah($product->price);
        }
    }
}

if (!function_exists('get_cart_count')) {
    function get_cart_count()
    {
        $CI = &get_instance();
        $CI->load->database();
        $CI->load->library('user_auth');
        $current_user = $CI->user_auth->id();
        $cart_count = 0;

        $cart_items = $CI->db->get_where('cart', ['user_id' => $current_user])->result();
        if ($cart_items) {
            foreach ($cart_items as $item) {
                $cart_count += $item->quantity;
            }
        } else {
            $cart_count = 0;
        }

        return $cart_count;
    }
}
if (!function_exists('get_cart_amount')) {
    function get_cart_amount($user_id)
    {
        $CI = &get_instance();
        $CI->load->database();
        $grand_total = 0;
        $subtotals = [];

        $cart_items = $CI->db->select('cart.id as cart_id, product.id as product_id, cart.*, product.*')
            ->from('cart')
            ->join('product', 'product.id=cart.product_id')
            ->where('cart.user_id', $user_id)
            ->get()
            ->result();

        if (!empty($cart_items)) {
            foreach ($cart_items as $item) {
                $item_subtotal = 0;
                if ($item->variations != null) {
                    $variations_cart = json_decode($item->variations);
                    if ($variations_cart != null) {
                        $price = 0;
                        foreach ($variations_cart as $key => $val) {
                            $variations = $CI->db->get_where('product_variations', ['variations_key' => $key, 'variations_value' => $val])->result();

                            if ($variations) {
                                foreach ($variations as $var) {
                                    if ($var->variations_price != 0) {
                                        $price += $var->variations_price;
                                    }
                                }
                            }
                        }
                        if ($price == 0) {
                            $price = $item->price;
                        }
                        $item_subtotal = $item->quantity * $price;
                    }
                } else {
                    $item_subtotal = $item->price * $item->quantity;
                }

                $subtotals[$item->cart_id] = $item_subtotal;
                $grand_total += $item_subtotal;
            }
        }

        return [
            'grand_total' => $grand_total,
            'subtotals' => $subtotals
        ];
    }
}