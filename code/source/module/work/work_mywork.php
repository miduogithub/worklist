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

//获取任务类型分类

$typeclassarr = get_project_type_class();

		//获取客户列表
		$organizationlist = get_organizationlist();
		//获取项目类型
		$typelist = get_typelist();
		//获取员工列表
		//$memberlist = get_memberlist_by_groupid('24');


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

$missionstatus1count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE editorid='$_G[uid]' AND status='1' "), 0);
$missionstatusallcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE editorid='$_G[uid]' "), 0);

$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE groupid = '24' OR groupid = '1'");
while($value_users = DB::fetch($query)) {
	

		if($_G['adminid'] == '1') {
			$membermissioninfo[$value_users['uid']]['userinfo'] = $value_users; 
		} else {
			if($_G['uid'] == $value_users['uid']) {
				$membermissioninfo[$_G['uid']]['userinfo'] = $value_users; 
			} else {
				continue;
			}
		}

		$missionquery = DB::query("SELECT m.*,p.favicon FROM ".DB::table('work_project_mission')." m LEFT JOIN ".DB::table('work_project')." p ON m.projectid = p.projectid WHERE m.editorid='$value_users[uid]' AND m.status='0' AND p.status !='99' ORDER BY p.favicon DESC,m.missionstarttimeline DESC");
		while ($missionvalue = DB::fetch($missionquery)) {




/*
				if($_G['adminid'] == '1') {

					$membermissioninfo[$value_users['uid']]['missionlist'][] = $missionvalue; 

				} else {

					if($_G['uid'] == $value_users['uid']) {
						$membermissioninfo[$_G['uid']]['missionlist'][] = $missionvalue; 
					}
				
				}
*/

			if($typeclassarr[$typelist[$missionvalue['projecttypeid']]['classid']]['classcode'] == 'mission' || $typeclassarr[$typelist[$missionvalue['projecttypeid']]['classid']]['classcode'] == 'results') {

				if($_G['adminid'] == '1') {

					$membermissioninfo[$value_users['uid']]['missionlist'][] = $missionvalue; 

				} else {

					if($_G['uid'] == $value_users['uid']) {
						$membermissioninfo[$_G['uid']]['missionlist'][] = $missionvalue; 
					}
				
				}

			}

			
		}
		$membermissioninfo[$value_users['uid']]['missionstatus1count'] = count($membermissioninfo[$value_users['uid']]['missionlist']);
		
		$users[] = $value_users['uid'];
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


	
		$projectcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project')." WHERE 1"), 0);
		$projectstatus9count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project')." WHERE status='9'"), 0);
		$membercount = count($memberlist);
	


	//$incomecount = 
	$Projectprice = '0';
	$Projectpricestatus9 = '0';
	$Projectcountstatus0 = '0';
	$Projectcountstatus1 = '0';

	$query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE 1 ORDER BY favicon DESC,projectstarttimeline DESC");
	while ($value = DB::fetch($query)) {
		
		$missionquery = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE projectid='$value[projectid]' ORDER BY status,missionstarttimeline ASC");
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











include template('diy:work/pc/work_mywork_index');








?>