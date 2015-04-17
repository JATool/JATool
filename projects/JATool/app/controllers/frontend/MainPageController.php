<?php
 /**====================================================================
 * file name    ： MainPageController.php
 * author       ： @Rcv!Chau.Duc
 * @ticket
 * version      ： 1.0.0
 * date created ： 2015/04/15
 * description  ： sample.
 *
 =====================================================================*/
class MainPageController extends BaseController{

    /**
     **********************************************************************
     * indexFontEnd
     * <b>Description:</b><br>
     *
     * @author      @Rcv!Chau.Duc
     * @ticket
     * @date        2015/04/15
     * @return \Illuminate\View\View
     * @exception
     ***********************************************************************
     */
    public function indexFontEnd(){
        return View::make('layouts.frontend.page.index');
    }
}