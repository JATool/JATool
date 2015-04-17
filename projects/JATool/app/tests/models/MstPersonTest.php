<?php
/**====================================================================
* file name    ： MstPersonTest.php
* author       ： @Rcv!Son.Tran
* version      ： 1.0.0
* date created ： 2015/03/09
* description  ： Automation test for MstPerson class.
*
=====================================================================*/

class MstPersonTest extends TestCase {
    /**
     **********************************************************************
     * tearDown
     * <b>Description: Run each test case.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @throws
     ***********************************************************************
     */
    public function tearDown(){
        parent::SetUp();
    }

    public function testGetAllPerson() {
        $mockCache = Mockery::mock('Cache');
        $mockCache->shouldReceive('has')->once()->andReturn();
    }
}
