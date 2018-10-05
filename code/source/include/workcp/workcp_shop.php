<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: spacecp_class.php 25246 2011-11-02 03:34:53Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$ops = array('tiebavote');
$op = $_GET['op'];
$action = $_GET['action'];
$goodsid = $_GET['goodsid'];


if($op == 'shoplist') {


	if($action == 'add') {

		$newthreadinfo = array();
		$shopname = $_GET['shopname'];
		$goodscode = $_GET['goodscode'];
		$goodsurl = $_GET['goodsurl'];
		$editor = $_G['username'];
		$editorid = $_G['uid'];


		//检查店铺商品提交表单是否完整
		check_goodsinfo_form($shopname,$goodscode,$goodsurl);

		$submitdateline = $_GET['submitdateline'];
		$dateline = get_dateline_by_GET_submitdateline($submitdateline);

		//验证该商品编码的商品资料
		$goodsinfo = check_work_shop_goodslibrary_by_goodscode($goodscode);

		//查询店铺商品中商品上传是否重复
		check_work_shop_goodslog_repeat($goodscode,$goodsurl,$shopname);

		$data = array(
			'shopname' => $shopname,
			'goodscode' => $goodscode,
			'goodsurl' => $goodsurl,
			'editorid' => $editorid,
			'editor' => $editor,
			'dateline' => $dateline,
			'goodsname' => $goodsinfo['goodsname'],
			'barcode' => $goodsinfo['barcode'],
			'unit' => $goodsinfo['unit'],
			'price' => $goodsinfo['price'],
			
		);

		DB::insert('work_shop_goodslog', $data);

		dheader("Location: ".dreferer()."");

	} elseif($action == 'edit') {


		$newthreadinfo = array();

		if(!empty($_GET['submitdateline'])) {

			$dateline = $_GET['submitdateline'];

		}
		
		$shopname = $_GET['shopname'];
		$goodscode = $_GET['goodscode'];
		$goodsurl = $_GET['goodsurl'];

		if($_G['adminid'] == '1') {
			$reason = $_GET['reason'];
			$newthreadinfo['reason'] = $reason;
		}

		

		//检查店铺商品提交表单是否完整
		check_goodsinfo_form($shopname,$goodscode,$goodsurl);


		//验证该商品编码的商品资料
		$goodsinfo = check_work_shop_goodslibrary_by_goodscode($goodscode);


		//查询店铺商品中商品上传是否重复
		//check_work_shop_goodslog_repeat($goodscode,$goodsurl,$shopname);

		$newthreadinfo['goodsname'] = $goodsinfo['goodsname'];
		$newthreadinfo['barcode'] = $goodsinfo['barcode'];
		$newthreadinfo['unit'] = $goodsinfo['unit'];
		$newthreadinfo['price'] = $goodsinfo['price'];

		$newthreadinfo['goodscode'] = $goodscode;
		$newthreadinfo['goodsurl'] = $goodsurl;
		$newthreadinfo['shopname'] = $shopname;
		

		DB::update('work_shop_goodslog', $newthreadinfo, "goodsid='$goodsid'");
		
		dheader("Location: work.php?mod=shoplist&dateline=".$dateline."");

	} elseif($action == 'delete') {

		if($_G['adminid'] != '1') {
			//showmessage('您无权访问本页面', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if(empty($goodsid)) {

			showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}


		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		DB::delete('work_shop_goodslog', array('goodsid'=>$goodsid));
		dheader("Location: work.php?mod=shoplist&dateline=".$dateline."");

	} elseif($action == 'backtoday') {

		if(!empty($_GET['submitdateline'])) {

			$dateline = $_GET['submitdateline'];

		}
		dheader("Location: work.php?mod=shoplist".$dateline."");


	} elseif($action == 'finish') {

		if(empty($goodsid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '1';

		DB::update('work_shop_goodslog', $newthreadinfo, "goodsid='$goodsid'");






		$editorid = $_GET['editorid'];

		$check = $_GET['check'];

		if($check == 'incomplete') {
			
			if(!empty($editorid)) {

				dheader("Location: work.php?mod=shoplist&check=incomplete&editorid=".$editorid."");

			} else {

				dheader("Location: work.php?mod=shoplist&check=incomplete");
			}
			
		} else {

			dheader("Location: work.php?mod=shoplist&dateline=".$dateline."");
		}




		//dheader("Location: work.php?mod=shoplist&dateline=".$dateline."");
		//showmessage('该任务已标记完成！', 'work.php?mod=shoplist&dateline='.$dateline.'', array(), array('return' => true));

	} elseif($action == 'unfinish') {


		if(empty($goodsid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '0';

		DB::update('work_shop_goodslog', $newthreadinfo, "goodsid='$goodsid'");


		$editorid = $_GET['editorid'];

		$check = $_GET['check'];

		if($check == 'incomplete') {
			
			if(!empty($editorid)) {

				dheader("Location: work.php?mod=shoplist&check=incomplete&editorid=".$editorid."");

			} else {

				dheader("Location: work.php?mod=shoplist&check=incomplete");
			}
			
		} else {

			dheader("Location: work.php?mod=shoplist&dateline=".$dateline."");
		}

		//dheader("Location: work.php?mod=shoplist&dateline=".$dateline."");
		//showmessage('该任务已标记未完成！', 'work.php?mod=shoplist&dateline='.$dateline.'', array(), array('return' => true));

	} elseif($action == 'nofinish') {


		if(empty($goodsid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '2';

		DB::update('work_shop_goodslog', $newthreadinfo, "goodsid='$goodsid'");


		$editorid = $_GET['editorid'];

		$check = $_GET['check'];

		if($check == 'incomplete') {
			
			if(!empty($editorid)) {

				dheader("Location: work.php?mod=shoplist&check=incomplete&editorid=".$editorid."");

			} else {

				dheader("Location: work.php?mod=shoplist&check=incomplete");
			}
			
		} else {

			dheader("Location: work.php?mod=shoplist&dateline=".$dateline."");
		}

		//dheader("Location: work.php?mod=shoplist&dateline=".$dateline."");
		//showmessage('该任务已标记未完成！', 'work.php?mod=shoplist&dateline='.$dateline.'', array(), array('return' => true));

	}  

} elseif($op == 'goodslist') {


	if($action == 'add') {

		$newthreadinfo = array();
		$shopname = $_GET['shopname'];		
		$goodscode = $_GET['goodscode'];
		$goodsurl = $_GET['goodsurl'];
		$editor = $_G['username'];
		$editorid = $_G['uid'];


		check_goodsinfo_admin_form($goodscode,$goodsurl);

		$submitdateline = $_GET['submitdateline'];
		$dateline = get_dateline_by_GET_submitdateline($submitdateline);
		 
		//验证该商品编码的商品资料
		$goodsinfo = check_work_shop_goodslibrary_by_goodscode($goodscode);

		//查询商品库中商品上传是否重复
		check_work_shop_goodslog_admin_repeat($goodscode,$goodsurl);

		$data = array(
			'goodscode' => $goodscode,
			'goodsurl' => $goodsurl,
			'editorid' => $editorid,
			'editor' => $editor,
			'dateline' => $dateline,
			'goodsname' => $goodsinfo['goodsname'],
			'barcode' => $goodsinfo['barcode'],
			
		);

		DB::insert('work_shop_goodslog_admin', $data);

		dheader("Location: ".dreferer()."");

	} elseif($action == 'edit') {


		$newthreadinfo = array();

		if(!empty($_GET['submitdateline'])) {

			$dateline = $_GET['submitdateline'];

		}
		
		$goodscode = $_GET['goodscode'];
		$goodsurl = $_GET['goodsurl'];
		if($_G['adminid'] == '1') {
			$reason = $_GET['reason'];
			$newthreadinfo['reason'] = $reason;
		}

		check_goodsinfo_admin_form($goodscode,$goodsurl);

		//验证该商品编码的商品资料
		$goodsinfo = check_work_shop_goodslibrary_by_goodscode($goodscode);

		//查询商品库中商品上传是否重复
		//check_work_shop_goodslog_admin_repeat($goodscode,$goodsurl);


		$newthreadinfo['goodsname'] = $goodsinfo['goodsname'];
		$newthreadinfo['barcode'] = $goodsinfo['barcode'];
		$newthreadinfo['unit'] = $goodsinfo['unit'];
		$newthreadinfo['price'] = $goodsinfo['price'];

		$newthreadinfo['goodscode'] = $goodscode;
		$newthreadinfo['goodsurl'] = $goodsurl;

		DB::update('work_shop_goodslog_admin', $newthreadinfo, "goodsid='$goodsid'");
		
		dheader("Location: work.php?mod=goodslist&dateline=".$dateline."");

	} elseif($action == 'delete') {

		if($_G['adminid'] != '1') {
			//showmessage('您无权访问本页面', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if(empty($goodsid)) {

			showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}


		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		DB::delete('work_shop_goodslog_admin', array('goodsid'=>$goodsid));
		dheader("Location: work.php?mod=goodslist&dateline=".$dateline."");

	} elseif($action == 'backtoday') {

		if(!empty($_GET['submitdateline'])) {

			$dateline = $_GET['submitdateline'];

		}
		dheader("Location: work.php?mod=goodslist".$dateline."");


	} elseif($action == 'finish') {

		if(empty($goodsid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '1';

		$editorid = $_GET['editorid'];

		$check = $_GET['check'];

		DB::update('work_shop_goodslog_admin', $newthreadinfo, "goodsid='$goodsid'");

		if($check == 'incomplete') {
			
			if(!empty($editorid)) {

				dheader("Location: work.php?mod=goodslist&check=incomplete&editorid=".$editorid."");

			} else {

				dheader("Location: work.php?mod=goodslist&check=incomplete");
			}
			
		} else {

			dheader("Location: work.php?mod=goodslist&dateline=".$dateline."");
		}


		
		//showmessage('该任务已标记完成！', 'work.php?mod=shoplist&dateline='.$dateline.'', array(), array('return' => true));

	} elseif($action == 'unfinish') {


		if(empty($goodsid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '0';

		$editorid = $_GET['editorid'];

		$check = $_GET['check'];

		DB::update('work_shop_goodslog_admin', $newthreadinfo, "goodsid='$goodsid'");

		if($check == 'incomplete') {
			
			if(!empty($editorid)) {

				dheader("Location: work.php?mod=goodslist&check=incomplete&editorid=".$editorid."");

			} else {

				dheader("Location: work.php?mod=goodslist&check=incomplete");
			}
			
		} else {

			dheader("Location: work.php?mod=goodslist&dateline=".$dateline."");
		}
		//showmessage('该任务已标记未完成！', 'work.php?mod=shoplist&dateline='.$dateline.'', array(), array('return' => true));

	}  elseif($action == 'nofinish') {


		if(empty($goodsid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '2';

		$editorid = $_GET['editorid'];

		$check = $_GET['check'];

		DB::update('work_shop_goodslog_admin', $newthreadinfo, "goodsid='$goodsid'");

		if($check == 'incomplete') {
			
			if(!empty($editorid)) {

				dheader("Location: work.php?mod=goodslist&check=incomplete&editorid=".$editorid."");

			} else {

				dheader("Location: work.php?mod=goodslist&check=incomplete");
			}
			
		} else {

			dheader("Location: work.php?mod=goodslist&dateline=".$dateline."");
		}
		//showmessage('该任务已标记未完成！', 'work.php?mod=shoplist&dateline='.$dateline.'', array(), array('return' => true));

	} 




 


}






//查询店铺商品中商品上传是否重复
function check_work_shop_goodslog_repeat($goodscode,$goodsurl,$shopname) {

	//查询是否重复
	$query = DB::query("SELECT * FROM ".DB::table('work_shop_goodslog')." WHERE goodscode='$goodscode' OR goodsurl='$goodsurl' AND shopname='$shopname'");
	while($value = DB::fetch($query)) {
		if(!empty($value['goodscode']) || !empty($value['goodsurl']) && !empty($value['shopname'])) {
			showmessage("该商品地址已经存在了！请返回检查商品地址");
		}
	}
}

//查询商品库中商品上传是否重复
function check_work_shop_goodslog_admin_repeat($goodscode,$goodsurl) {

	$query = DB::query("SELECT * FROM ".DB::table('work_shop_goodslog_admin')." WHERE goodscode='$goodscode' OR goodsurl='$goodsurl'");
	while($value = DB::fetch($query)) {
		if(!empty($value['goodscode']) || !empty($value['goodsurl'])) {
			showmessage("该商品地址已经存在了！请返回检查商品地址");
		}
	}
}


//验证该商品编码的商品资料
function check_work_shop_goodslibrary_by_goodscode($goodscode) {

	$query = DB::query("SELECT * FROM ".DB::table('work_shop_goodslibrary')." WHERE goodscode='$goodscode'");
	while($value = DB::fetch($query)) {
		$goodsinfo = $value; 
	}
	if(empty($goodsinfo)) {
		showmessage("商品库中没有此商品，请填写正确的商品编码！点击返回");
		//,"work.php?mod=shoplist&dateline=".$dateline.""
	} else {
		return $goodsinfo;
	}
}



//检查店铺商品提交表单是否完整
function check_goodsinfo_form($shopname,$goodscode,$goodsurl) {

	if(empty($shopname)) {
		showmessage("店铺名称不能为空，请返回填写！");
	}

	if(empty($goodscode)) {
		showmessage("商品编码不能为空，请返回填写！");
	}

	if(empty($goodsurl)) {
		showmessage("商品地址不能为空，请返回填写！");
	}

}

//检查商品库商品提交表单是否完整
function check_goodsinfo_admin_form($goodscode,$goodsurl) {

	if(empty($goodscode)) {
		showmessage("商品编码不能为空，请返回填写！");
	}


	if(empty($goodsurl)) {
		showmessage("商品地址不能为空，请返回填写！");
	}

}





function get_dateline_by_GET_submitdateline($submitdateline) {

	global	$_G;

	if(!empty($submitdateline)) {

		$dateline = $submitdateline;

	} else {

		$dateline = $_G['timestamp'];
	}

	return	$dateline;
}


?>