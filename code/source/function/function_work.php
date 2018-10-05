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

function showmessage_work($message,$returnurl,$status) {
	include template('diy:work/pc/work_showmessage_newadmin');
	exit;

}

function showmessage_work_sidebar($message,$returnurl,$status) {

	global $groups,$forums;

	include template('diy:work/pc/work_showmessage2_newadmin');
	exit;

}

function get_The_day_of_the_week() {

	global $_G;

	$dateline = $_G['timestamp'];

	$weekarr = array();

	$week = date('w',$dateline);


	if($week == '0') {
		$week = '7';
	}

	//2018年5月13日 01:04:46 莫名其妙 星期日 不显示了
	if($week == '7') {
		//$week = '0';
	}


	$weekarray = array('日','一','二','三','四','五','六');

	$weekarr['weekarray'] = $weekarray;
	$weekarr['week'] = $week;

	return $weekarr;
}

function getmonday($timeline){

	if(!empty($timeline)) {

		$curtime=$timeline;
	} else {

		$curtime=time();
	}

    $weekarray=array("日","一","二","三","四","五","六");
      
    $curweekday = date('w',$curtime);

	if($curweekday == '0') {
		$mondaydateline = $curtime - 6 * 86400;
	} elseif($curweekday == '1') {
		$mondaydateline = $curtime;
	} elseif($curweekday == '2') {
		$mondaydateline = $curtime - 1 * 86400;
	} elseif($curweekday == '3') {
		$mondaydateline = $curtime - 2 * 86400;
	} elseif($curweekday == '4') {
		$mondaydateline = $curtime - 3 * 86400;
	} elseif($curweekday == '5') {
		$mondaydateline = $curtime - 4 * 86400;
	} elseif($curweekday == '6') {
		$mondaydateline = $curtime - 5 * 86400;
	}

	return $mondaydateline;
}


//自动登录
function settbcard_login_status($uid) {

	loaducenter();
	require libfile('function/member');
	require libfile('class/member');

	//uc_user_synlogin($uid);
	$result['member'] = getuserbyuid($uid);
	setloginstatus($result['member'], '2592000');
	
}

//自动退出
function settbcard_logout_status() {

	loaducenter();
	require libfile('function/member');

	uc_user_synlogout();
	clearcookies();
	$_G['groupid'] = $_G['member']['groupid'] = 7;
	$_G['uid'] = $_G['member']['uid'] = 0;
	$_G['username'] = $_G['member']['username'] = $_G['member']['password'] = '';
}

function get_memberlist_by_groupid($groupid) {

	$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE groupid='$groupid' OR groupid='1' order by regdate asc");
	while ($value = DB::fetch($query)) {
		$memberlist[$value['uid']] = $value; 
	}

	return $memberlist;
}
 


function get_memberlist_by_projectid($projectid) {

	$query = DB::query("SELECT m.*,f.* FROM ".DB::table('common_member')." m LEFT JOIN ".DB::table('work_project_follow')." f ON m.uid = f.uid WHERE f.projectid='$projectid' ORDER BY m.uid ASC");
	while ($value = DB::fetch($query)) {
		$memberlist[$value['uid']] = $value; 
	}

	return $memberlist;
}


//获取客户列表
function get_organizationlist() {

	$query = DB::query("SELECT * FROM ".DB::table('work_project_Organization')." WHERE 1");
	while ($value = DB::fetch($query)) {

		$Organizationid = $value['Organizationid'];

		$projectlist = array();
		$work_project_query = DB::query("SELECT sum(Projectprice) as Projectprice_sum, COUNT(*) as count  FROM ".DB::table('work_project')." WHERE Organizationid = '$Organizationid'");
		while ($work_project_value = DB::fetch($work_project_query)) {
			$projectlist = $work_project_value; 
		}

		$value['projectlist'] = $projectlist;
		$organizationlist[$value['Organizationid']] = $value; 
	}

	return $organizationlist;
}

function get_typelist() {

	$typequery = DB::query("SELECT * FROM ".DB::table('work_project_type')." WHERE 1");
	 while ($typevalue = DB::fetch($typequery)) {
		$typelist[$typevalue['typeid']] = $typevalue; 
	}

	return $typelist;
}

