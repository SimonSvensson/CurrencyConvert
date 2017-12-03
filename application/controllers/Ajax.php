<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
        
        /* Gets and displays a JSON from the DB containing all saved currencies. */
	public function all_currencies(){
  
            $data['data'] = $this->Currency->get_all_currencies();

            $this->load->view('ajax', $data);
	}
        
        /* Gets updates all currencies from openexchangerates.org.
         * The return is basically an ACK */
        public function update_currencies(){
            
            $data['data'] = $this->Currency->update_currencies();
            
            $this->load->view('ajax', $data);
        }
        
        /* gets the rate of a currency */
        public function get_rate($currency = NULL){
            
            $data['data'] = $this->Currency->get_rate($currency, true);
            
            $this->load->view('ajax', $data);
        }
        
        /* Gets the conversion factor for the two selected currencies */
        public function conversion_factor($source_currency = NULL, $target_currency = NULL){
            
            $data['data'] = $this->Currency->conversion_factor($source_currency, $target_currency);
            
            $this->load->view('ajax', $data);
        }
        
        /* Removes all the currencies from the DB */
        public function wipe_currencies(){
            
            $data['data'] = $this->Currency->clear_currency('everything');
            
            $this->load->view('ajax', $data);
        }
        
        /* Removes a currency from the DB */
        public function clear_currency($iso = NULL){
            
            $data['data'] = $this->Currency->clear_currency($iso);
            
            $this->load->view('ajax', $data);
        }
        
        /* gets the data to be put in the selectboxes */
        public function selectboxes(){
            
            $common = $this->Currency->get_common();
            $currencies = $this->Currency->get_names();
            $result = Array();
            $errors = false;
            
            if(!isset( json_encode($common)->error) ){
                $result['common'] = $common;
            }else{
                $result['error'] = json_encode($common)->error;
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
