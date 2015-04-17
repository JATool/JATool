<?php
 /**====================================================================
 * file name    ： EmployeesListControllerTest.php
 * author       ： @Rcv!Chau.Duc
 * version      ： 1.0.0
 * date created ： 2015/03/05
 * description  ： Test EmployeesListController.
 *
 =====================================================================*/

class EmployeesListControllerTest extends TestCase{

	/**
	 * @var MstPerson
	 */
	public $mstPerson;

	/**
	 **********************************************************************
	 * tearDown
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/03/05
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
	 * testGetEmployeeList
	 * <b>Description:</b><br>
	 *
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/03/05
	 * @throws
	 ***********************************************************************
	 */
	public function testGetEmployeeList(){
		//mock list return from DB
		$dbList = array("0" => array('person_id'=>'1','person_name' =>'Thai Son','object_id' => '0','object_name' => 'Summary','object_value' => 'fun','invalidFlag' => '0', 'listFlag' => '1'),
                        "1" =>  array('person_id'=>'1','person_name' =>'Thai Son','object_id' => '1','object_name' => 'Birthday','object_value' => '01/01/1111','invalidFlag' => '0', 'listFlag' => '1'),
                        "2" =>  array('person_id'=>'2','person_name' =>'Chau Duc','object_id' => '0','object_name' => 'Summary','object_value' => 'Funny','invalidFlag' => '0', 'listFlag' => '1'),
                        "3" =>  array('person_id'=>'2','person_name' =>'Chau Duc','object_id' => '1','object_name' => 'Birthday','object_value' => '1989/12/11','invalidFlag' => '0', 'listFlag' => '1'));
        //mock list header
        $headerList = array("0" => array('object_id' => '0', 'object_name' => 'Summary'),
                            "1" => array('object_id' => '1', 'object_name' => 'Birthday'),
                            "2" => array('object_id' => '2', 'object_name' => 'Age'));

		//mock list return to View
		$viewList = array("0" => array('person_id'=>'1','person_name' =>'Thai Son','object_name' => array('fun','01/01/1111'),'object_val' => array('fun','01/01/1111','')),
                            "1" => array('person_id'=>'2','person_name' =>'Chau Duc','object_name' => array('Funny','1989/12/11'),'object_val' => array('Funny','1989/12/11','')));

		$this->mstPerson = Mockery::mock('MstPerson');
		$this->mstPerson->shouldReceive('getEmployeeObjectValueList')->once()->andReturn($dbList);
        $this->mstPerson->shouldReceive('getEmployeeListHeader')->once()->andReturn($headerList);
		$this->app->instance('MstPerson', $this->mstPerson);
		$this->call('GET', 'employee/list');
		$this->assertViewHas('employeeList', $viewList);
	}


} 