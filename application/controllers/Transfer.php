<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends CI_Controller {

	public function __construct(){
        parent::__construct();
        //if the user_id in session is not registered in the database, go to login
        $user = $this->all->get_item('users', array('user_is_deleted' => 0, 'user_id' => $this->session->userdata('user_id')));
		if(empty($user)){
			session_destroy();
			redirect('auth');
		}
	}
    //transfer home
	public function index($id = null){
        if(!empty($id) && is_numeric($id)){ //If 'id' exists, the user is admin. The incoming 'id' is a member
            //find user's data
            $data['get_all'] = $this->all->get_all('records', array('record_is_deleted' => 0, 'record_user_id' => $id));
            //users to which records will be transferred
            $data['get_users'] = $this->all->get_all('users', array('user_is_deleted' => 0, 'user_type' => 2, 'user_id <> ' => $id));
            
            $data['title'] = 'Kayıtları Aktar';
            $data['id'] = $id;
            $order_array = array(
                'stage_rank' => 'ASC'
            );
            $data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
        } else { //If there is no 'id', the user is not admin. You can only transfer your own records
            //find user's data
            $data['get_all'] = $this->all->get_all('records', array('record_is_deleted' => 0, 'record_user_id' => $this->session->userdata('user_id')));
            //users to which records will be transferred
            $data['get_users'] = $this->all->get_all('users', array('user_is_deleted' => 0, 'user_type' => 2, 'user_id <>' => $this->session->userdata('user_id')));
            
            $data['title'] = 'Kayıtlarımı Aktar';
            $order_array = array(
                'stage_rank' => 'ASC'
            );
            $data['get_stage'] = $this->all->get_all('stage', array('stage_is_deleted' => 0), null, null, null, $order_array);
        }
		
		$data['view'] = 'transfer/index';
		$this->load->view('layout',$data);
    }
    //transfer operation
    public function transfer($id = null){
        //entered data
        $check = $this->input->post('check');
        $select = $this->input->post('select');
        //data controls
        if(empty($check)){
            $this->session->set_flashdata('error', 'Lütfen aktaracağınız kayıtları seçiniz!');
			redirect('transfer');
        } else {
            if($select == 0){
                $this->session->set_flashdata('error', 'Lütfen aktaracağınız kişiyi seçiniz!');
			    redirect('transfer');
            } else { //if controls is succesfull
                foreach($check as $c){ //update records to transfer
                    //update records table
                    $return = $this->all->update('records', array('record_user_id' => $select), 'record_id', $c);
                    if($return){ //if updated
                        //update notes table
                        $return = $this->all->update('notes', array('note_user_id' => $select), 'note_record_id', $c);
                    }
                }
                if($return){ //if updated
                    $this->session->set_flashdata('msg', 'Kayıtlar başarıyla aktarıldı.');
                    echo empty($id) ? redirect('transfer') : redirect('transfer/index/'.$id);
                } else { //if not updated
                    $this->session->set_flashdata('error', 'Bir sorun oluştu!');
                    echo empty($id) ? redirect('transfer') : redirect('transfer/index/'.$id);
                }
            }
        }
    }

}
