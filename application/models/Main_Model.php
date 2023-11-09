<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
    }

    // To get data in row
    public function getData($tbl,$where)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($where);
        $query =$this->db->get();
        return $query->row_array();
    }
    
     // To get All Data
    public function getAllOrderData($tbl,$order_by)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->order_by($order_by);
        $query = $this->db->get();
        return $query->result_array();
    } 

    public function getAllData_as_per_order($tbl,$where,$order_by)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($where);
        $this->db->order_by($order_by);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // num_rows
    public function getAllArrayData_row($tbl)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        $query = $this->db->get();
        return $query->num_rows();
    }   

    public function getAllArrayData_row_wh($tbl,$where)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // To Insert Data 
    public function insertData($tbl,$arr)
    {
        $this->db->insert($tbl,$arr);
        return $this->db->insert_id();
    }
    
    // To Edit Data 
    public function editData($tbl,$where,$arr)
    {
        $this->db->where($where);
        if($this->db->update($tbl,$arr))
        {
            return TRUE;
        } 
        else 
        {
            return FALSE;
        }
    }

    // To  delete  
    public function deleteData($tbl,$where)
    {
        $this->db->where($where);
        if($this->db->delete($tbl))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    function getAllRecords($tbl,$limit,$offset,$order_by)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        // $this->db->from('students');
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getAllRecords_wh($tbl,$where,$limit,$offset,$order_by)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        // $this->db->from('students');
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get();
        return $query->result_array();
    }

    
}
?>