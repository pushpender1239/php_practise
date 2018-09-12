<?php
/**
 * 
 */
class Drop_model extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	function country()
	{
		$this->db->select('*');
		$q=$this->db->get('country');
		return $q->result_array();

	}
	function state($id)
	{
		$this->db->select('*');
		// $this->db->from('state');
		$this->db->where('c_id',$id);
		$q=$this->db->get('state');
		return $q->result_array();
	}
	function city($id)
	{
		$this->db->select('*');
		// $this->db->from('state');
		$this->db->where('s_id',$id);
		$q=$this->db->get('city');
		return $q->result_array();
	}
}

?>