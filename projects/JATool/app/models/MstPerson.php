<?php

/**====================================================================
 * file name    ： MstPerson.php
 * author       ： @Rcv!Son.Tran
 * version      ： 1.0.0
 * date created ： 2015/03/02
 * description  ： Correspond with mst_person table.
 *
 * =====================================================================*/
class MstPerson
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mst_person';

    private $tblChangeLog;

    private $tblChangeLogDetails;

    public function __construct()
    {

    }

    public function __contruct() {}

    /**
     **********************************************************************
     * getAllPerson
     * @param bool $useCache
     * <b>Description: Get all person.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @return array|mixed|static[]
     * @throws
     ***********************************************************************
     */
    public function getAllPerson($useCache = false) {
        if ($useCache && Cache::has(ALL_PERSON)) {
            return Cache::get(ALL_PERSON);
        }

        $personLst = DB::table('mst_person')->get();
        if ($useCache && $personLst) {
            Cache::add(ALL_PERSON, $personLst, CACHE_TIME);
        }
        return $personLst;
    }

    /**
     **********************************************************************
     * getPerson
     * @param $empId
     * <b>Description: Get person record by employee id.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @return \Illuminate\Support\Collection|mixed|null|static
     * @throws
     ***********************************************************************
     */
    public function getPerson($empId, $useCache = false)
    {
        $key = sprintf(PERSON, $empId);
        if ($useCache && Cache::has($key)) {
            return Cache::get($key);
        }

        $person = DB::table('mst_person')->where('id', $empId)->first();
        if ($useCache && $person) {
            Cache::add($key, $person, CACHE_TIME);
        }
        return $person;
    }

    /**
     **********************************************************************
     * updatePerson
     * @param $empId
     * @param $mst_person
     * <b>Description: Update person info by employee id.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @throws
     ***********************************************************************
     */
    public function updatePerson($empId, $mst_person) {
        $oldPersonName = DB::table('mst_person')->where('id', $empId)->first(['name']);

        if ($oldPersonName['name'] != $mst_person['value']) {
            DB::transaction(function () use ($empId, $mst_person, $oldPersonName) {
                DB::table('mst_person')->where('id', $empId)
                    ->update(array(
                        $mst_person['column'] => $mst_person['value'],
                        'update_on' => DB::raw('NOW()'),
                        'update_by' => Auth::user()->id
                    ));

                $changeLogId = $this->tblChangeLog->insertReturnId($empId);

                $this->tblChangeLogDetails->writeMstLogDetail(
                    $changeLogId,
                    $mst_person['column'],
                    $oldPersonName['name'],
                    $mst_person['value']
                );
            });

            /*
             * Forget cache whe update person info.
             */
            $cachePersonKey = sprintf(PERSON, $empId);
            if (Cache::has($cachePersonKey)) {
                Cache::forget($cachePersonKey);
            }
        }
    }

    /**
     **********************************************************************
     * createPerson
     * @param $mst_person
     * <b>Description: Add new employee person.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @return null
     * @throws
     ***********************************************************************
     */
    public function createPerson($mst_person) {
        $empId = null;
        DB::transaction(function () use ($mst_person, &$empId) {
            $empId = DB::table('mst_person')->insertGetId(array(
                $mst_person['column'] => $mst_person['value'],
                'create_on' => DB::raw('NOW()'),
                'create_by' => Auth::user()->id,
                'update_on' => DB::raw('NOW()'),
                'update_by' => Auth::user()->id
            ));

            $changeLogId = $this->tblChangeLog->insertReturnId($empId);

            $this->tblChangeLogDetails->writeMstLogDetail(
                $changeLogId,
                $mst_person['column'],
                null,
                $mst_person['value']
            );
        });

        return $empId;
    }

    /**
     **********************************************************************
     * getEmployeeObjectValueList
     * @param bool $useCache
     * <b>Description:</b><br>
     *
     * @author      @Rcv!Chau.Duc
     * @date        2015/03/05
     * @return mixed
     * @throws
     ***********************************************************************
     */
    public function getEmployeeObjectValueList($useCache = false)
    {
        $dbList = array();
        if ($useCache && Cache::has(EMPLOYEE_LIST_DATA)) {
            return Cache::get(EMPLOYEE_LIST_DATA);
        }

        $listEmployeeData = DB::table('mst_person')
                            ->leftJoin('tbl_object_values', 'mst_person.id', '=', 'tbl_object_values.person_id')
                            ->leftJoin('tbl_object', 'tbl_object.id', '=', 'tbl_object_values.object_id')
                            ->orderBy('mst_person.id', 'asc')
                            ->orderBy('tbl_object.sort', 'asc')
                            ->select('mst_person.id as person_id', 'mst_person.name as person_name', 'tbl_object.id as object_id', 'tbl_object.name as object_name', 'tbl_object_values.value as object_value', 'tbl_object.invalid_flg as invalidFlag', 'tbl_object.list_display_flg as listFlag')
                            ->get();
        for ($i = 0; $i < count($listEmployeeData); $i++) {
            if ($listEmployeeData[$i]['invalidFlag'] !== 1 && $listEmployeeData[$i]['listFlag'] !== 0) {
                $dbList[] = $listEmployeeData[$i];
            }
        }
        if ($useCache && $dbList) {
            Cache::add(EMPLOYEE_LIST_DATA, $dbList, CACHE_TIME);
        }
        return $dbList;
    }

    public function getEmployeeListHeader($useCache = false){
        if ($useCache && Cache::has(EMPLOYEE_LIST_HEADER)) {
            return Cache::get(EMPLOYEE_LIST_HEADER);
        }

        $listEmployeeHeader = DB::table('tbl_object')
                                    ->orderBy('tbl_object.sort', 'asc')
                                    ->where('tbl_object.invalid_flg', '=', '0')
                                    ->where('tbl_object.list_display_flg', '=', '1')
                                    ->select('tbl_object.id as object_id', 'tbl_object.name as object_name')
                                    ->get();
        if ($useCache && $listEmployeeHeader) {
            Cache::add(EMPLOYEE_LIST_HEADER, $listEmployeeHeader, CACHE_TIME);
        }
        return $listEmployeeHeader;
    }

    /**
     * @param TblChangeLog $tblChangeLog
     */
    public function setTblChangeLog($tblChangeLog)
    {
        $this->tblChangeLog = $tblChangeLog;
    }

    /**
     * @param TblChangeLogDetails $tblChangeLogDetails
     */
    public function setTblChangeLogDetails($tblChangeLogDetails)
    {
        $this->tblChangeLogDetails = $tblChangeLogDetails;
    }

}