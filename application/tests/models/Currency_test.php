<?php

class currency_test extends TestCase {
    
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
        $expected = 'United Staters';
        $this->assertNotContains($expected, $actual);
    }
}