<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	    
	    

		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		
		
		// load prefs
		$this->data['prefs'] = $this->EST_model->load_prefs()->result(); // 
		
		
		$this->_render_page('templates/header', $this->data);
		
		
		if (!$this->ion_auth->logged_in())
        {
            redirect('auth', 'refresh');
            // individual Start-Page??
            //$this->load->view('templates/navbar_site', $this->data);
            //$this->load->view('parent_conference', $this->data);
        } 
		else if($this->ion_auth->is_admin()){

		    redirect('auth', 'refresh');
		}		
		else if($this->ion_auth->in_group("parents")){

		    redirect('users', 'refresh');
		}
		
		$this->load->view('templates/footer');
	}
	
	
	
	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{
	    
	    $this->viewdata = (empty($data)) ? $this->data: $data;
	    
	    $view_html = $this->load->view($view, $this->viewdata, $returnhtml);
	    
	    if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}
}
