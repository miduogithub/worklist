<?php


include_once libfile('function/work');
$weekarr = get_The_day_of_the_week();

$weekarray = $weekarr['weekarray'];
$week = $weekarr['week'];

include './source/class/class_wechat.class.php';
loaducenter();

$options = array(
		'token'=>'tokenaccesskey', //��д���趨��key
		'encodingaeskey'=>'encodingaeskey', //��д�����õ�EncodingAESKey
		'appid'=>'wxa07a4260b6193c03', //��д�߼����ù��ܵ�app id
		'appsecret'=>'37cab0a80a4aa0af9f636adf93cecda7' //��д�߼����ù��ܵ���Կ
	);
?>