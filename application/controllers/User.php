<?php


defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_auth');
        if (!$this->user_auth->check()) {
            $this->session->set_flashdata('fail', 'Kamu harus login terlebih dahulu');

            redirect('auth/login');
        }
        $this->load->library('upload');
    }

    public function dashboardUser()
    {

        if ($this->user_auth->is_admin()) {
            redirect('admin');
        } else {
            $this->load->view('frontend/layout/pages-layout', ['title' => 'Dashboard User', 'content' => 'frontend/pages/user/dashboard-user'], false);
        }
    }

    public function updateUserProfile()
    {
        if ($this->input->is_ajax_request()) {
            $user = $this->db->get_where('users', ['id' => $this->user_auth->id()])->row();

            if ($user->username != $this->input->post('username')) {
                $this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|is_unique[users.username]', [
                    'required' => '%s tidak boleh kosong',
                    'min_length' => '%s minimal 6 karakter',
                    'is_unique' => '%s telah di gunakan',
                ]);
            }

            $this->form_validation->set_rules('phone', 'Nomor Telepon', 'numeric', ['numeric' => '%s Harus Berupa angka']);
            if ($user->email != $this->input->post('email')) {
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]', [
                    'required' => '%s Tidak boleh kosong',
                    'valid_email' => '%s tidak valid',
                    'is_unique' => '%s Telah di gunakan'

                ]);
            }

            if ($this->form_validation->run() == FALSE) {
                # code...
                $errors = $this->form_validation->error_array();
                echo json_encode(['status' => 0, 'error' => $errors]);
            } else {
                # code...
                $userData = [
                    'name' => $this->input->post('name'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'alamat' => $this->input->post('alamat'),
                ];

                $update = $this->db->where('id', $this->user_auth->id())->set($userData)->update('users');
                if ($update) {
                    echo json_encode(['status' => 1, 'msg' => 'Berhasil Update Profile Info', 'user' => $userData]);
                } else {
                    echo json_encode(['status' => 0, 'msg' => 'Something Went Wrong']);
                }
            }
        }
    }

    public function updateUserProfilePicture()
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
        if ($this->upload->do_upload('profile_pict')) {
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
}

/* End of file User.php */