function get_projectlist($status,$order) {

	if($status == '0') {
		$wherearr[] = "status = '0'";

	}

	if(!empty($status)) {
		$wherearr[] = "status = '$status'";
	}

	if(empty($order)) {

		$order = 'ORDER BY organizationid ASC';

	} else {

		$order = $order;
	}
	
	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
	$query = DB::query("SELECT * FROM ".DB::table('work_project')." $wheresql $order");
	while ($value = DB::fetch($query)) {
		$projectlist[$value['projectid']] = $value; 
	}

	return $projectlist;
}


function get_financial_organizationlist() {

	$query = DB::query("SELECT * FROM ".DB::table('work_financial_project_organization')." $wheresql ORDER BY $order organizationid ASC LIMIT 500");
	while ($value = DB::fetch($query)) {
		$organizationlist[$value['Organizationid']] = $value; 
	}

	return $organizationlist;
}

function get_financial_typelist($typename_checktype) {

	$typequery = DB::query("SELECT * FROM ".DB::table('work_financial_project_type')." WHERE 1");
	 while ($typevalue = DB::fetch($typequery)) {

		if($typevalue['typefup'] == '0') {
			$typelist['fuplist'][$typevalue['typecode']] = $typevalue;
		} else {

			//项目成本 单独查询项目
			if($typevalue['typecode'] == '8001') {
				
				$work_project_query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE status='0' ORDER BY favicon DESC, status ASC, projectstarttimeline DESC");
				while ($work_project_value = DB::fetch($work_project_query)) {

					$work_projectid = '';
					$work_projectid = $work_project_value['projectid'];
					$typevalue['work_projectid'] = $work_projectid;

					if($typename_checktype == 'post') {
						$typevalue['typename'] = $work_project_value['projectname'];
					}
					
					$typelist['typelist'][$typevalue['typefup']][$work_project_value['projectid']] = $typevalue; 

				}
	
			} else {

				$typelist['typelist'][$typevalue['typefup']][] = $typevalue; 

			}
			
		}

		$typelist['ttypelist'][$typevalue['typecode']] = $typevalue; 
	}


	return $typelist;
}

function get_financial_projectlist($status,$order) {

	if($status == '0') {
		$wherearr[] = "status = '0'";

	}

	if(empty($order)) {

		$order = 'ORDER BY organizationid ASC, status ASC, projectstarttimeline DESC';

	} else {

		$order = $order;
	}

	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
	$query = DB::query("SELECT * FROM ".DB::table('work_financial_project')." $wheresql $order");
	while ($value = DB::fetch($query)) {
		$projectlist[$value['projectid']] = $value; 
	}

	return $projectlist;
}


//获取当前月查询列表
function get_checkmonth_list_by_thismonthfirstdaytimedateline($checkmontime,$showcount) {

		if(empty($showcount))$showcount = '9';

		for($i = 0; $i < $showcount; $i++) {

			if(date('m-d', strtotime('-'.$i.' month')) == '03-01') {//处理瑞年

				$monthsarr[] = date('Y').'-02';

			} else {

				$monthsarr[] = date('Y-m', strtotime('-'.$i.' month'));
			}
			

		}

		sort($monthsarr);


		return $monthsarr;
}


function get_yearslist($checkmontime,$showcount) {

		if(empty($showcount))$showcount = '9';
		for($i = 0; $i < $showcount; $i++) {
			$yearsarr[] = date('Y', strtotime('-'.$i.' year'));
		}
		sort($yearsarr);

		return $yearsarr;
	
}


