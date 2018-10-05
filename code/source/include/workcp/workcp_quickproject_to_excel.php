<?php
error_reporting(0);
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: spacecp_class.php 25246 2011-11-02 03:34:53Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$time =  date("Ymd");
$timeline = $_G['timestamp'];
//$excelcode = $time.'_'.$timeline;
$excelcode = $timeline;

$editorid = getgpc('editorid');
$editor = '';
$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE uid='$editorid' ");
while ($value = DB::fetch($query)) {
	$editor = $value['username']; 
}

$thedatelinestart = getgpc('thedatelinestart');
$thedatelineend = getgpc('thedatelineend');

if(!empty($editorid)) {
	$wherearr[] = "editorid = ".$editorid."";
}elseif($_G['adminid'] != '1') {
	$wherearr[] = "editorid = ".$_G['uid']."";
}

$wherearr[] = "dateline >= '$thedatelinestart'";

$wherearr[] = "dateline <= '$thedatelineend'";


$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

if(empty($count)) {
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_loglist')." $wheresql"), 0);
	//待办总数
	$count_status0 = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_loglist')." WHERE dateline >= '$thedatelinestart' AND dateline <= '$thedatelineend' AND status='0'"), 0);
}

$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." $wheresql ORDER BY $order dateline DESC");
while ($value = DB::fetch($query)) {
	$threadlist[] = $value; 
}








		//获取客户列表
		$organizationlist = get_organizationlist();
		//获取项目类型
		$typelist = get_typelist();
		//获取员工列表
		//$memberlist = get_memberlist_by_groupid('24');

	
		$projectcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid'"), 0);
		$projectstatus9count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid' AND p.status='9'"), 0);

		$membercount = count($memberlist);

	//$incomecount = 
	$Projectprice = '0';
	$Projectpricestatus9 = '0';
	$Projectcountstatus0 = '0';
	$Projectcountstatus1 = '0';
	$Projectcountstatus0_favicon_1 = '0';
	$Projectcountstatus0_favicon_0 = '0';

	$query = DB::query("SELECT f.*, p.* FROM ".DB::table('work_project_follow')." f LEFT JOIN ".DB::table('work_project')." p ON f.projectid = p.projectid WHERE f.uid = '$editorid' ORDER BY p.favicon DESC,p.projectendtimeline DESC");

	//$query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE 1 ORDER BY favicon DESC,projectstarttimeline DESC");
	while ($value = DB::fetch($query)) {
		
		$missioncount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE projectid='$value[projectid]'"), 0);
		$missioncount_status_0 = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." WHERE projectid='$value[projectid]' AND status='0'"), 0);


	
		$missionquery = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE projectid='$value[projectid]' AND status='0' ORDER BY status,missionstarttimeline DESC");
		while ($missionvalue = DB::fetch($missionquery)) {
			//$value[missionlist][$value['projectid']] = $missionvalue; 
			$value['missionlist'][] = $missionvalue; 
		}
		

		$value['missioncount'] = $missioncount;
		$value['missioncount_status_0'] = $missioncount_status_0;
		$value['progress'] = ($missioncount - $missioncount_status_0) / $missioncount * 100;


		//只显示进行中的项目
		if($value['status'] == '0') {


			if($value['favicon'] == '1') {

				$Projectcountstatus0_favicon_1++;
				$Projectcountstatus0_threadlist_favicon_1[] = $value; 
			} elseif($value['favicon'] == '0') {

				$Projectcountstatus0_favicon_0++;
				$Projectcountstatus0_threadlist_favicon_0[] = $value; 
			}
		}

		//只显示结算中的项目
		if($value['status'] == '1') {
			$Projectcountstatus1++;
			$Projectcountstatus1_threadlist[] = $value; 
		}

		$Projectprice = $Projectprice + $value['Projectprice'];
		if($value['status'] == '9') {
			$Projectpricestatus9 = $Projectpricestatus9 + $value['Projectprice'];
		}
	}

	$incomecount = $Projectprice;

	$Projectpricestatus9count = $Projectpricestatus9;



























//miduo($Projectcountstatus0_threadlist_favicon_1);
$todaytime = date('Y年m月d日');
$todaytime = $todaytime.'（周'.$weekarray[$week].'）';

$thistimeHis = date('H:i:s');

$thedaytimestart = date('Y年m月d日',$thedatelinestart);
$thedaytimeend = date('Y年m月d日',$thedatelineend);


error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once './source/class/PHPExcelClasses/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

//合并单元格
$objPHPExcel->getActiveSheet()->mergeCells('A1:E1'); 





$objPHPExcel->getActiveSheet()->setCellValue('A1', ''.$editor.'的'.$todaytime.'项目加急表['.$Projectcountstatus0_favicon_1.']');




//文字字号
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18); 
//文字左右居中
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//文字垂直方向上中间居中  
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//文字加粗
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);  







$objPHPExcel->getActiveSheet()->setCellValue('A2', '');












//添加打印时间

