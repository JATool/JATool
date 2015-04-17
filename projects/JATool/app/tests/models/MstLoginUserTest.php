<?php
 /**====================================================================
 * file name    ： MstLoginUserTest.php
 * author       ： @Rcv!Chau.Duc
 * version      ： 1.0.0
 * date created ： 2015/02/11
 * description  ： sample.
 *
 =====================================================================*/
	class MstLoginUserTest extends TestCase {

		protected $mstLoginUser;
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
		 * testCheckValidAccount
		 * <b>Description:</b><br>
		 *
		 * @author      @Rcv!Chau.Duc
		 * @date        2015/02/10
		 * @throws
		 ***********************************************************************
		 */
		public function testCheckValidAccountSuccess(){
			DB::shouldReceive('table->select->where->get')->once()->andReturn(true);
			$this->mstLoginUser = new MstLoginUser();
			$this->assertEquals(true,$this->mstLoginUser->checkValidAccount("duc"));
		}

	}