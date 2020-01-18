<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Record extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$user = $this->all->get_item('users', array('user_is_deleted' => 0, 'user_id' => $this->session->userdata('user_id')));
		if(empty($user)){ //if there isn't such a user
			session_destroy();
			redirect('auth');
		}
	}
	//record home
	public function index(){
		$config = array( //array of paging
			'base_url' => base_url('record'),
			'total_rows' => count($this->all->get_all('records', array('record_is_deleted' => 0))),
			'uri_segment' => 2,
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
		$return = $this->all->pagination($config, 'records', array('record_is_deleted' => 0));
		
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		$data['get_all'] = $return->result; //datas
		$data['links'] = $return->links; //pages
		$data['title'] = 'Tüm Müşteriler';
		$data['view'] = 'record/index';
		$this->load->view('layout',$data);
	}
	//registration page for users
	public function user_index(){
		$config = array( //array of paging
			'base_url' => base_url('record/user_index/page'),
			'total_rows' => count($this->all->get_all('records', array('record_is_deleted' => 0, 'record_user_id' => 0))),
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
		$return = $this->all->pagination($config, 'records', array('record_is_deleted' => 0, 'record_user_id' => 0));

		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		$data['get_all'] = $return->result; //datas
		$data['links'] = $return->links; //pages
		$data['title'] = 'Müşteri Seç';
		$data['view'] = 'record/index';
		$this->load->view('layout',$data);
	}
	//add record form
	public function add(){
		//send stages to the menu each time the controller is triggered
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		//open adding record form
		$data['title'] = 'Müşteri Ekle';
		$data['view'] = 'record/add';
		$this->load->view('layout',$data);
	}
	//add record
	public function add_record(){ 
		//entered data thrown to variable
		$name_surname = $this->input->post('name_surname');
		$clinic_name = $this->input->post('clinic_name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');

		//is there a record of the phone or mail entered
		$or_where = array(
			'record_email' => $email,
			'record_phone' => $phone
		);
		$data['get_item'] = $this->all->get_item('records', array('record_is_deleted' => 0), null, $or_where);

		//data controls
		$this->form_validation->set_rules('name_surname', 'Ad Soyad', 'trim|required',
						array(
							'required' => 'Lütfen ad soyad giriniz!'
						)
		);
		
		$this->form_validation->set_rules('clinic_name', 'Klinik Adı', 'trim|required',
			array(
				'required' => 'Lütfen klinik adı giriniz!'
			)
		);

		if(!empty($data['get_item']->record_phone) && $data['get_item']->record_phone === $phone) {
            $this->form_validation->set_rules('phone', 'Telefon', 'trim|required|numeric|min_length[10]|is_unique[records.record_phone]',
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
		
        if(!empty($data['get_item']->record_email) && $data['get_item']->record_email === $email) {
            $this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|is_unique[records.record_email]',
                array(
                    'valid_email' => 'Lütfen doğru mail adresi giriniz!',
                    'is_unique' => 'Bu mail adresi kayıtlıdır, lütfen farklı bir mail adresi giriniz!'
                )
            );
        } 
        else {					
            $this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email',
                array(
                    'valid_email' => 'Lütfen doğru mail adresi giriniz!'
                )
		    );			
        }
		
		if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            $data['title'] = 'Kayıt Ekle';
            $data['view'] = 'record/add';
            $this->load->view('layout',$data);
		} else { //isn't there an error
			//phone controls
            $phone_array = str_split($phone, 1);
			if($phone_array[0] == "0"){
				$this->session->set_flashdata('error', 'Telefon numarasını başında 0 olmadan yazınız!');
            	redirect('record');
			} else { //phone check is successful
				//received data
                $add_data = array(
                    'record_name_surname' => $name_surname,
                    'record_clinic_name'  => $clinic_name,
                    'record_phone'        => $phone,
					'record_email'        => $email,
					'record_address'      => $address,
                    'record_created_at'   => date('Y-m-d H:i:s')
                );
			    $return = $this->all->insert('records', $add_data); //insertion operation
			
                if($return){ //if added
                    $this->session->set_flashdata('msg', 'Kayıt başarıyla eklendi.');
                    redirect('record/add');
                } else { //if not added
                    $this->session->set_flashdata('error', 'Bir sorun oluştu.');
                    redirect('record/add');
                }
            }
		}
	}
	//update record
	public function update_record($id){
		//send stages to the menu each time the controller is triggered
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		
		//entered datas
		$get_item = $this->all->get_item('records', array('record_id' => $id, 'record_is_deleted' => 0));
		$name_surname = $this->input->post('name_surname');
		$clinic_name = $this->input->post('clinic_name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$address = $this->input->post('address');

		//is there a record of the phone or mail entered
		$or_where = array(
			'record_email' => $email,
			'record_phone' => $phone
		);
		$data['get_item'] = $this->all->get_item('records', array('record_is_deleted' => 0), null, $or_where); 
		
		//data controls
		$this->form_validation->set_rules('name_surname', 'Ad Soyad', 'trim|required',
			array(
				'required' => 'Lütfen ad soyad giriniz!'
			)
		);
		$this->form_validation->set_rules('clinic_name', 'Klinik Adı', 'trim|required',
			array(
				'required' => 'Lütfen klinik adı giriniz!'
			)
		);
		if(!empty($data['get_item']->record_phone) && $data['get_item']->record_phone !== $phone) {
            $this->form_validation->set_rules('phone', 'Telefon', 'trim|required|numeric|min_length[10]|is_unique[records.record_phone]',
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
		
        if(!empty($data['get_item']->record_email) && $data['get_item']->record_email !== $email) {
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[records.record_email]',
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
            redirect('record/detail/'.$id);
		} else { //isn't there an error
			//new datas
			$update_data = array(
				'record_name_surname' => $name_surname,
				'record_clinic_name' => $clinic_name,
				'record_phone' => $phone,
				'record_email' => $email,
				'record_address' => $address
			);
			//does the user have this record
			if($get_item->record_user_id == $this->session->userdata('user_id')){
				$return = $this->all->update('records', $update_data, 'record_id', $id); //update records
			} else {
				redirect('record/detail/'.$id);
			}

			if($return){ //if updated
				$this->session->set_flashdata('msg', 'Kayıt başarıyla güncellendi.');
				redirect('record/detail/'.$id);
			} else { //if not updated
				$this->session->set_flashdata('error', 'Bir sorun oluştu!');
				redirect('record/detail/'.$id);
			}
		}
	}
	//record details
	public function detail($id){
		//receive data details
		$get_item = $this->all->get_item('records', array('record_id' => $id, 'record_is_deleted' => 0));

		if(!empty($get_item)){ //is there data
			if($get_item->record_user_id == 0){ //if the record does not belong to any user
				$get_record = $get_item;
			} else { //if the record belong to any user
				$join_array = array(
					'status' => 'status_id = record_status', 
					'stage'  => 'stage_id = record_stage'
				);
				$get_record = $this->all->get_item('records', array('record_id' => $id, 'record_is_deleted' => 0), $join_array);
			}
			//send stages to the menu each time the controller is triggered
			$order_array = array(
				'stage_rank' => 'ASC'
			);
			$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
			//required data
			$data['get_status'] = $this->all->get_all('status', array('status_is_deleted' => 0));
			$join_array = array(
				'records' => 'note_record_id = record_id',
				'status'  => 'status_id = note_status',
				'stage'   => 'stage_id = note_stage',
				'users'   => 'note_user_id = user_id'
			);
			$data['get_notes'] = $this->all->get_all('notes', array('record_id' => $id, 'record_is_deleted' => 0), $join_array);
			$data['get_record'] = $get_record;
			
			$data['title'] = 'Üye Detayları';
			$data['view'] = 'record/detail';
			$this->load->view('layout',$data);
		} else {
			redirect(base_url('user'));
		}
	}
	//record delete
	public function delete($id){
		//receive record
		$join_array = array(
			'notes' => 'record_user_id = note_user_id'
		);
		$get_item = $this->all->get_item('records', array('record_is_deleted' => 0, 'record_id' => $id), $join_array);
		if(empty($get_item)){ //isn't there record
			$this->session->set_flashdata('error', 'Böyle bir kayıt yoktur!');
            redirect('record');
		} else { //is there note
			//delete record
			$return = $this->all->update('records', array('record_is_deleted' => 1), 'record_id', $id);
			if($return){ //if deleted
				$this->session->set_flashdata('msg', 'Kayıt başarıyla silindi.');
				redirect('record');
			} else { //if not deleted
				$this->session->set_flashdata('error', 'Bir sorun oluştu.');
				redirect('record');
			}
		}
	}
	//all record
	public function all_record($id = null){
		$join_array = array(
			'status' => 'status_id = record_status',
			'stage'  => 'stage_id = record_stage'
		);
		$config = array( //array of paging
			'total_rows' => count($this->all->get_all('records', array('record_is_deleted' => 0, 'record_stage' => $id, 'record_user_id' => $this->session->userdata('user_id')), $join_array)),
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
		//define id
		$id == "page" ? $id = null : $id = $id;

		if($id === null){
			//add to config
			$config['base_url'] =  base_url('record/all_record/page');
			$config['uri_segment'] =  4;
			$join_array = array(
				'users'  => 'user_id = record_user_id',
                'status' => 'status_id = record_status',
                'stage'  => 'stage_id = record_stage'
			);
			$config['total_rows'] = count($this->all->get_all('records', array('record_is_deleted' => 0), $join_array));
			//go to pagination
			$return = $this->all->pagination($config, 'records', array('record_is_deleted' => 0), $join_array);
			$data['title'] = "Tüm Hareketler";
		} else { //if there is id
			$get_stage = $this->all->get_item('stage', array('stage_id' => $id)); //receive stage
			if(!empty($get_stage)){ //if there is stage
				$data['title'] = $get_stage->stage_name;
				//add to config
				$config['base_url'] =  base_url('record/all_record/'.$id.'/page');
				$config['total_rows'] = count($this->all->get_all('records', array('record_is_deleted' => 0, 'record_stage' => $id, 'record_user_id' => $this->session->userdata('user_id')), $join_array));
				$config['uri_segment'] =  5;
				$join_array = array(
					'users'  => 'user_id = record_user_id',
					'status' => 'status_id = record_status',
					'stage'  => 'stage_id = record_stage'
				);
				//go to pagination
				$return = $this->all->pagination($config, 'records', array('record_is_deleted' => 0, 'record_stage' => $id, 'record_user_id' => $this->session->userdata('user_id')), $join_array);
				
				if($this->session->userdata('user_type') == 1){ //if user is admin
					//go to pagination
					$return = $this->all->pagination($config, 'records', array('record_is_deleted' => 0, 'record_stage' => $id), $join_array);
					//add to config
					$config['total_rows'] = count($this->all->get_all('records', array('record_is_deleted' => 0, 'record_stage' => $id), $join_array));
					$data['title'] = $get_stage->stage_name;
				}
			} else { //if there isn't stage
				redirect('record/all_record');
			}
		}

		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		$data['get_all'] = $return->result;
		$data['links'] = $return->links;
		$data['view'] = 'record/index';
		$this->load->view('layout',$data);
	}
	//add note
	public function add_note($id){
		//data controls
		$this->form_validation->set_rules('stage', 'Aşama', 'trim|required',
			array(
				'required' => 'Lütfen aşama seçiniz!'
			)
		);
		$this->form_validation->set_rules('status', 'Durum', 'trim|required',
			array(
				'required' => 'Lütfen durum seçiniz!'
			)
		);
		$this->form_validation->set_rules('note', 'Not', 'trim|required',
			array(
				'required' => 'Lütfen not yazınız!'
			)
		);

		if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            redirect('record/detail/'.$id);
		} else { //isn't there an error
			//received data
			$stage = $this->input->post('stage');
			$status = $this->input->post('status');
			$note = $this->input->post('note');
			$datetime = $this->input->post('datetime');
			//get note to write
			$get_item = $this->all->get_item('records', array('record_id' => $id, 'record_is_deleted' => 0));
	
			if($stage == 0){ //stage controls
				$this->session->set_flashdata('error', 'Lütfen aşama seçiniz!');
				redirect('record/detail/'.$id);
			} else {
				if($status == 0){ //status controls
					$this->session->set_flashdata('error', 'Lütfen durum seçiniz!');
					redirect('record/detail/'.$id);
				} else { //if controls is successfull
					//new datas
					$update_data = array(
						'record_stage' => $stage,
						'record_status' => $status
					);
					//if there are no customer notes when adding notes, record_user_id is 0 in the 'record' table.
					//record_user_id is updated when adding the first note.

					//is there a note of this id
					$get_note = $this->all->get_item('notes', array('note_record_id' => $id, 'note_is_deleted' => 0));
	
					if(empty($get_note)){ //if there isn't note
						//add update_data
						$update_data['record_user_id'] = $this->session->userdata('user_id');
					}
					//update records
					$return = $this->all->update('records',$update_data, 'record_id', $id);
	
					if($return){ //if updated
						//entered data
						$add_data = array(
							'note_record_id'  => $id,
							'note_user_id'    => $this->session->userdata('user_id'),
							'note_stage	' 	  => $stage,
							'note_content' 	  => $note,
							'note_status' 	  => $status,
							'note_created_at' => date('Y-m-d H:i:s')
						);
						if($datetime != null){ //if datetime is not empty
							$datetime = str_replace('/', '-', $datetime);  
							$datetime = date("Y-m-d H:i:s", strtotime($datetime)); 
							$add_data['note_datetime'] = $datetime; //add add_data
						}
						$return = $this->all->insert('notes', $add_data); //insertion operation

						if($return){ //if added
							$this->session->set_flashdata('msg', 'Not başarıyla kaydedildi.');
							redirect('record/detail/'.$id);
						} else { //if not added
							$this->session->set_flashdata('error', 'Bir sorun oluştu!');
							redirect('record/detail/'.$id);
						}
					}
				}
			}
		}
	}

}
