<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: home_follow.php 33660 2013-07-29 07:51:05Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


if(empty($_G['uid'])) {

	if(!empty($_GET['uid'])) {
		$loginuid = $_GET['uid'];
		settbcard_login_status($loginuid);
	} else {
		dheader("Location: work.php?mod=login");
		//showmessage('to_login', '', array(), array('showmsg' => true, 'login' => 1));
	}

}



if($_G['adminid'] != '1' && $_G['groupid'] != '24') {
	showmessage("您无权是有该模块");
}

$daytimeline = 60 * 60 * 24;
$view = getgpc('view');


$dateline = getgpc('dateline');

if(empty($dateline)) {
	$dateline = strtotime(date('Y-m-d 0:0:0')); 
}

$thedaytime = date("Y-m-d 0:0:0", $dateline); 
$thedaytimeurl = date("m月d日", $dateline); 


$date=new DateTime();

$date->modify('this week');

//$Mondaytime = $date->format('2015-7-1 0:0:0');//本周第一天

$Mondaytime = date("Y-m-d 0:0:0", getmonday($dateline));
 




//星期一
$Monday = $date->format('m月d日');


$Mondaydateline = strtotime($Mondaytime);
$Monday = date("m月d日", $Mondaydateline); 



//上周日
$PreviousSundaydateline  = $Mondaydateline - $daytimeline * 1;
$PreviousSunday = date("m月d日", $PreviousSundaydateline); 

//星期二
$Tuesdaydateline = $Mondaydateline + $daytimeline * 1;
$Tuesday = date("m月d日", $Tuesdaydateline); 

//星期三
$Wednesdaydateline = $Mondaydateline + $daytimeline * 2;
$Wednesday = date("m月d日", $Wednesdaydateline); 

//星期四
$Thursdaydateline  = $Mondaydateline + $daytimeline * 3;
$Thursday = date("m月d日", $Thursdaydateline); 

//星期五
$Fridaydateline  = $Mondaydateline + $daytimeline * 4;
$Friday = date("m月d日", $Fridaydateline); 

//星期六
$Saturdaydateline  = $Mondaydateline + $daytimeline * 5;
$Saturday = date("m月d日", $Saturdaydateline); 

//星期七
$Sundaydateline  = $Mondaydateline + $daytimeline * 6;
$Sunday = date("m月d日", $Sundaydateline); 

//下周一
$nextMondaydateline  = $Mondaydateline + $daytimeline * 7;
$nextMonday = date("m月d日", $nextMondaydateline); 

/*
 
 
 
 

$newpost = array();
$missionquery = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE 1");
while ($missionvalue = DB::fetch($missionquery)) {

	$newpost['projectstarttimeline'] = strtotime($missionvalue['projectstarttimeline']);
	DB::update('work_project_mission ', $newpost, "missionid='$missionvalue[missionid]'");
}
 
  
*/



$todaydateline = strtotime(date('Y-m-d 0:0:0'));
$next1daydateline = $todaydateline + 86400;

$thedatelinestart = $dateline;
$thedatelineend = $thedatelinestart + 86400;


include_once libfile('function/work');

//获取客户列表
$organizationlist = get_organizationlist(0);
//获取项目类型
$typelist = get_typelist();
//获取员工列表
$memberlist = get_memberlist_by_groupid('24');



$yearsarr = get_yearslist();

$checkyear = getgpc('checkyear');
if(empty($checkyear)) {
	$checkyear = date('Y');
}

//微信模板消息阅读状态更改
update_tmplmsg_logs_status_by_tmplmsgid();

