<?php
/**====================================================================
* file name    ： EmployeeDetailControllerTest.php
* author       ： @Rcv!Son.Tran
* version      ： 1.0.0
* date created ： 2015/03/02
* description  ： Test file for employee detail screen.
*
=====================================================================*/

class EmployeeDetailControllerTest extends TestCase {
    /**
     **********************************************************************
     * tearDown
     * <b>Description: </b><br>
     *
     * @author      @Rcv!Son.Tran
     * @throws
     ***********************************************************************
     */
    public function tearDown(){
        parent::SetUp();

        Session::start();

        // Enable filters
        Route::enableFilters();
    }

    
}
