<?php

require './source/class/class_core.php';
$discuz = & discuz_core::instance();
$discuz->init();
set_time_limit(0);


$callbackurl = base64_decode($_GET['callbackurl']);

$code = $_GET['code'];//获取code
$appid = 'wxa07a4260b6193c03';
$secret = '37cab0a80a4aa0af9f636adf93cecda7';
$weixin =  file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token


$jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
$array = get_object_vars($jsondecode);//转换成数组


$openid = $array['openid'];//输出openid

loaducenter();
$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE openid='$openid'");
while ($value = DB::fetch($query)) {
	$uid = $value['uid']; 
}

if(!empty($uid)) {//在本站有用户信息

	//登录
	//settbcard_login_status($uid);

	if(strstr($callbackurl,"?")) {

		dheader("Location: ".$callbackurl."&weixinopenid=".$openid."");
	} else {
		dheader("Location: ".$callbackurl."?weixinopenid=".$openid."");
	}
	
	//miduo($uid);
}else {//没用户信息
	
		

	$weixin_userinfo =  file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$array[access_token].'&openid='.$openid.'&lang=zh_CN');//通过code换取网页授权access_token
	$jsondecode_userinfo = json_decode($weixin_userinfo); //对JSON格式的字符串进行编码

	$userinfoarray = get_object_vars($jsondecode_userinfo);//转换成数组



	if($userinfoarray['errcode'] == '48001') {//array ( 'errcode' => 48001, 'errmsg' => 'req id: _i7Ypa0650ns40, api unauthorized', )
		
		/*
		//$openid = $openid;
		$nickname = 'wx_'.set_salt();
		$sex = '';
		$language = '';
		$city = '';//城市
		$province = '';//省份
		$country = '';//国籍
		$headimgurl = '';
		$status = '0';//0是游客未授权

		$userinfoarray = array(
			'openid' => $openid,
			'nickname' => $nickname,
			'sex' => '',
			'language' => '',
			'city' => '',
			'province' => '',
			'country' => '',
			'headimgurl' => '',
			'status' => $status,
		);

		add_weixin_member_to_uc($userinfoarray);

		if(strstr($callbackurl,"?")) {
			dheader("Location: ".$callbackurl."&weixinopenid=".$openid."");
		} else {
			dheader("Location: ".$callbackurl."?weixinopenid=".$openid."");
		}

		*/

		//原先要在这里跳转到授权页面的，后来发现体验太差了，所以把跳入授权页面的流程独立出来让用户自己选择了 2015年10月18日 21:31:02 by miduo
		$callbackurl = base64_encode($callbackurl);
		$websiterul = 'mi1.work';
		$redirect_uri = "http%3A%2F%2F".$websiterul."%2Fgetweixinuserinfo_think.php%3fcallbackurl=".$callbackurl;
		
		dheader("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect");
	} else {


		$userinfoarray['status'] = '1';

		add_weixin_member_to_uc($userinfoarray);

		if(strstr($callbackurl,"?")) {
			dheader("Location: ".$callbackurl."&weixinopenid=".$openid."");
		} else {
			dheader("Location: ".$callbackurl."?weixinopenid=".$openid."");
		}
	}

}


function save_avatar2discuz($newuid,$imgurl) {


	require_once libfile('class/phpgetImage');

	$phpgetImage = new phpgetImage();

	$uid = sprintf("%09d", $newuid);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);

	$ucpath = './uc_server';


	$dir1Folder = $ucpath.'/data/avatar/'.$dir1.'/';
	$dir2Folder = $ucpath.'/data/avatar/'.$dir1.'/'.$dir2.'/';
	$annexFolder = $ucpath.'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/';//头像middle目录
	$smallFolder = $ucpath.'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/';//头像small目录



	MkFolder(DISCUZ_ROOT.$dir1Folder);//判断avatar 1级目录是否存在，不存在就建立
	MkFolder(DISCUZ_ROOT.$dir2Folder);//判断avatar 2级目录是否存在，不存在就建立
	MkFolder(DISCUZ_ROOT.$annexFolder);//判断头像middle目录是否存在，不存在就建立
			
	//不足两位数前加 0 补足两位
	$avatar_number = sprintf( "%02d",$newuid);

	$imageName_big = substr($avatar_number, -2).'_avatar_big.jpg';//big头像文件名
	$imageName_middle = substr($avatar_number, -2).'_avatar_middle.jpg';//big头像文件名
	$imageName_small = substr($avatar_number, -2).'_avatar_small.jpg';//big头像文件名

	@unlink($smallFolder.$imageName_big);//
	@unlink($smallFolder.$imageName_middle);//删除原文件
	@unlink($smallFolder.$imageName_small);//删除原文件

	$phpgetImage->getImage($imgurl,$smallFolder,$imageName_big);
	$phpgetImage->getImage($imgurl,$smallFolder,$imageName_middle);
	$phpgetImage->getImage($imgurl,$smallFolder,$imageName_small);



	//更新members表头像字段
	C::t('common_member')->update($newuid, array('avatarstatus'=>'1'));	

	return $smallFolder.$imageName_middle;

}