function get_worktimerange_by_dateline($dateline,$timearr) {

	global $_G;

	$worktimerangearr = array();

	if(empty($dateline)) {

		$dateline = $_G['timestamp'];
	}

	if(empty($timearr)) {

		$today_morning_start = '08:20:00';
		$today_morning_end = '12:30:00';
		$today_afternoon_start = '14:30:00';
		$today_afternoon_end = '18:30:00';

	} else {

		$today_morning_start = $timearr['today_morning_start'];
		$today_morning_end = $timearr['today_morning_end'];
		$today_afternoon_start = $timearr['today_afternoon_start'];
		$today_afternoon_end = $timearr['today_afternoon_end'];
	}

	$Ymd = date("Y-m-d",$dateline);

	$today_morning_dateline_start = strtotime(date("".$Ymd." ".$today_morning_start.""));//上午开始
	$today_morning_dateline_end = strtotime(date("".$Ymd." ".$today_morning_end.""));//上午结束

	$today_afternoon_dateline_start = strtotime(date("".$Ymd." ".$today_afternoon_start.""));//下午开始
	$today_afternoon_dateline_end = strtotime(date("".$Ymd." ".$today_afternoon_end.""));//下午结束

	$worktimerangearr['today_morning_dateline_start'] = $today_morning_dateline_start;
	$worktimerangearr['today_morning_dateline_end'] = $today_morning_dateline_end;

	$worktimerangearr['today_afternoon_dateline_start'] = $today_afternoon_dateline_start;
	$worktimerangearr['today_afternoon_dateline_end'] = $today_afternoon_dateline_end;

	return $worktimerangearr;

}



function get_time_range_name_by_dateline($dateline,$timearr) {

	global $_G;

	$worktimerangearr = array();

	if(empty($dateline)) {

		$dateline = $_G['timestamp'];
	}

	if(empty($timearr)) {


		//凌晨（00:00 ~ 4:59） inthesmallhours
		$timearr['today_inthesmallhours_start'] = '00:00:00';
		$timearr['today_inthesmallhours_end'] = '04:59:59';

		//早晨（05:00 ~ 7:59）earlymorning
		$timearr['today_earlymorning_start'] = '05:00:00';
		$timearr['today_earlymorning_end'] = '07:59:59';

		//上午（08:00 ~ 11:59）morning
		$timearr['today_morning_start'] = '08:00:00';
		$timearr['today_morning_end'] = '11:59:59';

		//中午（12:00 ~ 13:59）noon
		$timearr['today_noon_start'] = '12:00:00';
		$timearr['today_noon_end'] = '13:59:59';

		//下午（14:00 ~ 18:59）afternoon
		$timearr['today_afternoon_start'] = '14:00:00';
		$timearr['today_afternoon_end'] = '18:59:59';

		//晚上（19:00 ~ 23:59）night
		$timearr['today_night_start'] = '19:00:00';
		$timearr['today_night_end'] = '23:59:59';
	}

	$Ymd = date("Y-m-d",$dateline);

	$timearr['today_inthesmallhours_dateline_start'] = strtotime(date("".$Ymd." ".$timearr['today_inthesmallhours_start'].""));
	$timearr['today_inthesmallhours_dateline_end'] = strtotime(date("".$Ymd." ".$timearr['today_inthesmallhours_end'].""));

	$timearr['today_earlymorning_dateline_start'] = strtotime(date("".$Ymd." ".$timearr['today_earlymorning_start'].""));
	$timearr['today_earlymorning_dateline_end'] = strtotime(date("".$Ymd." ".$timearr['today_earlymorning_end'].""));

	$timearr['today_morning_dateline_start'] = strtotime(date("".$Ymd." ".$timearr['today_morning_start'].""));
	$timearr['today_morning_dateline_end'] = strtotime(date("".$Ymd." ".$timearr['today_morning_end'].""));

	$timearr['today_noon_dateline_start'] = strtotime(date("".$Ymd." ".$timearr['today_noon_start'].""));
	$timearr['today_noon_dateline_end'] = strtotime(date("".$Ymd." ".$timearr['today_noon_end'].""));

	$timearr['today_afternoon_dateline_start'] = strtotime(date("".$Ymd." ".$timearr['today_afternoon_start'].""));
	$timearr['today_afternoon_dateline_end'] = strtotime(date("".$Ymd." ".$timearr['today_afternoon_end'].""));

	$timearr['today_night_dateline_start'] = strtotime(date("".$Ymd." ".$timearr['today_night_start'].""));
	$timearr['today_night_dateline_end'] = strtotime(date("".$Ymd." ".$timearr['today_night_end'].""));



	if($dateline >= $timearr['today_inthesmallhours_dateline_start'] && $dateline <= $timearr['today_inthesmallhours_dateline_end'] ) {
		$timearr['dateline_time_range_name'] = '凌晨';
	}

	if($dateline >= $timearr['today_earlymorning_dateline_start'] && $dateline <= $timearr['today_earlymorning_dateline_end'] ) {
		$timearr['dateline_time_range_name'] = '早上';
	}

	if($dateline >= $timearr['today_morning_dateline_start'] && $dateline <= $timearr['today_morning_dateline_end'] ) {
		$timearr['dateline_time_range_name'] = '上午';
	}	

	if($dateline >= $timearr['today_noon_dateline_start'] && $dateline <= $timearr['today_noon_dateline_end'] ) {
		$timearr['dateline_time_range_name'] = '中午';
	}	

	if($dateline >= $timearr['today_afternoon_dateline_start'] && $dateline <= $timearr['today_afternoon_dateline_end'] ) {
		$timearr['dateline_time_range_name'] = '下午';
	}	

	if($dateline >= $timearr['today_night_dateline_start'] && $dateline <= $timearr['today_night_dateline_end'] ) {
		$timearr['dateline_time_range_name'] = '晚上';
	}	

	return $timearr;

}

