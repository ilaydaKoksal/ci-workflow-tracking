<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$user = $this->all->get_item('users', array('user_is_deleted' => 0, 'user_id' => $this->session->userdata('user_id')));
		if(empty($user)){ //if there isn't such a user
			session_destroy();
			redirect('auth');
		}
	}
	//profile home
	public function index(){
		//send stages to the menu each time the controller is triggered
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		//receive user datas
		$data['get_item'] = $this->all->get_item('users', array('user_is_deleted' => 0, 'user_id' => $this->session->userdata('user_id')));
		
		$data['title'] = 'Profil';
		$data['view'] = 'profile/index';
		$this->load->view('layout',$data);
    }
    // update datas
    public function update($id){
		//entered datas
        $name_surname = $this->input->post('name_surname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
		$password = md5(base64_encode($this->input->post('password')));
		//is there any other record by phone or mail entered?
        $or_where = array(
			'user_email' => $email,
			'user_phone' => $phone
		);
		$data['get_item'] = $this->all->get_item('users', array('user_is_deleted' => 0), null, $or_where);  
		//data controls
		$this->form_validation->set_rules('name_surname', 'Ad Soyad', 'trim|required',
						array(
							'required' => 'Lütfen ad soyad giriniz!'
						)
		);
		
		if(!empty($data['get_item']->user_phone) && $data['get_item']->user_phone !== $phone) {
            $this->form_validation->set_rules('phone', 'Telefon', 'trim|required|numeric|min_length[10]|is_unique[users.user_phone]',
                array(
                    'required' => 'Lütfen telefon numarası giriniz!',
					'is_unique' => 'Bu telefon numarası kayıtlıdır, lütfen farklı bir telefon numarası giriniz!',
					'min_length' => 'Telefon numarası 10 haneli olmalı!',
					'numeric' => 'Telefon numarası rakamlardan oluşmalı!'
                )
            );
        } 
        else {					
            $this->form_validation->set_rules('phone', 'Telefon', 'trim|required|numeric|min_length[10]',
                array(
					'required' => 'Lütfen email giriniz!',
					'min_length' => 'Telefon numarası 10 haneli olmalı!',
					'numeric' => 'Telefon numarası rakamlardan oluşmalı!'
                )
		    );			
		}
		
        if(!empty($data['get_item']->user_email) && $data['get_item']->user_email !== $email) {
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[users.user_email]',
                array(
                    'required' => 'Lütfen email giriniz!',
                    'valid_email' => 'Lütfen doğru mail adresi giriniz!',
                    'is_unique' => 'Bu mail adresi kayıtlıdır, lütfen farklı bir mail adresi giriniz!'
                )
            );
        } 
        else {					
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email',
                array(
                    'required' => 'Lütfen email giriniz!',
                    'valid_email' => 'Lütfen doğru mail adresi giriniz!'
                )
		    );			
		}
		if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/detail/'.$id);
		} else { //isn't there an error
			//phone controls
			$phone_array = str_split($phone, 1);
			if($phone_array[0] == "0"){ //phone check is successfull
				$this->session->set_flashdata('error', 'Telefon numarasını başında 0 olmadan yazınız!');
            	redirect('admin/detail/'.$id);
			} else { //phone check isn't successfull
				$update_data = array( //new datas
					'user_name_surname' => $name_surname,
					'user_phone' 		=> $phone,
					'user_email' 		=> $email,
					'user_password' 	=> $password
				);
                if($this->session->userdata('user_id') == 1){ //if user is admin
                    $update_data['user_type'] = 1;
                } else { //if user isn't admin
                    $update_data['user_type'] = 2;
                }
				$return = $this->all->update('users', $update_data, 'user_id', $id); //update datas
				if($return){ //if updated
					$this->session->set_flashdata('msg', 'Kayıt başarıyla güncellendi.');
					redirect('admin/detail/'.$id);
				} else { //if not updated
					$this->session->set_flashdata('error', 'Bir sorun oluştu!');
					redirect('admin/detail/'.$id);
				}
			}
		}
    }

}
