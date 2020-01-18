<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class All_model extends CI_Model{

        public function get_item($table, $data, $join_array = null, $or_where = null){
            $request = $this->db->from($table);

            if($join_array != null) {
                foreach($join_array as $key => $value){
                    $request = $this->db->join($key, $value);
                }
            }
            if($or_where != null) {
                foreach($or_where as $key => $value){
                    $request = $this->db->or_where($key, $value);
                }
            }

            $request = $this->db->where($data);
            $request = $this->db->get()->row();
            return $request;
        }

        public function get_all($table, $data, $join_array = null, $per_page = null, $page = null, $order_array = null, $like = null, $or_like = null){
            $request = $this->db->from($table);

            if($join_array != null) {
                foreach($join_array as $key => $value){
                    $request = $this->db->join($key, $value);
                }
            }
            if($like != null) {
                foreach($like as $key => $value){
                    $request = $this->db->like($key, $value);
                }
            }

            if($or_like != null) {
                foreach($or_like as $key => $value){
                    $request = $this->db->or_like($key, $value);
                }
            }
            
            if($per_page !== null && $page !== null){
                $request = $this->db->limit($per_page, $page);
            }
            
            if($order_array != null) {
                foreach($order_array as $key => $value){
                    $request = $this->db->order_by($key, $value);
                }
            }

            $request = $this->db->where($data);
            $request = $this->db->get()->result();
            return $request;
        }

        public function update($table, $update_data, $where, $id){
            return $this->db->set($update_data)
                            ->where($where, $id)
                            ->update($table);
        }

        public function insert($table, $add_data){
            return $this->db->insert($table, $add_data);
        }

        public function delete($table, $delete_data){
            return $this->db->delete($table, $delete_data);
        }

        public function pagination($config = array(), $table, $array = array(), $join_array = null){
            $this->pagination->initialize($config);

            $page = !empty($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
            
            $view_data = new stdClass();
            $view_data->result = $this->get_all($table, $array, $join_array, $config['per_page'], $page);
          
            $view_data->links = $this->pagination->create_links();
            
            return $view_data;
        }

        public function fetch_data($query, $key = null){
            if(!empty($query)){
                if(!empty($key) && $key == 'register'){
                    $request = $this->get_all('users', array('user_is_deleted' => 0, 'user_type' => 2), null, null, null, null, array('user_name_surname' => $query));
                    return $request;
                } else {
                    $request = $this->get_all('records', array('record_is_deleted' => 0), null, null, null, null, array('record_name_surname' => $query), array('record_clinic_name' => $query));
                    return $request;
                }
            }
        }
    }
