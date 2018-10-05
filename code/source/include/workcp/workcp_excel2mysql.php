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

require_once libfile('function/work');

$ops = array('loglist');
$op = in_array($_GET['op'], $ops) ? $_GET['op'] : '';
$action = $_GET['action'];
$workid = $_GET['workid'];



if($_G['adminid'] != '1' && $_G['groupid'] != '24') {
	showmessage('您无权访问本页面', null, array(), array('showmsg' => true, 'login' => 1));
}

$file = $_FILES['exampleInputFile'];  
//通过PHPExcel_IOFactory::load方法来载入一个文件，load会自动判断文件的后缀名来导入相应的处理类，读取格式保含xlsx/xls/xlsm/ods/slk/csv/xml/gnumeric


require_once './source/class/PHPExcelClasses/PHPExcel.php';


$objPHPExcel = PHPExcel_IOFactory::load($file['tmp_name']);
//吧载入的文件默认表（一般都是第一个）通过toArray方法来返回一个多维数组
$dataArray = $objPHPExcel->getActiveSheet()->toArray();


$threadlist = $dataArray;

DB::delete('work_testresults_2017jinshengzhongxiaoxue_2', "1");
foreach($threadlist as $key=>$value) {
	
	//if($key == '0')continue;
	$data = array(
		'resultstid' => NULL,
		'lecturenumber' => $value['0'],
		'realname' => $value['1'],
		'sex' => $value['2'],
		'idcard' => $value['3'],
		'employer' => $value['4'],
		'stage' => $value['5'],
		'subject' => $value['6'],
		'scores' => $value['7'],
		'averagescore' => $value['8'],
		'comparescore' => $value['9'],
	);
	DB::insert('work_testresults_2017jinshengzhongxiaoxue_2', $data);
}



//$guangfuprojectlist = get_guangfuproject_list();


dheader("Location: work.php?mod=excel2mysql&view=debuglsit");






?>