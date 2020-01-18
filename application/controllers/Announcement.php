<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {

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
	//Announcement home
    public function index($id = null){
		$config = array( //array of paging
			'base_url' => base_url('announcement/index'),
			'total_rows' => count($this->all->get_all('announcements', array('announcement_is_deleted' => 0))),
			'uri_segment' => 3,
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
		//receive announcement
		$return = $this->all->pagination($config, 'announcements', array('announcement_is_deleted' => 0));
		
		//send stages to the menu each time the controller is triggered
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		
		$data['get_all'] = $return->result; //datas
		$data['links'] = $return->links; //pages
		$data['title'] = 'Tüm Duyurular';
		$data['view'] = 'back/announcement/index';
		$this->load->view('layout',$data);
    }
	//cerate announcement
	public function announcement(){
		$order_array = array(
			'stage_rank' => 'ASC'
		);
		$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
		//go to the announcement creation form
		$data['title'] = 'Duyuru Oluştur';
		$data['view'] = 'back/announcement/add';
		$this->load->view('layout',$data);
    }
    //add announcement
    public function add_announcement(){
		//entered data thrown to variable
        $content = $this->input->post('content');
		$datetime = $this->input->post('datetime');
		$datetime = str_replace('/', '-', $datetime);  
		$datetime = date("Y-m-d H:i:s", strtotime($datetime));
		//data controls
        $this->form_validation->set_rules('content', 'Duyuru', 'trim|required',
						array(
							'required' => 'Lütfen duyuru yazınız!'
						)
        );
        $this->form_validation->set_rules('datetime', 'Tarih / Saat', 'trim|required',
						array(
							'required' => 'Lütfen tarih / saat giriniz!'
						)
		);
		
        if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            $this->announcement();
		} else { //isn't there an error
			//received data
            $add_data = array(
                'announcement_content'   => $content,
                'announcement_date'      => $datetime,
                'announcement_created_at' => date('Y-m-d H:i:s')
            );
            $return = $this->all->insert('announcements', $add_data); //insertion operation
            if($return){ //if added
                $this->session->set_flashdata('msg', 'Duyuru başarıyla oluşturuldu.');
                redirect('announcement/announcement');
            } else { //if not added
                $this->session->set_flashdata('error', 'Bir sorun oluştu.');
                redirect('announcement/announcement');
            }
        }
	}
	//announcement detail
	public function detail($id){
		if(!empty($id) && is_numeric($id)){
			$data['get_item'] = $this->all->get_item('announcements', array('announcement_is_deleted' => 0, 'announcement_id' => $id));
			$order_array = array(
				'stage_rank' => 'ASC'
			);
			$data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
			$data['title'] = 'Duyuru Detayları';
			$data['view'] = 'back/announcement/detail';
			$this->load->view('layout',$data);
		}
	}
	//update details
	public function detail_update($id){
		//entered data
		$content = $this->input->post('content');
        $datetime = $this->input->post('datetime');
		$datetime = str_replace('/', '-', $datetime);  
		$datetime = date("Y-m-d H:i:s", strtotime($datetime));
		//data controls
		$this->form_validation->set_rules('content', 'Duyuru', 'trim|required',
						array(
							'required' => 'Lütfen duyurunuzu giriniz!'
						)
		);
		$this->form_validation->set_rules('datetime', 'Tarih / Saat', 'trim|required',
						array(
							'required' => 'Lütfen Tarih / Saat giriniz!'
						)
		);
		
		if ($this->form_validation->run() == FALSE){ //is there an error
            $this->session->set_flashdata('error', validation_errors());
            $this->detail();
		} else { //isn't there an error
			$update_data = array( //new datas
				'announcement_content' => $content,
				'announcement_date'    => $datetime
			);
			//update details
			$return = $this->all->update('announcements', $update_data, 'announcement_id', $id);
			if($return){ //if updated
				$this->session->set_flashdata('msg', 'Duyuru başarıyla güncellendi.');
				redirect('announcement/detail/'.$id);
			} else { //if not updated
				$this->session->set_flashdata('error', 'Bir sorun oluştu!');
				redirect('announcement/detail/'.$id);
			}
		}
	}
}