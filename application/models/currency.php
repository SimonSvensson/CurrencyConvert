<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    var $app_id = '55cabee23e6047d1b32513c93d7fb40c'; /* app id for openexchangerates.org */
    
    
    /* gets and returns an array with the most common currencies */
    /* (common currencies are predefined in the database) */
    function get_common($as_array = false){
        
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('common');
        
        if($query->num_rows() > 0){  /* checks that we got something from th DB */
            foreach($query->result() as $row){
                $result[] = $row->iso_4217;
            }
        }else{
            log_message('error', 'Failed to load common currencies from the DB');
            $result['error'] = 'Failed to load common currencies from the DB';
        }
        return $as_array ? $result : json_encode($result);
    }
    
    
    /* gets and returns JSON with currency names from DB */
    function get_names($as_array = false){
        
        $this->db->order_by('iso_4217', 'ASC');
        $this->db->select('iso_4217, name');
        $query = $this->db->get('currencies');
        
        if($query->num_rows() > 0){ /* checks that we got something from the DB */
            foreach($query->result() as $row){
                $result[$row->iso_4217] = $row->name;
            }
            return $as_array ? $result : json_encode($result);
            
        }else{
            log_message('error', 'Failed to fetch currency names from database. Trying to get external update');
            if($this->update_currencies()){
                return $this->get_names($as_array);
            }else{
                log_message('error', 'Could not get external update of the currencies');
                return json_encode(Array('error' => 'Query to DB returned an empty result, and could not get external update.'));
            }
        }
    }
    
    
    /* gets and returns JSON with currency names from OEX */
    function get_online_names(){
        $this->load->library('PHPRequests');
        
        $json = Requests::get('https://openexchangerates.org/api/currencies.json');
        
        return $json->body;
    }
    
    
    /* gets and returns JSON with rates from OEX */
    function get_online_currency_rates(){
        
        $this->load->library('PHPRequests');
        
        $json = Requests::get('https://openexchangerates.org/api/latest.json?app_id='.$this->app_id);
        
        $currency_rates = json_decode( $json->body );
        
        return json_encode($currency_rates->rates);
    }
    
    
    /* gets and returns an array with rates and currency names */
    function get_combined(){
        
        $all = Array();
        
        $currency_names = json_decode($this->get_online_names());
        $currency_rates = json_decode($this->get_online_currency_rates());
        
        foreach($currency_rates AS $iso => $rate){
            $all[$iso]['rate'] = $rate;
            $all[$iso]['name'] = $currency_names->$iso;
        }

        return $all;
    }
    
    
    /* gets and returns the stored rate for the currency from the database */ 
    function get_rate($iso, $as_json = false){
        
        $result = (object) ['rate' => 0]; /* 0 will be the return value if there
                                           * is some DB error */
        
        $query = $this->db->get_where('currencies', Array('iso_4217' => $iso));
        if($query->num_rows() > 0 ){
            $result = $query->first_row();
        }
        
        /* return it as a json if specified, otherwise as a string */
        return $as_json ? json_encode( Array( 'rate' => $result->rate ) ) : $result->rate;
    }
    
    
    /* fetches and inserts/updates the currencies in the db */
    function update_currencies(){
        
        foreach( $this->get_combined() as $iso => $curr ){
            
            $data = Array(
                'iso_4217' => $iso,
                'name' => $curr['name'],
                'date_modified' => date("Y-m-d H:i:s"),
                'rate' => $curr['rate']
            );
            
            $this->db->where('iso_4217', $iso);
            if( $this->db->count_all_results('currencies', false) >= 1 ){
                $this->db->update('currencies', $data);
            }else{
                $this->db->insert('currencies', $data);
            }
        }
        
        /* no return, other than an ACK */
        return json_encode(Array('success' => true));
    }
    
    
    /* gets all the currencies from the db as a JSON */
    function get_all_currencies(){
        
        $this->db->order_by('iso_4217', 'ASC');
        $query = $this->db->get('currencies');
        
        if($query->num_rows() > 0){
            return json_encode($query->result());
        }else{
            log_message('error', 'Failed to fetch currency rates from DB. No currencies in DB? Trying to get external update');
            if($this->update_currencies()){
                return $this->get_all_currencies();
            }else{
                log_message('error', 'Could not get external update of the currencies');
                return json_encode(Array('error' => 'Query to DB returned an empty result, and could not get external update.'));
            }
        }
    }
    
    
    /* calculates and returns the correct conversion factor */ 
    function conversion_factor($sourceCurrency, $targetCurrency){
        $source = $this->get_rate($sourceCurrency);
        $target = $this->get_rate($targetCurrency);
        
        if($source > 0){ /* we don't want to divide by 0 */
            return json_encode(Array('factor' => $target/$source));
        }else{
            log_message('error', 'Could not get correct rate for '.$sourceCurrency);
            return json_encode(Array('error' => 'Could not get correct rate for the currencies<br>'
                . 'Are the source and target currencies selected?<br>'
                . 'Try to update currencies or refreshing if there are no available.'));
        }
        
        
    }
    
    
    /* deletes the selected currency or currencies from the DB */
    function clear_currency($iso){
        
        if( $iso == 'everything'){
            $this->db->empty_table('currencies');
        }else{
            $this->db->where('iso_4217', $iso);
            $this->db->delete('currencies');
        }
        return json_encode(Array('success' => ($this->db->affected_rows() > 0 ? true : false) )); 
    }
}