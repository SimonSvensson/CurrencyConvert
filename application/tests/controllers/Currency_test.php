<?php

class Currency_test extends TestCase {
    public function test_get_names(){
        
        $CI =& get_instance();
        $CI->load->model('Currency');
        $this->assertTrue(strlen($CI->Currency->get_names()) > 0 );
        //$output = $this->Currency->get_names();
        
    }
}