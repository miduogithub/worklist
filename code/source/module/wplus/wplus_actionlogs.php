<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum_post.php 33848 2013-08-21 06:24:53Z hypowang $
 */
//header("Content-Type:text/html;charset=GBK");
//echo '<meta http-equiv="Content-Type" content="text/html; charset=GBK">';

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('NOROBOT', TRUE);

if(empty($_G['uid'])) {

	if(!empty($_GET['uid'])) {
		$loginuid = $_GET['uid'];
		settbcard_login_status($loginuid);
	} else {
		dheader("Location: work.php?mod=login");
		//showmessage('to_login', '', array(), array('showmsg' => true, 'login' => 1));
	}

}


if($_G['adminid'] != '1' && $_G['groupid'] != '24') {
	showmessage("您无权是有该模块");
}

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
	$order = 'status,editorid,';
} else {
	$order = '';
}

$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
 

if(empty($count)) {
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_actionlogs')." $wheresql"), 0);
	//待办总数
	$count_status0 = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_actionlogs')." WHERE dateline >= '$thedatelinestart' AND dateline < '$thedatelineend' AND status='0'"), 0);
}

$query = DB::query("SELECT * FROM ".DB::table('work_actionlogs')." $wheresql ORDER BY $order dateline DESC");
while ($value = DB::fetch($query)) {

	$threadlist[] = $value; 
}


$navtitle = date('m月d日',$dateline).'星期'.$weekarray[$week];




//include template('diy:work/pc/work_loglist_newadmin');



include template('diy:work/pc/work_actionlogs_newadmin');




?>