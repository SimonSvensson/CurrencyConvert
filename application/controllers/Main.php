<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	
	public function index(){
                
                $this->load->model('Currency');
                
                $data['common'] = $this->Currency->get_common();
                $data['currencies'] = $this->Currency->get_names(true);
                
                $this->load->view('header');
		$this->load->view('main_content', $data);
                $this->load->view('footer');
                
	}

}
