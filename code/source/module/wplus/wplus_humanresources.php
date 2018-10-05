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

if($_G['adminid'] != '1' && $_G['groupid'] != '24') {
	showmessage("您无权是有该模块");
}


//获取员工列表
$memberlist = get_memberlist_by_groupid('24');

$editorid = $_GET['editorid'];


$daytimeline = 60 * 60 * 24;



$dateline = getgpc('dateline');

if(empty($dateline)) {
	$dateline = strtotime(date('Y-m-d 0:0:0')); 
}

$thedaytime = date("Y-m-d 0:0:0", $dateline); 
$thedaytimeurl = date("m月d日", $dateline); 


$date=new DateTime();

$date->modify('this week');

//$Mondaytime = $date->format('2015-7-1 0:0:0');//本周第一天

$Mondaytime = date("Y-m-d 0:0:0", getmonday($dateline));
 




//星期一
$Monday = $date->format('m月d日');


$Mondaydateline = strtotime($Mondaytime);
$Monday = date("m月d日", $Mondaydateline); 



//上周日
$PreviousSundaydateline  = $Mondaydateline - $daytimeline * 1;
$PreviousSunday = date("m月d日", $PreviousSundaydateline); 

//星期二
$Tuesdaydateline = $Mondaydateline + $daytimeline * 1;
$Tuesday = date("m月d日", $Tuesdaydateline); 

//星期三
$Wednesdaydateline = $Mondaydateline + $daytimeline * 2;
$Wednesday = date("m月d日", $Wednesdaydateline); 

//星期四
$Thursdaydateline  = $Mondaydateline + $daytimeline * 3;
$Thursday = date("m月d日", $Thursdaydateline); 

//星期五
$Fridaydateline  = $Mondaydateline + $daytimeline * 4;
$Friday = date("m月d日", $Fridaydateline); 

//星期六
$Saturdaydateline  = $Mondaydateline + $daytimeline * 5;
$Saturday = date("m月d日", $Saturdaydateline); 

//星期七
$Sundaydateline  = $Mondaydateline + $daytimeline * 6;
$Sunday = date("m月d日", $Sundaydateline); 

//下周一
$nextMondaydateline  = $Mondaydateline + $daytimeline * 7;
$nextMonday = date("m月d日", $nextMondaydateline); 

/*
 
 
 

 
 
  
*/










$view = getgpc('view');

