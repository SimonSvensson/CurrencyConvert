<?php

class currency_test extends TestCase {
    
    /* many of these actually test what is in the DB */
    
    public function setUp()
    {
        $this->obj = $this->newModel('Currency');
    }
    
    public function test_get_names()
    {
        $actual = $this->obj->get_names();
        $expected = 'United States';
        $this->assertContains($expected, $actual);
    }
    
    public function test_negative_get_names()
    {
        $actual = $this->obj->get_names();
        $not_expected = 'United Staters';
        $this->assertNotContains($not_expected, $actual);
    }
    
    public function test_get_common(){
        $actual = $this->obj->get_common();
        $expected = 'AUD';
        $this->assertContains($expected, $actual);
    }
    
    public function test_negative_get_common(){
        $actual = $this->obj->get_common();
        $not_expected = 'PEN';
        $this->assertNotContains($not_expected, $actual);
    }
    
    public function test_get_rate(){
        $response = $this->obj->get_rate('JPY');
        $this->assertTrue($response*1 > 0);
    }
    
    public function test_get_rate_json(){
        $response = json_decode($this->obj->get_rate('JPY', true));
        $this->assertTrue($response->rate > 0);
    }
    
    /* may fail if openexchangerates.org is unreachable */
    public function test_get_online_names(){
        $actual = $this->obj->get_online_names();
        $expected = 'Peruvian';
        $this->assertContains($expected, $actual);
    }
    
    /* may fail if openexchangerates.org is unreachable */
    public function test_negative_get_online_names(){
        $actual = $this->obj->get_online_names();
        $not_expected = 'Peruano';
        $this->assertNotContains($not_expected, $actual);
    }
}
