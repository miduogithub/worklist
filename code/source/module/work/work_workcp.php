<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: home_spacecp.php 33660 2013-07-29 07:51:05Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


require_once libfile('function/spacecp');
require_once libfile('function/magic');


$acs = array('loglist','shop','project','mission','Organization','projecttype','financial','financial_project_mission','worklist_statistics_month_to_excel','excel2mysql','tasklist','company_Organization','upload','herader_setting','project_setting','quickproject_to_excel','project_to_excel','financial_project_to_excel','financial_runningaccount_to_excel','login_ajax','notebook','worklist_to_excel','daojishi','loglist_addworklist_ajax');//路由数组


$_GET['ac'] = $ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'profile':$_GET['ac'];
$op = empty($_GET['op'])?'':$_GET['op'];
if(!in_array($ac, array('doing', 'upload', 'blog', 'album'))) {
	$_G['mnid'] = 'mn_common';
}


if($ac != 'comment' || !$_G['group']['allowcomment']) {
	/*
	if(empty($_G['uid'])) {
		$_G['uid'] = '1';//1为管理员啊卧槽	2014年6月18日 22:36:25
	}
	if(empty($_G['uid'])) {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			dsetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
		} else {
			dsetcookie('_refer', rawurlencode('home.php?mod=spacecp&ac='.$ac));
		}
		showmessage('to_login', '', array(), array('showmsg' => true, 'login' => 1));
	}

	$space = getuserbyuid($_G['uid']);
	
	if(empty($space)) {
		showmessage('space_does_not_exist');
	}
	space_merge($space, 'field_home');

	if(($space['status'] == -1 || in_array($space['groupid'], array(4, 5, 6))) && $ac != 'usergroup') {
		showmessage('space_has_been_locked');
	}
	*/
}
$actives = array($ac => ' class="a"');

list($seccodecheck, $secqaacheck) = seccheck('publish');

$navtitle = lang('core', 'title_setup');
if(lang('core', 'title_memcp_'.$ac)) {
	$navtitle = lang('core', 'title_memcp_'.$ac);
}

$_G['disabledwidthauto'] = 0;

require_once libfile('workcp/'.$ac, 'include');

?>