if($view == 'checklog') {








	//今天
	$todaydateline = strtotime(date('Y-m-d 0:0:0'));

	//本月第一天
	$thismonthfirstdaytime = date('Y-m-01 00:00:00', strtotime(date("Y-m-d")));
	$thedatelinestart = $thismonthfirstdaytimedateline = strtotime($thismonthfirstdaytime);



	//本月最后一天
	$thismonthlastdaytime = date('Y-m-d 23:59:59', strtotime("$thismonthfirstdaytime +1 month -1 day"));
	$thedatelineend = $thismonthlastdaytimedateline = strtotime($thismonthlastdaytime);


	//上1个月第一天
	$lastmonthfirstdaytime = date('Y-m-01 00:00:00', strtotime('-1 month'));
	$lastmonthfirstdaytimedateline = strtotime($lastmonthfirstdaytime);

	//上1个月最后一天
	$lastmonthlastdaytime = date('Y-m-t 23:59:59', strtotime('-1 month'));
	$lastmonthlastdaytimedateline =  strtotime($lastmonthlastdaytime);


	$checkmonthdateline = getgpc('checkmonth');
	if(empty($checkmonthdateline)) {
		$checkmonthdateline = strtotime(date('Y-m', $thedatelinestart));
	}
	$checkmontime = date('Y-m',$checkmonthdateline);


	//获取当前月查询列表
	$monthsarr = get_checkmonth_list_by_thismonthfirstdaytimedateline($checkmontime);

	$check_year = date('Y',$checkmonthdateline);
	$check_month = date('m',$checkmonthdateline);
	$check_day = '15';

	//要查询月的第一天
	$check_thismonthfirstdaytime = date('Y-m-01 00:00:00', strtotime(date("$check_year-$check_month-$check_day")));
	$thedatelinestart = $check_thismonthfirstdaytimedateline = strtotime($check_thismonthfirstdaytime);

	//要查询月的最后一天
	$check_thismonthlastdaytime = date('Y-m-d 23:59:59', strtotime("$check_thismonthfirstdaytime +1 month -1 day"));
	$thedatelineend = $check_thismonthlastdaytimedateline = strtotime($check_thismonthlastdaytime);



	//上个月最后一天


	//下一天
	$next1daydateline = $todaydateline + 86400;

	//$thedatelinestart = $dateline;
	//$thedatelineend = $thedatelinestart + 86400 * 365;

	$thedaynextdaydateline = $thedatelinestart + 86400;
	$thedayyesterdaydateline =  $thedatelinestart - 86400;

	if($_G['adminid'] != '1') {
		//$wherearr[] = "editorid = ".$_G['uid']."";
	}

	if(!empty($editorid)) {
		$wherearr[] = "editorid = ".$editorid."";
	}elseif($_G['adminid'] != '1') {
		$wherearr[] = "editorid = ".$_G['uid']."";
	}

	if($_GET['check'] != 'incomplete') {
		$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";
		$order = 'status,editorid,';
	} else {
		$order = '';
	}

	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';



	if(empty($count)) {
		$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_wx_checkin_logs')." $wheresql"), 0);
	}

	$query = DB::query("SELECT * FROM ".DB::table('work_wx_checkin_logs')." $wheresql ORDER BY $order dateline DESC");
	while ($value = DB::fetch($query)) {
		$threadlist[] = $value; 
	}

	include template('diy:work/pc/work_HumanResources_checklog_newadmin');
	exit;

} elseif($view == 'tmplmsglogs') {




$todaydateline = strtotime(date('Y-m-d 0:0:0'));
$next1daydateline = $todaydateline + 86400;

$thedatelinestart = $dateline;
$thedatelineend = $thedatelinestart + 86400;

$thedaynextdaydateline = $thedatelinestart + 86400;
$thedayyesterdaydateline =  $thedatelinestart - 86400;

if($_G['adminid'] != '1') {
	//$wherearr[] = "editorid = ".$_G['uid']."";
}

if(!empty($editorid)) {
	$wherearr[] = "editorid = ".$editorid."";
}elseif($_G['adminid'] != '1') {
	$wherearr[] = "editorid = ".$_G['uid']."";
}

if($_GET['check'] != 'incomplete') {
	$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";
	$order = '';
} else {
	$order = '';
}

$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';


	if(empty($count)) {
		$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_wx_tmplmsg_logs')." $wheresql"), 0);
	}

	$query = DB::query("SELECT * FROM ".DB::table('work_wx_tmplmsg_logs')." $wheresql ORDER BY $order dateline DESC");
	while ($value = DB::fetch($query)) {
		$threadlist[] = $value; 
	}

	include template('diy:work/pc/work_HumanResources_tmplmsglog_newadmin');
	exit;
}













if($_G['adminid'] != '1') {
	$wherearr[] = "editorid = ".$_G['uid']."";
}

$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";

$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

if(empty($count)) {
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_loglist')." $wheresql"), 0);
}

$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." $wheresql ORDER BY $order username,dateline DESC LIMIT 100");
while ($value = DB::fetch($query)) {
	$threadlist[] = $value; 
}






if(checkMobile() == true && $_G['cookie']['mobile'] != 'no') {//$_G['cookie']['mobile'] 手机切换电脑版会种入cookie 所以增加判断条件

	include template('diy:work/mobile/work_loglist');

} else{
	include template('diy:work/pc/work_loglist');

	

}



?>