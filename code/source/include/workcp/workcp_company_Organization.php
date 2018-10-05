<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: spacecp_class.php 25246 2011-11-02 03:34:53Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$ops = array('tiebavote');
$op = $_GET['op'];
$action = $_GET['action'];
$Organizationid = $_GET['Organizationid'];
$Organizationname = $_GET['Organizationname'];


$zhiwei = $_GET['zhiwei'];

if($zhiwei == 'zongjingli') {


	$return_flag = 'ok';
	$return_title = '总经理';
	$return_message = '负责管理调度';

} elseif($zhiwei == 'zhuli') {
	$return_flag = 'ok';
	$return_title = '助理';
	$return_message = '负责秘书工作';

} elseif($zhiwei == 'yingshizhizuo_cehua') {
	$return_flag = 'ok';
	$return_title = '影视制作→策划';
	$return_message = '文案、分镜';
} elseif($zhiwei == 'yingshizhizuo_houqi') {
	$return_flag = 'ok';
	$return_title = '影视制作→后期';
	$return_message = '剪辑、特效、合成、配音';
}
	
	$arr = array(
		'flag'=>$return_flag,
		'title'=>$return_title,
		'message'=>$return_message,
	);	

	echo json_encode($arr);










/*
$query = DB::query("SELECT * FROM ".DB::table('work_project_Organization')." WHERE Organizationid='$Organizationid'");
while ($value = DB::fetch($query)) {
	
	$Organizationinfo = $value; 
}
*/
if($action == 'add') {

	$data = array(
		'Organizationid' => NULL,
		'Organizationname' => $Organizationname,
		'status' => '0',
	);
	DB::insert('	', $data);

	dheader("Location: work.php?mod=project&view=Organizationid");

} elseif($action == 'edit') {

	$newpost['Organizationname'] = $Organizationname;

	DB::update('work_project_Organization', $newpost, "Organizationid='$Organizationid'");

	dheader("Location: work.php?mod=project&view=Organizationid");

} elseif($action == 'delete') {

	DB::delete('work_project_Organization', "Organizationid='$Organizationid'");
	dheader("Location: ".dreferer()."");

}


?>