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

$editorid = $_GET['editorid'];

$daytimeline = 60 * 60 * 24;

$dateline = getgpc('dateline');

//
//$dateline = strtotime(date("Y-m-d 0:0:0",$dateline)); 

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









if(!empty($editorid)) {
	$wherearr[] = "editorid = ".$editorid."";
}elseif($_G['adminid'] != '1') {
	$wherearr[] = "editorid = ".$_G['uid']."";
}

if($_GET['check'] != 'incomplete') {
	$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";
	$order = 'status,editorid,';
} else {
	$wherearr[] = "1";
	$order = '';
}





//$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";

$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

if(empty($count)) {

	//当前店铺上传商品
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_shop_goodslog')." $wheresql"), 0);

	//当前店铺上传商品合格数
	$status1count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_shop_goodslog')." $wheresql AND status = '1'"), 0);

	//当前店铺总上传商品
	$goodslogcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_shop_goodslog')." WHERE 1"), 0);

	//当前店铺总上传商品总合格数
	$goodslogstatus1count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_shop_goodslog')." WHERE status = '1'"), 0);

	//商品库总商品数
	$goodslibrarycount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_shop_goodslibrary')." WHERE 1"), 0);
}

$query = DB::query("SELECT * FROM ".DB::table('work_shop_goodslog')." $wheresql ORDER BY editor,dateline ASC LIMIT 1000");
while ($value = DB::fetch($query)) {
	$threadlist[] = $value; 
}



include template('diy:work/pc/work_shoplist_newadmin');






function getgoodsinfo_admin_by_goodscode($goodscode) {

	$goodsurl_adminquery = DB::query("SELECT * FROM ".DB::table('work_shop_goodslog_admin')." WHERE goodscode='$goodscode'");
	$goodsinfo_admin = DB::fetch($goodsurl_adminquery);

	return $goodsinfo_admin;
}
?>