function insert_tmplmsg_logs($editorid,$editor,$openid,$message,$msgtype) {

	GLOBAL $_G;

	$data = array(
		'msgid' => NULL,
		'editor' => $editor,
		'editorid' => $editorid,
		'openid' => $openid,
		'dateline' => $_G['timestamp'],
		'message' => $message,
		'msgtype' => $msgtype,
	);
	DB::insert('work_wx_tmplmsg_logs', $data);
}


function update_tmplmsg_logs_status_by_tmplmsgid($msgid,$status) {
	
	if(empty($msgid)) {
		$msgid = getgpc('tmplmsgid');
	}

	if(empty($status)) {
		$status = '0';
	}

	$newdata['status'] = $status;

	if(!empty($msgid)) {
		DB::update('work_wx_tmplmsg_logs', $newdata, "msgid='$msgid'");
	}
}


function get_tmplmsgid_by_uid_openid($uid,$openid,$msgtype) {

	$query = DB::query("SELECT * FROM ".DB::table('work_wx_tmplmsg_logs')." WHERE editorid='$uid' AND openid='$openid' AND msgtype='$msgtype'");
	while ($value = DB::fetch($query)) {
		$tmplmsg = $value; 
	}

	return $tmplmsg;
}



function insert_work_action_logs($actionname,$actionmod,$actionmessage,$status) {

	GLOBAL $_G;

	$editorid = $_G['uid'];
	$editor = $_G['username'];

	$data = array(
		'logsid' => NULL,
		'editor' => $editor,
		'editorid' => $editorid,
		'actionname' => $actionname,
		'actionmod' => $actionmod,
		'dateline' => $_G['timestamp'],
		'actionmessage' => $actionmessage,
		'status' => $status,
	);
	DB::insert('work_actionlogs', $data);
}

function get_mission_tasklist_by_missionid($missionid) {
	
	$tasklist = array();
	$i = '0';
	$query = DB::query("SELECT * FROM ".DB::table('work_project_mission_tasklist')." WHERE missionid='$missionid' order by  status ASC , dateline DESC");
	while ($value = DB::fetch($query)) {
		$i++;

		if($value['status'] == '1') {
			$value['status_excel'] = '完成';
		} else {
			$value['status_excel'] = '';
		}

		if(!empty($value['tid'])) {
			$value['taskname_for_excel'] = $value['taskname'].'（附件）';
		} else {
			$value['taskname_for_excel'] = $value['taskname'];
		}

		if(!empty($value['taskurl'])) {
			$value['taskname_for_excel'] = $value['taskname_for_excel'].'（传送门）';
		}

		$value['num_taskname'] = $i.'、'.$value['taskname'];
		$tasklist[] = $value; 
	}

	return $tasklist;
}

