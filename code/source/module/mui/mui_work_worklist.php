<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum_post.php 33848 2013-08-21 06:24:53Z hypowang $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('NOROBOT', TRUE);
$view = getgpc('view');
if(empty($view)) {

	$view = 'index';

}



if(!empty($_GET['workid'])) {


	$workid = $_GET['workid'];

	$wherearr[] = "workid = '$workid'";


	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
	$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." $wheresql");	
	$workinfo = DB::fetch($query);

	$workinfo['content'] = $workinfo['message'];
	echo json_encode($workinfo);
	EXIT;


} else {


	$daytimeline = 60 * 60 * 24;



	$dateline = getgpc('dateline');

	if(empty($dateline)) {
		$dateline = strtotime(date('Y-m-d 0:0:0')); 


	}

	//前1个月
	$lastmonth = $dateline - $daytimeline * 30;

	//前7天
	$yesterday7 = $dateline - $daytimeline * 7;

	$tomorrow3 = $dateline + $daytimeline * 3;

	if(empty($_GET['dateline'])) {

		$dateline = strtotime(date('Y-m-d 0:0:0')); 

		//$wherearr[] = "dateline > $yesterday7";
		$wherearr[] = "dateline > $lastmonth";
		$wherearr[] = "dateline < $tomorrow3";
	}




	//下周日

	$date=new DateTime();

	$date->modify('this week');

	//$Mondaytime = $date->format('2015-7-1 0:0:0');//本周第一天

	$Mondaytime = date("Y-m-d 0:0:0", getmonday($dateline));
	 
	//本周一
	$Monday = $date->format('m月d日');

	$Mondaydateline = strtotime($Mondaytime);
	$Monday = date("m月d日", $Mondaydateline); 

	//上周日
	$PreviousSundaydateline  = $Mondaydateline - $daytimeline * 1;
	$PreviousSunday = date("m月d日", $PreviousSundaydateline); 


	$perpage = '100';


	$page = empty($_GET['page'])?0:intval($_GET['page']);
	if($page<1) $page=1;
	$start = ($page-1)*$perpage;

	$LIMIT = 'LIMIT '.$start.','.$perpage.'';


	$editorid = $_GET['DiscuzUid'];

	//
	//$editorid = '1';
	//$_G['uid'] = '1';

	if($editorid != $_G['uid']) {
		settbcard_login_status($editorid);
	}

	$groupid = '24';
	$memberlist = get_user_wx_info_list_by_groupid($groupid);
	 


	if($_G['adminid'] == '1') {
		$wherearr[] = "1";
	} else {
		//$wherearr[] = "editorid = ".$editorid."";
		$wherearr[] = "editorid = '$editorid'";
	}


	$wherearr[] = "status IN(0,1)";

	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

	$myprojectlist = array();
	$worklist = array();
	$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." $wheresql ORDER BY status ASC, lastpostdateline DESC $LIMIT");	
	while ($value = DB::fetch($query)) {

		//$value['message'] = set_worklist_conver($value['message']);

		if(!empty($memberlist[$value['editorid']]['headimgurl'])) {

			//$value['avatar'] = $memberlist[$value['editorid']]['headimgurl'];	
			$value['avatar'] = avatar($value['editorid'], 'middle', true);
		} else {

			$value['avatar'] = avatar($value['editorid'], 'middle', true);
		}

		



		if($value['status'] == '1') {
			$worklist['status_style'] = 'worklist_title_status_style_1';
		} else {
			$worklist['status_style'] = 'worklist_title_status_style_0';
		}

		$worklist['id'] = $value['workid'];
		$worklist['post_id'] = $value['workid'];
		$worklist['title'] = cutstr($value['message'], 128);
		$worklist['author_name'] = $value['editor'];
		$worklist['cover'] = $value['avatar'];
		
		$worklist['published_at'] = preg_replace("/\&nbsp;/", "", dgmdate($value['dateline'], 'u'));
		
		$worklist['worktime'] = date("Y-m-d H:i:s", $value['dateline']);  

		if($value['favicon'] == '1') {

			$worklist['favicon'] = 'mui-badge mui-badge-danger';

		} else {

			$worklist['favicon'] = 'mui-badge mui-badge-success';
		}


		$myworklist[] = $worklist;
		$worklist = array();



		
		
	}

	echo json_encode($myworklist);
	EXIT;


}





?>