<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->library('user_auth');
        $this->load->helper('date');
        $this->load->helper('phpmailer_helper');
        date_default_timezone_set('Asia/Jakarta');


        // $this->user_auth->check();
    }

    public function login()
    {
        if ($this->user_auth->check()) {

            if ($this->user_auth->is_admin()) {
                $this->session->set_flashdata('success', 'Kamu sudah login<br> <a class="text-primary bold" href="' . base_url('admin') . '"><strong>Kembali ke dashboard</strong></a>');
            } else {
                $this->session->set_flashdata('success', 'Kamu sudah login<br> <a class="text-primary bold" href="' . base_url('user/dashboarduser') . '"><strong>Kembali ke dashboard</strong></a>');
            }
        }
        $is_email = filter_var($this->input->post('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($is_email == 'email') {

            $this->form_validation->set_rules('login_id', 'Email', 'required|valid_email', [
                'required' => '%s Wajib di isi',
                'valid_email' => 'Masukan email yang valid',

            ]);
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
                'required' => '%s Wajib di isi',
                'min_length' => '%s minimal 6 karakter'
            ]);
        } else {
            $this->form_validation->set_rules('login_id', 'Username', 'required', [
                'required' => 'Username wajib di isi',

            ]);
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
                'required' => '%s Wajib di isi',
                'min_length' => '%s minimal 6 karakter'
            ]);
        }

        if ($this->form_validation->run() === false) {
            $data = [
                'title' => 'Login User'
            ];

            $this->load->view('auth/login', $data, FALSE);
        } else {
            if ($is_email == 'email') {
                $user = $this->user_model->get_user_by_email($this->input->post('login_id'));
                $field = 'email';
            } else {
                $user = $this->user_model->get_user_by_username($this->input->post('login_id'));
                $field = 'username';
            }
            if ($user) {
                $password = $this->input->post('password');
                if ($this->user_model->verify_password($user->id, $password)) {
                    $user_info = $this->db->get_where('users', ['id' => $user->id])->row_array();
                    if ($user_info['is_admin'] == 1) {
                        $this->user_auth->set_ci_auth($user_info);

                        redirect('admin');
                    } else {
                        $this->user_auth->set_ci_auth($user_info);
                        redirect('user/dashboarduser');
                    }
                } else {
                    $this->session->set_flashdata('fail', 'Password salah');

                    $this->load->view('auth/login', ['title' => 'Login User'], false);
                }
            } else {
                $this->session->set_flashdata('fail', ucfirst($field) . ' tidak terdaftar');

                $this->load->view('auth/login', ['title' => 'Login User'], false);
            }
        }
    }

    public function logout()
    {
        $this->user_auth->forget();
        $this->session->set_flashdata('success', 'Kamu berhasil logout');
        return redirect('auth/login');
    }
    public function registration()
    {
        $this->form_validation->set_rules('name', 'Nama', 'required|trim', [
            'required' => '%s Wajib Di isi',

        ]);

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]|min_length[6]|trim', [
            'required' => '%s Wajib Di isi',
            'is_unique' => 'Username Telah digunakan',
            'min_length' => '%s Minimal 6 Karakter',
        ]);

        $this->form_validation->set_rules('email', '', 'required|is_unique[users.email]|valid_email', [
            'required' => 'Email Wajib diisi',
            'is_unique' => 'Email Telah digunakan',
            'valid_email' => 'Masukan Email yang valid'
        ]);

        $this->form_validation->set_rules('phone', '', 'numeric', [
            'numeric' => 'No Telepon Harus Berupa Angka'
        ]);

        $this->form_validation->set_rules('password', '', 'required|min_length[6]|matches[conf_password]', [
            'min_length' => 'Password Minimal 6 karakter',
            'required' => 'Password Wajib Di isi',
            'matches' => 'password tidak cocok'
        ]);

        $this->form_validation->set_rules('conf_password', '', 'required|matches[password]', [
            'required' => 'Konfirmasi Password',
            'matches' => 'Password tidak cocok'
        ]);
        if ($this->form_validation->run() == false) {
            $data = [
                'title' => 'Registration User'
            ];
            $this->load->view('auth/registration', $data, false);
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'is_active' => '0',
                'is_admin' => '0',
            ];

            $this->db->insert('users', $data);
            $this->session->set_flashdata('success', 'Akun anda berhasil di buat');
            redirect('auth/registration');

            // redirect('auth/login');

        }
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
            'required' => 'Masukan %s untuk reset password',
            'valid_email' => 'Masukan %s yang valid'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Lupa Password',
            );
            $this->load->view('auth/forgot-password', $data, FALSE);
        } else {
            $user_by_email = $this->db->get_where('users', ['email' => $this->input->post('email')], 1)->row();
            if ($user_by_email == null) {
                $this->session->set_flashdata('fail', 'Email tidak terdaftar');
                $data = array(
                    'title' => 'Lupa Password',
                );
                $this->load->view('auth/forgot-password', $data, FALSE);
            } else {
                $token = bin2hex(openssl_random_pseudo_bytes(65));
                $datetime = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                $now = $datetime->format('Y-m-d H:i:s');
                // cek token
                $isOldTokenExist = $this->db->get_where('password_reset_token', ['email' => $user_by_email->email], 1)->row();
                if ($isOldTokenExist != null) {
                    $this->db->where('email', $user_by_email->email)->set(['token' => $token, 'created_at' => $now])->update('password_reset_token');
                } else {
                    $this->db->insert('password_reset_token', ['email' => $user_by_email->email, 'token' => $token, 'created_at' => $now]);
                }
                $action_link = base_url('auth/resetpassword/' . urlencode($token));
                // print_r($user_by_email);
                $mail_data = [
                    'action_link' => $action_link,
                    'user' => $user_by_email,
                ];
                $mail_body = $this->load->view('mail-template/reset-password-template', $mail_data, TRUE);
                $mailConfig = array(
                    'mail_from_email' => 'fiqriawan36@gmail.com',
                    'mail_from_name' => 'admin',
                    'mail_recipient_email' => $user_by_email->email,
                    'mail_recipient_name' => $user_by_email->name,
                    'mail_subject' => 'Reset Password',
                    'mail_body' => $mail_body,
                );
                if (sendEmail($mailConfig)) {
                    $this->session->set_flashdata('success', 'Email reset password berhasil di kirim');
                    $this->load->view('auth/forgot-password', ['title' => 'Lupa Password'], FALSE);
                } else {
                    $this->session->set_flashdata('fail', 'Something went wrong');
                    $this->load->view('auth/forgot-password', ['title' => 'Lupa Password'], FALSE);
                }
            }
        }
    }
    public function resetPassword($token)
    {
        $password_reset_token = $this->db->get_where('password_reset_token', ['token' => $token])->row();
        if ($password_reset_token == null) {
            $this->session->set_flashdata('fail', 'Token tidak bisa di gunakan,  Coba lagi !');
            return redirect('auth/forgotpassword');
        } else {
            $now = new DateTime();

            $token_created_at = DateTime::createFromFormat('Y-m-d H:i:s', $password_reset_token->created_at);

            $diff = $token_created_at->diff($now);
            if ($diff->days * 24 * 60 + $diff->h * 60 + $diff->i > 15) {
                $this->session->set_flashdata('fail', ' Token Kadalruasa kirim email lagi');
                return redirect('auth/forgotpassword');
            } else {

                $user_data = $this->db->get_where('users', ['email' => $password_reset_token->email])->row();
                if ($user_data != null) {
                    $this->form_validation->set_rules('new_password', 'Password', 'required|min_length[6]|trim', [
                        'required' => '%s Wajib di isi',
                        'min_length' => '%s Minimal 6 karakter'
                    ]);
                    $this->form_validation->set_rules('conf_password', 'Password', 'required|min_length[6]|trim|matches[new_password]', [
                        'required' => 'Konfirmasi Passowrd',
                        'min_length' => '%s Minimal 6 karakter',
                        'matches' => 'Password tidak cocok'
                    ]);

                    if ($this->form_validation->run() == FALSE) {
                        $data = [
                            'title' => 'Reset Password Anda',
                            'token' => $token
                        ];
                        $this->load->view('auth/reset', $data, FALSE);
                    } else {
                        $update = $this->db->where('email', $user_data->email)->set(['password' => password_hash($this->input->post('new_password'), PASSWORD_DEFAULT)])->update('users');

                        if ($update) {

                            $mail_data = array(
                                'user' => $user_data,
                                'new_password' => $this->input->post('new_password'),
                                'link_login' => base_url('auth/login')
                            );

                            $mail_body = $this->load->view('mail-template/password-changed', $mail_data, TRUE);
                            $mailConfig = array(
                                'mail_from_email' => 'fiqriawan36@gmail.com',
                                'mail_from_name' => 'admin',
                                'mail_recipient_email' => $user_data->email,
                                'mail_recipient_name' => $user_data->name,
                                'mail_subject' => 'Reset Password',
                                'mail_body' => $mail_body,
                            );

                            if (sendEmail($mailConfig)) {
                                $this->db->where('email', $user_data->email)->delete('password_reset_token');
                                $this->session->set_flashdata('success', 'Password Berhasil di ubah <br> <a href="' . base_url('auth/login') . '" class="text-primary"><strong>Login</strong></a>');
                                $data = [
                                    'title' => 'Reset Password Anda',
                                    'token' => $token
                                ];
                                $this->load->view('auth/reset', $data, FALSE);
                            } else {
                                $this->session->set_flashdata('fail', 'Something went wrong');

                                $data = [
                                    'title' => 'Reset Password Anda',
                                    'token' => $token
                                ];
                                $this->load->view('auth/reset', $data, FALSE);
                            }
                        }
                    }
                } else {
                    $this->session->set_flashdata('fail', 'something went wrong');
                    return redirect('auth/forgotpassword');
                }
            }
        }
    }
}

/* End of file Auth.php */