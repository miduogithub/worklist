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
$view = getgpc('view');
if($view == '1') {
	miduo('1231');
}
/*
include './source/class/class_wechat.class.php';
loaducenter();

$options = array(
		'token'=>'tokenaccesskey', //填写你设定的key
		'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
		'appid'=>'wx40eccd5237108749', //填写高级调用功能的app id
		'appsecret'=>'52daba69bc6253d2e8c445f8841bc2e8' //填写高级调用功能的密钥
	);
$weObj = new Wechat_thinkphp($options);


$UserList = $weObj->getUserList();
$openidlist = $UserList['data']['openid'];



if($view == 'push_project_mission_ing') {

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

		if($count > '0') {//有新任务

			if(!empty($weixinmemberinfo_uid) && $memberinfo['groupid'] == '1' || $memberinfo['groupid'] == '24') {

				//计划事件提醒
				$data = array(
					'touser'=>$openid,
					'template_id'=>"ZmlBwglzJBazv7E8WJjeza4xK0zTjnzWLbYvxh21RQc",
					'url'=>"http://work.dagaoping.com/work.php?mod=project&view=mission",
					'topcolor'=>"#F32613",
					'data'=>array(
						'first'=>array(
													'value'=>''.$memberinfo['username'].'，您'.$count.'条待办任务',
													'color'=>'#0000FF',
										),
						'keyword1'=>array(
											'value'=>'请点击详情进行处理',
											'color'=>'#0000FF',
										),
						'keyword2'=>array(
											'value'=>date('Y年m月d日',$_G['timestamp']),
											'color'=>'123',
										),
					)
				);
				$weObj->sendTemplateMessage($data);
			}
		}

	}

} else {

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

		if(!empty($weixinmemberinfo_uid) && $memberinfo['groupid'] == '1' || $memberinfo['groupid'] == '24') {

			//计划事件提醒
			$data = array(
				'touser'=>$openid,
				'template_id'=>"RIGSNCkkFHIpB9XvmTOmIKH8bM_nbuDBeQTsk_HJeaY",
				'url'=>"http://work.dagaoping.com/index",
				'topcolor'=>"#F32613",
				'data'=>array(
					'first'=>array(
												'value'=>'您好，根据日历安排，您有以下计划',
												'color'=>'#0000FF',
									),
					'keyword1'=>array(
										'value'=>'今日进行中的项目',
										'color'=>'#0000FF',
									),
					'keyword2'=>array(
										'value'=>$memberinfo['username'],
										'color'=>'123',
									),
					'keyword3'=>array(
										'value'=>date('Y年m月d日',$_G['timestamp']),
										'color'=>'123',
									),
				)
			);
			//$weObj->sendTemplateMessage($data);
		}



	}

}




//miduo($UserList);
*/
?>