function add_weixin_member_to_uc($userinfoarray) {

	global $_G;

	loaducenter();
	$openid = $userinfoarray['openid'];
	$nickname = utf8_2_gbk($userinfoarray['nickname']).'_'.set_salt();
	$sex = $userinfoarray['sex'];
	$language = utf8_2_gbk($userinfoarray['language']);
	$city = utf8_2_gbk($userinfoarray['city']);//城市
	$province = utf8_2_gbk($userinfoarray['province']);//省份
	$country = utf8_2_gbk($userinfoarray['country']);//国籍


	$headimgurl = utf8_2_gbk($userinfoarray['headimgurl']);//头像



	$headimgurl = save_avatar2discuz($_G['uid'],$userinfoarray['headimgurl']);

	$status = $userinfoarray['status'];
	$regip = $_G['clientip'];
	$regdateline = $_G['timestamp'];

	$nationality = $province;//国籍
	$resideprovince = $province;//省份
	$residecity = $country;	//城市
	
	if(!empty($openid)) {

		//在这个地方加一个判断：判断openid是否重复绑定过
		$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE openid='$openid'");
		while ($value = DB::fetch($query)) {
			$checuidinfo = $value; 
		}
		if(!empty($checuidinfo)) {
			//echo "该微信已绑定帐号ID：（"$checuidinfo['uid']"），请先解绑！";exit;
			showmessage("该微信已绑定帐号ID：（".$checuidinfo['uid']."），请先解绑！");
		}
			//重复则检测当前uid是否和绑定过该openid的uid是否一致
				//一致则转到登录状态
					//不一致就提示该openid已经绑定过其他帐号（username），请先解绑！
		

		if(!empty($_G['uid'])) {
			
			$newuid = $_G['uid'];

		} else {

			$newuid = setnewuser_forweixin($openid,$nickname,$sex,$nationality,$resideprovince,$residecity);
		}
		

		DB::query("INSERT INTO ".UC_DBTABLEPRE."weixin_member (uid,openid,nickname,sex,language,city,province,country,headimgurl,status,regip,regdateline) VALUES ('$newuid','$openid','$nickname','$sex','$language','$city','$province','$country','$headimgurl','$status','$regip','$regdateline')", 'UNBUFFERED');
	}

}


