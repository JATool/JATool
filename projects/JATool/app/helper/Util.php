<?php
	/**
	 **********************************************************************
	 * urlResource
	 * @param $param
	 * <b>Description:</b><br>
	 * Get URL Server Resource
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @return string
	 * @throws
	 ***********************************************************************
	 */
	function urlResource($param){
		return domain_ja_tool.'/'.$param;
	}

	/**
	 **********************************************************************
	 * isEmpty
	 * @param $param
	 * <b>Description:</b><br>
	 * Check empty string.
	 * @author      @Rcv!Chau.Duc
	 * @date        2015/02/10
	 * @return bool
	 * @throws
	 ***********************************************************************
	 */
	function isEmpty($param){
		if($param === null || $param === '' || !isset($param)){
			return true;
		}
		return false;
	}
