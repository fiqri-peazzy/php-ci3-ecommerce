<?php


defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_user_by_email($email)
    {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->row();
    }

    public function get_user_by_username($username)
    {
        $query = $this->db->get_where('users', ['username' => $username]);
        return $query->row();
    }

    public function verify_password($user_id, $password)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        $user = $query->row();

        if ($user) {
            return password_verify($password, $user->password);
        }

        return false;
    }
}

/* End of file User_model.php */