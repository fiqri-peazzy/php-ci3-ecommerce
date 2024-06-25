<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function place_order()
    {
        $data = [
            'title' => 'Buat Pesanan',
            'content' => 'frontend/pages/place_order'
        ];
        $this->load->view('frontend/layout/pages-layout', $data, FALSE);
    }
}

/* End of file Order.php */