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
$typeid = $_GET['projecttypeid'];
$typename = $_GET['typename'];
$classid = $_GET['classid'];

$query = DB::query("SELECT * FROM ".DB::table('work_project_type')." WHERE typeid='$typeid'");
while ($value = DB::fetch($query)) {
	
	$projecttypeinfo = $value; 
}

if($action == 'add') {

	$data = array(
		'typeid' => NULL,
		'typename' => $typename,
		'classid' => $classid,
		'status' => '0',
	);
	DB::insert('work_project_type', $data);

	dheader("Location: work.php?mod=project&view=projecttype");

} elseif($action == 'edit') {

	$newpost['typename'] = $typename;
	$newpost['classid'] = $classid;

	DB::update('work_project_type', $newpost, "typeid='$typeid'");
	dheader("Location: work.php?mod=project&view=projecttype");
} elseif($action == 'delete') {

	DB::delete('work_project_type', "typeid='$typeid'");
	dheader("Location: ".dreferer()."");

}


?>