<?php
 /**====================================================================
 * file name    ： TblLoginHistoryTest.php
 * author       ： @Rcv!Chau.Duc
 * version      ： 1.0.0
 * date created ： 2015/02/10
 * description  ： PHPUnit test for TblLoginHistory.php
 *
 =====================================================================*/

class TblLoginHistoryTest extends TestCase {

	protected $tblLoginHistory;
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
	 * testWriteLoginLog
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testWriteLoginLog(){
		DB::shouldReceive('table->insertGetId')->andReturn(true);
		$this->tblLoginHistory = new TblLoginHistory();
		$this->assertEquals($this->tblLoginHistory->writeLoginLog("duc",1),true);
	}

	/**
	 **********************************************************************
	 * testConfirmLoginAttemptAccept
	 * <b>Description:</b><br>
	 * ConfirmLoginAttempt is accepted
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testConfirmLoginAttemptAccept(){
		$user =  array("0" =>  array('id'=>'1','user_id' =>'duc','login_time' => '2015-02-11 15:53:58','attempts' => '1'));
		$mockTblLoginHistory = Mockery::mock('TblLoginHistory');
		$mockTblLoginHistory->shouldReceive('getLoginTimes')->with('duc')->once()->andReturn($user);
		$mockMstLoginUser = Mockery::mock('Eloquent', 'MstLoginUser');
		$confirmLogin = new ConfirmLogin($mockTblLoginHistory,$mockMstLoginUser);
		$this->assertEquals($confirmLogin->confirmLoginAttempt("duc"),0);
	}

	/**
	 **********************************************************************
	 * testConfirmLoginAttemptDeny
	 * <b>Description:</b><br>
	 * ConfirmLoginAttempt is denied
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testConfirmLoginAttemptDeny(){
		$user =  array("0" => array('id'=>'1','user_id' =>'duc','login_time' => '2015-02-11 15:53:58','attempts' => '2','current'=>'2015-02-11 15:54:58'));
		$mockTblLoginHistory = Mockery::mock('TblLoginHistory');
		$mockTblLoginHistory->shouldReceive('getLoginTimes')->with('duc')->once()->andReturn($user);
		$mockMstLoginUser = Mockery::mock('Eloquent', 'MstLoginUser');
		$confirmLogin = new ConfirmLogin($mockTblLoginHistory,$mockMstLoginUser);
		$this->assertEquals(14,$confirmLogin->confirmLoginAttempt("duc"));
	}

	/**
	 **********************************************************************
	 * testGetLoginTimes
	 * <b>Description:</b><br>
	 * Test Get login times in predefine minutes.
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @throws
	 ***********************************************************************
	 */
	public function testGetLoginTimes(){
		$user = array("0" =>array('id'=>'1','user_id' =>'duc','login_time' => '2/10/2015 6:16:54 PM','attempts' => '1'));
		DB::shouldReceive('raw');
		DB::shouldReceive('table->select->where->whereRaw->orderBy->take->get')->once()->andReturn($user);
		$this->tblLoginHistory = new TblLoginHistory();
		$rs = $this->tblLoginHistory->getLoginTimes("duc");
		$this->assertEquals(1,count($rs));
	}

}
 