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
$checkinid = $_GET['checkinid'];

if($action == 'delete') {


	if(empty($checkinid)) {

		showmessage('选择记录不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}

	DB::delete('work_wx_checkin_logs', array('checkinid'=>$checkinid));
	
	dheader("Location: work.php?mod=HumanResources&view=checklog");


} else {

	$ip_checkin_winfi = gethostbyname("1840p5t641.imwork.net");//wifi_ip
	$ip_checkin_weixin_post = $_GET['ip_checkin_weixin'];//提交ip
	$ip_checkin_weixin = $_G['clientip'];//当前微信用户ip

	$Location = $_GET['Location'];//经纬度
	$message = $_GET['message'];//外出事由
	$dateline = $_G['timestamp'];//签到时间
	$uagent = $_SERVER['HTTP_USER_AGENT'];//浏览器信息
	$editor = $_G['username'];
	$editorid = $_G['uid'];
	//获取签到设备msc
	$getmac = new GetMacAddr(PHP_OS);
	$mac = $getmac->mac_addr;

	if(!empty($mac)) {//如果提交设备有mac码说明不是手机，疑似作弊
		showmessage_work("疑似作弊，请联系管理员了解详情","","0");
	}


	if(empty($ip_checkin_winfi)) {
		showmessage_work("签到wifi异常，请联系管理员或使用外出签到并写明事由","","0");
	}


	$checkinfoarr = get_this_checkaction($editorid);
	$thischeckaction = $checkinfoarr['thischeckaction'];
	$thischeckaction_value = $checkinfoarr['thischeckaction_value'];
	$checkaction = $thischeckaction_value;


	if($checkinfoarr['lastcheckstatus'] == '1') {

		if($thischeckaction_value == '1') {

			showmessage_work("您在岗时间不满规定时间，无法".$thischeckaction."","","0");
		} else {
			showmessage_work("您休息时间不满规定时间，无法".$thischeckaction."","","0");
		}
		
	}




	$timearr = array();

	//获取工作时间段
	$worktimerangearr = get_worktimerange_by_dateline($dateline,$timearr);

	$today_morning_dateline_start = $worktimerangearr['today_morning_dateline_start'];
	$today_morning_dateline_end = $worktimerangearr['today_morning_dateline_end'];

	$today_afternoon_dateline_start = $worktimerangearr['today_afternoon_dateline_start'];
	$today_afternoon_dateline_end = $worktimerangearr['today_afternoon_dateline_end'];

	$timearr = get_time_range_name_by_dateline($dateline,$timearr);

	$timerange = $timearr['dateline_time_range_name'];

	//考勤结果
	$result = '';






	if($checkaction == '1') {

		if($dateline > $today_morning_dateline_start && $dateline < ($today_morning_dateline_end - 600)) {
			$result = '早退';

		} elseif($dateline > $today_morning_dateline_end && $dateline < ($today_afternoon_dateline_start - 1800)) {

			$result = '忘退';

		}elseif($dateline > $today_afternoon_dateline_start && $dateline < ($today_afternoon_dateline_end - 600)) {

			$result = '早退';

		}elseif($dateline > $today_afternoon_dateline_end && $dateline < ($today_afternoon_dateline_end + 54000)) {

			$result = '忘退';

		} else {
			
			$result = '异常';
		}

		if($checkinfoarr['lastcheckstatus'] == '3') {

			$result = '异常';
		}
		
	}

	if($checkaction == '0') {

		if($dateline > $today_morning_dateline_end) {//大于12点 是下午

			if($checkaction == '0' && $dateline - $today_afternoon_dateline_start >= 600 && ($dateline - $today_afternoon_dateline_start) < 60 * 60 * 1) {//#迟到
				$result = '迟到';

			}elseif($checkaction == '0' && $dateline - $today_afternoon_dateline_start >= 60 * 60 * 1) {//#迟到 1 小时算矿工
				$result = '旷工';

			}

		}else{


			if($checkaction == '0' && $dateline - $today_morning_dateline_start > 600 && ($dateline - $today_afternoon_dateline_start) < 60 * 60 * 1) {//#迟到
				$result = '迟到';
				
			}elseif($checkaction == '0' && $dateline - $today_morning_dateline_start >= 60 * 60 * 1) {//#迟到 1 小时算矿工
				$result = '旷工';
			}
		}
	}

	if($ip_checkin_weixin_post == $ip_checkin_weixin) {

		if($ip_checkin_weixin == $ip_checkin_winfi) {//公司签到

			$checktype = '0';//签到方式 0 公司签到 1外出签到


			$data = array(
				'checkinid' => NULL,
				'editor' => $editor,
				'editorid' => $editorid,
				'dateline' => $dateline,
				'timerange' => $timerange,
				'ip_checkin_winfi' => $ip_checkin_winfi,
				'ip_checkin_weixin' => $ip_checkin_weixin,
				'uagent' => $uagent,
				'checktype' => $checktype,
				'checkaction' => $checkaction,//签到：0 签退：1
				'result' => $result,
				//'Location' => $Location,
			);

			DB::insert('work_wx_checkin_logs', $data);

			//dheader("Location: ".dreferer()."");

			showmessage_work("公司".$thischeckaction."成功！","wx.php?mod=checkin","1");


		} else {//外出签到

			$thecheckaddr = $_GET['thecheckaddr'];//浏览器定位地址
			$thecheckaddr_point_lng = $_GET['thecheckaddr_point_lng'];//经度
			$thecheckaddr_point_lat = $_GET['thecheckaddr_point_lat'];//纬度
		
			$checktype = '1';//签到方式 0 公司签到 1外出签到

			if(empty($message)) {//检查外出事由
				showmessage_work("外出事由不能为空，请返回填写！","","0");
			}

			if(empty($Location)) {//检查坐标位置
				//showmessage_work("无法获取位置信息，请检查手机是否开启位置","","0");
			}

			if(empty($thecheckaddr_point_lng) || empty($thecheckaddr_point_lat)) {//检查坐标位置
				showmessage_work("无法获取位置信息，请检查手机是否开启位置","","0");
			}

			$data = array(
				'checkinid' => NULL,
				'editor' => $editor,
				'editorid' => $editorid,
				'message' => $message,
				'dateline' => $dateline,
				'timerange' => $timerange,
				'ip_checkin_winfi' => $ip_checkin_winfi,
				'ip_checkin_weixin' => $ip_checkin_weixin,
				'uagent' => $uagent,
				'Location' => $Location,
				'thecheckaddr' => $thecheckaddr,
				'thecheckaddr_point_lng' => $thecheckaddr_point_lng,
				'thecheckaddr_point_lat' => $thecheckaddr_point_lat,
				'checktype' => $checktype,
				'checkaction' => $checkaction,//签到：0 签退：1
				'result' => $result,
			);

			DB::insert('work_wx_checkin_logs', $data);

			showmessage_work("外出".$thischeckaction."成功！","wx.php?mod=checkin","1");
			
		}
	} else {

		showmessage_work("ip异常，疑似作弊！","","0");
	}


}

exit;



    class GetMacAddr{ 
         
            var $return_array = array(); // 返回带有MAC地址的字串数组 
            var $mac_addr; 
         
            function GetMacAddr($os_type){ 
                 switch ( strtolower($os_type) ){ 
                          case "linux": 
                                    $this->forLinux(); 
                                    break; 
                          case "solaris": 
                                    break; 
                          case "unix": 
                                     break; 
                           case "aix": 
                                     break; 
                           default: 
                                     $this->forWindows(); 
                                     break; 
          
                  } 
          
                     
                  $temp_array = array(); 
                  foreach ( $this->return_array as $value ){ 
          
                            if ( 
    preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i",$value, 
    $temp_array ) ){ 
                                     $this->mac_addr = $temp_array[0]; 
                                     break; 
                           } 
          
                  } 
                  unset($temp_array); 
                  return $this->mac_addr; 
             } 
          
          
             function forWindows(){ 
                  @exec("ipconfig /all", $this->return_array); 
                  if ( $this->return_array ) 
                           return $this->return_array; 
                  else{ 
                           $ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe"; 
                           if ( is_file($ipconfig) ) 
                              @exec($ipconfig." /all", $this->return_array); 
                           else 
                              @exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $this->return_array); 
                           return $this->return_array; 
                  } 
             } 
          
          
          
             function forLinux(){ 
                  @exec("ifconfig -a", $this->return_array); 
                  return $this->return_array; 
             } 
          
    } 



