<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum_post.php 33848 2013-08-21 06:24:53Z hypowang $
 */
//header("Content-Type:text/html;charset=GBK");
//echo '<meta http-equiv="Content-Type" content="text/html; charset=GBK">';

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('NOROBOT', TRUE);
loaducenter();

$action = getgpc('action');
$uid = $_G['uid'];

include './source/class/class_wechat.class.php';

$options = array(
		'token'=>'tokenaccesskey', //填写你设定的key
		'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
		'appid'=>'wx40eccd5237108749', //填写高级调用功能的app id
		'appsecret'=>'52daba69bc6253d2e8c445f8841bc2e8' //填写高级调用功能的密钥
	);
$weObj = new Wechat_thinkphp($options);

$UserQRCode = $weObj->getQRCode($uid);
$UsergetQRUrl = $weObj->getQRUrl($UserQRCode['ticket']);

//miduo($UsergetQRUrl);


if($action == 'remove2wxuser') {

	DB::query("DELETE FROM ".UC_DBTABLEPRE."weixin_member WHERE uid='$uid'");
	settbcard_logout_status();
	dheader("Location: ".dreferer()."");
}

setcache_wxuser2dzuser_qr($uid);
$wxuser2dzuser_qrurl = getcache_wxuser2dzuser_qr($uid);

$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE uid='$uid'");
while ($value = DB::fetch($query)) {
	$weixinmemberinfo = $value;
	$weixinmemberinfo_uid = $value['uid']; 
}


include template('diy:work/pc/work_profile_wxuser2dzuser_weixinifo');



function setcache_wxuser2dzuser_qr($uid) {

	global $_G;

	require_once libfile('class/phpqrcode');//二维码类

	$picUrl = ''.$_G['siteurl'].'wx.php?mod=wxuser2dzuser&workuserloginuid='.$uid.'';//二维码扫描出的链接

	$codeuid = sprintf("%09d", $uid);
	$dir1 = substr($codeuid, 0, 3);
	$dir2 = substr($codeuid, 3, 2);
	$dir3 = substr($codeuid, 5, 2);
	$qrpath = DISCUZ_ROOT.'/data/attachment/qr/wxuser2dzuser_qr/'.$dir1.'/'.$dir2.'/'.$dir3.'/';
	Mk_Folder($qrpath);//建立目录
	$qrfile = './data/attachment/qr/wxuser2dzuser_qr/'.$dir1.'/'.$dir2.'/'.$dir3.'/wxuser2dzuser_qr_'.$uid.'.png';
	QRcode::png($picUrl, $qrfile,'L',4,0);     //生成png图片

}

function getcache_wxuser2dzuser_qr($uid) {

	global $_G;

	$codeuid = sprintf("%09d", $uid);
	$dir1 = substr($codeuid, 0, 3);
	$dir2 = substr($codeuid, 3, 2);
	$dir3 = substr($codeuid, 5, 2);

	$qrfile = 'data/attachment/qr/wxuser2dzuser_qr/'.$dir1.'/'.$dir2.'/'.$dir3.'/wxuser2dzuser_qr_'.$uid.'.png';
	$qrurl = ''.$_G['siteurl'].''.$qrfile;

	return $qrurl;
}
?>