function get_mission_task_by_taskid($taskid) {
	
	$task = array();
	$query = DB::query("SELECT * FROM ".DB::table('work_project_mission_tasklist')." WHERE taskid='$taskid'");
	$task = DB::fetch($query);	

	return $task;
}

function taskbar_to_thread($taskid,$tid) {

	$newdata['tid'] = $tid;

	if(!empty($tid)) {
		DB::update('work_project_mission_tasklist', $newdata, "taskid='$taskid'");
	}

}

//检测用户是否有模块权限
function check_work_forum_spviewperm($forum) {

	global $_G;

	if($_G['adminid'] == 1 || in_array($_G['groupid'], explode("\t", $forum['spviewperm']))) {

		return TRUE;
	}
}

//获取用户正在进行的任务列表
function get_user_missionlist_by_uid($uid) {

	global $_G;
	$membermissioninfo = array();
	//获取员工用户组的的uidlist	(groupid:24)

	$missionstatus1count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE editorid='$uid' AND status='1' "), 0);
	$missionstatusallcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE editorid='$uid' "), 0);

	$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE  groupid = '24' OR groupid = '1'");
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

				if($_G['adminid'] == '1') {

					$membermissioninfo[$value_users['uid']]['missionlist'][] = $missionvalue; 

				} else {

					if($_G['uid'] == $value_users['uid']) {
						$membermissioninfo[$_G['uid']]['missionlist'][] = $missionvalue; 
					}
				
				}
				
			}



			$membermissioninfo[$value_users['uid']]['missionstatus1count'] = count($membermissioninfo[$value_users['uid']]['missionlist']);
			
			$users[] = $value_users['uid'];
	}
	


	return $membermissioninfo;

}

function get_wx_userinfo_by_uid($uid) {

	loaducenter();

	$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE uid='$uid'");
	while ($value = DB::fetch($query)) {
		$weixinmemberinfo = $value;
	}

	return $weixinmemberinfo;
}




function set_project_addfollow($projectid, $followuid) {
 

	global  $_G;

	$pquery = DB::query("SELECT * FROM ".DB::table('work_project_follow')." WHERE projectid='$projectid' AND uid='$followuid'");
	$project_follow = DB::fetch($pquery);	

	if(empty($project_follow)) {


		$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE uid='$followuid'");
		$member = DB::fetch($query);
		$followusername = $member['username'];

		$data = array(
			'projectid' => $projectid,
			'uid' => $followuid,
			'username' => $followusername,
			'dateline' => $_G['timestamp'],

		);
		DB::insert('work_project_follow', $data);
		//$query = DB::query("REPLACE INTO ".DB::table('work_project_follow')." (projectid, uid, username, dateline) VALUES ('$projectid', '$followuid', '$followusername', ' $_G[timestamp]')");
	}


}

function get_project_followlist($projectid) {
 

	$followlist = array();
	$query = DB::query("SELECT * FROM ".DB::table('work_project_follow')." WHERE projectid='$projectid'");
	while ($value = DB::fetch($query)) {
		$weixinmemberinfo = get_wx_userinfo_by_uid($value['uid']);
		$value['weixinmemberinfo'] = $weixinmemberinfo;
		$followlist[] = $value;
	}

	return $followlist;

}


function get_project_followlist_by_uid($uid) {
 

	$projectlist = array();


	$query = DB::query("SELECT p.* FROM ".DB::table('work_project')." p LEFT JOIN ".DB::table('work_project_follow')." f ON p.projectid = f.projectid WHERE f.uid='$uid' AND p.status='0'");
	while ($value = DB::fetch($query)) {
		$weixinmemberinfo = get_wx_userinfo_by_uid($value['uid']);
		$value['weixinmemberinfo'] = $weixinmemberinfo;
		$projectlist[] = $value;
	}

	return $projectlist;

}


function update_project_follow_by_mission() {

	$query = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE 1");
	while ($value = DB::fetch($query)) {
		set_project_addfollow($value['projectid'],$value['editorid']);
	}

}

