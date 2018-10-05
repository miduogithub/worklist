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

$editorid = $_GET['DiscuzUid'];

if($editorid != $_G['uid']) {
	settbcard_login_status($editorid);
}



$Projectcountstatus0 = '0';
$Projectcountstatus1 = '0';

$projectcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid'"), 0);
//$projectstatus9count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$_G[uid]' AND p.status='9'"), 0);


$my_project_list_0_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid' AND p.status='0'"), 0);
$my_project_list_1_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid' AND p.status='1'"), 0);


$query = DB::query("SELECT f.*, p.* FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid' ORDER BY p.favicon DESC,p.projectstarttimeline DESC");	
while ($value = DB::fetch($query)) {

	$organizationquery = DB::query("SELECT * FROM ".DB::table('work_project_organization')." WHERE Organizationid='$value[Organizationid]'");
	while ($organizationvalue = DB::fetch($organizationquery)) {

		$value['organization'] = $organizationvalue;
		
	}

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

}




$mui_app_index_list = array();

$mui_app_index_list['my_project_list_0'] = $myprojectlist_0;
$mui_app_index_list['my_project_list_0_count'] = $my_project_list_0_count;
$mui_app_index_list['my_project_list_1'] = $myprojectlist_1;
$mui_app_index_list['my_project_list_1_count'] = $my_project_list_1_count;



echo json_encode($mui_app_index_list);
EXIT;












?>