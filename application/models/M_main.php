<?php 

class M_main extends CI_Model{	

	function auth_process($where)
	{		
		return $this->db->get_where("login",$where);
	}	

	function getWhere($table,$params = "*",$where)
	{		
		$this->db->select($params);
		$this->db->where($where);
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) 
		{
			$result[] = $query->row_array();
		}
		else
		{
			$result[] = array();
		}
		return $result;
	}	


	function get($table)
	{		
		$sql = $this->db->get($table);
		if ($sql->num_rows() > 0) 
		{
			return $sql->result_array();
		}
		else
		{
			return false;
		}
	}	


	function update($table,$params,$where)
	{
		$this->db->set($params);
		$this->db->where($where);
		$query = $this->db->update($table);
		
		if ($query) 
		{
			$result = true;
		}
		else
		{
			$result = false;
		}
		return $result;
	}

	function delete($table)
	{
		return $this->db->empty_table($table);
	}

	function add($table,$params)
	{
		$this->db->set($params);
		
		if ($this->db->insert($table)) 
		{
			$result = true;
		}
		else
		{
			$result = false;
		}
		return $result;
	}

	function count()
	{
		$this->db->select('data_id');
		$this->db->from('data');
		$query = $this->db->get();	
		return $query->num_rows();	
	}	

	function getAll($table,$params ="*")
	{
		$this->db->select($params);
		$this->db->order_by("created_date","desc");
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) 
		{
			$result = $query->result_array();
		}
		else
		{
			$result = array();
		}
		return $result;		
	}
}