<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	
	public function index(){
                
                //$data['common'] = $this->Currency->get_common(true);
                //$data['currencies'] = $this->Currency->get_names(true);
                
                $this->load->view('header');
		//$this->load->view('main_content', $data);
                $this->load->view('main_content');
                $this->load->view('footer');
                
	}

}