if($_G['adminid'] != '1' && $_G['groupid'] != '24') {
	showmessage('您无权访问本页面', null, array(), array('showmsg' => true, 'login' => 1));
}
if($action == 'add') {

	$newthreadinfo = array();

	
	$message = $_GET['message'];

	//$message = iconv('GBK', 'UTF-8', $_GET['message']);

	$url = $_GET['url'];
	$editor = $_G['username'];
	$editorid = $_G['uid'];

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	} else {

		$dateline = $_G['timestamp'];
	}
	
	if(empty($message)) {
		dheader("Location: ".dreferer()."");
	}

	//转码
	//$message = iconv("UTF-8","gb2312",$message);

	$data = array(
		'message' => $message,
		'editor' => $editor,
		'editorid' => $editorid,
		'dateline' => $dateline,
	);

	DB::insert('work_loglist', $data);

	dheader("Location: ".dreferer()."");

	//showmessage('添加成功', dreferer(), array('fuid' => $followuid, 'type' => 0, 'special' => $special, 'from' => !empty($_GET['from']) ? $_GET['from'] : 'list'), array('closetime' => '2', 'showmsg' => '1'));

} elseif($action == 'edit') {



	$newthreadinfo = array();

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	}



	if($_GET['editback'] =='ture') {
		dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	}

	$message = $_GET['message'];

	//$editor = $_G['username'];
	//$editorid = $_G['uid'];

	//$editor = '海鸟跟鱼';
	//$editorid = '87778';


	if(!empty($_GET['editor']) && !empty($_GET['editorid'])) {

		$editor = $_GET['editor'];
		$editorid = $_GET['editorid'];

		$newthreadinfo['editor'] = $editor;
		$newthreadinfo['editorid'] = $editorid;
	} 

	$newthreadinfo['message'] = $message;


	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	dheader("Location: work.php?mod=worklist&dateline=".$dateline."");

	//showmessage('编辑成功', "work.php?mod=worklist&dateline=".$dateline."", array('fuid' => $followuid, 'type' => 0, 'special' => $special, 'from' => !empty($_GET['from']) ? $_GET['from'] : 'list'), array('closetime' => '2', 'showmsg' => '1'));
} elseif($action == 'finish') {



	if(empty($workid)) {

		showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '1';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	$editorid = $_GET['editorid'];

	$check = $_GET['check'];

	if($check == 'incomplete') {
		
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=worklist&check=incomplete&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=worklist&check=incomplete");
		}
		
	} else {

		dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	}

	//dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	//showmessage('该任务已标记完成！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'unfinish') {



	if(empty($workid)) {

		showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '0';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");



	$editorid = $_GET['editorid'];

	$check = $_GET['check'];

	if($check == 'incomplete') {
		
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=worklist&check=incomplete&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=worklist&check=incomplete");
		}
		
	} else {

		dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	}

	
	//showmessage('该任务已标记未完成！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'delete') {



	if(empty($workid)) {

		showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	DB::delete('work_loglist', array('workid'=>$workid));
	
	dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	//showmessage('删除成功', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'pushtoday') {//推送到今天


	if(empty($workid)) {

		showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		//$dateline = $_GET['dateline'];

	}

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	} else {

		$dateline = $_G['timestamp'];
	}


	$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." WHERE workid = '$workid'");
	while($row = DB::fetch($query)) {
		$loginfo = $row;
	}

	$data = array(
		'message' => $loginfo['message'],
		'editor' => $loginfo['editor'],
		'dateline' => $dateline,
	);

	DB::insert('work_loglist', $data);

	showmessage('推送成功！', 'work.php?mod=worklist', array(), array('return' => true));

} elseif($action == 'pushtop') {//提升

	$newthreadinfo = array();

	if(empty($workid)) {

		showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		//$dateline = $_GET['dateline'];

	}

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	} else {

		$dateline = $_G['timestamp'];
	}


	$newthreadinfo['dateline'] = $_G['timestamp'];

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	//showmessage('提升成功！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'backtoday') {

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	}
	dheader("Location: work.php?mod=worklist".$dateline."");


}

?>