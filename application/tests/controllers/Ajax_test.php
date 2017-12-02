<?php

class Ajax_test extends TestCase {
    
    public function test_all_currencies(){
        $output = $this->request('GET', 'ajax/all_currencies');
        $this->assertContains('United States', $output);
    }
    
    public function test_get_rate(){
        $output = $this->request('GET', 'ajax/get_rate/USD');
        $this->assertContains('{"rate":"', $output);
    }
    
    public function test_conversion_factor(){
        $output = $this->request('GET', 'ajax/conversion_factor/USD/USD');
        $this->assertEquals('{"factor":1}', $output);
    }
    
    public function test_selectboxes_common(){
        $output = $this->request('GET', 'ajax/selectboxes');
        $this->assertContains('{"common":"', $output);
    }
    
    public function test_selectboxes_currencies(){
        $output = $this->request('GET', 'ajax/selectboxes');
        $this->assertContains('"currencies":"{', $output);
    }
}