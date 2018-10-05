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



$caiarr = array(
	'1'=>'土豆',  
	'2'=>'豆角王',
	'3'=>'白不老',
	'4'=>'韭菜',  
	'5'=>'蒜苗',  
	'6'=>'茴子白',
	'7'=>'西红柿',
	'8'=>'蒜苔',  
	'9'=>'尖椒',  
	'10'=>'青椒', 
	'11'=>'黄瓜', 
	'12'=>'北瓜', 
	'13'=>'茄子', 
	'14'=>'白萝卜',
	'15'=>'红萝卜',
	'16'=>'洋葱', 
	'17'=>'大葱', 
	'18'=>'小葱', 
	'19'=>'大蒜', 
	'20'=>'姜',   
	'21'=>'南瓜', 
	'22'=>'杏鲍菇',
	'23'=>'蘑菇', 
);



if(!empty($_POST['step'])) {

	$step = $_POST['step'];

	if($step == '4') {
		dheader('location: work.php?mod=vegetables');
	} elseif($step == '3') {

		$newtext = $_POST['newtext'];
		$step = '3';
	} else {
		$newcaiarr = $_POST['caiarr'];
		foreach($newcaiarr as $k=>$v) {


			$newtext .= $caiarr[$k].$v.'元一斤，';
		}

		$step = '2';
	}


}


if(empty($_POST['step'])) {
	$step = '1';
}


include template('diy:work/pc/work_vegetables');



?>