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

require libfile('function/member');
require libfile('class/member');
require libfile('function/wx');

//$wherearr[] = "dateline >= '$thedatelinestart' AND dateline < '$thedatelineend'";

$wherearr[] = "groupid = '24'";

$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

if(empty($count)) {
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('common_member')." WHERE groupid ='1' OR groupid ='24'"), 0);
}

$_G['forum_extgroupids'] = implode("\t", $_G['forum_extgroupids']);

$query = DB::query("SELECT m.*,p.*
		FROM ".DB::table('common_member')." m
		LEFT JOIN ".DB::table('common_member_profile')." p 
		ON m.uid=p.uid WHERE m.groupid ='1' OR m.groupid ='24' ORDER BY m.uid ASC");

//$query = DB::query("SELECT * FROM ".DB::table('common_member')." $wheresql ORDER BY $order username DESC LIMIT 100");
while ($value = DB::fetch($query)) {

	$wxuserinfo = get_wx_userinfo_by_uid($value['uid']);

	if(!empty($wxuserinfo['headimgurl'])) {
		$value['avatar']  = $wxuserinfo['headimgurl'];
	} else {
		$value['avatar']  = avatar($value['uid'], 'middle', true);
	}

	$userlist[] = $value; 
}



$mui_app_contacts_list['userlist'] = $userlist;
$mui_app_contacts_list['userlistcount'] = $count;

echo json_encode($mui_app_contacts_list);
EXIT;



?>