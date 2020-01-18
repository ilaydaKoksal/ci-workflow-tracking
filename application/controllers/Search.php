<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
    //search home
	public function index(){
        $data['title'] = 'Tüm Müşteriler';
        if($this->session->userdata('user_type') == 1){ //if user is admin
            $data['view'] = 'back/home/index';
        } else { //if user isn't admin
            $data['view'] = 'home/index';
        }
		$this->load->view('layout',$data);
    }
    //search
    public function fetch(){
        $key = $this->input->post('key');
        if($this->input->post('query')){
            $query = $this->input->post('query');
            $array = array();
            if(!empty($key) && $key == 'record'){
                $data = $this->all->fetch_data($query, $key);
            } else if(!empty($key) && $key == 'register'){
                $data = $this->all->fetch_data($query, $key);
            } else {
                $data = $this->all->fetch_data($query);
            }
            if(!empty($data)){
                $array['success'] = $data;
            }
            echo json_encode($array);
        } else {
            $array = array();
            if(!empty($key) && $key == 'record'){
                $data = $this->all->get_all('records', array('record_is_deleted' => 0), null, 10, 0);
                if(!empty($data)){
                    $array['success'] = $data;
                }
            } else if(!empty($key) && $key == 'register'){
                $data = $this->all->get_all('users', array('user_is_deleted' => 0, 'user_type' => 2), null, 10, 0);
                if(!empty($data)){
                    $array['success'] = $data;
                }
            } else {
                $data = '';
                $array['success'] = $data;
            }
            echo json_encode($array);
        }
    }
}
