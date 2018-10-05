<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_userapp.php 25756 2011-11-22 02:47:45Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function get_user_wx_info_list_by_groupid($groupid) {

	loaducenter();

	$query = DB::query("SELECT m.*, w.* FROM ".DB::table('common_member')." m LEFT JOIN ".UC_DBTABLEPRE."weixin_member w ON m.uid = w.uid WHERE m.groupid = '$groupid' OR m.groupid = '1' ORDER BY m.uid DESC");	
	while ($value = DB::fetch($query)) {

		$memberlist[$value['uid']] = $value;

	}

	return $memberlist;

}
?>