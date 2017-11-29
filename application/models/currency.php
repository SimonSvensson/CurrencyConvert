<?php

class Currency extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    var $app_id = '55cabee23e6047d1b32513c93d7fb40c';
    
    /* gets and returns an array with the most common currencies */
    function get_common(){
        
        $query = $this->db->get('common');
        foreach($query->result() as $row){
            $result[] = $row->iso_4217;
        }
        return $result;
    }
    
    /* gets and returns JSON with currency names */
    function get_names($as_array = false){
        
        $json = file_get_contents('https://openexchangerates.org/api/currencies.json');
        
        return $as_array ? json_decode($json, true) : $json;
    }
    
    /* gets and returns JSON with rates */
    function get_currency_rates(){
        
        $currency_rates = json_decode(file_get_contents('https://openexchangerates.org/api/latest.json?app_id='.$this->app_id));
        
        return json_encode($currency_rates->rates);
    }
    
    /* gets and returns JSON with rates and currency names */
    function get_combined(){
        
        $all = Array();
        
        $currency_names = json_decode($this->get_names());
        $currency_rates = json_decode($this->get_currency_rates());
        
        foreach($currency_rates AS $iso => $rate){
            $all[$iso]['rate'] = $rate;
            $all[$iso]['name'] = $currency_names->$iso;
        }
        
        
        return $all;
    }
    
    /* gets and returns the stored rate for the currency from the database */ 
    function get_rate($iso){
        $query = $this->db->get_where('currencies', Array('iso_4217' => $iso));
        $result = $query->result();
        
        return $result[0]->rate;
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
    }
    
    /* gets all the currencies from the db as a JSON */
    function get_all_currencies(){
        
        $query = $this->db->get('currencies');
        
        return json_encode($query->result());
    }
    
    /* calculates and returns the correct conversion factor */ 
    function conversion_factor($sourceCurrency, $targetCurrency){
        $source = $this->get_rate($sourceCurrency);
        $target = $this->get_rate($targetCurrency);
        
        return json_encode(Array('factor' => $target/$source));
        
    }
}