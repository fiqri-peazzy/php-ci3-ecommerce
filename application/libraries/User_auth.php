<?php


defined('BASEPATH') or exit('No direct script access allowed');

class User_auth
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->library('session');
    }
    public function set_ci_auth($result)
    {
        $array = array('logged_in' => true);
        $userData = $result;
        $this->ci->session->set_userdata($userData);
        $this->ci->session->set_userdata($array);
    }
    public function get_user()
    {
        return $this->db->get_where('users', ['id' => $this->id()], 1)->row();
    }

    public function is_admin()
    {
        if ($this->ci->session->userdata) {
            if ($this->ci->session->userdata('logged_in') == true) {
                return $this->ci->session->userdata['is_admin'] == 1 ? true : false;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function id()
    {
        if ($this->ci->session->userdata('logged_in')) {
            return $this->ci->session->userdata['id'];
        }
    }
    public function check()
    {
        return $this->ci->session->userdata('logged_in');
    }

    public function forget()
    {
        $this->ci->session->unset_userdata('userdata');
        $this->ci->session->unset_userdata('logged_in');
    }
}

/* End of file User_auth.php */