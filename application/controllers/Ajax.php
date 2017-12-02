<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
    
	public function all_currencies(){
  
            $data['data'] = $this->Currency->get_all_currencies();

            $this->load->view('ajax', $data);
	}
        
        public function update_currencies(){
            
            $data['data'] = $this->Currency->update_currencies();
            
            $this->load->view('ajax', $data);
        }
        
        public function get_rate($currency = NULL){
            
            $data['data'] = $this->Currency->get_rate($currency, true);
            
            $this->load->view('ajax', $data);
        }
        
        public function conversion_factor($source_currency = NULL, $target_currency = NULL){
            
            $data['data'] = $this->Currency->conversion_factor($source_currency, $target_currency);
            
            $this->load->view('ajax', $data);
        }
        
        public function wipe_currencies(){
            
            $data['data'] = $this->Currency->clear_currency('everything');
            
            $this->load->view('ajax', $data);
        }
        
        public function clear_currency($iso = NULL){
            
            $data['data'] = $this->Currency->clear_currency($iso);
            
            $this->load->view('ajax', $data);
        }
        
        public function selectboxes(){
            
            $common = $this->Currency->get_common();
            $currencies = $this->Currency->get_names();
            $result = Array();
            $errors = false;
            if(!isset( json_encode($common)->error) ){
                $result['common'] = $common;
            }else{
                $result['error'] = 'Could not load common currencies from DB';
                $errors = true;
            }
            
            if(!isset(json_decode($currencies)->error) ){
                $result['currencies'] = $currencies;
            }else{
                $result['error'] = json_decode($currencies)->error;
                $errors = true;
            }
            
            $data['data'] = json_encode( $errors ? $result['error'] : $result );
            $this->load->view('ajax', $data);
        }
}
