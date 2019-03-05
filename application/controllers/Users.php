<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();

		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	// redirect if needed, otherwise display parents choice
	public function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			// set the flash data error message if there is one
			


			
			// load prefs
			$this->data['prefs'] = $this->EST_model->load_prefs()->result(); // 
			if($this->data['prefs'][0]->choice_on==0){
			    //$this->session->set_flashdata('message_user', $this->config->item('no_choice', 'est'));
			    $this->session->set_flashdata('message_user', 'Achtung: Sie können keine Veränderungen mehr speichern. Die Wahlzeit ist beendet.');
			}
			
			$this->data['message_user'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_user');
			
			$userx = $this->ion_auth->user()->row();

			$this->data['usersx'] = $userx;
			
			$this->data['teachers'] = $this->EST_model->teachers()->result();
			$this->data['choices'] = $this->EST_model->choices($userx->id)->result();
			
			$options = $this->EST_model->options($userx->id)->result();
			
			if(sizeof($options) != 0 ){$this->data['options'] = explode(",",$options[0]->options);}
			else{$this->data['options'] = $options;}
			
			$this->data['choice_for_children1'] = $this->data['prefs'][0]->choice_children1;
			$this->data['choice_for_children2'] = $this->data['prefs'][0]->choice_children2;
			$this->data['choice_for_children3'] = $this->data['prefs'][0]->choice_children3;
			$this->data['parent_option'] = array($this->data['prefs'][0]->option1,$this->data['prefs'][0]->option2,$this->data['prefs'][0]->option3,$this->data['prefs'][0]->option4,$this->data['prefs'][0]->option5,$this->data['prefs'][0]->option6);

			$this->data['number_of_children'] = substr_count(htmlspecialchars($userx->children,ENT_QUOTES,'UTF-8'), ',')+1;
			$this->data['stored_choices'] = count($this->data['choices']);


			$this->_render_page('templates/header', $this->data);
			$this->_render_page('templates/navbar_users', $this->data);
			$this->_render_page('users/parent_choice', $this->data);
			$this->_render_page('templates/footer');
		}
	}


	

	public function storeParentChoices()
	{
	    
	    
	    if (!$this->ion_auth->logged_in())
	    {
	        redirect('auth', 'refresh');
	       
	    }
	    

	    else
	    {	        
	        $this->data['prefs'] = $this->EST_model->load_prefs()->result();
	        if($this->data['prefs'][0]->choice_on==1){
    	        $parentChoices = json_decode($this->input->post('parent_choices'));
    	        $parentOptions = $this->input->post('parent_checkboxes');
    	        $userx = $this->ion_auth->user()->row();
    	        $this->EST_model->storeChoices($userx->id,$parentChoices, $parentOptions);
	        }

	    }
	}
	
	
	

	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{
	    
	    $this->viewdata = (empty($data)) ? $this->data: $data;
	    
	    $view_html = $this->load->view($view, $this->viewdata, $returnhtml);
	    
	    if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}

}
