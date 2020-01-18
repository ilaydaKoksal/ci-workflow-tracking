<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    //auth home
	public function index(){
        //if session is empty
        if(empty($this->session->has_userdata('user_type'))){
            $this->load->view('login/index');
        } else { //if session isn't empty
            $this->load->view('login/error');
        }
        
    }
    //login
    public function login(){
        //data controls
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email',
                        array(
                            'required' => 'Lütfen e-mail giriniz!',
                            'valid_email' => 'Lütfen doğru bir email adresi giriniz!'
                        )
        );
        $this->form_validation->set_rules('password', 'Şifre', 'trim|required',
                        array(
                            'required' => 'Lütfen şifre giriniz!'
                        )
        );
        
        if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth');
        } else { //isn't there an error
            //entered datas
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $password = md5(base64_encode($password));
            //do you have a user with this mail
            $get_item = $this->all->get_item('users', array('user_email' => $email, 'user_is_deleted' => 0)); 

            if(!empty($get_item)){ //if there is an user
                if($password == $get_item->user_password){ //password controls
                    //create session if controls is successfully
                    $user = array(
                        'user_id'  => $get_item->user_id,
                        'user_type' => $get_item->user_type,
                        'user_name_surname' => $get_item->user_name_surname
                    );
                    $this->session->set_userdata($user);
                    
                    if($user['user_type'] == 1){ //if user is admin
                        redirect('admin');
                    } else { //if user isn't admin
                        redirect('user');
                    }
                } else { //if password controls isn't successfully
                    $this->session->set_flashdata('error', 'Yanlış şifre girdiniz!');
                    redirect('auth');
                }
            } else { //if email controls isn't successfully
                $this->session->set_flashdata('error', 'E-mail kayıtlı değildir. Lütfen kayıt olunuz!');
                redirect('auth');
            }
        }
    }
    //logout
    public function logout(){
        //logout if session is open 
        if($this->session->userdata('user_id')){
            session_destroy();
            redirect('auth');
        }
    }
}
