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
if(empty($_G['uid'])) {

	if(!empty($_GET['uid'])) {
		$loginuid = $_GET['uid'];
		settbcard_login_status($loginuid);
		if($_G['adminid'] == '1') {
			dheader("Location: work.php?mod=index_qk");
		} else {
			dheader("Location: work.php?mod=index");
		}
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


//前15天
$after15dateline  = $Mondaydateline - $daytimeline * 15;
$after15day = date("m月d日", $PreviousSundaydateline); 

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
	//$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";

	//前15天时间

	//按时间获取
	//$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";

	$wherearr[] = "dateline >= '$after15dateline' ";


	$order = 'status,editorid,';
} else {
	$order = '';
}

$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

if(empty($count)) {
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_loglist')." $wheresql"), 0);
	//待办总数
	$count_status0 = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_loglist')." WHERE dateline >= '$thedatelinestart' AND dateline < '$thedatelineend' AND status='0'"), 0);
}

$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." $wheresql ORDER BY $order dateline DESC LIMIT 800");
while ($value = DB::fetch($query)) {
	$threadlist[] = $value; 
}






$navtitle = date('m月d日',$dateline).'星期'.$weekarray[$week];

$membermissioninfo = array();
//获取员工用户组的的uidlist	(groupid:24)

$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE groupid = '24' OR groupid = '1'");
while($value_users = DB::fetch($query)) {
	

//签到记录 start

		$checkin_logsquery = DB::query("SELECT * FROM ".DB::table('work_wx_checkin_logs')." WHERE editorid='$value_users[uid]' ORDER BY dateline DESC LIMIT 1");
		while ($checkin_logs_value = DB::fetch($checkin_logsquery)) {
				
				
				if($checkin_logs_value['checktype'] == '1') {

					$checklogtype = '外出';
				} else {
					$checklogtype = '公司';
				}

				if($checkin_logs_value['checkaction'] == '1') {

					$checklogaction = '签退';
				} else {
					$checklogaction = '签到';
				}

				if(!empty($checkin_logs_value['message'])) {

					$checklogmessage = ",".$checkin_logs_value['message'];

				} else {
					$checklogmessage = '.';
				}


				$checkin_logs_value['checkinmessage'] = date("m月d日 H:i", $checkin_logs_value['dateline']).'完成'.$checklogtype.$checklogaction.$checklogmessage; 
				



				$member_wx_checkin_logs_last = $checkin_logs_value; 

				unset($checkin_logs_value);
				unset($checklogmessage);
				unset($checklogaction);
				unset($checklogtype);
				unset($checkinmessage);

		}

		if(!empty($member_wx_checkin_logs_last)) {
			$value_users['wx_checkin_logs_last']  = $member_wx_checkin_logs_last;
		} else {
			$value_users['wx_checkin_logs_last']['checkinmessage']  = '未签到';
		}
		
		unset($member_wx_checkin_logs_last);

		$wxuserinfo = get_wx_userinfo_by_uid($value_users['uid']);
		
		if(!empty($wxuserinfo['headimgurl'])) {
			$value_users['avatar']  = $wxuserinfo['headimgurl'];
		} else {
			$value_users['avatar']  = avatar($value_users['uid'], 'middle', true);
		}

//签到记录 end










		$membermissioninfo[$value_users['uid']]['userinfo'] = $value_users; 
		$missionquery = DB::query("SELECT m.*,p.favicon FROM ".DB::table('work_project_mission')." m LEFT JOIN ".DB::table('work_project')." p ON m.projectid = p.projectid WHERE m.editorid='$value_users[uid]' AND m.status='0' ORDER BY p.favicon DESC,m.missionstarttimeline DESC");
		while ($missionvalue = DB::fetch($missionquery)) {
			$membermissioninfo[$value_users['uid']]['missionlist'][] = $missionvalue; 
			
		}
		$membermissioninfo[$value_users['uid']]['missionstatus1count'] = count($membermissioninfo[$value_users['uid']]['missionlist']);
		
		$users[] = $value_users['uid'];

		$member_checklist[] = $value_users;
}





