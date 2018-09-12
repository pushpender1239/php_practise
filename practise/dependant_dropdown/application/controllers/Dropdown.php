<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dropdown extends CI_Controller
{


 function __construct()
	{
		parent::__construct();	
		$this->load->helper('url');
		$this->load->model('Drop_model');
	}
	function index()
	{
		$data['res'] = $this->Drop_model->country();

		$this->load->view('dropdown',$data);
	}
	function state(){
		$id = $this->input->post('id');
		$res=$this->Drop_model->state($id);
		$dt='';
		foreach ($res as $r) {
			$dt.='<option value="'.$r['id'].'" >'.$r['name'].'</option>';

		}
		$data =array('status'=>true,'result'=>$dt);
		print_r($data['result']);
	}
	function city(){
		$id = $this->input->post('id');
		$res=$this->Drop_model->city($id);
		$dt='';
		foreach ($res as $r) {
			$dt.='<option value="'.$r['id'].'" >'.$r['name'].'</option>';

		}
		$data =array('status'=>true,'result'=>$dt);
		print_r($data['result']);	
	}
}

?>