<?php
class UserTest extends TestCase{

	public function tearDown(){
		parent::SetUp();

	}

	public function testCheckLogin(){
		$mock = Mockery::mock('User');
		$mock->shouldReceive('checkLogin')
			->with('abc','123')
			->once();
	}
} 