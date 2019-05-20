<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Userreview extends REST_Controller {

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get() {
    	$query = $this->db->get('user_review');

    	$data = [];

    	if($query->num_rows() > 0) {
    		$data = $query->result_array();
    	}

    	echo json_encode(array(
    		'success' => ( count($data) > 0 ? true : false ),
    		'data' => $data
    	));
    }

    function index_post() {
    	$post = $this->post();
    	$success = false;
    	$message = '';

    	if($post) {
    		$post['created_at'] = date('Y-m-d H:i:s');

    		$insert = $this->db->insert('user_review', $post);

	        if ($insert) {
	            $success = true;
	            $message = 'Data updated successfully';
	        } else {
	            $success = false;
	            $message = 'An error occured while saving data';
	        }
    	}

    	echo json_encode(array(
    		'success' => $success,
    		'message' => $message,
    		'data' => $post
    	));
    }

    function index_put() {
    	$put = $this->put();

    	$success = false;
    	$message = '';

    	if(isset($put['id']) && $put['id'] != '' && $put['id'] != null) {

    		$put['updated_at'] = date('Y-m-d H:i:s');

    		$id = $put['id'];

    		$this->db->where('id', $id);
    		$update = $this->db->update('user_review', $put);

    		if($update) {
    			$success = true;
    			$message = 'Data updated successfully';
    		}
    		else {
    			$success = false;
    			$message = 'An error occured while saving data';
    		}
    	}

    	echo json_encode(array(
    		'success' => $success,
    		'message' => $message,
    		'data' => $put
    	));
    }

    function index_delete() {
    	$delete = $this->delete();

    	$success = false;
    	$message = '';

    	if(isset($delete['id']) && $delete['id'] != '' && $delete['id'] != null) {

    		$id = $delete['id'];

    		$this->db->where('id', $id);
    		$doDelete = $this->db->delete('user_review');

    		if($doDelete) {
    			$success = true;
    			$message = 'Data updated successfully';
    		}
    		else {
    			$success = false;
    			$message = 'An error occured while deleting data';
    		}

    	}

    	echo json_encode(array(
    		'success' => $success,
    		'message' => $message
    	));
    }

}