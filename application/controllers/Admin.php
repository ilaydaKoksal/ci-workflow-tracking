<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//admin user_type = 1. If user_type is not equal to 1, go to base_url
		if($this->session->has_userdata('user_type') && $this->session->userdata('user_type') != 1){
			redirect(base_url());
		}
		//if the user_id in session is not registered in the database, go to login
		$user = $this->all->get_item('users', array('user_is_deleted' => 0, 'user_id' => $this->session->userdata('user_id')));
		if(empty($user)){
			session_destroy();
			redirect('auth');
		}
	}
	//admin home
	public function index(){
		//send stages to the menu each time the controller is triggered
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		
		//announcements about the notes
		$join_array = array(
			'records' => 'note_record_id = record_id',
			'status'  => 'status_id = note_status',
			'stage'   => 'stage_id = note_stage',
			'users'   => 'note_user_id = user_id'
		);
		$data['get_announcement'] = $this->all->get_all('notes', array('note_is_deleted' => 0, 'note_datetime <> ' => null), $join_array);
		
		$data['title'] = 'Anasayfa';
		$data['view'] = 'back/home/index';
		$this->load->view('layout',$data);
	}
	//member registration page
	public function member(){
		//stage sent to the menu each time the controller is triggered
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		
		//open member registration form
		$data['title'] = 'Üye Kayıt';
		$data['view'] = 'back/register/add';
		$this->load->view('layout',$data);
	}
	//add members
	public function add_member(){
		//entered data thrown to variable
        $name_surname = $this->input->post('name_surname');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
		$password = md5(base64_encode($this->input->post('password')));
		
		//Is there a record of the phone or mail entered
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
		
		if(!empty($data['get_item']->user_phone) && $data['get_item']->user_phone === $phone) {
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
		
        if(!empty($data['get_item']->user_email) && $data['get_item']->user_email === $email) {
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
		$this->form_validation->set_rules('password', 'Şifre', 'trim|required',
						array(
							'required' => 'Lütfen şifre giriniz!'
						)
		);
		
		if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/member');
		} else { //isn't there an error
			//phone controls
			$phone_array = str_split($phone, 1);
			if($phone_array[0] == "0"){
				$this->session->set_flashdata('error', 'Telefon numarasını başında 0 olmadan yazınız!');
            	redirect('admin/member');
			} else { //phone check is successful
				//received data
				$add_data = array(
					'user_type' 		=> 2,
					'user_name_surname' => $name_surname,
					'user_phone' 		=> $phone,
					'user_email' 		=> $email,
					'user_password' 	=> $password,
					'user_created_at'	=> date('Y-m-d H:i:s')
				);
	
				$return = $this->all->insert('users', $add_data); //insertion operation
				if($return){ //if added
					$this->session->set_flashdata('msg', 'Kayıt başarıyla oluşturuldu.');
					redirect('admin/member');
				} else { //if not added
					$this->session->set_flashdata('error', 'Bir sorun oluştu!');
					redirect('admin/member');
				}
			}
		}
	}
	//delete members
	public function member_delete($id){ //members id was received
		//find member
		$get_item = $this->all->get_item('notes', array('note_is_deleted' => 0, 'note_user_id' => $id));
		if(empty($get_item)){ //if there is a member
			$return = $this->all->update('users', array('user_is_deleted' => 1), 'user_id', $id); //members is delete
			if($return){ //if deleted
				$this->session->set_flashdata('msg', 'Üye başarıyla silindi.');
				redirect('admin/all_member/page');
			} else { // if not deleted
				$this->session->set_flashdata('error', 'Bir sorun oluştu.');
				redirect('admin/all_member/page');
			}
		} else { //if there isn't a member
			$this->session->set_flashdata('error', 'Böyle bir üye bulunmamaktadır!');
			redirect('admin/all_member/page');
		}
	}
	//all members
	public function all_member(){
		$config = array( //array of paging
			'base_url' => base_url('admin/all_member/page'),
			'total_rows' => count($this->all->get_all('users', array('user_is_deleted' => 0, 'user_type' => 2))),
			'uri_segment' => 4,
			'per_page' => 10,
			'first_tag_open' => '<li class="page-item">',
			'first_tag_close' => '</li>',
			'last_tag_open' => '<li class="page-item">',
			'last_tag_close' => '</li>',
			'prev_tag_open' => '<li class="page-item">',
			'prev_tag_close' => '</li>',
			'next_tag_open' => '<li class="page-item">',
			'next_tag_close' => '</li>',
			'num_tag_open' => '<li class="page-item">',
			'num_tag_close' => '</li>',
			'cur_tag_open' => '<li class="page-item disabled"><a href="#" class="page-link">',
			'cur_tag_close' => '</a></li>',
			'attributes'	=>  array('class' => 'page-link'),
		);
		//go to pagination
		$return = $this->all->pagination($config, 'users', array('user_is_deleted' => 0, 'user_type' => 2));

		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		$data['get_all'] = $return->result; //datas
		$data['links'] = $return->links; //pages
		$data['title'] = 'Tüm Üyeler';
		$data['view'] = 'back/register/index';
		$this->load->view('layout',$data);
	}
	//member detail
	public function detail($id){
		if(!empty($id) && is_numeric($id)){
			$data['get_item'] = $this->all->get_item('users', array('user_is_deleted' => 0, 'user_id' => $id));
			$order_array = array(
				'stage_rank' => 'ASC'
			);
			$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
			$data['title'] = 'Üye Detayları';
			$data['view'] = 'back/register/detail';
			$this->load->view('layout',$data);
		}
	}
	//update details
	public function detail_update($id){
		//entered datas
		$name_surname = $this->input->post('name_surname');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
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
		} else { //if isn't there an error
			//phone controls
			$phone_array = str_split($phone, 1);
			if($phone_array[0] == "0"){
				$this->session->set_flashdata('error', 'Telefon numarasını başında 0 olmadan yazınız!');
            	redirect('admin/detail/'.$id);
			} else { //phone check is successful
				$update_data = array( //new datas
					'user_type' 		=> 2,
					'user_name_surname' => $name_surname,
					'user_phone' 		=> $phone,
					'user_email' 		=> $email
				);
				//update details
				$return = $this->all->update('users', $update_data, 'user_id', $id);
				if($return){ //if updated
					$this->session->set_flashdata('msg', 'Kayıt başarıyla güncellendi.');
					redirect('admin/detail/'.$id);
				} else { // if not updated
					$this->session->set_flashdata('error', 'Bir sorun oluştu!');
					redirect('admin/detail/'.$id);
				}
			}
		}
	}

}
