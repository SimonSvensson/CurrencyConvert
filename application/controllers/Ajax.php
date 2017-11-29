<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
    
	public function all_currencies(){
  
            $data['data'] = $this->Currency->get_all_currencies();

            $this->load->view('ajax', $data);
	}
        
        public function get_rate($currency){
            
            $data['data'] = $this->Currency->get_rate($currency);
            
            $this->load->view('ajax', $data);
        }
        
        public function conversion_factor($source_currency, $target_currency){
            $data['data'] = $this->Currency->conversion_factor($source_currency, $target_currency);
            
            $this->load->view('ajax', $data);
        }
}