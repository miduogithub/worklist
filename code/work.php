<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum.php 33828 2013-08-20 02:29:32Z nemohou $
 */


define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');


require './source/class/class_core.php';


require './source/function/function_forum.php';


$modarray = array('ajax','announcement','attachment','forumdisplay',
	'group','image','index','medal','misc','modcp','notice','post','redirect',
	'relatekw','relatethread','rss','topicadmin','trade','viewthread','tag','collection','guide','worklist','loglist','workcp','login','profile','contacts','vegetables','shoplist','goodslist','project','blank','file','profile2','organization','projecttype','financial','worklist_statistics','excel2mysql','wxuser2dzuser','humanresources','mywork','taskbar','company','taskpsot','actionlogs','upload','dateline','index_qk','dashboard','quickproject','notebook','daojishi','excel2mysql_import','excel2mysql_list'
);

$modcachelist = array(
	'index'		=> array('announcements', 'onlinelist', 'forumlinks',
			'heats', 'historyposts', 'onlinerecord', 'userstats', 'diytemplatenameforum'),
	'forumdisplay'	=> array('smilies', 'announcements_forum', 'globalstick', 'forums',
			'onlinelist', 'forumstick', 'threadtable_info', 'threadtableids', 'stamps', 'diytemplatenameforum'),
	'viewthread'	=> array('smilies', 'smileytypes', 'forums', 'usergroups',
			'stamps', 'bbcodes', 'smilies',	'custominfo', 'groupicon', 'stamps',
			'threadtableids', 'threadtable_info', 'posttable_info', 'diytemplatenameforum'),
	'redirect'	=> array('threadtableids', 'threadtable_info', 'posttable_info'),
	'post'		=> array('bbcodes_display', 'bbcodes', 'smileycodes', 'smilies', 'smileytypes',
			'domainwhitelist', 'albumcategory'),
	'space'		=> array('fields_required', 'fields_optional', 'custominfo'),
	'group'		=> array('grouptype', 'diytemplatenamegroup'),
);

//$mod = !in_array(C::app()->var['mod'], $modarray) ? 'worklist' : C::app()->var['mod'];
$mod = !in_array(C::app()->var['mod'], $modarray) ? 'index' : C::app()->var['mod'];

define('CURMODULE', $mod);
$cachelist = array();
if(isset($modcachelist[CURMODULE])) {
	$cachelist = $modcachelist[CURMODULE];

	$cachelist[] = 'plugin';
	$cachelist[] = 'pluginlanguage_system';
}
if(C::app()->var['mod'] == 'group') {
	$_G['basescript'] = 'group';
}

C::app()->cachelist = $cachelist;
C::app()->init();


loadforum();


set_rssauth();


runhooks();


$browinfo = browinfo();

include_once libfile('function/work');

$work_setting = get_work_setting();
if($work_setting['headersidebar_status'] == '1') {
	$headersidebar_status = 'sidebar-closed';
}

$weekarr = get_The_day_of_the_week();

$weekarray = $weekarr['weekarray'];
$week = $weekarr['week'];


if(strstr($browinfo,'Internet Explorer') ) {
	showmessage("您使用的浏览器过于低级，请更换高级浏览器继续访问");
}

if(empty($_G['uid'])) {
	//dheader("Location: work.php?mod=login");
}

$navtitle = str_replace('{bbname}', $_G['setting']['bbname'], $_G['setting']['seotitle']['forum']);
$_G['setting']['threadhidethreshold'] = 1;







		$forumcount = C::t('work_forum_forumtest')->fetch_forum_num();

		$query = C::t('work_forum_forumtest')->fetch_all_forum_for_sub_order();
		foreach($query as $forum) {
			if($forum['type'] == 'group') {
				$groups[$forum['fid']] = $forum;
			} elseif($forum['type'] == 'sub') {
				$subs[$forum['fup']][] = $forum;
			} else {
				$forums[$forum['fup']][] = $forum;
			}
			$fids[] = $forum['fid'];
		}


		foreach ($groups as $id => $gforum) {

				foreach ($forums[$id] as $forum) {

					if($forum['fup'] == $id) {
						$domainlist[$id][] = $forum['modcode'];
					}	
					

				}

		}




//获取当前用户加急项目列表
require_once libfile('function/getcache');
$cache_Projectcountstatus0_threadlist_favicon_1_arr = getcache_project_favicon_1($_G['uid']);





require DISCUZ_ROOT.'./source/module/work/work_'.$mod.'.php';


?>