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

$perpage = '500';


$page = empty($_GET['page'])?0:intval($_GET['page']);
if($page<1) $page=1;
$start = ($page-1)*$perpage;

$LIMIT = 'LIMIT '.$start.','.$perpage.'';


$editorid = $_GET['DiscuzUid'];

//$editorid = '1';
//$_G['uid'] = '1';

if($editorid != $_G['uid']) {
	settbcard_login_status($editorid);
}

$organizationlist = get_organizationlist();

$Projectcountstatus0 = '0';
$Projectcountstatus1 = '0';

$projectcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid'"), 0);
//$projectstatus9count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$_G[uid]' AND p.status='9'"), 0);


$my_project_list_0_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid' AND p.status='0'"), 0);
$my_project_list_1_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid' AND p.status='1'"), 0);

$myprojectlist = array();
$indexlist = array();
$query = DB::query("SELECT f.*, p.* FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid' ORDER BY p.favicon DESC,p.projectendtimeline DESC $LIMIT");	
while ($value = DB::fetch($query)) {



	$projectlist_mission_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE projectid = '$value[projectid]' AND editorid='$editorid' AND status='0'"), 0);


	$indexlist = array();
	$value['Organization_name'] = $organizationlist[$value['Organizationid']]['Organizationname'];
	$value['Organization_avatar'] = $_G['siteurl']."/".$organizationlist[$value['Organizationid']]['avatar'];



	
	//只显示进行中的项目
	if($value['status'] == '0') {

		$Projectcountstatus0++;
		$myprojectlist_0[] = $value;
	}

	//只显示结算中的项目
	if($value['status'] == '1') {
		$Projectcountstatus1++;
		$myprojectlist_1[] = $value; 
	}


	if($value['status'] == '0') {

		$indexlist['id'] = $value['projectid'];
		$indexlist['post_id'] = $value['projectid'];
		$indexlist['title'] = $value['projectname'];
		$indexlist['author_name'] = $value['Organization_name'];
		$indexlist['cover'] = $value['Organization_avatar'];
		$indexlist['published_at'] = date("Y-m-d H:i:s", $value['projectstarttimeline']); 
		$indexlist['projectlist_mission_count'] = $projectlist_mission_count; 


		if($value['favicon'] == '1') {

			$indexlist['Favicon_Style'] = 'mui-badge mui-badge-danger';
			$indexlist['Project_Name_Style'] = 'mui-ellipsis-2 mui-badge-danger mui-badge-inverted';

		} else {

			$indexlist['Favicon_Style'] = 'mui-badge mui-badge-success';
			$indexlist['Project_Name_Style'] = 'mui-ellipsis-2';
		}


		$myprojectlist[] = $indexlist;
		$indexlist = array();
	}



	
	
}
$indexlist = array();

echo json_encode($myprojectlist);
EXIT;


$mui_app_index_list = array();

$mui_app_index_list['my_project_list_0'] = $myprojectlist_0;
$mui_app_index_list['my_project_list_0_count'] = $my_project_list_0_count;
$mui_app_index_list['my_project_list_1'] = $myprojectlist_1;
$mui_app_index_list['my_project_list_1_count'] = $my_project_list_1_count;



echo json_encode($mui_app_index_list);
EXIT;








?>