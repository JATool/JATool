<?php
 /**====================================================================
 * file name    ： AuthControllerTest.php
 * author       ： @Rcv!Chau.Duc
 * version      ： 1.0.0
 * date created ： 2015/02/13
 * description  ： sample.
 *
 =====================================================================*/

class AuthControllerTest  extends TestCase{
	/**
	 * @var MstLoginUser model
	 */
	public $mstLoginUser;

	/**
	 * @var ConfirmLogin model
	 */
	public $confirmLogin;

	/**
	 * @var TblLoginHistory
	 */
	public $tblLoginHistory;

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

		Session::start();

		// Enable filters
		Route::enableFilters();
	}

	/**
	 **********************************************************************
	 * testPostLoginInputValidateMissingUserId
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testPostLoginInputValidateMissingUserId(){
		$credentials = array(
				'userId'=>'',
				'password'=>'admin'
		);

		$response = $this->call('POST', 'login', $credentials);
		$this->assertRedirectedTo('/');
		$this->assertSessionHasErrors();
		$this->assertEquals( Lang::get('validation.required', array('attribute' => 'UserID')), Session::get('errors')->getBag('default')->first('userId') );
	}

	/**
	 **********************************************************************
	 * testPostLoginInputValidateUserIdMaxLength
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testPostLoginInputValidateUserIdMaxLength(){
		$credentials = array(
				'userId'=>'012345678901234567890',
				'password'=>'admin'
		);

		$response = $this->call('POST', 'login', $credentials);
		$this->assertRedirectedTo('/');
		$this->assertSessionHasErrors();
		$this->assertEquals( Lang::get('validation.max.string', array('attribute' => 'UserID','max' => '20')), Session::get('errors')->getBag('default')->first('userId') );
	}

	/**
	 **********************************************************************
	 * testPostLoginInputValidatePasswordMaxLength
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testPostLoginInputValidatePasswordMaxLength(){
		$credentials = array(
				'userId'=>'admin',
				'password'=>'012345678901234567890'
		);

		$response = $this->call('POST', 'login', $credentials);
		$this->assertRedirectedTo('/');
		$this->assertSessionHasErrors();
		$this->assertEquals( Lang::get('validation.max.string', array('attribute' => 'Password','max' => '20')), Session::get('errors')->getBag('default')->first('password') );
	}

	/**
	 **********************************************************************
	 * testPostLoginInputValidateMissingPassword
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testPostLoginInputValidateMissingPassword(){
		$credentials = array(
				'userId'=>'admin',
				'password'=>''
		);

		$response = $this->call('POST', 'login', $credentials);
		$this->assertRedirectedTo('/');
		$this->assertSessionHasErrors();
		$this->assertEquals( Lang::get('validation.required', array('attribute' => 'Password')), Session::get('errors')->getBag('default')->first('password') );
	}

	/**
	 **********************************************************************
	 * testPostCheckValidAccountFail
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testPostLoginCheckValidAccountFail(){
		$credentials = array(
				'userId'=>'admin',
				'password'=>'1234'
		);

		$this->mstLoginUser = Mockery::mock('MstLoginUser');
		$this->mstLoginUser->shouldReceive('checkValidAccount')->with('admin')->once()->andReturn(1);
		$this->app->instance('MstLoginUser', $this->mstLoginUser);
		$this->call('POST', 'login', $credentials);
		$this->assertRedirectedTo('/');
		$this->assertSessionHas('error_message');
		$this->assertEquals( Lang::get('errorMessages.account_invalid'), Session::get('error_message'));

	}

	/**
	 **********************************************************************
	 * testPostConfirmLoginAttemptFail
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testPostLoginConfirmLoginAttemptFail(){
		$credentials = array(
				'userId'=>'admin',
				'password'=>'1234'
		);

		$this->confirmLogin = Mockery::mock('ConfirmLogin');
		$this->confirmLogin->shouldReceive('confirmLoginAttempt')->with('admin')->once()->andReturn(1);
		$this->app->instance('ConfirmLogin', $this->confirmLogin);
		$this->call('POST', 'login', $credentials);
		$this->assertRedirectedTo('/');
		$this->assertSessionHas('error_message');
		$this->assertEquals( Lang::get('errorMessages.limit_attempt', array('minute' => '1')), Session::get('error_message'));
	}

	/**
	 **********************************************************************
	 * testPostAuthenticateAccountFail
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function  testPostLoginAuthenticateAccountFail(){
		$credentials = array(
				'userId'=>'admin',
				'password'=>'1234'
		);

		$this->confirmLogin = Mockery::mock('ConfirmLogin');
		$this->confirmLogin->shouldReceive('confirmLoginAttempt')->with('admin')->once()->andReturn(0);
		$this->confirmLogin->shouldReceive('authenticateAccount')->with('admin','1234')->once()->andReturn(0);
		$this->tblLoginHistory = Mockery::mock('TblLoginHistory');
		$this->tblLoginHistory->shouldReceive('writeLoginLog')->with('admin',0)->andReturn(true);
		$this->app->instance('ConfirmLogin', $this->confirmLogin);
		$this->app->instance('TblLoginHistory', $this->tblLoginHistory);
		$this->call('POST', 'login', $credentials);
		$this->assertRedirectedTo('/');
		$this->assertSessionHas('error_message');
		$this->assertEquals( Lang::get('errorMessages.authenticate_error'), Session::get('error_message'));
	}

	/**
	 **********************************************************************
	 * testPostLoginSuccess
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function  testPostLoginSuccess(){
		$credentials = array(
				'userId'=>'admin',
				'password'=>'1234'
		);

        $this->mstLoginUser = Mockery::mock('MstLoginUser');
        $this->mstLoginUser->shouldReceive('checkValidAccount')->with('admin')->once()->andReturn(0);
		$this->confirmLogin = Mockery::mock('ConfirmLogin');
		$this->confirmLogin->shouldReceive('confirmLoginAttempt')->with('admin')->once()->andReturn(0);
		$this->confirmLogin->shouldReceive('authenticateAccount')->with('admin','1234')->once()->andReturn(2);
		$this->tblLoginHistory = Mockery::mock('TblLoginHistory');
		$this->tblLoginHistory->shouldReceive('writeLoginLog')->with('admin',true)->andReturn(true);
        $this->app->instance('MstLoginUser', $this->mstLoginUser);
		$this->app->instance('ConfirmLogin', $this->confirmLogin);
		$this->app->instance('TblLoginHistory', $this->tblLoginHistory);
		$this->call('POST', 'login', $credentials);
		$this->assertRedirectedTo('/employee/list');
        $this->assertEquals(null, Session::get('error_message'));
	}
} 