function get_work_setting() {
	global $_G;

	$query = DB::query("SELECT * FROM ".DB::table('work_setting')." WHERE uid='$_G[uid]'");
	$settinginfo = DB::fetch($query);
	
	return $settinginfo;
}
//获取用户浏览项目的行为记录
function get_work_setting_project_status_by_uid($uid) {

	$project_setting_list = array();
	$query = DB::query("SELECT * FROM ".DB::table('work_setting_project_status')." WHERE uid = '$uid'");
	while($value = DB::fetch($query)) {
		
		$project_setting_list[$value['projectid']] = $value;
	}
	
	return $project_setting_list;
}

function get_important_count() {

	global $_G;

	$important_count = DB::result(DB::query("SELECT count(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$_G[uid]' AND p.status='0' AND p.favicon='1'"), 0);

	return $important_count;
}

function get_work_project_payout_count($projectid) {

	$work_project_payout_count = DB::result(DB::query("SELECT sum(fm.Projectprice) FROM ".DB::table('work_project')." p LEFT JOIN ".DB::table('work_financial_project_mission')." fm ON p.projectid = fm.work_project_projectid WHERE p.projectid = '$projectid'"), 0);

	return	$work_project_payout_count;

}

function get_daojishi_data($editorid) {

	$daojishiarr = array();
	$wherearr[] = "editorid = ".$editorid."";
	$wherearr[] = "status IN(0)";
	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_daojishi')." $wheresql"), 0);
	$query = DB::query("SELECT * FROM ".DB::table('work_daojishi')." $wheresql ORDER BY $order endtimedateline ASC");
	while ($value = DB::fetch($query)) {

		$threadlist[] = $value; 
	}

	$daojishiarr['count'] = $count;
	$daojishiarr['list'] = $threadlist;

	return $daojishiarr;
}

function get_project_type_class() {

	$typeclassarr = array();

	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
	$query = DB::query("SELECT * FROM ".DB::table('work_project_type_class')." $wheresql ORDER BY $order classid ASC");
	while ($value = DB::fetch($query)) {

		$typeclassarr[$value['classid']] = $value; 
	}

	return $typeclassarr;

}



function get_worklist_info_by_workid($workid) {
 

	$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." WHERE workid='$workid'");
	$value = DB::fetch($query);
	

	return $value;

}

function check_worklist_is_project_by_workid($workid) {

	$query = DB::query("SELECT * FROM ".DB::table('work_project_worklist')." WHERE workid='$workid'");
	$value = DB::fetch($query);

	return $value;
}


function get_project_progress_by_projectid($projectid) {



	$missioncount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." m LEFT JOIN ".DB::table('work_project_type')." pt ON m.projecttypeid = pt.typeid WHERE m.projectid='$projectid' AND pt.classid='1' OR m.projectid='$projectid' AND pt.classid='4'"), 0);

	$missioncount_status_0 = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." m LEFT JOIN ".DB::table('work_project_type')." pt ON m.projecttypeid = pt.typeid WHERE m.projectid='$projectid' AND m.status='0' AND pt.classid='1' OR m.projectid='$projectid' AND m.status='0' AND pt.classid='4'"), 0);

	$progress = ($missioncount - $missioncount_status_0) / $missioncount * 100;

	return round($progress);

}



function check_message_number_to_Highlight($str=''){

	$newstr = $str;
	$str=trim($str);
	if(empty($str)){ 
		return '';
	}

	$temp=array('1','2','3','4','5','6','7','8','9','0','.');

	$result='';
	$result_bold = '';

	for($i=0; $i<strlen($str); $i++){

		if(in_array($str[$i],$temp)){

			$result .= '<span style="color:red;font-weight:bold">'.$str[$i].'</span>';
			$result_bold = '<span style="color:red;font-weight:bold">'.$str[$i].'</span>';

			$newstr = str_replace($str[$i],$result_bold,$newstr);
		}

		
	}

	return $newstr;


}


function set_worklist_conver($text) {

	$text = str_replace("\s","%nbsp;",$text);

	if($_GET['action'] != 'edit') {

		$text = str_replace("\n","<p/><p>",$text);
	}
	
	return $text;
}




?>