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






if($_G['adminid'] != '1') {
	$wherearr[] = "editorid = ".$_G['uid']."";
}

if(!empty($editorid)) {
	//$wherearr[] = "editorid = ".$editorid."";
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

$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." $wheresql ORDER BY dateline ASC");
while ($value = DB::fetch($query)) {
	$threadlist[] = $value; 
}


$timecha = $thedatelineend - $thedatelinestart;

$thedaytimestart = date('Y年m月d日',$thedatelinestart);
$thedaytimeend = date('Y年m月d日',$thedatelineend);


$thistimeHis = date('Y-m-d H:i:s');

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
$objPHPExcel->getActiveSheet()->mergeCells('A1:D1'); 




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

$week0 = '';
$week0 = date('w',$thedatelineend);

if($timecha <= 86400) {

	$objPHPExcel->getActiveSheet()->setCellValue('A1', ''.$editor.'的'.$thedaytimestart.'（周'.$weekarray[$week0].'）工作日志');

} else {

	$objPHPExcel->getActiveSheet()->setCellValue('A1', ''.$editor.''.$thedaytimestart.'至'.$thedaytimeend.'工作日志');
}


$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); 





//第二行
$print_time_hang = 2;

$objPHPExcel->getActiveSheet()->mergeCells('C'.$print_time_hang.':D'.$print_time_hang.''); 
$objPHPExcel->getActiveSheet()->setCellValue('C'.$print_time_hang.'', 'PrintTime：'.$thistimeHis.'');

		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('C'.$print_time_hang.'')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('C'.$print_time_hang.'')->getFont()->setBold(true);  

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('C'.$print_time_hang.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('C'.$print_time_hang.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);






//背景色
$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00b5f0');//设置第一行背景色为00b5f0
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', '时间')
			->setCellValue('B3', '作者')
			->setCellValue('C3', '内容')
			->setCellValue('D3', '备注');



		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);






$i = '3';
foreach($threadlist as $list) {
$i++;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i.'', ''.date('H:i',($list['dateline']+25200)).'')
				->setCellValue('B'.$i.'', ''.$list['editor'].'')
				->setCellValue('C'.$i.'', ''.$list['message'].'')
				->setCellValue('D'.$i.'', '');




		//设置文字字号
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getFont()->setSize(9);


		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

}




//加边框	  
$objPHPExcel->getActiveSheet()->getStyle('A3:D'.$i.'')->applyFromArray(

           array(

               'borders' => array(

                   'allborders' => array(

                       'style' => PHPExcel_Style_Border::BORDER_THIN

                   )

               )

           )

);

 

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');



header('Content-Disposition: attachment;filename="'.$editor.''.$thedaytimestart.'至'.$thedaytimeend.'日程_worklist-uid-'.$editorid.'-'.date('Ymd',$thedatelinestart).'-'.date('Ymd',$thedatelineend).'-'.$excelcode.'.xlsx"');
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


?>