$members = C::t('common_member')->fetch_all($users);


foreach($threadlist as $workmessage) {

	foreach($members as $uid => $uidinfo) {

		if($workmessage['editorid'] == $uid) {
			$workuidlist[$uid]['userinfo'] = $uidinfo;
			$workuidlist[$uid]['worklist'][] = $workmessage;
			
		}

	}
}












//项目收入


		//获取客户列表
		$organizationlist = get_organizationlist();
		//获取项目类型
		$typelist = get_typelist();
		//获取员工列表
		//$memberlist = get_memberlist_by_groupid('24');

	
		$projectcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$_G[uid]'"), 0);
		$projectstatus9count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$_G[uid]' AND p.status='9'"), 0);
		$membercount = count($memberlist);

	//$incomecount = 
	$Projectprice = '0';
	$Projectpricestatus9 = '0';
	$Projectcountstatus0 = '0';
	$Projectcountstatus1 = '0';

	$query = DB::query("SELECT f.*, p.* FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$_G[uid]' ORDER BY p.favicon DESC,p.projectstarttimeline DESC");

	//$query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE 1 ORDER BY favicon DESC,projectstarttimeline DESC");
	while ($value = DB::fetch($query)) {
		
		//set_project_addfollow($value[projectid],$_G['uid']);
		$missionquery = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE projectid='$value[projectid]' AND status='0' ORDER BY status,missionstarttimeline ASC");
		while ($missionvalue = DB::fetch($missionquery)) {
			//$value[missionlist][$value['projectid']] = $missionvalue; 
			$value['missionlist'][] = $missionvalue; 
		}

		//只显示进行中的项目
		if($value['status'] == '0') {

			$Projectcountstatus0++;
			$Projectcountstatus0_threadlist[] = $value; 
		}

		//只显示结算中的项目
		if($value['status'] == '1') {
			$Projectcountstatus1++;
			$Projectcountstatus1_threadlist[] = $value; 
		}

		$Projectprice = $Projectprice + $value['Projectprice'];
		if($value['status'] == '9') {
			$Projectpricestatus9 = $Projectpricestatus9 + $value['Projectprice'];
		}
	}

	$incomecount = $Projectprice;

	$Projectpricestatus9count = $Projectpricestatus9;








//报销支出

	$Financial_organizationlist = get_financial_organizationlist();

	//$incomecount = 
	$Financial_Projectprice = '0';
	$Financial_Projectpricestatus9 = '0';
	$Financial_Projectpricestatus0 = '0';
	$query = DB::query("SELECT * FROM ".DB::table('work_financial_project')."  WHERE 1");
	while ($value = DB::fetch($query)) {
		
		$financialmissionProjectprice = '0';
		$missionquery = DB::query("SELECT * FROM ".DB::table('work_financial_project_mission')." WHERE projectid='$value[projectid]' ORDER BY missionstarttimeline ASC");
		while ($missionvalue = DB::fetch($missionquery)) {
			//$value[missionlist][$value['projectid']] = $missionvalue; 
			$value['missionlist'][] = $missionvalue; 
			$financialmissionProjectprice = $financialmissionProjectprice + $missionvalue['Projectprice'];
		}
		
		$value['financialProjectpricecount'] = $financialmissionProjectprice;
		$financialmissionProjectprice = '0';


		//只显示进行中的项目
		if($value['status'] == '0') {
			$Financial_Projectpricestatus0++;
			$Financial_threadlist[] = $value; 
		}

		$Financial_Projectprice = $Financial_Projectprice + $value['Projectprice'];
		if($value['status'] == '9') {
			$Financial_Projectpricestatus9 = $Financial_Projectpricestatus9 + $value['Projectprice'];
		}
	}

	$Financial_incomecount = $Financial_Projectprice;

	$Financial_Projectpricestatus9count = $Financial_Projectpricestatus9;



	//获取员工列表
	$memberlist = get_memberlist_by_groupid('24');
	$membercount = count($memberlist);









if($_G['adminid'] != '1') {
	dheader("Location: work.php?mod=worklist");
} else {

	include template('diy:work/pc/work_index');
}










?>