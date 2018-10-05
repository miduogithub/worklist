<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('DISCUZ_CORE_FUNCTION', true);

function check_in_weixin() {

	global $_G;

	if(is_weixin()) {

		//if(empty($_G['uid'])) {

			if(empty($_GET['weixinopenid'])) {
				get_weixin_userinfo();
			} else {
				$weixinopenid = $_GET['weixinopenid'];
				loaducenter();
				$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE openid='$weixinopenid'");
				while ($value = DB::fetch($query)) {
					$weixinuserinfo_by_uc = $value; 
				}

				setweixin_login_status($weixinuserinfo_by_uc['uid']);
			}

		//}
	}


}



function get_weixin_userinfo($callbackurl) {

	
	//$callbackurl='callbackurl%3dhttp%3a%2f%2fwww.dagaoping.com%2fweixin.php';

	$callbackurl = 'callbackurl%3d'.base64_encode(curPageURL());
	
	$appid = 'wxa07a4260b6193c03';
	$websiterul = 'mi1.work';

	dheader("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=http%3A%2F%2F".$websiterul."%2Fgetweixinuserinfo_think.php%3fa%3d1%26".$callbackurl."&response_type=code&scope=snsapi_base&state=123#wechat_redirect");

}


//自动登录
function setweixin_login_status($uid) {

	loaducenter();
	require libfile('function/member');
	require libfile('class/member');

	//uc_user_synlogin($uid);
	$result['member'] = getuserbyuid($uid);
	setloginstatus($result['member'], '2592000');
	
}


?>