function setnewuser_forweixin($openid,$nickname,$sex,$nationality,$resideprovince,$residecity) {
	
	global $_G;

	loaducenter();
	$username = $nickname;
	$password = $openid;
	$email = $openid.'@weixin.com';
	$newregdate = $_G['timestamp'];//注册时间
	$newgroupid = '27';//新建立一个自定义用户组：微信用户
	$salt = set_salt();
	$regip = $_G['clientip'];
	$gender = $sex;

	
	$nationality = $nationality;//国籍
	$residecity = $residecity;//城市
	$resideprovince = $resideprovince;//省份

	//$address = $address;//邮寄地址
	//$mobile = $mobile;
	//$birthyear = date('Y',strtotime($birthdaytime));//生日年
	//$birthmonth = str_replace('0','',date('m',strtotime($birthdaytime)));//生日月
	//$birthday = date('d',strtotime($birthdaytime));//生日日


	//检查用户名是否重复
	//if(check_username_repeat($username) == '1') {
		//continue;//重复则跳过这个用户
	//};

	//uc_members
	DB::query("INSERT INTO ".UC_DBTABLEPRE."members (username, password, email, myid, myidkey, regdate, lastloginip,lastlogintime,salt,secques) VALUES ('$username', '$password', '$email', '','','$newregdate','$regip','$newregdate','$salt','$value[secques]')", 'UNBUFFERED');

	$query = DB::query("SELECT uid FROM ".UC_DBTABLEPRE."members ORDER BY uid DESC LIMIT 1");	
	while ($value = DB::fetch($query)) {
		$newuid = $value['uid']; 
	}

	DB::query("UPDATE ".UC_DBTABLEPRE."members SET regip='$regip' WHERE uid = '$newuid'");

	//uc_memberfields
	//DB::query("INSERT INTO ".UC_DBTABLEPRE."memberfields (uid, blacklist) VALUES ('$newuid', '')", 'UNBUFFERED');

	//用户主表
	$data_common_member = array(
		'uid' => $newuid,
		'username' => $username,
		'password' => $password,
		'groupid' => $newgroupid,
		'adminid' => $value['adminid'],
		'groupexpiry' => $value['groupexpiry'],//用户组有效期
		'extgroupids' => $value['extgroupids'], //扩展用户组
		'regdate' => $newregdate,//注册时间
		'email' => $email,
		'timeoffset' => $value['timeoffset'],//时区校正
		'newpm' => $value['newpm'],//新短消息数量
		'accessmasks' => $value['accessmasks'],//标志

	);
	DB::insert('common_member', $data_common_member);

	//用户栏目表
	$data_common_member_profile = array(
		'uid' => $newuid,
		'realname' => $cardname,
		'gender' => $gender ,
		'birthyear' => $birthyear,
		'birthmonth' => $birthmonth,
		'birthday' => $birthday,
		'mobile' => $mobile,
		'address' => $address,
		'site' => $value['memberfields']['site'],
		'alipay' => $value['memberfields']['alipay'],
		'icq' => $value['memberfields']['icq'],
		'qq' => $value['memberfields']['qq'],//用户组有效期
		'yahoo' => $value['memberfields']['yahoo'], //扩展用户组
		'msn' => $value['memberfields']['msn'],
		'taobao' => $value['memberfields']['taobao'],//时区校正
		'bio' => $value['memberfields']['bio'],
		'nationality' => $nationality,
		'residecity' => $residecity,
		'resideprovince' => $resideprovince,

	);
	DB::insert('common_member_profile', $data_common_member_profile);

	//用户状态表
	$data_common_member_status = array(
		'uid' => $newuid,
		'regip' => $regip,//注册ip 同步到 pre_common_member_status
		'lastip' => $regip,//最后登录IP 同步到 pre_common_member_status
		'lastvisit' => $newregdate,//最后访问 同步到 pre_common_member_status
		'lastactivity' => $newregdate,//最后活动 同步到 pre_common_member_status
		'lastpost' => $value['lastpost'], //最后发表 同步到 pre_common_member_status
		'invisible' => $value['invisible'],//隐身登录
		'buyercredit' => $value['memberfields']['buyercredit'],//买家信用等级及积分
		'sellercredit' => $value['memberfields']['sellercredit'],//卖家信用等级及积分

	);
	DB::insert('common_member_status', $data_common_member_status);



	//用户统计表
	$data_common_member_count = array(
		'uid' => $newuid,
		'posts' =>$value['posts'],
		'digestposts' =>$value['digestposts'],
		'oltime' =>$value['oltime'],
		'extcredits1' =>$value['extcredits1'],
		'extcredits2' =>$value['extcredits2'],
		'extcredits3' =>$value['extcredits3'],
		'extcredits4' =>$value['extcredits4'],
		'extcredits5' =>$value['extcredits5'],
		'extcredits6' =>$value['extcredits6'],
		'extcredits7' =>$value['extcredits7'],
		'extcredits8' =>$value['extcredits8'],

	);
	DB::insert('common_member_count', $data_common_member_count);



	//用户论坛字段表
	$data_common_member_field_forum = array(
		'uid'=>$newuid,
		'customshow'=>$value['customshow'],//自定义帖子显示模式
		'customstatus'=>$value['memberfields']['customstatus'],//自定义头衔
		'medals'=>$value['memberfields']['medals'],//勋章信息
		'sightml'=>$value['memberfields']['sightml'],//签名
		'groupterms'=>$value['memberfields']['groupterms'],//公共用户组
		'authstr'=>$value['memberfields']['authstr'],//找回密码验证串

	);
	DB::insert('common_member_field_forum',$data_common_member_field_forum);


	//用户家园字段表
	$data_common_member_field_home = array(
		'uid'=>$newuid,
		'spacename'=>$value['memberfields']['spacename'],//空间名称
	);
	DB::insert('common_member_field_home',$data_common_member_field_home);




	return $newuid;

}

function set_salt() {

	$randStr = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
	$salt = substr($randStr,0,3);

	return $salt;
}


function utf8_2_gbk($str) {
	
	//$str = iconv("UTF-8", "GB2312//IGNORE", $str);

	return $str;
}
?>