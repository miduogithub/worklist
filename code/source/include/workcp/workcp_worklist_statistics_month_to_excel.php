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
$excelcode = $time.'_'.$timeline;

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

$wherearr[] = "status IN(0,1)";

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
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1'); 




$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(

          array(

              'font' => array (

                  'bold' => true

              ),

              'alignment' => array(

                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

              )

          )

);


$objPHPExcel->getActiveSheet()->setCellValue('A1', ''.$editor.''.$thedaytimestart.'至'.$thedaytimeend.'基本工资明细');
$objPHPExcel->getActiveSheet()->mergeCells('A2:C2'); 
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); 

//背景色
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00b5f0');//设置第一行背景色为00b5f0
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '时间')
			->setCellValue('B2', '')
			->setCellValue('B2', '')
			->setCellValue('C2', '')
			->setCellValue('D2', '作者')
			->setCellValue('E2', '内容')
			->setCellValue('F2', '备注')
			->setCellValue('G2', '工资');




		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);














$i = '2';
foreach($threadlist as $list) {
$i++;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i.'', ''.date('Y年m月d日',($list['dateline']+25200)).'')
				->setCellValue('B'.$i.'', '（'.$weekarray[date('w',($list['dateline']+25200))].'）')
				->setCellValue('C'.$i.'', ''.date('H:i',($list['dateline']+25200)).'')
				->setCellValue('D'.$i.'', ''.$list['editor'].'')
				->setCellValue('E'.$i.'', ''.$list['message'].get_gongzi_status($list['message']).'')
				->setCellValue('F'.$i.'', '')
				->setCellValue('G'.$i.'', '');





		//设置文字字号
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i.'')->getFont()->setSize(9);


		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);






	if(strstr($list['message'],"请假")) {
		//背景色
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f50000');
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f50000');
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('F'.$i.'', '-工资');
	}
}

$yuangongqianzi_hang = $i+1;

//合并单元格 
$objPHPExcel->getActiveSheet()->mergeCells('A'.$yuangongqianzi_hang.':F'.$yuangongqianzi_hang.''); 

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
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$yuangongqianzi_hang.'')->applyFromArray(

           array(

               'borders' => array(

                   'allborders' => array(

                       'style' => PHPExcel_Style_Border::BORDER_THIN

                   )

               )

           )

);

//合并工资栏
$objPHPExcel->getActiveSheet()->mergeCells('G3:G'.$i.''); 

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');



header('Content-Disposition: attachment;filename="'.$editor.''.$thedaytimestart.'至'.$thedaytimeend.'工资明细_worklist-uid-'.$editorid.'-'.date('Ymd',$thedatelinestart).'-'.date('Ymd',$thedatelineend).'-'.$excelcode.'.xlsx"');
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