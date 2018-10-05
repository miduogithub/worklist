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


if($action == 'nomal') {//上传原始图片


	//require_once('upload.php');

	require libfile('class/avatar_upload');

	$type = array('jpg', 'jpeg', 'png', 'gif');
	$path = sprintf('%s/%s/%s/', date('Y'), date('m'), date('d'));

	$upload = new App_Util_Upload('file1', 0, $type);
	//获取上传信息
	$info = $upload->getUploadFileInfo();
	$fileName = time() . rand(1000, 9999) . '_nomal.' . $info['suffix'];
	$fullName = $path . $fileName;	
	$path = rtrim('data/attachment/work/project/organizationid/avatar', DIRECTORY_SEPARATOR) . '/' . $fullName;
	
	$success = $upload->save($path);

	update_avatar_to_Organization($Organizationid,$path,$action);

	$width = 0;
	$height = 0;
	if($success) {
		$attr = getimagesize($path);
		$width = $attr[0];
		$height = $attr[1];
	}
	$msg = $success ? '上传成功' : '上传失败';
	echo json_encode(array('result' => $success, 'msg' => $msg, 'src' => $path, 'width' => $width, 'height' => $height, 'path' => $path));
	//print_r($success);

} elseif($action == 'btncrop') {//上传裁剪图片

	//require_once('crop.php');
	require libfile('class/avatar_crop');
	

	//$src = 'upload/2014/06/07/14021146715797.jpg';
	$src = $_GET['src'];
	$rs = explode(".",$src);
	$ext = strtolower($rs[count($rs)-1]);
	$type = array('jpg', 'jpeg', 'png');
	$path = sprintf('%s/%s/%s/', date('Y'), date('m'), date('d'));

	$fileName = time() . rand(1000, 9999) . '_thumbnail.' . $ext;
	$fullName = $path . $fileName;	
	$path = rtrim('data/attachment/work/project/organizationid/avatar', DIRECTORY_SEPARATOR) . '/' . $fullName;

	$crop = new App_Util_Crop();
	$crop->initialize($src, $path, $_GET['x'], $_GET['y'], 200, 200, $_GET['w'], $_GET['h']);
	$success = $crop->generate_shot();

	update_avatar_to_Organization($Organizationid,$path,$action);


	//print_r($success);
	$msg = $success ? '裁剪成功' : '裁剪失败';
	echo json_encode(array('result' => $success, 'msg' => $msg));
	//print_r($success);
}


function update_avatar_to_Organization($Organizationid,$avatar,$action) {

	if($action == 'nomal') {

		$newinfo['avatar_tmp'] = $avatar;
		DB::update('work_project_Organization', $newinfo, "Organizationid='$Organizationid'");

	} elseif($action == 'btncrop') {

		$query = DB::query("SELECT * FROM ".DB::table('work_project_Organization')." WHERE Organizationid='$Organizationid'");
		while ($value = DB::fetch($query)) {
			$Organizationinfo = $value; 
		}
		
		@unlink($Organizationinfo['avatar_tmp']);//删除封面文件
		$newinfo['avatar_tmp'] = '';
		$newinfo['avatar'] = $avatar;
		DB::update('work_project_Organization', $newinfo, "Organizationid='$Organizationid'");
	}

}

?>