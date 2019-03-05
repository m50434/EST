<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EST_model extends CI_Model {
	
    /**
     * Holds an array of tables used
     *
     * @var array
     **/
    public $tables = array();
    
    
    
    
	public function __construct(){
		

		parent::__construct();
		$this->load->database();
		$this->config->load('ion_auth', TRUE);
		$this->config->load('est', TRUE);
		//$this->load->helper('cookie');
		//$this->load->helper('date');
		//$this->lang->load('ion_auth');
		
		// initialize db tables data
		$this->tables_ion_auth  = $this->config->item('tables', 'ion_auth');
		$this->tables_est  = $this->config->item('tables', 'est');
	}
	
	
	public function teachers($id = False){
		
		if ($id === FALSE)
		{
		    return $this->db->get($this->tables_est['teachers']);
		}
		
		$query = $this->db->select('password, salt')
		->where('ID', intval($id))
		->get($this->tables_est['teachers']);
		return $query;
		
	}
	
	
	
	public function set_teacher($teacher_data){
	    
	    $this->db->insert($this->tables_est['teachers'], $teacher_data);
	    
	}
	

	
	public function choices($id = False, $all = False){

	    if($all=="teacher")
	    {
	        $query = $this->db->select('*')
	        ->join('teachers', 'teachers.ID = parent_choice.teachers_ID')
	        ->join('users', 'users.ID = parent_choice.users_ID')
	        ->order_by("teachers.shortcode", "asc")
	        ->order_by("parent_choice.Priority", "asc")
	        ->order_by("users.username", "asc")
	        ->get($this->tables_est['parent_choice']);
	        //print_r($query);
	        return $query;
	        
	    }
	    
	    if($all=="parent")
	    {
	        $query = $this->db->select('*')
	        ->join('teachers', 'teachers.ID = parent_choice.teachers_ID')
	        ->join('users', 'users.ID = parent_choice.users_ID')
	        ->join('parent_options', 'users.ID = parent_options.users_ID')
	        ->order_by("users.username", "asc")
	        ->order_by("parent_choice.Priority", "asc")
	        ->order_by("teachers.shortcode", "asc")
	        ->get($this->tables_est['parent_choice']);
	        //print_r($query);
	        return $query;
	        
	    }
	    
	    if ($id === FALSE)
	    {
	        $query = $this->db->select('*')
	        ->order_by("parent_choice.users_ID", "asc")
	        ->order_by("parent_choice.Priority", "asc")
	        ->get($this->tables_est['parent_choice']);
	        return $query;
	    }
	    
	    $query = $this->db->select('*')
	    ->join('teachers', 'teachers.ID = parent_choice.teachers_ID')
	    ->where('users_ID', intval($id))
	    ->order_by("Priority", "asc")
	    ->get($this->tables_est['parent_choice']);
	    //print_r($query);
	    return $query;
	    
	}
	
	
	public function options($id = False){
	    
	    if ($id === FALSE)
	    {
	        return $this->db->get($this->tables_est['parent_options']);
	    }
	    
	    $query = $this->db->select('options')
	    ->where('users_ID', intval($id))
	    ->get($this->tables_est['parent_options']);
	    return $query;
	    
	}
	
	
	
	public function storeChoices($userid, $parentChoices, $parentOptions){
	    
	    
	    
	    // store choices
	    $this->db->where('users_ID', $userid);
	    $this->db->delete($this->tables_est['parent_choice']);
	    	        
	    $data = array();

	    
	    foreach ($parentChoices as $choice)
	    {
	        array_push($data,
	        array(
	            'users_ID' => $userid,
	            'teachers_ID' => $choice[0],
	            'Priority' => $choice[1]
	        )
	        );

	    }
	    //print_r($data);
	    if (!empty($data)){
	    $this->db->insert_batch($this->tables_est['parent_choice'], $data);
	    }
	    
	    
	    // store options
	    $this->db->where('users_ID', $userid);
	    $this->db->delete($this->tables_est['parent_options']);
	    $this->db->set('users_ID', $userid);
	    $this->db->set('options', $parentOptions);
	    $this->db->insert($this->tables_est['parent_options']);

	}
	
	
	
	public function delete_alldata($table){
	    $this->db->empty_table($table);
	}
	
	
	public function delete_teacher($id){
	    $this->db->where('ID', $id);
	    $this->db->delete($this->tables_est['teachers']);
	}
	
	public function delete_users_not_admin(){
	    //delete all user whithout admin
	    $this->db->where('id != ', -1);
	    $this->db->delete($this->tables_est['users']);
	    
	    // delete all parents (parents in group 2!!!)
	    $this->db->where('group_id', 2);
	    $this->db->delete($this->tables_est['users_groups']);
	}
	
	public function check_teacherid($id){
	    $query = $this->db->select('*')
	    ->where('ID', intval($id))
	    ->get($this->tables_est['teachers']);
	    return $query->result_array();
	}
	
	
	public function set_prefs($data){
	    $this->db->where('ID', 1);
	    $this->db->update($this->tables_est['prefs'], $data);
	}
	
	public function load_prefs(){
	    $query = $this->db->select('*')
	    ->get($this->tables_est['prefs']);
	    return $query;
	}
	

}