<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->tables_est  = $this->config->item('tables', 'est');
	}

	// redirect if needed, otherwise display the user list
	public function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			// set the flash data error message if there is one
		    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['message_parents'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_parents');
			$this->data['message_teachers_results'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_teachers_results');
			$this->data['message_teachers'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_teachers');
			$this->data['message_rooms'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_rooms');
			$this->data['message_prefs'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_prefs');

			
			// load prefs
			$this->data['prefs'] = $this->EST_model->load_prefs()->result(); // 
			
			//list the users
			$this->data['users'] = $this->ion_auth->users()->result(); // 
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			
			
			// list the parents
			$this->data['parents'] = $this->ion_auth->users(2)->result(); // without admins
			
			
			// list the teachers
			$this->data['teachers'] = $this->EST_model->teachers()->result();
			
			//teacher choices
			$choices_tmp = $this->EST_model->choices(false, "teacher")->result();
			$choices = array(array());
			$previousValue = null;
			$i=-1;
			foreach($choices_tmp as $choice){
			    if(isset($previousValue) && $choice->teachers_ID == $previousValue->teachers_ID) {
			        array_push($choices[$i],$choice);
			    }
			    else{
			    $i++;
			    $choices[$i] = array();
			    array_push($choices[$i],$choice);
			    }
			    $previousValue = $choice;
			}
			$this->data['teacher_choices'] = $choices;
			
			
			//parent choices
			$choices_tmp = $this->EST_model->choices(false, "parent")->result();
			$choices = array(array());
			$previousValue = null;
			$i=-1;
			foreach($choices_tmp as $choice){
			    if(isset($previousValue) && $choice->users_ID == $previousValue->users_ID) {
			        array_push($choices[$i],$choice);

			        //if(sizeof($options) != 0 ){$this->data['options'] = explode(",",$options[0]->options);}
			    }
			    else{
			        $i++;
			        $choices[$i] = array();
			        array_push($choices[$i],$choice);

			        //if(sizeof($choices[$i][0]->options) != 0 ){$choices[$i][0]->options = explode(",", $choices[$i][0]->options);}
			        $choices[$i][0]->options = explode(",", $choices[$i][0]->options);

			    }
			    $previousValue = $choice;
			}
			$this->data['parent_choices'] = $choices;

			$this->data['parent_option'] =  array($this->data['prefs'][0]->option1,$this->data['prefs'][0]->option2,$this->data['prefs'][0]->option3,$this->data['prefs'][0]->option4,$this->data['prefs'][0]->option5,$this->data['prefs'][0]->option6);

			$this->data['teachers_results'] = $this->EST_model->results(false,"teacher")->result();
			
			$this->data['parents_results'] = $this->EST_model->results(false,"parents")->result();
			
			$this->data['rooms'] = $this->EST_model->getRooms()->result();
			
			$userx = $this->ion_auth->user()->row();
			$this->data['usersx'] = $userx;
			$this->_render_page('templates/header', $this->data);
			$this->_render_page('templates/navbar_admin', $this->data);
			$this->_render_page('auth/index', $this->data);
			$this->_render_page('templates/footer');
		}
	}
	
	
	
	public function edit_prefs(){
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    
	    if($this->input->post('choice_on')=="off")$temp=0;
		else if($this->input->post('choice_on')=="on")$temp=1;
		else if($this->input->post('choice_on')=="erg")$temp=2;
	    $data = array(
	        'title'   => $this->input->post('title'),
	        'school' => $this->input->post('school'),
	        'choice_children1' => $this->input->post('choice_children1'),
	        'choice_children2' => $this->input->post('choice_children2'),
	        'choice_children3' => $this->input->post('choice_children3'),
	        'choice_on' => $temp,
	        'option1' => $this->input->post('option1'),
	        'option2' => $this->input->post('option2'),
	        'option3' => $this->input->post('option3'),
	        'option4' => $this->input->post('option4'),
	        'option5' => $this->input->post('option5'),
	        'option6' => $this->input->post('option6'),
	        'footer' => $this->input->post('footer'),
	        'navbarcolor' => (strpos($this->input->post('navbarcolor'),"#")) ? $this->input->post('navbarcolor') : "#".$this->input->post('navbarcolor'),
	        'textnavbarcolor' => (strpos($this->input->post('textnavbarcolor'),"#")) ? $this->input->post('textnavbarcolor') : "#".$this->input->post('textnavbarcolor'),
	        'linknavbarcolor' => (strpos($this->input->post('linknavbarcolor'),"#")) ? $this->input->post('linknavbarcolor') : "#".$this->input->post('linknavbarcolor'),
	        'datum1' => $this->input->post('datum1'),
	        'datum2' => $this->input->post('datum2'),
	        'manual' => $this->input->post('manual'),
	    );
	    
	    $this->EST_model->set_prefs($data);
	    $this->session->set_flashdata('message_prefs', "Einstellungen gespeichert");
	    redirect('auth', 'refresh');
	    
	}
	
	
	public function delete_parents(){
	    
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    
	    $data = array();
	    $data['response'] = "";
	    $deletelines=0;
	    
	    $simulate = $this->input->post('edit_simulate');
	    
	    $data['users'] = $this->ion_auth->users(2)->result();
	    
	    $data['response'] .= "<b>Folgende Datensätze werden gelöscht: </b>";
	    
	    foreach($data['users'] as $data_parent){
	        
	        if( $data_parent->id!=-1){
	        $data['response'] .= "</br> " . $data_parent->id . " " . $data_parent->username . " " . $data_parent->children;
	        $deletelines++;}
	        
	    }
	    
	    
	    if($simulate!="on"){
	        $this->EST_model->delete_users_not_admin();
	        $this->EST_model->delete_alldata($this->tables_est['parent_options']);
	        $this->EST_model->delete_alldata($this->tables_est['parent_choice']);
	        $this->EST_model->delete_alldata($this->tables_est['parent_results']);
	    }
	    
	    $data['response'] .= "</br><b> Es wurden " .  $deletelines . " Datensätze sowie alle möglichen Elternwahlen und Elternergebnisse gelöscht! </b></br></br></br> ";
	    
	    
	    $this->session->set_flashdata('message_parents', $data['response']);
	    redirect('auth', 'refresh');
	}
	
	
	
	
	public function delete_teachers(){
	    
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    
	    $data_teachers = array();
	    $data_teachers['response'] = "";
	    $deletelines=0;
	    
	    $simulate = $this->input->post('edit_simulate_teachers');
	    
	    $data_teachers['teachers'] = $this->EST_model->teachers()->result();
	    
	    $data_teachers['response'] .= "<b>Folgende Datensätze werden gelöscht: </b>";
	    
	    foreach($data_teachers['teachers'] as $data_teacher){
	        
	        $data_teachers['response'] .= "</br> " . $data_teacher->ID . " " . $data_teacher->surname . " " . $data_teacher->shortcode . " " . $data_teacher->gender . " " . $data_teacher->section1 . " " . $data_teacher->section2;
	        $deletelines++;
  
	    }
	    
	    
	    if($simulate!="on"){
	        $this->EST_model->delete_alldata($this->tables_est['teachers']);
	        $this->EST_model->delete_alldata($this->tables_est['parent_choice']);
	    }
	    
	    $data_teachers['response'] .= "</br><b> Es wurden " .  $deletelines . " Datensätze sowie alle möglichen Elternwahlen gelöscht! </b></br></br></br> ";
	    
	    
	    $this->session->set_flashdata('message_teachers', $data_teachers['response']);
	    redirect('auth', 'refresh');
	}
	
	
	public function delete_teachers_results(){
	    
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    
	    $data = array();
	    $data['response'] = "";
	    $deletelines=0;
	    
	    $simulate = $this->input->post('edit_simulate_teachers_results');
	    
	    $data['parent_results'] = $this->EST_model->results(false,"parents")->result();
	    
	    $data['response'] .= "<b>Folgende Datensätze werden gelöscht: </b>";
	    
	    foreach($data['parent_results'] as $data_teacher_result){
	        
	        $data['response'] .= "</br> " . $data_teacher_result->users_ID . " " . $data_teacher_result->teachers_ID . " " . $data_teacher_result->Day . " " . $data_teacher_result->Time;
	        $deletelines++;
	        
	    }
	    
	    
	    if($simulate!="on"){
	        $this->EST_model->delete_alldata($this->tables_est['parent_results']);
	    }
	    
	    $data['response'] .= "</br><b> Es wurden " .  $deletelines . " Datensätze gelöscht! </b></br></br></br> ";
	    
	    
	    $this->session->set_flashdata('message_teachers_results', $data['response']);
	    redirect('auth', 'refresh');
	}
	
	
	public function delete_rooms(){
	    
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    
	    $data = array();
	    $data['response'] = "";
	    $deletelines=0;
	    
	    $simulate = $this->input->post('edit_simulate_rooms');
	    
	    $data['rooms'] = $this->EST_model->getRooms()->result();
	    
	    $data['response'] .= "<b>Folgende Datensätze werden gelöscht: </b>";
	    
	    foreach($data['rooms'] as $room){
	        
	        $data['response'] .= "</br> " . $room->teachers_ID . " " . $room->roomnumber;
	        $deletelines++;
	        
	    }
	    
	    
	    if($simulate!="on"){
	        $this->EST_model->delete_alldata($this->tables_est['teacher_rooms']);
	    }
	    
	    $data['response'] .= "</br><b> Es wurden " .  $deletelines . " Datensätze gelöscht! </b></br></br></br> ";
	    
	    
	    $this->session->set_flashdata('message_rooms', $data['response']);
	    redirect('auth', 'refresh');
	}
	
	public function insert_csv_parents(){
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    $data = array();
	    
	   
	    if(!empty($_FILES['file']['name'])){
	        
	        // set Checkboxes
	        $data['response'] = "";
	        $simulate = $this->input->post('edit_simulate');
	        $delete = $this->input->post('edit_delete');
	        $headline = $this->input->post('edit_headline');

	        
	        $deletelines=0;
	        
	        if($simulate=="on"){
	            $data['response'] .= "<h3><b>SIMULATION des Imports !!! </b></h3></br>";
	            
	        }
	        
	        
	        // delete data 

	        if($delete=="on"){
	            $data['users'] = $this->ion_auth->users(2)->result();
	            
	            $data['response'] .= "<b>Folgende Datensätze werden gelöscht: </b>";
	            
	            foreach($data['users'] as $data_parent){
	              
	                $data['response'] .= "</br> " . $data_parent->id . " " . $data_parent->username . " " . $data_parent->children;
	                $deletelines++;

	            }
	            
	            
	            if($simulate!="on"){
	                $this->EST_model->delete_alldata($this->tables_est['parent_options']);
	                $this->EST_model->delete_alldata($this->tables_est['parent_choice']);
	            }
	            
	            $data['response'] .= "</br><b> Es wurden " .  $deletelines . " Datensätze gelöscht! </b></br></br></br> ";
	            
	        }
	        
	       
	        
	        
	        // Set preference
	        $config['upload_path'] = 'assets/files/';
	        $config['allowed_types'] = 'csv|txt';
	        $config['max_size'] = '1000'; // max_size in kb
	        $config['file_name'] = $_FILES['file']['name'];
	        
	        // Load upload library
	        $this->load->library('upload',$config);
	        
	        // File upload
	        if($this->upload->do_upload('file')){
	            // Get data about the file
	            $uploadData = $this->upload->data();
	            $filename = $uploadData['file_name'];
	            
	            // Reading file
	            $file = fopen("assets/files/".$filename,"r");
	            $i = 0;
	            
	            $importData_arr = array();
	            
	            while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
	                $num = count($filedata);
	                //$filedata = array_map("utf8_encode", $filedata); //added
	                
	                for ($c=0; $c < $num; $c++) {
	                    
	                    $filedata [$c] = htmlspecialchars(html_entity_decode($filedata [$c], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
	                    $importData_arr[$i][] = $filedata [$c];
	                    
	                }
	                $i++;
	            }
	            fclose($file);
	            unlink("assets/files/".$filename);
	            
	            // ignore first line
	            if($headline=="on"){
	                $skip = 0;
	                $line = 0;
	            }
	            else{
	                $skip = 1;
	                $line = 1;
	            }
	            

	            
	            $data_imports = 0;
	            
	            // insert import data
	            $data_import="";
	            
	            
	            //helper for id=0;
	            $id_imported=false;
	            
	            
	            if($simulate!="on"){
	                $this->ion_auth->db_trans_start();
	            }
	            
	            
	            foreach($importData_arr as $userdata){
	                if($skip != 0){
	                    

	                    //$userdata = explode(";", $userdata[0]);
	                    if(isset($userdata[0]) && isset($userdata[1]) && isset($userdata[2]) && isset($userdata[3]) && is_numeric($userdata[0]) && $userdata[0]!="" && $userdata[1]!="" && $userdata[2]!="" && $userdata[3]!="" ){
	                    
	                        if($this->ion_auth->check_id(intval($userdata[0]))==null && $this->ion_auth->check_username($userdata[1])==null){
	                            $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3] . " <i class=\"icon fa fa-check\"></i>";
	                       
	                            if($simulate!="on"){ 
	                                $this->ion_auth->register($userdata[1], $userdata[2], "", array("id" => $userdata[0], "children" => $userdata[3])); 
	                                if($userdata[0]==0)$id_imported=true;
	                            }
	  	                            
	                        $data_imports++;
	                        }
	                        
	                        else{
	                            $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3] . " - Fehler - ID oder Username bereits vorhanden! <i class=\"icon fa fa-ban\" style=\"color:red;\"></i>";
	                        }
	                        
	                        
	                        
	                    }
	                    else{
	                        $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3] . " Fehler - Daten falsch oder unvollständig! <i class=\"icon fa fa-ban\" style=\"color:red;\"></i>";
	                    }
	                    
	                    
	                    
	                }
	                $skip ++;
	                $line ++;
	            }
	            
	            if($simulate!="on"){
	                $this->ion_auth->db_trans_complete();
	                
	                //Admin wird automatisch beim Import in Parents-Gruppe gesteckt, daher löschen
	                $this->ion_auth->delete_admin_parent();
	                if($id_imported){
	                    $this->ion_auth->insert0idtogroup();
	                }
	                
	            }
	            
	            $data['response'] .= 'Aus der Datei <b>'.$filename . ' </b> wurden folgende Daten importiert: </br>';
	            $data['response'] .= $data_import;
	            $data['response'] .= '</br></br>'.$data_imports . ' Datensätze wurden importiert.';
	            
	        }else{
	            $data['response'] .= 'Die Datei konnte nicht geladen werden.';
	        }
	    }else{
	        $data['response'] .= 'Die Datei ist beschädigt oder leer.';
	    }

	        
	    $this->session->set_flashdata('message_parents', $data['response']);
	    redirect('auth', 'refresh');
	    
	}
	
	public function insert_csv_results(){
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    $data = array();
	    

	    if(!empty($_FILES['file']['name'])){
	        
	        // set Checkboxes
	        $data['response'] = "";
	        $simulate = $this->input->post('edit_simulate_teachers_results');
	        $delete = $this->input->post('edit_delete_teachers_results');
	        $headline = $this->input->post('edit_headline_teachers_results');
	        
	        
	        $deletelines=0;
	        
	        if($simulate=="on"){
	            $data['response'] .= "<h3><b>SIMULATION des Imports !!! </b></h3></br>";
	            
	        }
	        
	       
	        // delete data
	        
	        if($delete=="on"){
	            $data['parent_results'] = $this->EST_model->results(false,"parents")->result();
	            
	            $data['response'] .= "<b>Folgende Datensätze werden gelöscht: </b>";
	            
	            foreach($data['parent_results'] as $parent_result){
	                
	                $data['response'] .= "</br> " . $parent_result->id . " " . $parent_result->username . " " . $parent_result->surname . " " . $parent_result->Day . " " . $parent_result->Time;
	                $deletelines++;
	                
	            }
	            
	            
	            if($simulate!="on"){
	               $this->EST_model->delete_alldata($this->tables_est['parent_results']);
	                
	            }
	            
	            $data['response'] .= "</br><b> Es wurden " .  $deletelines . " Datensätze gelöscht! </b></br></br></br> ";
	            
	        }
	        
	        
	        
	        
	        // Set preference
	        $config['upload_path'] = 'assets/files/';
	        $config['allowed_types'] = 'csv|txt';
	        $config['max_size'] = '1000'; // max_size in kb
	        $config['file_name'] = $_FILES['file']['name'];
	        
	        // Load upload library
	        $this->load->library('upload',$config);
	        
	        // File upload
	        if($this->upload->do_upload('file')){
	            // Get data about the file
	            $uploadData = $this->upload->data();
	            $filename = $uploadData['file_name'];
	            
	            // Reading file
	            $file = fopen("assets/files/".$filename,"r");
	            $i = 0;
	            
	            $importData_arr = array();
	            
	            while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
	                $num = count($filedata);
	                //$filedata = array_map("utf8_encode", $filedata); //added
	                
	                for ($c=0; $c < $num; $c++) {
	                    
	                    $filedata [$c] = htmlspecialchars(html_entity_decode($filedata [$c], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
	                    $importData_arr[$i][] = $filedata [$c];
	                    
	                }
	                $i++;
	            }
	            fclose($file);
	            unlink("assets/files/".$filename);
	            
	            // ignore first line
	            if($headline=="on"){
	                $skip = 0;
	                $line = 0;
	            }
	            else{
	                $skip = 1;
	                $line = 1;
	            }
	            
	            
	            
	            $data_imports = 0;
	            
	            // insert import data
	            $data_import="";
	            
	            
	            if($simulate!="on"){
	                $this->ion_auth->db_trans_start();
	            }
	            
	            
	            foreach($importData_arr as $userdata){
	                if($skip != 0){
	                    
	                    
	                    //$userdata = explode(";", $userdata[0]);
	                    if(isset($userdata[0]) && isset($userdata[1]) && isset($userdata[2]) && isset($userdata[3]) && is_numeric($userdata[0]) && $userdata[0]!="" && $userdata[1]!="" && $userdata[2]!="" && $userdata[3]!="" ){
	                        
	                        if($this->EST_model->check_parentresultsid(intval($userdata[0]),intval($userdata[1]))==null){
	                            $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3] . " <i class=\"icon fa fa-check\"></i>";
	                            
	                            if($simulate!="on"){
	                                $result_data = array(
	                                    'users_ID'   => $userdata[0],
	                                    'teachers_ID'   => $userdata[1],
	                                    'Day'   => $userdata[2],
	                                    'Time'      => $userdata[3]
	                                );
	                                $this->EST_model->set_parents_results($result_data);
	                            }
	                            
	                            $data_imports++;
	                            }
	                            else{
	                                $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3] . " - Fehler - ElternID  und LehrerID in dieser Kombination bereits vorhanden! <i class=\"icon fa fa-ban\" style=\"color:red;\"></i>";
	                            }
	                        
	                        
	                        
	                    }
	                    else{
	                        $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3] . " Fehler - Daten falsch oder unvollständig! <i class=\"icon fa fa-ban\" style=\"color:red;\"></i>";
	                    }
	                    
	                    
	                    
	                }
	                $skip ++;
	                $line ++;
	            }
	            
	         
	            
	    
	            if($simulate!="on"){
	                $this->ion_auth->db_trans_complete();
	                
	            }
	     
	            
	            $data['response'] .= 'Aus der Datei <b>'.$filename . ' </b> wurden folgende Daten importiert: </br>';
	            $data['response'] .= $data_import;
	            $data['response'] .= '</br></br>'.$data_imports . ' Datensätze wurden importiert.';
	            
	        }else{
	            $data['response'] .= 'Die Datei konnte nicht geladen werden.';
	        }
	       
	    }else{
	        $data['response'] .= 'Die Datei ist beschädigt oder leer.';
	    }
	    
	    
	    $this->session->set_flashdata('message_teachers_results', $data['response']);
	    redirect('auth', 'refresh');
	    
	}
	
	
	
	public function insert_csv_rooms(){
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    $data = array();
	    
	    
	    if(!empty($_FILES['file']['name'])){
	        
	        // set Checkboxes
	        $data['response'] = "";
	        $simulate = $this->input->post('edit_simulate_rooms');
	        $delete = $this->input->post('edit_delete_rooms');
	        $headline = $this->input->post('edit_headline_rooms');
	        
	        
	        $deletelines=0;
	        
	        if($simulate=="on"){
	            $data['response'] .= "<h3><b>SIMULATION des Imports !!! </b></h3></br>";
	            
	        }
	        
	        
	        // delete data
	        
	        if($delete=="on"){
	            $data['rooms'] = $this->EST_model->getRooms()->result();
	            
	            $data['response'] .= "<b>Folgende Datensätze werden gelöscht: </b>";
	            
	            foreach($data['rooms'] as $room){
	                
	                $data['response'] .= "</br> " . $room->shortcode . " " . $room->surname . " " . $room->roomnumber;
	                $deletelines++;
	                
	            }
	            
	            
	            if($simulate!="on"){
	                $this->EST_model->delete_alldata($this->tables_est['teacher_rooms']);
	              
	                
	            }
	            
	            $data['response'] .= "</br><b> Es wurden " .  $deletelines . " Datensätze gelöscht! </b></br></br></br> ";
	            
	        }
	        
	        
	        
	        
	        // Set preference
	        $config['upload_path'] = 'assets/files/';
	        $config['allowed_types'] = 'csv|txt';
	        $config['max_size'] = '1000'; // max_size in kb
	        $config['file_name'] = $_FILES['file']['name'];
	        
	        // Load upload library
	        $this->load->library('upload',$config);
	        
	        // File upload
	        if($this->upload->do_upload('file')){
	            // Get data about the file
	            $uploadData = $this->upload->data();
	            $filename = $uploadData['file_name'];
	            
	            // Reading file
	            $file = fopen("assets/files/".$filename,"r");
	            $i = 0;
	            
	            $importData_arr = array();
	            
	            while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
	                $num = count($filedata);
	                //$filedata = array_map("utf8_encode", $filedata); //added
	                
	                for ($c=0; $c < $num; $c++) {
	                    
	                    $filedata [$c] = htmlspecialchars(html_entity_decode($filedata [$c], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
	                    $importData_arr[$i][] = $filedata [$c];
	                    
	                }
	                $i++;
	            }
	            fclose($file);
	            unlink("assets/files/".$filename);
	            
	            // ignore first line
	            if($headline=="on"){
	                $skip = 0;
	                $line = 0;
	            }
	            else{
	                $skip = 1;
	                $line = 1;
	            }
	            
	            
	            
	            $data_imports = 0;
	            
	            // insert import data
	            $data_import="";
	            
	            
	            if($simulate!="on"){
	                $this->ion_auth->db_trans_start();
	            }
	            
	            
	            foreach($importData_arr as $userdata){
	                if($skip != 0){
	                    
	                    
	                    //$userdata = explode(";", $userdata[0]);
	                    if(isset($userdata[0]) && isset($userdata[1]) && is_numeric($userdata[0]) && $userdata[0]!="" && $userdata[1]!=""){
	                        
	                      if($this->EST_model->check_roomid(intval($userdata[0]))==null){
	                        $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " <i class=\"icon fa fa-check\"></i>";
	                        
	                        if($simulate!="on"){
	                            $result_data = array(
	                                'teachers_ID'   => $userdata[0],
	                                'roomnumber'   => $userdata[1]
	                            );
	                            $this->EST_model->set_rooms($result_data);
	                        }
	                        
	                        $data_imports++;
	                        
	                        }
	                        else{
	                            $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " - Fehler - ID und Raumnummer bereits vorhanden! <i class=\"icon fa fa-ban\" style=\"color:red;\"></i>";
	                        }
	                        
	                        
	                    }
	                    else{
	                        $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1]  . " Fehler - Daten falsch oder unvollständig! <i class=\"icon fa fa-ban\" style=\"color:red;\"></i>";
	                    }
	                    
	                 
	                    
	                }
	                $skip ++;
	                $line ++;
	            }
	            
	            
	            
	            
	            if($simulate!="on"){
	                $this->ion_auth->db_trans_complete();
	                
	            }
	            
	            
	            $data['response'] .= 'Aus der Datei <b>'.$filename . ' </b> wurden folgende Daten importiert: </br>';
	            $data['response'] .= $data_import;
	            $data['response'] .= '</br></br>'.$data_imports . ' Datensätze wurden importiert.';
	            
	        }else{
	            $data['response'] .= 'Die Datei konnte nicht geladen werden.';
	        }
	        
	    }else{
	        $data['response'] .= 'Die Datei ist beschädigt oder leer.';
	    }
	    
	    
	    $this->session->set_flashdata('message_rooms', $data['response']);
	    redirect('auth', 'refresh');
	    
	}
	
	
	public function insert_csv_teachers(){
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }
	    
	    $data_teachers = array();
	    
	    
	    if(!empty($_FILES['file_teachers']['name'])){
	        
	        // set Checkboxes
	        $data_teachers['response'] = "";
	        $simulate = $this->input->post('edit_simulate_teachers');
	        $delete = $this->input->post('edit_delete_teachers');
	        $headline = $this->input->post('edit_headline_teachers');
	        
	        
	        $deletelines=0;
	        
	        if($simulate=="on"){
	            $data_teachers['response'] .= "<h3><b>SIMULATION des Imports !!! </b></h3></br>";
	            
	        }
	        
	        
	        // delete data
	        
	        if($delete=="on"){
	            $data_teachers['teachers'] = $this->EST_model->teachers()->result();
	            //$data['users'] = $this->ion_auth->users(2)->result();
	            
	            $data_teachers['response'] .= "<b>Folgende Datensätze werden gelöscht: </b>";
	            
	            foreach($data_teachers['teachers'] as $data_teacher){
	                
	                $data_teachers['response'] .= "</br> " . $data_teacher->ID . " " . $data_teacher->surname . " " . $data_teacher->shortcode . " " . $data_teacher->gender . " " . $data_teacher->section1 . " " . $data_teacher->section2;
	                $deletelines++;

	            }
	            
	            
	            if($simulate!="on"){
	                $this->EST_model->delete_alldata($this->tables_est['teachers']);
	                $this->EST_model->delete_alldata($this->tables_est['parent_choice']);
	            }
	            
	            $data_teachers['response'] .= "</br><b> Es wurden " .  $deletelines . " Datensätze gelöscht! </b></br></br></br> ";
	            
	        }
	        
	        
	        
	        
	        // Set preference
	        $config['upload_path'] = 'assets/files/';
	        $config['allowed_types'] = 'csv|txt';
	        $config['max_size'] = '1000'; // max_size in kb
	        $config['file_name'] = $_FILES['file_teachers']['name'];
	        
	        // Load upload library
	        $this->load->library('upload',$config);
	        
	        // File upload
	        if($this->upload->do_upload('file_teachers')){
	            // Get data about the file
	            $uploadData = $this->upload->data();
	            $filename = $uploadData['file_name'];
	            
	            // Reading file
	            $file = fopen("assets/files/".$filename,"r");
	            $i = 0;
	            
	            $importData_arr = array();
	            
	            while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
	                $num = count($filedata );
	                //$filedata = array_map("utf8_encode", $filedata); //added
	                
	                for ($c=0; $c < $num; $c++) {
	                    $filedata [$c] = htmlspecialchars(html_entity_decode($filedata [$c], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
	                    $importData_arr[$i][] = $filedata [$c];
	                }
	                $i++;
	            }
	            fclose($file);
	            unlink("assets/files/".$filename);
	            
	            // ignore first line
	            if($headline=="on"){
	                $skip = 0;
	                $line = 0;
	            }
	            else{
	                $skip = 1;
	                $line = 1;
	            }
	            
	            
	            
	            $data_imports = 0;
	            
	            // insert import data
	            $data_import="";
	            
	            
	            if($simulate!="on"){
	            $this->ion_auth->db_trans_start();
	            }
	            
	            foreach($importData_arr as $userdata){
	                if($skip != 0){
	                    
	                    
	                    //$userdata = explode(";", $userdata[0]);
	                    if(isset($userdata[0]) && isset($userdata[1]) && isset($userdata[2]) && isset($userdata[3]) && is_numeric($userdata[0]) && $userdata[0]!="" && $userdata[1]!="" && $userdata[2]!="" && $userdata[3]!=""){
	                        
	                        if($this->EST_model->check_teacherid(intval($userdata[0]))==null){
	                            
	                            if($userdata[4]=="")$userdata[4]="-"; 
	                            if($userdata[5]=="")$userdata[5]="-"; 
	                            
	                            $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3]. " " . $userdata[4]. " " . $userdata[5] . " <i class=\"icon fa fa-check\"></i>";
	                            
	                            if($simulate!="on"){
	                                $teacher_data = array(
	                                    'ID'   => $userdata[0],
	                                    'surname'   => $userdata[1],
	                                    'shortcode'   => $userdata[2],
	                                    'gender'      => $userdata[3],
	                                    'section1' => $userdata[4],
	                                    'section2' => $userdata[5]
	                                );
	                                $this->EST_model->set_teacher($teacher_data);
	                                
	                                
	                            }
	                            
	                            $data_imports++;
	                        }
	                        
	                        else{
	                            $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3] . " " . $userdata[4]. " " . $userdata[5] . " - Fehler - ID oder Username bereits vorhanden! <i class=\"icon fa fa-ban\" style=\"color:red;\"></i>";
	                        }
	                        
	                        
	                        
	                    }
	                    else{
	                        $data_import .= "</br> " . $line . ". Datensatz: " . $userdata[0] . " " . $userdata[1] . " " . $userdata[2] . " " . $userdata[3] . " " . $userdata[4]. " " . $userdata[5] . " Fehler - Daten falsch oder unvollständig! <i class=\"icon fa fa-ban\" style=\"color:red;\"></i>";
	                    }
	                    
	                    
	                    
	                }
	                $skip ++;
	                $line ++;
	            }
	            
	            
	            if($simulate!="on"){
	                $this->ion_auth->db_trans_complete();
	            }
	            
	            
	            $data_teachers['response'] .= 'Aus der Datei <b>'.$filename . ' </b> wurden folgende Daten importiert: </br>';
	            $data_teachers['response'] .= $data_import;
	            $data_teachers['response'] .= '</br></br>'.$data_imports . ' Datensätze wurden importiert.';
	            
	        }else{
	            $data_teachers['response'] .= 'Die Datei konnte nicht geladen werden.';
	        }
	    }else{
	        $data_teachers['response'] .= 'Die Datei ist beschädigt oder leer.';
	    }
    
	    
	    $this->session->set_flashdata('message_teachers', $data_teachers['response']);
	    redirect('auth', 'refresh');
	    
	}
	
	
	// Export data in CSV format
	public function exportCSV($table="choices"){
	    
	    
	    if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
	    {
	        redirect('auth', 'refresh');
	    }


	    if($table=="choices"){
	        $filename = 'parent_choice'.date('Ymd').'.csv';
	        $data = $this->EST_model->choices(false,false)->result_array();
	        $header = array("parentID","teacherID","Priority");
	    }
	    if($table=="options"){
	        $filename = 'parent_options'.date('Ymd').'.csv';
	        $data = $this->EST_model->options()->result_array();
	        $header = array("parentID","options");
	    }
	        

	    header("Content-Description: File Transfer");
	    header("Content-Disposition: attachment; filename=$filename");
	    header("Content-Type: application/csv; ");
	    
	
	    // file creation
	    $file = fopen('php://output', 'w');
	    
	   
	    $newline = $this->getcsvline( $header, ";", "\"", "\r\n" );
	    fwrite($file, $newline);

	    
	    foreach ($data as $key=>$line){
	        $newline = $this->getcsvline( $line, ";", "\"", "\r\n" );
	        fwrite( $file, $newline);

	    }
	    fclose($file);
	    exit;
	}
	
	function getcsvline($list,  $seperator, $enclosure, $newline = "" ){
	    $fp = fopen('php://temp', 'r+');
	    
	    fputcsv($fp, $list, $seperator, $enclosure );
	    rewind($fp);
	    
	    $line = fgets($fp);
	    if( $newline and $newline != "\n" ) {
	        if( $line[strlen($line)-2] != "\r" and $line[strlen($line)-1] == "\n") {
	            $line = substr_replace($line,"",-1) . $newline;
	        } else {
	            // return the line as is (literal string)
	            //die( 'original csv line is already \r\n style' );
	        }
	    }
	    
	    return $line;
	}

	

	// log the user in
	public function login()
	{
		$this->data['title'] = $this->lang->line('login_heading');
		// load prefs
		$this->data['prefs'] = $this->EST_model->load_prefs()->result(); // 
		
		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/', 'refresh');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);

			$this->_render_page('templates/header', $this->data);
			$this->_render_page('templates/navbar_site');
			$this->_render_page('auth/login', $this->data);
			$this->_render_page('templates/footer');
		}
	}

	// log the user out
	public function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	// change password
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			// render
			$userx = $this->ion_auth->user()->row();
			$this->data['usersx'] = $userx;
			$this->data['prefs'] = $this->EST_model->load_prefs()->result();
			$this->_render_page('templates/header', $this->data);
			
			if($this->ion_auth->is_admin()){
				$this->_render_page('templates/navbar_admin', $this->data);
			}
			else{
				$this->_render_page('templates/navbar_users', $this->data);
			}
			$this->_render_page('auth/change_password', $this->data);
			$this->_render_page('templates/footer');
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	// forgot password
	public function forgot_password()
	{
	    print_r("Turned off");
	    
	    /*
	    
		// setting validation rules by checking whether identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' )
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false)
		{
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
			);

			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['prefs'] = $this->EST_model->load_prefs()->result();
			$this->_render_page('templates/header', $this->data);
			$this->_render_page('templates/navbar_site');
			$this->_render_page('auth/forgot_password', $this->data);
			$this->_render_page('templates/footer');
		}
		else
		{
			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if(empty($identity)) {

	            		if($this->config->item('identity', 'ion_auth') != 'email')
		            	{
		            		$this->ion_auth->set_error('forgot_password_identity_not_found');
		            	}
		            	else
		            	{
		            	   $this->ion_auth->set_error('forgot_password_email_not_found');
		            	}

		                $this->session->set_flashdata('message', $this->ion_auth->errors());
                		redirect("auth/forgot_password", 'refresh');
            		}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
		*/
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$userx = $this->ion_auth->user()->row();
				$this->data['usersx'] = $userx;
				$this->data['prefs'] = $this->EST_model->load_prefs()->result();
				$this->_render_page('templates/header', $this->data);
				$this->_render_page('templates/navbar_admin', $this->data);
				$this->_render_page('auth/reset_password', $this->data);
				$this->_render_page('templates/footer');
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	// activate the user
	public function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$userx = $this->ion_auth->user()->row();
			$this->data['usersx'] = $userx;
			$this->data['prefs'] = $this->EST_model->load_prefs()->result();
			$this->_render_page('templates/header', $this->data);
			$this->_render_page('templates/navbar_admin', $this->data);
			$this->_render_page('auth/deactivate_user', $this->data);
			$this->_render_page('templates/footer');
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	// create a new user
	public function create_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        //$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        //$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim');
        
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            if($this->config->item('email_required', 'ion_auth'))
            {
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
            }
            else
            {
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim');
            }
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
         
			$userx = $this->ion_auth->user()->row();
			$this->data['usersx'] = $userx;
			$this->data['prefs'] = $this->EST_model->load_prefs()->result();
			$this->_render_page('templates/header', $this->data);
			$this->_render_page('templates/navbar_admin', $this->data);
            $this->_render_page('auth/create_user', $this->data);
			$this->_render_page('templates/footer');
        }
    }

	// register a new user
	public function register()
    {
	    print_r("Turned off");
        /*
        $this->data['title'] = $this->lang->line('create_user_heading');
        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            if($this->config->item('email_required', 'ion_auth'))
            {    
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
            }
            else
            {
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim');
            }
                
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        }
        else
        {
           
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->data['prefs'] = $this->EST_model->load_prefs()->result();
            $this->_render_page('templates/header', $this->data);
			$this->_render_page('templates/navbar_site');
            $this->_render_page('auth/register', $this->data);
			$this->_render_page('templates/footer');
        }
        */
    }

	// edit a user
	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		
		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		
		$tables = $this->config->item('tables','ion_auth');
		$identity_column = $this->config->item('identity','ion_auth');
		$this->data['identity_column'] = $identity_column;
		
		
		// validate form input
		//$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		//$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim');
		
		if($identity_column!=='email')
		{
		
		    //$this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
		    $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required');
		    if($this->config->item('email_required', 'ion_auth'))
		    {
		        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
		    }
		    else
		    {
		        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim');
		    }
		}
		else
		{
		    $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
		}
		//$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		//$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
			    
			    $email    = strtolower($this->input->post('email'));
			    
				$data = array(
				    'username'   => ($identity_column==='email') ? $email : $this->input->post('identity'),
				    'email'      => $email,
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		
		$this->data['identity'] = array(
		    'name'  => 'identity',
		    'id'    => 'identity',
		    'type'  => 'text',
		    'value' => $this->form_validation->set_value('identity', $user->username),
		);
		
		$this->data['email'] = array(
		    'name'  => 'email',
		    'id'    => 'email',
		    'type'  => 'text',
		    'value' => $this->form_validation->set_value('email', $user->email),
		);
		
		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$userx = $this->ion_auth->user()->row();
		$this->data['usersx'] = $userx;
		$this->data['prefs'] = $this->EST_model->load_prefs()->result();
		$this->_render_page('templates/header', $this->data);
		$this->_render_page('templates/navbar_admin', $this->data);
		$this->_render_page('auth/edit_user', $this->data);
		$this->_render_page('templates/footer');
	}

	// create a new group
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$userx = $this->ion_auth->user()->row();
			$this->data['usersx'] = $userx;
			$this->data['prefs'] = $this->EST_model->load_prefs()->result();
			$this->_render_page('templates/header', $this->data);
			$this->_render_page('templates/navbar_admin', $this->data);
			$this->_render_page('auth/create_group', $this->data);
			$this->_render_page('templates/footer');
		}
	}

	// edit a group
	public function edit_group($id)
	{
		// bail if no group id given
		if(!$id || !isset($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$userx = $this->ion_auth->user()->row();
		$this->data['usersx'] = $userx;
		$this->data['prefs'] = $this->EST_model->load_prefs()->result();
		$this->_render_page('templates/header', $this->data);
		$this->_render_page('templates/navbar_admin', $this->data);
		$this->_render_page('auth/edit_group', $this->data);
		$this->_render_page('templates/footer');
	}


	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}

}
