<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_userapp.php 25756 2011-11-22 02:47:45Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function get_this_checkaction($uid) {
	
	global $_G;

	$thischeckinfoarr = array();

	//获取当前用户check记录
	$query = DB::query("SELECT * FROM ".DB::table('work_wx_checkin_logs')." WHERE editorid='$uid' ORDER BY dateline DESC LIMIT 1");
	while ($value = DB::fetch($query)) {
		$lastchecklog = $value;
		$lastcheckdateline = $value['dateline'];
	}

	$thischeckinfoarr['lastcheckdateline'] = $lastcheckdateline;//上一次签到时间

	$differencedateline = $_G['timestamp'] - $lastcheckdateline;//计算本次和上一次签到时间差

	if(empty($lastchecklog)) {//第一次签到

		$thischeckinfoarr['thischeckaction'] = '签到';
		$thischeckinfoarr['thischeckaction_value'] = '0';

	} elseif($lastchecklog['checkaction'] == '0') {//最后一条记录为0 则下一条为 1

			$thischeckinfoarr['thischeckaction'] = '签退';
			$thischeckinfoarr['thischeckaction_value'] = '1';


			if($differencedateline < 60 * 60 * 0.1) {
				$thischeckinfoarr['lastcheckstatus'] = '1';
			} 

	} elseif($lastchecklog['checkaction'] == '1') {//

			$thischeckinfoarr['thischeckaction'] = '签到';
			$thischeckinfoarr['thischeckaction_value'] = '0';

			if($differencedateline < 60 * 60 * 0.1) {
				$thischeckinfoarr['lastcheckstatus'] = '1';
			}elseif($differencedateline < 60 * 60 * 7) {
				$thischeckinfoarr['lastcheckstatus'] = '3';
			}
	}

	
	return $thischeckinfoarr;
}

?>