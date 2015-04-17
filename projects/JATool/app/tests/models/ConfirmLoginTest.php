<?php
 /**====================================================================
 * file name    ： ConfirmLoginTest.php
 * author       ： @Rcv!Chau.Duc
 * version      ： 1.0.0
 * date created ： 2015/02/13
 * description  ： sample.
 *
 =====================================================================*/

class ConfirmLoginTest extends TestCase{

	public $confirmLogin;
	/**
	 **********************************************************************
	 * tearDown
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function tearDown(){
		parent::SetUp();
	}
	/**
	 **********************************************************************
	 * testAuthenticateAccountSuccessfully
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testAuthenticateAccountSuccessfully(){
		$user = new MstLoginUser();
		$user->setAttribute('password','202cb962ac59075b964b07152d234b70');
		$mockMstLoginUser = Mockery::mock('Eloquent', 'MstLoginUser');
		$mockMstLoginUser->shouldReceive('getAccountFromDB')->once()->andReturn($user);
		Auth::shouldReceive('login')->once();
		$mockTblLoginHistory = Mockery::mock('Eloquent', 'TblLoginHistory');
		$this->confirmLogin = new ConfirmLogin($mockTblLoginHistory, $mockMstLoginUser);
		$this->assertEquals(true,$this->confirmLogin->authenticateAccount("duc",'123'));
	}

	public function testAuthenticateAccountUnSuccessfully(){
		$user = (object) array('userid' => 'admin','password' => '1234');
		$mockMstLoginUser = Mockery::mock('Eloquent', 'MstLoginUser');
		$mockMstLoginUser->shouldReceive('getAccountFromDB')->once()->andReturn($user);
		Auth::shouldReceive('login')->once();
		$mockTblLoginHistory = Mockery::mock('Eloquent', 'TblLoginHistory');
		$this->confirmLogin = new ConfirmLogin($mockTblLoginHistory, $mockMstLoginUser);
		$this->assertEquals(0,$this->confirmLogin->authenticateAccount("duc",'123'));
	}
} 