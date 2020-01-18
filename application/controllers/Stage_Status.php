<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stage_Status extends CI_Controller {

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
	//stage_status home
	public function index(){
		//send stages to the menu each time the controller is triggered
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		$data['get_status'] = $this->all->get_all('status', array('status_is_deleted' => 0));

		$data['title'] = 'Aşamalar / Durumlar';
		$data['title1'] = 'Aşama Ekle';
		$data['title2'] = 'Durum Ekle';
		$data['view'] = 'back/stage_status/index';
		$this->load->view('layout',$data);
	}
	//add stage
	public function add_stage(){
		$stage_name = $this->input->post('stage_name');
		$get_item = $this->all->get_item('stage', array('stage_is_deleted' => 0, 'stage_name' => $stage_name));
		//data controls
		if(!empty($get_item->stage_name) && $get_item->stage_name === $stage_name){
			$this->form_validation->set_rules('stage_name', 'Aşama Adı', 'trim|required|is_unique[stage.stage_name]',
				array(
					'is_unique' => 'Bu aşama kayıtlıdır, lütfen farklı bir aşama adı giriniz!',
					'required'  => 'Lütfen aşama adı giriniz!'
				)
			);
		} else {
			$this->form_validation->set_rules('stage_name', 'Aşama Adı', 'trim|required',
				array(
					'required'  => 'Lütfen aşama adı giriniz!'
				)
			);
		}

		if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            redirect('stage_status');
		} else { //isn't there an error
			$return = $this->all->insert('stage', array('stage_name' => $stage_name)); // insertion operation
			if($return){ //if added
				$this->session->set_flashdata('msg', 'Aşama başarıyla kaydedildi.');
                redirect('stage_status');
			} else { //if not added
				$this->session->set_flashdata('error', 'Bir sorun oluştu.');
                redirect('stage_status');
			}
		}
	}
	//add status
	public function add_status(){
		$status_name = $this->input->post('status_name');
		$get_item = $this->all->get_item('status', array('status_is_deleted' => 0, 'status_name' => $status_name));
		//data controls
		if(!empty($get_item->status_name) && $get_item->status_name === $status_name){
			$this->form_validation->set_rules('status_name', 'Durum Adı', 'trim|required|is_unique[status.status_name]',
				array(
					'is_unique' => 'Bu durum kayıtlıdır, lütfen farklı bir durum adı giriniz!',
					'required'  => 'Lütfen durum adı giriniz!'
				)
			);
		} else {
			$this->form_validation->set_rules('status_name', 'Durum Adı', 'trim|required',
				array(
					'required'  => 'Lütfen durum adı giriniz!'
				)
			);
		}

		if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            redirect('stage_status');
		} else { //isn't there an error
			$return = $this->all->insert('status', array('status_name' => $status_name)); // insertion operation
			if($return){ //if added
				$this->session->set_flashdata('msg', 'Durum başarıyla kaydedildi.');
                redirect('stage_status');
			} else { //if not added
				$this->session->set_flashdata('error', 'Bir sorun oluştu.');
                redirect('stage_status');
			}
		}
	}
	//delete stage
	public function delete_stage($id){
		//is there data for the stage
		$join_array = array(
			'status' => 'status_id = record_status',
            'stage'  => 'stage_id = record_stage'
		);
		$get_record = $this->all->get_item('records', array('record_is_deleted' => 0, 'record_stage' => $id), $join_array);

		if(empty($get_record)){ // if there isn't record
			$return = $this->all->delete('stage', array('stage_id' => $id)); //delete selected stage
			if($return){ //if deleted
				$this->session->set_flashdata('msg', 'Aşama başarıyla silindi.');
				redirect('stage_status');
			} else { //if not deleted
				$this->session->set_flashdata('error', 'Bir sorun oluştu.');
				redirect('stage_status');
			}
		} else { // if there is record
			$this->session->set_flashdata('error', 'Bu aşamadaki kayıtlarınızı kaybetmeyin! Üyeleriniz için duyuru oluşturarak bu aşamadaki kayıtları aktarmalarını isteyebilirsiniz.');
			redirect('stage_status');
		}
	}
	//delete status
	public function delete_status($id){
		//is there data for the status
		$join_array = array(
			'status' => 'status_id = record_status',
            'stage'  => 'stage_id = record_stage'
		);
		$get_record = $this->all->get_item('records', array('record_is_deleted' => 0, 'record_status' => $id), $join_array);
		if(empty($get_record)){ // if there isn't record
			$return = $this->all->delete('status', array('status_id' => $id, 'status_is_deleted' => 0)); //delete selected status
			if($return){ //if deleted
				$this->session->set_flashdata('msg', 'Durum başarıyla silindi.');
				redirect('stage_status');
			} else { // if not deleted
				$this->session->set_flashdata('error', 'Bir sorun oluştu.');
				redirect('stage_status');
			}
		} else { // if there is record
			$this->session->set_flashdata('error', 'Bu durumdaki kayıtlarınızı kaybetmemek için lütfen başka duruma aktarınız!');
			redirect('stage_status');
		}
		
	}
	//stage detail
	public function stage_page($id){
		if(is_numeric($id) && $id != null){
			$order_array = array(
				'stage_rank' => 'ASC'
			);
			$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
			//find id's stage
			$data['get_stages'] = $this->all->get_item('stage', array('stage_is_deleted' => 0, 'stage_id' => $id));
			if(!empty($data['get_stages'])){ //if there is stage
				$data['title'] = $data['get_stages']->stage_name;
			} else { //if there isn't stage
				$data['title'] = 'Aşama';
			}
			$data['view'] = 'back/stage_status/detail';
			$this->load->view('layout',$data);
		}
	}
	//status detail
	public function status_page($id){
		if(is_numeric($id) && $id != null){
			$order_array = array(
				'stage_rank' => 'ASC'
			);
			$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
			//find id's status
			$data['get_status'] = $this->all->get_item('status', array('status_is_deleted' => 0, 'status_id' => $id));
			if(!empty($data['get_stages'])){ //if there is status
				$data['title'] = $data['get_status']->status_name;
			} else {  //if there isn't status
				$data['title'] = 'Durum';
			}
			$data['view'] = 'back/stage_status/detail';
			$this->load->view('layout',$data);
		}
	}
	//update stage
	public function stage_detail($id){
		$stage_name = $this->input->post('stage_name');
		//find id's stage
		$get_item = $this->all->get_item('stage', array('stage_is_deleted' => 0, 'stage_id' => $id));
		//data controls(Is the new record the same as the previous record)
		if(!empty($get_item->stage_name) && $get_item->stage_name !== $stage_name){
			$this->form_validation->set_rules('stage_name', 'Aşama Adı', 'trim|required|is_unique[stage.stage_name]',
				array(
					'is_unique' => 'Bu aşama kayıtlıdır, lütfen farklı bir aşama adı giriniz!',
					'required'  => 'Lütfen aşama adı giriniz!'
				)
			);
		} else {
			$this->form_validation->set_rules('stage_name', 'Aşama Adı', 'trim|required',
				array(
					'required'  => 'Lütfen aşama adı giriniz!'
				)
			);
		}
		
		if ($this->form_validation->run() == FALSE){ // if there is error
			$this->session->set_flashdata('error', validation_errors());
			redirect('stage_status/stage_page/'.$id);
		} else { //if there isn't error
			$return = $this->all->update('stage', array('stage_name' => $stage_name), 'stage_id', $id); //update $id
			if($return){ // if updated
				$this->session->set_flashdata('msg', 'Aşama başarıyla kaydedildi.');
				redirect('stage_status/stage_page/'.$id);
			} else { // if not updated
				$this->session->set_flashdata('error', 'Bir sorun oluştu.');
				redirect('stage_status/stage_page/'.$id);
			}
		}
	}
	//update status
	public function status_detail($id){
		$status_name = $this->input->post('status_name');
		//find id's status
		$get_item = $this->all->get_item('status', array('status_is_deleted' => 0, 'status_id' => $id));
		//data controls(Is the new record the same as the previous record)
		if(!empty($get_item->status_name) && $get_item->status_name !== $status_name){
			$this->form_validation->set_rules('status_name', 'Durum Adı', 'trim|required|is_unique[status.status_name]',
				array(
					'is_unique' => 'Bu durum kayıtlıdır, lütfen farklı bir durum adı giriniz!',
					'required'  => 'Lütfen durum adı giriniz!'
				)
			);
		} else {
			$this->form_validation->set_rules('status_name', 'Durum Adı', 'trim|required',
				array(
					'required'  => 'Lütfen durum adı giriniz!'
				)
			);
		}

		if ($this->form_validation->run() == FALSE){ // if there is error
			$this->session->set_flashdata('error', validation_errors());
			redirect('stage_status/status_page/'.$id);
		} else { // if there isn't error
			$status_name = $this->input->post('status_name');
			$return = $this->all->update('status', array('status_name' => $status_name), 'status_id', $id);
			if($return){ // if updated
				$this->session->set_flashdata('msg', 'Durum başarıyla kaydedildi.');
				redirect('stage_status/status_page/'.$id);
			} else { // if not updated
				$this->session->set_flashdata('error', 'Bir sorun oluştu.');
				redirect('stage_status/status_page/'.$id);
			}
		}
	}
	//stage sorting
	public function stage_sort(){
		$select = $this->input->post('slc');
		$select2 = $this->input->post('slc');
		//nested foreach to compare the values and keys of an array
		if(is_array($select) && $select != null){ //if $select is array
			foreach($select as $key => $val){ //examine the keys and values of the array
				if($val == 0){ //is the value equal to 0
					$this->session->set_flashdata('error', 'Lütfen tüm aşamalara sıra tanımlayınız!');
					redirect('stage_status');
				} else { //isn't the value equal to 0
					foreach($select2 as $k => $v){ //examine the keys and values of the array
						if($key != $k){ //comparing data with the same key
							if($val == $v){ //Are the values equal?
								$this->session->set_flashdata('error', 'Lütfen her aşamaya farklı sıra numarası veriniz!');
								redirect('stage_status');
							}
						}
					}
					$return = $this->all->update('stage', array('stage_rank' => $val), 'stage_id', $key); //update stages
				}
			}
			if($return){ //if updated
				$this->session->set_flashdata('msg', 'Sıralamalarınız başarıyla kaydedildi.');
				redirect('stage_status');
			}
		}
	}
}
