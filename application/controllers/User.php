<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//user user_type = 2. If user_type is not equal to 2, go to base_url
		if($this->session->has_userdata('user_type') && $this->session->userdata('user_type') != 2){
			redirect(base_url());
		}
		//if the user_id in session is not registered in the database, go to login
		$user = $this->all->get_item('users', array('user_is_deleted' => 0, 'user_id' => $this->session->userdata('user_id')));
		if(empty($user)){
			session_destroy();
			redirect('auth');
		}
	}
	//user home
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
		$data['get_announcement'] = $this->all->get_all('notes', array('note_is_deleted' => 0, 'note_datetime <> ' => null, 'note_user_id' => $this->session->userdata('user_id')), $join_array);
		//admin's announcements
		$data['get_announcements'] = $this->all->get_all('announcements', array('announcement_is_deleted' => 0, 'announcement_date <> ' => null));
		
		$data['title'] = 'Anasayfa';
		$data['view'] = 'home/index';
		$this->load->view('layout',$data);
	}

}
