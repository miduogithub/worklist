<?php


include_once libfile('function/work');
$weekarr = get_The_day_of_the_week();

$weekarray = $weekarr['weekarray'];
$week = $weekarr['week'];

include './source/class/class_wechat.class.php';
loaducenter();

$options = array(
		'token'=>'tokenaccesskey', //填写你设定的key
		'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
		'appid'=>'wxa07a4260b6193c03', //填写高级调用功能的app id
		'appsecret'=>'37cab0a80a4aa0af9f636adf93cecda7' //填写高级调用功能的密钥
	);
?>