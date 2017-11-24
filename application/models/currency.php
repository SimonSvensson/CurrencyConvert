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
    
    /* gets and returns json with currency names */
    function get_names($as_array = false){
        
        $json = file_get_contents('https://openexchangerates.org/api/currencies.json');
        
        return $as_array ? json_decode($json, true) : $json;
    }
    
    /* gets and returns json with rates */
    function get_currency_rates(){
        
        $currency_rates = json_decode(file_get_contents('https://openexchangerates.org/api/latest.json?app_id='.$this->app_id));
        
        return json_encode($currency_rates->rates);
    }
    
    /* gets and returns json with rates and currency names */
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
        $query = $this->db->get_where('currencies', Array('iso_4217' => $iso), 1);
    
        return Array($iso, $query->result()->rate);
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
}