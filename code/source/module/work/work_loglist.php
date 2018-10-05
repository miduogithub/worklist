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