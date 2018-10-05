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
$ops = array('loglist');
$op = in_array($_GET['op'], $ops) ? $_GET['op'] : '';
$action = $_GET['action'];
$workid = $_GET['workid'];
$messagenew = $_GET['message'];
$editorid = $_GET['editorid'];



if($_G['adminid'] != '1' && $_G['groupid'] != '24') {
	showmessage('您无权访问本页面', null, array(), array('showmsg' => true, 'login' => 1));
}


//查询	这里是纯读
if($action == 'getworklist') {

	$wherearr[] = "editorid = ".$_G['uid']."";

	$wherearr[] = "status = '0'";

	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

	$workidarr = array();
	

	$i = '0';
	$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." $wheresql ORDER BY lastpostdateline DESC LIMIT 100;");
	while ($value = DB::fetch($query)) {

		$i++;

		$workidarr[] = $value['workid']; 

		$value['notesappid'] = 'notes-app-'.$value['workid'];
		$jstime = $value['dateline'] * 1000;
		$jstitle =dhtmlspecialchars($value['message']);
		$jstitle =replaceSpecialChar($jstitle);
		$jsmessage =dhtmlspecialchars($value['message']);
		$jsmessage =replaceSpecialChar($jsmessage);
		$value['notesappdata'] = '{"id":'.$value['workid'].',"name":"'.$jstitle.'","description":"'.$jsmessage.'","date":'.$jstime.'}'; 
		$threadlist[] = $value; 

	}


	$workidarr = array_reverse($workidarr);


	$workinfo['notesappcount'] = $i;
	$workidarr_str = implode(",", $workidarr);
	$workinfo['notesapp'] = $workidarr_str;

	$workinfo['notesapplist'] = $threadlist;

	echo json_encode($workinfo);exit;

}


if($action == 'create') {

	//JS给的newworkid不准
	//$newworkid = $_GET['newworkid'];


	//自己重新建立newworkid
	$newworkid = getnewworkid();

	$message = '新便签';
	$title = $message;
	$data = array(
		'workid' => $newworkid,
		'title' => $title,
		'message' => $message,
		'editor' => $_G['username'],
		'editorid' => $_G['uid'],
		'dateline' => $_G['timestamp'],
		'lastpostdateline' => $_G['timestamp'],
		'lastposter' => $_G['username'],
	);

	DB::insert('work_loglist', $data);

}



//编辑
if($action == 'updateOnKeyup') {


	$newthreadinfo['message'] = $messagenew;
	$newthreadinfo['title'] = $messagenew;
	$newthreadinfo['lastpostdateline'] = $_G['timestamp'];
	$newthreadinfo['lastposter'] = $_G['username'];

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");


}






if($action == 'close_xxx') {

	$newthreadinfo['status'] = '1';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");
	exit;
	//DB::delete('work_loglist', array('workid'=>$workid));
}





function replaceSpecialChar($strParam){
	//$regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\(|\)|\（|\）|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\||\s+/";
    //$regex = "/\<|\>|\/|\||\s/";

	//$regex = "/\s/";

	//return preg_replace($regex,"\\n",$strParam);

	$strParam = str_replace("\\","/",$strParam);//替换反斜杠,就是本地路径的右斜杠

	$strParam = preg_replace("/\s+\r/is", "\n", $strParam);//回车符是\r  
	$strParam = preg_replace("/\s+\r\n/is", "\n", $strParam);//回车符是\r\n  
	$strParam = preg_replace("/\s+\n/is", "\n", $strParam);//回车符是\n  
	$strParam = str_replace("\n",'\\n',$strParam); 
	$strParam = str_replace("	",'　　',$strParam); 
	//$strParam = stripslashes($strParam); //stripslashes();返回已剥离反斜杠的字符串。
	

	return $strParam;
    
}


function getnewworkid() {

	$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." WHERE 1 ORDER BY workid DESC LIMIT 1;");
	$value = DB::fetch($query);
	$newworkid = $value['workid'] + 1;

	return $newworkid ;
}




?>