if($view == 'addproject') {



	include template('diy:work/pc/work_addproject_newadmin');

} elseif($view == 'editproject' && !empty($_GET['projectid'])) {
	

	$query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE projectid='$_GET[projectid]'");
	while ($value = DB::fetch($query)) {
		
		$project = $value; 
	}


	include template('diy:work/pc/work_addproject_newadmin');


}elseif($view == 'addmission') {

	$projectlist = get_projectlist('','ORDER BY projectstarttimeline DESC');

	foreach($organizationlist as $organizationid => $organization) {

		foreach($projectlist as $projecid=>$project) {
			if($organizationid == $project['Organizationid']) {
				$projectlist_select['projectlist'][$organizationid][] = $project;
			}

		}
		$projectlist_select['Organizationlist'][] = $organization;
	}
	

	include template('diy:work/pc/work_project_mission_addmission_newadmin');

}elseif($view == 'editmission' && !empty($_GET['missionid'])) {

	$query = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE missionid='$_GET[missionid]'");
	while ($value = DB::fetch($query)) {
		
		$mission = $value; 
	}

	$memberlist = get_memberlist_by_groupid('24');
	$projectlist =  get_projectlist('','ORDER BY projectstarttimeline DESC');

	foreach($organizationlist as $organizationid => $organization) {

		foreach($projectlist as $projecid=>$project) {
			if($organizationid == $project['Organizationid']) {
				$projectlist_select['projectlist'][$organizationid][] = $project;
			}

		}
		$projectlist_select['Organizationlist'][] = $organization;
	}
	
	include template('diy:work/pc/work_project_mission_addmission_newadmin');

}elseif($view == 'addOrganizationid') {

	
	include template('diy:work/pc/work_project_Organizationid_addOrganizationid_newadmin');

}elseif($view == 'editOrganizationid' && !empty($_GET['Organizationid'])) {


	$query = DB::query("SELECT * FROM ".DB::table('work_project_Organization')." WHERE Organizationid='$_GET[Organizationid]'");
	while ($value = DB::fetch($query)) {
		
		$Organization = $value; 
	}


	include template('diy:work/pc/work_project_Organizationid_addOrganizationid_newadmin');

}elseif($view == 'addprojecttype') {

	
	
	include template('diy:work/pc/work_project_type_addtype_newadmin');

}elseif($view == 'editprojecttype' && !empty($_GET['projecttypeid'])) {

	$query = DB::query("SELECT * FROM ".DB::table('work_project_type')." WHERE typeid='$_GET[projecttypeid]'");
	while ($value = DB::fetch($query)) {
		
		$projecttype = $value; 
	}


	include template('diy:work/pc/work_project_type_addtype_newadmin');

}elseif($view == 'mission') {
	
	$uid = $_G['uid'];



	if(!empty($checkyear)) {

		$startyeartime = $checkyear."-01-01 00:00:00";
		$endyeartime = $checkyear."-12-31 23:59:59";

		$startyeardateline = strtotime($startyeartime);
		$endyeardateline = strtotime($endyeartime);

		//$wherearr[] = "projectstarttimeline >= $startyeardateline";
		//$wherearr[] = "projectendtimeline <= $endyeardateline";
		$wherearr[] = "projectendtimeline <= $endyeardateline";
	}


	$editorid = getgpc('editorid');
	if(empty($editorid)) {
		$editorid = $_G['uid'];

	}

	$projectid = getgpc('projectid');
	if(!empty($projectid)) {
		$wherearr[] = "projectid = '$projectid'";	
	}

	if($_G['adminid'] != '1') {
		//$wherearr[] = "editorid = '$editorid'";
	}

	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

	$vieworder = getgpc('vieworder');
	if($vieworder == 'alleditor' || $vieworder == 'alleditoronlystatus1') {

		$wheresql2 = '';
		
	} else {

		$countwhere = "editorid='$editorid' AND";
		$missionstatus1countwhere = "editorid='$editorid' AND";
		$wheresql2 = "AND editorid='".$editorid."'" ;
	}

	//$projectlist = get_projectlist();
	$projectlist = get_projectlist('','ORDER BY projectstarttimeline DESC');

	if(empty($count)) {
		//任务总数
		$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')."  WHERE $countwhere  missionstarttimeline >= $startyeardateline AND missionstarttimeline <= $endyeardateline"), 0);

		$missionstatus1count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE $missionstatus1countwhere  status='1' AND missionstarttimeline >= $startyeardateline AND missionstarttimeline <= $endyeardateline"), 0);
		
	}

	$Projectprice = '0';

	$query = DB::query("SELECT * FROM ".DB::table('work_project')." $wheresql ORDER BY $order status,projectstarttimeline DESC");
	while ($value = DB::fetch($query)) {
		
		
		$missionquery = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE projectid='$value[projectid]' $wheresql2 ORDER BY status,missionstarttimeline DESC");
		while ($missionvalue = DB::fetch($missionquery)) {
			//$value[missionlist][$value['projectid']] = $missionvalue; 

			if($vieworder == 'alleditoronlystatus1') {
				if($missionvalue['status'] == '1') {
					continue;
				}
			} 

			$value['missionlist'][] = $missionvalue; 


		}



		if(!empty($value['missionlist'])) {
			$threadlist[] = $value; 
		}
		
		$Projectprice = $Projectprice + $value['Projectprice'];
	}
	$projectcount = count($threadlist);
	$incomecount = $Projectprice;



	include template('diy:work/pc/work_project_mission_newadmin');

}elseif($view == 'organizationid') {
	
	include template('diy:work/pc/work_project_Organizationid_newadmin');

}elseif($view == 'projecttype') {

	include template('diy:work/pc/work_project_type_newadmin');
}else {





	//按照年份查看
	if(!empty($checkyear)) {

		$startyeartime = $checkyear."-01-01 00:00:00";
		$endyeartime = $checkyear."-12-31 23:59:59";

		$startyeardateline = strtotime($startyeartime);
		$endyeardateline = strtotime($endyeartime);

		//$wherearr[] = "projectstarttimeline >= $startyeardateline";
		$wherearr[] = "projectendtimeline <= $endyeardateline";
	}

	if($_G['adminid'] != '1') {
		$wherearr[] = "editorid = ".$_G['uid']."";
	}

	//$wherearr[] = "projectstarttimeline >= '$thedatelinestart' AND projectstarttimeline < '$thedatelineend'";

	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

	if(empty($count)) {
		$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project')." $wheresql"), 0);
		$projectstatus9count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project')." WHERE status='9'"), 0);
		$membercount = count($memberlist);
	}

	$vieworder = getgpc('vieworder');
	if($vieworder == 'time') {

		$order = 'ORDER BY projectstarttimeline DESC';

	} elseif($vieworder == 'organization') {

		$order = 'ORDER BY organizationid ASC,projectstarttimeline DESC';

	} elseif($vieworder == 'price') {

		$order = 'ORDER BY Projectprice DESC';

	} elseif($vieworder == 'onlyproject') {
		
		$vieworder = 'onlyproject';
		$order = 'ORDER BY status,projectstarttimeline DESC';

	} elseif($vieworder == 'status') {
		
		$vieworder = 'status';
		$order = 'ORDER BY status ASC,projectstarttimeline DESC';

	} else {

		$vieworder = 'time';
		$order = 'ORDER BY projectstarttimeline DESC';
	}
	

	//$incomecount = 
	$Projectprice = '0';
	$Projectpricestatus9 = '0';
	$Projectcountstatus0 = '0';
	$query = DB::query("SELECT * FROM ".DB::table('work_project')." $wheresql $order");
	while ($value = DB::fetch($query)) {
		
		
		$missionquery = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE projectid='$value[projectid]' ORDER BY missionstarttimeline ASC");
		while ($missionvalue = DB::fetch($missionquery)) {
			//$value[missionlist][$value['projectid']] = $missionvalue; 
			$value['missionlist'][] = $missionvalue; 
		}


		//统计进行中的项目
		if($value['status'] == '0') {
			$Projectcountstatus0++;
			$Project_threadlist[] = $value; 
		}

		$threadlist[] = $value; 
		$Projectprice = $Projectprice + $value['Projectprice'];
		if($value['status'] == '9') {
			$Projectpricestatus9 = $Projectpricestatus9 + $value['Projectprice'];
		}
	}

	$incomecount = $Projectprice;

	$Projectpricestatus9count = $Projectpricestatus9;


	

	if(checkMobile() == true && $_G['cookie']['mobile'] != 'no') {//$_G['cookie']['mobile'] 手机切换电脑版会种入cookie 所以增加判断条件

		include template('diy:work/pc/work_project_newadmin');

	} else{
		include template('diy:work/pc/work_project_newadmin');

		

	}

}






?>