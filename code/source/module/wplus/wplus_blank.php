<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum_post.php 33848 2013-08-21 06:24:53Z hypowang $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('NOROBOT', TRUE);

require libfile('function/member');
require libfile('class/member');





if(checkMobile() == true && $_G['cookie']['mobile'] != 'no') {//$_G['cookie']['mobile'] 手机切换电脑版会种入cookie 所以增加判断条件

	include template('diy:work/pc/work_blank');
	//include template('forum/post_work');
	//include template('diy:work/mobile/work_loglist');

} else{
	//include template('diy:work/pc/work_loglist');
	include template('diy:work/pc/work_blank');
	

}


?>