//最后一行
//$print_time_hang = $count_hang + 2;

//第二行
$print_time_hang = 2;

$objPHPExcel->getActiveSheet()->mergeCells('D'.$print_time_hang.':E'.$print_time_hang.''); 
$objPHPExcel->getActiveSheet()->setCellValue('D'.$print_time_hang.'', 'PrintTime：'.$thistimeHis.'');

		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('D'.$print_time_hang.'')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('D'.$print_time_hang.'')->getFont()->setBold(true);  

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('D'.$print_time_hang.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('D'.$print_time_hang.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);







$i = '2';
//$j = '0';

foreach($Projectcountstatus0_threadlist_favicon_1 as $list) {
	
$i++;
$j = $i + 1;

	//合并单元格
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':E'.$i.''); 
	//写入项目名称
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i.'',  $list['projectname'].'（'.$list['missioncount_status_0'].'）');
	//项目名称样式
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->applyFromArray(

			  array(

				  'font' => array (

					  'bold' => true

				  ),

				  'alignment' => array(

					  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

				  )

			  )

	);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getFont()->setSize(14); 



	//背景色
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':E'.$j.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00b5f0');//设置第一行背景色为00b5f0

	// 写入表头
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$j.'', '作者')
				->setCellValue('B'.$j.'', '类型')
				->setCellValue('C'.$j.'', '任务')
				->setCellValue('D'.$j.'', '时间')
				->setCellValue('E'.$j.'', '状态');

		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$j.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$j.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.'')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.'')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('B'.$j.'')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.'')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('D'.$j.'')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.'')->getFont()->setBold(true);

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);







	//开始循环数据
	foreach($list['missionlist'] as $mlist) {
		$j++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$j.'', ''.$mlist['editor'].'')
					->setCellValue('B'.$j.'', ''.$typelist[$mlist['projecttypeid']]['typename'] .'')
					->setCellValue('C'.$j.'', ''.$mlist['missionname'].'')
					->setCellValue('D'.$j.'', ''.date('m月d日',($mlist['missionstarttimeline']+25200)).'')
					->setCellValue('E'.$j.'', '');

		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$j.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$j.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.'')->getFont()->setSize(9);


		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//$objPHPExcel->getActiveSheet()->getStyle('C'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	}

	$i = $i + ($list['missioncount_status_0']+1);




}

$count_hang = $i;
//加边框	  
$objPHPExcel->getActiveSheet()->getStyle('A3:E'.$count_hang.'')->applyFromArray(

           array(

               'borders' => array(

                   'allborders' => array(

                       'style' => PHPExcel_Style_Border::BORDER_THIN

                   )

               )

           )

);



/*
//背景色
$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00b5f0');//设置第一行背景色为00b5f0
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '时间')
			->setCellValue('B2', '')
			->setCellValue('B2', '')
			->setCellValue('C2', '')
			->setCellValue('D2', '作者')
			->setCellValue('E2', '内容')
			->setCellValue('F2', '工资');




$i = '2';


foreach($Projectcountstatus0_threadlist_favicon_1 as $list) {
$i++;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i.'', ''.date('Y年m月d日',($list['dateline']+25200)).'')
				->setCellValue('B'.$i.'', '（'.$weekarray[date('w',($list['dateline']+25200))].'）')
				->setCellValue('C'.$i.'', ''.date('H:i:s',($list['dateline']+25200)).'')
				->setCellValue('D'.$i.'', ''.$list['editor'].'')
				->setCellValue('E'.$i.'', ''.$list['message'].get_gongzi_status($list['message']).'')
				->setCellValue('F'.$i.'', '');

	if(strstr($list['message'],"请假")) {
		//背景色
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f50000');
	}
}

$yuangongqianzi_hang = $i+1;

//合并单元格
$objPHPExcel->getActiveSheet()->mergeCells('A'.$yuangongqianzi_hang.':E'.$yuangongqianzi_hang.''); 

$objPHPExcel->getActiveSheet()->getStyle('A'.$yuangongqianzi_hang.'')->applyFromArray(

          array(

              'font' => array (

                  'bold' => true

              ),

              'alignment' => array(

                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

              )

          )

);

$objPHPExcel->getActiveSheet()->setCellValue('A'.$yuangongqianzi_hang.'', '员工签字');

//加边框	  
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$yuangongqianzi_hang.'')->applyFromArray(

           array(

               'borders' => array(

                   'allborders' => array(

                       'style' => PHPExcel_Style_Border::BORDER_THIN

                   )

               )

           )

);

//合并工资栏
$objPHPExcel->getActiveSheet()->mergeCells('F3:F'.$i.''); 

*/

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');










header('Content-Disposition: attachment;filename="'.$editor.'的'.$todaytime.'项目加急表['.$Projectcountstatus0_favicon_1.']_quickproject_uid_'.$editorid.'_dateline_'.$excelcode.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;




function get_gongzi_status($message) {

	if(strstr($message,"请假")) {
		return '（-工资）';
	} else {
		return '';
	}
}
?>