<?php
/**====================================================================
* file name    ： TblObject.php
* author       ： @Rcv!Son.Tran
* version      ： 1.0.0
* date created ： 2015/03/02
* description  ： Correspond with tbl_object table.
*
=====================================================================*/

class TblObject extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_object';

    public function getAllObjects() {
        $col = array(
            'tbl_object.id'
        , 'tbl_object.category_id'
        , 'tbl_object.name'
        , 'tbl_object.object_type'
        , 'tbl_object.required_flg'
        , 'tbl_object.min_length'
        , 'tbl_object.max_length'
        , 'tbl_object.default_value'
        , 'tbl_object.multiple_flg'
        , 'tbl_object.list_display_flg'
        , 'tbl_object.invalid_flg'
        , 'tbl_object.description'
        );

        $objects = DB::table('tbl_object')
            ->orderBy('tbl_object.sort', 'ASC')
            ->get($col);

        return $objects;
    }

    /**
     **********************************************************************
     * getObjectsByCateId
     * @param $cateSelectedId
     * <b>Description: Get category's objects.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @return array|static[]
     * @throws
     ***********************************************************************
     */
    public function getObjectsByCateId($cateSelectedId) {
        $col = array(
            'tbl_object.id'
        , 'tbl_object.name'
        , 'tbl_object.object_type'
        , 'tbl_object.required_flg'
        , 'tbl_object.min_length'
        , 'tbl_object.max_length'
        , 'tbl_object.default_value'
        , 'tbl_object.multiple_flg'
        , 'tbl_object.list_display_flg'
        , 'tbl_object.invalid_flg'
        , 'tbl_object.description'
        );

        $objects = DB::table('tbl_object')
            ->where('category_id', '=', $cateSelectedId)
            ->orderBy('tbl_object.sort', 'ASC')
            ->get($col);

        return $objects;
    }

    /**
     **********************************************************************
     * getObjValByCateIdEmpId
     * @param $cateSelectedId
     * @param $empId
     * <b>Description: Get object's value by cateogory id and employee id.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @return array|static[]
     * @throws
     ***********************************************************************
     */
    public function getObjValByCateIdEmpId($cateSelectedId, $empId) {
        $col = array(
            'tbl_object.id'
        , 'tbl_object_values.value'
        );

        $objValues = DB::table('tbl_object')
            ->where('category_id', '=', $cateSelectedId)
            ->join('tbl_object_values', function ($join) use ($empId) {
                $join->on('tbl_object.id', '=', 'tbl_object_values.object_id')
                    ->where('tbl_object_values.person_id', '=', $empId);
            })
            ->orderBy('tbl_object.sort', 'ASC')
            ->get($col);

        return $objValues;
    }

    /**
     **********************************************************************
     * getObjValByEmpId
     * @param $empId
     * <b>Description: Get all object's values by employee id.</b><br>
     *
     * @author      @Rcv!Son.Tran
     * @return array|static[]
     * @throws
     ***********************************************************************
     */
    public function getObjValByEmpId($empId) {
        $col = array(
            'tbl_object.id'
        , 'tbl_object_values.value'
        );

        $objValues = DB::table('tbl_object')
            ->join('tbl_object_values', function ($join) use ($empId) {
                $join->on('tbl_object.id', '=', 'tbl_object_values.object_id')
                    ->where('tbl_object_values.person_id', '=', $empId);
            })
            ->orderBy('tbl_object.sort', 'ASC')
            ->get($col);

        return $objValues;
    }
}