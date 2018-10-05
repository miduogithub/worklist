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

$projectlist = get_projectlist('','ORDER BY projectstarttimeline DESC');
$fid = getgpc('fid');

include template('diy:work/pc/work_file_taskpsot');


?>