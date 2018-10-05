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

include './source/class/class_wechat.class.php';

$options = array(
		'token'=>'tokenaccesskey', //填写你设定的key
		'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
		'appid'=>'wx40eccd5237108749', //填写高级调用功能的app id
		'appsecret'=>'52daba69bc6253d2e8c445f8841bc2e8' //填写高级调用功能的密钥
	);
//$weObj = new Wechat_thinkphp($options);

//$UserList = $weObj->getUserList();

//miduo($UserList);

?>