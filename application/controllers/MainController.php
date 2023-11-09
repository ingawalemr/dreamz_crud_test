<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
        $this->load->helper('date'); 
        $this->load->library('form_validation');
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('Main_Model');
        $this->load->library('pagination');
	}
	
	// add and get student record
	public function index()
	{
		$student_nos = $this->input->post('student_nos');
		$student_name = $this->input->post('student_name');
		$student_dob = $this->input->post('student_dob');
        $student_doj = $this->input->post('student_doj');

        $wh_stud = '(student_nos = "'.$student_nos.'" AND student_name = "'.$student_name.'" AND student_dob = "'.$student_dob.'" AND student_doj = "'.$student_doj.'")';
        $students_exist = $this->Main_Model->getData($tbl='students', $wh_stud);

        if (isset($_POST['add_info'])) 
        {
        	if(empty($students_exist)) 
            {
            	$arr = array(
                                'student_nos'=>$student_nos,
                                'student_name'=>$student_name,
                                'student_dob'=>$student_dob,
                                'student_doj'=>$student_doj,
                            );
                $this->Main_Model->insertData($tbl='students', $arr);
                $this->session->set_flashdata('create', 'Student info has been added successfully..!');
                redirect(base_url().'index');
            }
            else
            {
                $this->session->set_flashdata('exists', 'Student info already exists!');
                redirect(base_url().'index');
            }
		} 
		else
        {
            $config['base_url'] = base_url('index'); 
            $config['total_rows'] = $this->Main_Model->getAllArrayData_row($tbl='students'); 
            // echo $config['total_rows'] ;die;
            $config['per_page'] = 10;

            $config['first_link'] = 'First';
            $config['last_link'] = 'Last';
            $config['next_link'] = '>';
            $config['prev_link'] = '<';
            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open']= '<li class="page-item">';
            $config['num_tag_close']='</li>';
            $config['cur_tag_open'] ="<li class='disabled page-item'><li class='active page-item'>
                                        <a href='#' class='page-link'>";
            $config['cur_tag_close'] ="<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] ="<li class='page-item'>";
            $config['next_tag1_close'] ="</li>";
            $config['prev_tag_open'] ="<li>";
            $config['prev_tag1_close'] ="<li class='page-item'>";
            $config['first_tag_open'] ="<li>";
            $config['first_tag1_close'] ="<li class='page-item'>";
            $config['last_tag_open'] = "<li>";
            $config['last_tag1_close'] = "<li class='page-item'>";
            $config['attributes'] = array('class' => 'page-link wid'); 

            $this->pagination->initialize($config);


            $order_by = ('uid desc');
            $data['students_list']= $this->Main_Model->getAllRecords($tbl='students', $config['per_page'], $this->uri->segment(2), $order_by);
            //$this->Main_Model->getAllOrderData($tbl='students', $order_by);
            // echo "<pre>"; print_r($data['students_list']); echo "<pre>"; die;
            $this->load->view('index', $data);
        }          
		// $this->load->view('index');
	}

	public function delete_student($uid)
    {
        // echo $uid;
        $where = '(uid="'.$uid.'")';
        $this->Main_Model->deleteData($tbl='students',$where);
        $this->session->set_flashdata('exists', 'Student info has been deleted successfully..!');
        redirect(base_url().'index');
    }

    public function update_student($uid)
    {
        // echo $uid; 
        $student_nos = $this->input->post('student_nos');
		$student_name = $this->input->post('student_name');
		$student_dob = $this->input->post('student_dob');
        $student_doj = $this->input->post('student_doj');

        $arr = array(
                        'student_nos'=>$student_nos,
                        'student_name'=>$student_name,
                        'student_dob'=>$student_dob,
                        'student_doj'=>$student_doj,
                    );
        $where = '(uid = "'.$uid.'")';
        $this->Main_Model->editData($tbl='students', $where, $arr);
        $this->session->set_flashdata('edit', 'Student info has been updated successfully..!');
        redirect(base_url().'index');
    }

    
    /*public function active_student_status() 
    {
        $status = $this->input->post('status'); 

        $uid = $this->input->post('uid');
        // echo $uid;die;         
        $where = '(uid="'.$uid.'")';
        $arr = array(
                        'status' => $status
                    );
        $update_id = $this->Main_Model->editData($tbl='students',$where,$arr);
         
        if($update_id)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }*/

}
?>