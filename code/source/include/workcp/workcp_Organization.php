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
	DB::insert('work_project_Organization', $data);

	dheader("Location: work.php?mod=project&view=organizationid");

} elseif($action == 'edit') {

	$newpost['Organizationname'] = $Organizationname;

	DB::update('work_project_Organization', $newpost, "Organizationid='$Organizationid'");
						
	dheader("Location: work.php?mod=project&view=organizationid");

} elseif($action == 'delete') {

	DB::delete('work_project_Organization', "Organizationid='$Organizationid'");
	dheader("Location: ".dreferer()."");

}


?>