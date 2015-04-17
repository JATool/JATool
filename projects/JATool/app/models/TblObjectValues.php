<?php
/**====================================================================
* file name    ： TblObjectValues.php
* author       ： @Rcv!Son.Tran
* version      ： 1.0.0
* date created ： 2015/03/02
* description  ： Correspond with tbl_object_values table.
*
=====================================================================*/

class TblObjectValues extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_object_values';

    private $tblChangeLog;

    private $tblChangeLogDetails;

    public function __construct()
    {


    }

    /**
     **********************************************************************
     * updateValuesByObjIdEmpId
     * @param $obj
     * @param $empId
     * <b>Description: Update object's values by object id and employee id.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @throws
     ***********************************************************************
     */
    public function updateValuesByObjAndEmpId($obj, $empId) {
        /*
         * Explode name of component to get object's id. (objId_objType_reFlag_min_max)
         */
        $validateArgs = explode('_', $obj['name']);

        DB::transaction(function () use ($validateArgs, $obj, $empId) {
            $oldObjValue = DB::table('tbl_object_values')->where('object_id', $validateArgs[0])
                ->where('person_id', $empId)->first(['value']);

            if (is_null($oldObjValue)) {
                /*
                 * Insert new object's value if not exist and write logs.
                 */
                DB::table('tbl_object_values')->insert(array(
                    'person_id' => $empId,
                    'object_id' => $validateArgs[0],
                    'value' => $obj['value'],
                    'create_on' => DB::raw('NOW()'),
                    'create_by' => Auth::user()->id,
                    'update_on' => DB::raw('NOW()'),
                    'update_by' => Auth::user()->id
                ));

                $changeLogId = $this->tblChangeLog->insertReturnId($empId);

                $this->tblChangeLogDetails->writeTblLogDetail(
                    $changeLogId,
                    $validateArgs[0],
                    null,
                    $obj['value']
                );
            } elseif ($oldObjValue['value'] != $obj['value']) {
                /*
                 * Update employee info and write logs.
                 */
                DB::table('tbl_object_values')->where('person_id', $empId)
                    ->where('object_id', $validateArgs[0])
                    ->update(array(
                        'value' => $obj['value'],
                        'update_on' => DB::raw('NOW()'),
                        'update_by' => Auth::user()->id
                    ));

                $changeLogId = $this->tblChangeLog->insertReturnId($empId);

                $this->tblChangeLogDetails->writeTblLogDetail(
                    $changeLogId,
                    $validateArgs[0],
                    $oldObjValue['value'],
                    $obj['value']
                );
            }
        });
    }

    /**
     **********************************************************************
     * createValuesByObjAndEmpId
     * @param $obj
     * @param $empId
     * <b>Description: Create object's values by object data and employee id.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @throws
     ***********************************************************************
     */
    public function createValuesByObjAndEmpId($obj, $empId) {
        /*
         * Explode name of component to get object's id. (objId_objType_reFlag_min_max)
         */
        $validateArgs = explode('_', $obj['name']);

        /*
         * Insert new employee info and write logs.
         */
        DB::transaction(function () use ($validateArgs, $obj, $empId) {
            DB::table('tbl_object_values')->insert(array(
                'person_id' => $empId,
                'object_id' => $validateArgs[0],
                'value' => $obj['value'],
                'create_on' => DB::raw('NOW()'),
                'create_by' => Auth::user()->id,
                'update_on' => DB::raw('NOW()'),
                'update_by' => Auth::user()->id
            ));

            $changeLogId = $this->tblChangeLog->insertReturnId($empId);

            $this->tblChangeLogDetails->writeTblLogDetail(
                $changeLogId,
                $validateArgs[0],
                null,
                $obj['value']
            );
        });
    }
}