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

$perpage = '500';



$page = empty($_GET['page'])?0:intval($_GET['page']);
if($page<1) $page=1;
$start = ($page-1)*$perpage;

$LIMIT = 'LIMIT '.$start.','.$perpage.'';


$editorid = $_GET['DiscuzUid'];

/*
if($editorid != $_G['uid']) {
	settbcard_login_status($editorid);
}
*/

$projectid = $_GET['projectid'];

$query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE projectid='$projectid'");	
$projectinfo = DB::fetch($query);


$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE uid='$editorid'");	
$memberinfo = DB::fetch($query);



$organizationlist = get_organizationlist();
//获取任务类型
$typelist = get_typelist();

$groupid = '24';
$memberlist = get_user_wx_info_list_by_groupid($groupid);

$wherearr[] = "projectid = ".$projectid."";
$wherearr[] = "status = '0'";

$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

if(empty($count)) {
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." $wheresql"), 0);
}

$myprojectlist = array();
$indexlist = array();
$missionlist = array();

$query = DB::query("SELECT * FROM ".DB::table('work_project_mission')." $wheresql ORDER BY missionstarttimeline DESC $LIMIT");	
while ($value = DB::fetch($query)) {

	$tasklistcount = '';
	$tasklistcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission_tasklist')." WHERE missionid='$value[missionid]'"), 0);
	
	$tasklist = get_mission_tasklist_by_missionid($value['missionid']);
	
	$missionlist['tasklist'] = $tasklist; 
	$missionlist['tasklistcount'] = $tasklistcount; 

	
	if(!empty($memberlist[$value['editorid']]['headimgurl'])) {

	//	$value['avatar'] = $memberlist[$value['editorid']]['headimgurl'];	

       $value['avatar'] = avatar($value['editorid'], 'middle', true);
	} else {

		$value['avatar'] = avatar($value['uid'], 'middle', true);
	}
	
	if($value['status'] == '1') {

		$missionlist['favicon'] = 'mui-badge mui-badge-danger';

	} else {

		$missionlist['favicon'] = 'mui-badge mui-badge-success';
	}



	$missionlist['id'] = $value['missionid'];
	$missionlist['post_id'] = $value['missionid'];
	$missionlist['title'] = $value['missionname'];
	$missionlist['author_name'] = $value['editor'];
	$missionlist['cover'] = $value['avatar'];
	$missionlist['published_at'] = date("Y-m-d H:i:s", $value['missionstarttimeline']); 
	$missionlist['typename'] = $typelist[$value['projecttypeid']]['typename'];
	$missionlist['missiontime'] = preg_replace("/\&nbsp;/", "", date("m-d", $value['missionstarttimeline']));


	//$missionlist[] = $value;
	$missionlist_json['missionlist'][] = $missionlist;

}
if(empty($missionlist_json['missionlist'])) {
	
	$missionlist_json['missionlist']['0']['author_name'] = $memberinfo['username'];
	$missionlist_json['missionlist']['0']['title'] = '请添加新任务…';
	$missionlist_json['missionlist']['0']['missiontime'] = '暂无任务';
	$missionlist_json['missionlist']['0']['typename'] = '暂无任务';
	$missionlist_json['missionlist']['0']['cover'] = avatar($editorid, 'middle', true);

}

$missionlist_json['porjectinfo'] = $projectinfo;

echo json_encode($missionlist_json);
EXIT;










?>
