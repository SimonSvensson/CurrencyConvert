<?php

class Main_test extends TestCase
{
	public function test_index()
	{
		$output = $this->request('GET', 'main/index');
		$this->assertContains('<legend>', $output);
	}

	public function test_bootstrap()
	{
		$output = $this->request('GET', 'main/index');
		$expected = 'assets/css/bootstrap.min.css';
		$this->assertContains($expected, $output);
	}

	public function test_bootstrap_select()
	{
		$output = $this->request('GET', 'main/index');
		$expected = "assets/css/bootstrap-select.css";
		$this->assertContains($expected, $output);
	}

	public function test_method_404()
	{
		$this->request('GET', 'main/method_not_exist');
		$this->assertResponseCode(404);
	}

	public function test_APPPATH()
	{
		$actual = realpath(APPPATH);
		$expected = realpath(__DIR__ . '/../..');
		$this->assertEquals(
			$expected,
			$actual,
			'Your APPPATH seems to be wrong. Check your $application_folder in tests/Bootstrap.php'
		);
	}
}
