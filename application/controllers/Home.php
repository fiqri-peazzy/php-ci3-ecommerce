<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{


    public function index()
    {
        $data = [
            'title' => 'Beranda CI3 Store',
            'content' => 'frontend/pages/home',
            'categories' => $this->db->get('categories')->result(),
            'products' => $this->db->get('product')->result()
        ];
        $this->load->view('frontend/layout/home-layout', $data, FALSE);
    }
}