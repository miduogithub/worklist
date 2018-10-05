<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum_viewthread.php 35494 2015-08-06 09:31:59Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//请慎用接口 慎用！！每天都有次数限制！！
$weObj = new Wechat_thinkphp($options);

$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE groupid='24' OR groupid='1' ");
while ($value = DB::fetch($query)) {

	$weixinquery = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE uid='$value[uid]'");
	while ($weixinvalue = DB::fetch($weixinquery)) {
		$openidlist[] = $weixinvalue['openid']; 
	}

	$members[$value['uid']] = $value; 
}

//获取工作时间段
$worktimerangearr = get_worktimerange_by_dateline();

$today_morning_dateline_start = $worktimerangearr['today_morning_dateline_start'];
$today_morning_dateline_end = $worktimerangearr['today_morning_dateline_end'];

$today_afternoon_dateline_start = $worktimerangearr['today_afternoon_dateline_start'];
$today_afternoon_dateline_end = $worktimerangearr['today_afternoon_dateline_end'];

if($_G['timestamp'] > $today_morning_dateline_end) {//大于12点 是下午
	$worktime = '14:30 ~ 18:30';
	$todaytime = '下午';
}else{
	$worktime = '08:30 ~ 12:30';
	$todaytime = '上午';
}
foreach($openidlist as $openid) {

	$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE openid='$openid'");
	while ($value = DB::fetch($query)) {
		$weixinmemberinfo = $value;
		$weixinmemberinfo_uid = $value['uid']; 
	}

	$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE uid='$weixinmemberinfo_uid'");
	while ($value = DB::fetch($query)) {
		$memberinfo = $value; 
	}

	
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE editorid='$weixinmemberinfo_uid' AND status='0'"), 0);

	if($count > '0' && $week != '7') {//有新任务

		if(!empty($weixinmemberinfo_uid) && $memberinfo['groupid'] == '1' || $memberinfo['groupid'] == '24') {

		
			$message = ''.$memberinfo['username'].'，您今天'.$todaytime.'有'.$count.'个待办任务';
			//今日工作提醒
			$msgtype = '今日工作提醒';


			//保存发送记录
			insert_tmplmsg_logs($memberinfo['uid'],$memberinfo['username'],$openid,$message,$msgtype);
			//获取上一条刚刚保存的发送记录，用于收集模板消息的阅读状态
			$tmplmsg = get_tmplmsgid_by_uid_openid($memberinfo['uid'],$openid,$msgtype);
			$tmplmsgid = $tmplmsg['msgid'];

			$data = array(
				'touser'=>$openid,
				'template_id'=>"0Dji7-Qjm4dPPtqww6yFZLcmk1KQn78GgxQYn8wmKXQ",
				'url'=>"http://work.dagaoping.com/work.php?mod=project&view=mission&from=weixin&tmplmsgid=".$tmplmsgid."",
				'topcolor'=>"#F32613",
				'data'=>array(
					'first'=>array(
												'value'=>$message,
												'color'=>'#0000FF',
									),
					'keyword1'=>array(
										'value'=>''.$worktime.'',
										'color'=>'#0000FF',
									),
					'keyword2'=>array(
										'value'=>'请点击详情进入查看>>',
										'color'=>'123',
									),
				/*
					//'remark'=>array(
										'value'=>'请点击详情进行查看',
										'color'=>'123',
									),
				*/
				)
			);

			$weObj->sendTemplateMessage($data);
		}
	}

}



//miduo($UserList);

?>