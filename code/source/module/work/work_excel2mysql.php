<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: home_follow.php 33660 2013-07-29 07:51:05Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(empty($_G['uid'])) {
	dheader("Location: work.php?mod=login");
}

if($_G['adminid'] != '1' && $_G['groupid'] != '24') {
	showmessage("您无权是有该模块");
}




$view = getgpc('view');
$vieworder = getgpc('vieworder');

if($view == 'debuglsit') {



	if(!empty($projectid)) {
		$wherearr[] = "projectid = $projectid";
	}

	
	
	if($vieworder == '') {
		//
	}

	if($_GET['check'] != 'incomplete') {
		//$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";
		$wherearr[] = '1';
		$order = 'resultstid';
	} else {
		$wherearr[] = '1';
		$order = '';
	}

	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

	if(empty($count)) {
		$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_testresults_2017jinshengzhongxiaoxue')." $wheresql"), 0);
		$count = $count - 1;
	}

	$debugstatus1count = '-1';
	$query = DB::query("SELECT * FROM ".DB::table('work_testresults_2017jinshengzhongxiaoxue')." $wheresql ORDER BY $order ASC LIMIT 10000");
	while ($value = DB::fetch($query)) {
	

		$threadlist[] = $value; 

		
	}
	

	include template('diy:work/pc/work_guangfu_debuglist_newadmin');

} else {

	include template('diy:work/pc/work_excel2mysql_form_newadmin');
}



?>