<?php
	/**
		* CodeIgniter Core Model
		*
		* @package         CodeIgniter
		* @subpackage      Model
		* @category        Core Model
		* @author          Amir Mufid
		* @version         1.1
	*/
	
	
	class Core_Model extends CI_Model{
		
		#variable private (poperpti)	
		
		function __construct()
		{
			parent:: __construct();
		}
		#Function for get data dan pagination 
		function get_all_data($table,$limit="",$offset=0,$param=array(),$sort=array())
		{	
			$key_field 	= (isset($param['keyword']))?$param['keyword']:null;
			$filter 	= (isset($param['filter']))?$param['keyword']:null;
			
			
			if($filter)
			{
				$this->db->where($filter);
			}
			
			if($key_field)
			{
				if(isset($key_field['key']) && isset($key_field['field']))
				{
					$this->db->group_start();
					foreach($key_field['field'] as $index=>$key)
					{
						if($index === 0)
						{
							$this->db->like($key,$key_field['key']);
						}
						else
						{
							$key_where[$key]=$key_field['key'];
						}
					}
					$this->db->or_like($key_where);
					$this->db->group_end();
				}
			}
			
			if($sort)
			{
				foreach($sort as $index=>$field)
				{
					$this->db->order_by($index,$field);
				}
			}
			if($limit)
			{
				return $this->db->get($table,$limit,$offset);
			}
			else
			{
				return $this->db->get($table);
			}
		}
		
		#Function for count all total row data
		function count_all_data($table,$param=array())
		{	
			$param['filter'] = '';
			$param['keyword'] = '';
			
			$key_field 	= $param['keyword'];
			$filter 	= $param['filter'];
			
			if($filter)
			{
				$this->db->where($filter);
			}
			
			if($key_field)
			{
				if(isset($key_field['key']) && isset($key_field['field']))
				{
					$this->db->group_start();
					foreach($key_field['field'] as $index=>$key)
					{
						if($index === 0)
						{
							$this->db->like($key,$key_field['key']);
						}
						else
						{
							$key_where[$key]=$key_field['key'];
						}
					}
					$this->db->or_like($key_where);
					$this->db->group_end();
				}
			}
			$fields = $this->db->field_data($table); $pk = null;
			foreach ($fields as $field)
			{
				if(isset($field->primary_key)){$pk = $field->primary_key;};
			}
			
			$this->db->select('count('.$pk.') as numrows',false);
			$row = $this->db->get($table)->row();
			return $row->numrows;
		}
		
		#Function for add data
		function insert_data($table,$data,$remove=array())
		{
			foreach($remove as $row)
			{
				unset($data[$row]);
			}
			return $this->db->insert($table,$data);
		}
		
		#Function for edit data
		function update_data($table,$data,$where=array(),$remove=array())
		{
			foreach($remove as $row)
			{
				unset($data[$row]);
			}
			
			$this->db->where($where);
			return $this->db->update($table,$data);
		}
		
		#Function for delete/remove data
		function delete_data($id)
		{
			$this->db->where($this->pk,$id);
			return $this->db->delete($this->table);
		}
		
	}