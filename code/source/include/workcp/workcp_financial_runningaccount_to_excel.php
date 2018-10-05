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
$view = getgpc('view');
$editorid = getgpc('editorid');
$projectid = getgpc('projectid');


$editor = '';
$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE uid='$editorid' ");
while ($value = DB::fetch($query)) {
	$editor = $value['username']; 
}










	$wherearr = array();

	if($_G['adminid'] != '1') {

		showmessage("您无权使用该模块");
	}


	//按照年份查看
	if(!empty($checkyear)) {

		$startyeartime = $checkyear."-01-01 00:00:00";
		$endyeartime = $checkyear."-12-31 23:59:59";

		$startyeardateline = strtotime($startyeartime);
		$endyeardateline = strtotime($endyeartime);

		$wherearr[] = "runtimeline >= $startyeardateline";
		$wherearr[] = "runtimeline <= $endyeardateline";
	}




	$startcheckdateline = getgpc('startcheckdateline');
	$endcheckdateline = getgpc('endcheckdateline');




	$star_checktime = date('Y年m月d日',$startcheckdateline);
	$end_checktime = date('Y年m月d日',$endcheckdateline);






	$wherearr[] = "runtimeline >= '$startcheckdateline'";
	$wherearr[] = "runtimeline <= '$endcheckdateline'";







	$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

	if(empty($count)) {
		$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_financial_running_account')." $wheresql"), 0);
		$work_financial_project_mission_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_financial_running_account')." $wheresql AND type='work_financial_project_mission'"), 0);
		$work_project_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_financial_running_account')." $wheresql AND type='work_project'"), 0);





		$work_financial_running_account_income_count = DB::result(DB::query("SELECT sum(income) FROM ".DB::table('work_financial_running_account')." $wheresql"), 0);
		$work_financial_running_account_payout_count = DB::result(DB::query("SELECT sum(payout) FROM ".DB::table('work_financial_running_account')." $wheresql"), 0);
	}




	$work_financial_project_mission_count_payout = '0';
	$work_project_count_income = '0';

	$query = DB::query("SELECT * FROM ".DB::table('work_financial_running_account')." $wheresql ORDER BY runtimeline ASC");
	while ($value = DB::fetch($query)) {
		
		if($value['type'] == 'work_financial_project_mission') {

			$work_financial_project_mission_count_payout = $value['payout'] + $work_financial_project_mission_count_payout;
		}

		if($value['type'] == 'work_project') {
			$work_project_count_income = $value['income'] + $work_project_count_income;
		}


		$threadlist[] = $value; 
	}












$todaytime = date('Y年m月d日');
$thistimeHis = date('Y-m-d H:i:s');
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


/*

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

*/

$objPHPExcel->getActiveSheet()->setCellValue('A1', ''.$editor.'的「'.$star_checktime.'~'.$end_checktime.'」流水明细');


//文字字号
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); 
//文字左右居中
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//文字垂直方向上中间居中  
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//文字加粗
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);  






//$objPHPExcel->getActiveSheet()->setCellValue('E2', '甲方单位：'.$organizationlist[$projectinfo['Organizationid']]['Organizationname'].'');


//添加打印时间

//最后一行
//$print_time_hang = $count_hang + 2;

//第二行
$print_time_hang = 2;

$objPHPExcel->getActiveSheet()->mergeCells('E'.$print_time_hang.':G'.$print_time_hang.''); 
$objPHPExcel->getActiveSheet()->setCellValue('E'.$print_time_hang.'', 'PrintTime：'.$thistimeHis.'');

		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('E'.$print_time_hang.'')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('E'.$print_time_hang.'')->getFont()->setBold(true);  

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('E'.$print_time_hang.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('E'.$print_time_hang.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);



//背景色
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00b5f0');//设置第一行背景色为00b5f0
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', '序号')
			->setCellValue('B3', '时间')
			->setCellValue('C3', '对方科目')
			->setCellValue('D3', '付款方')
			->setCellValue('E3', '摘要')
			->setCellValue('F3', '收入')
			->setCellValue('G3', '支出');


		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);






$i = '3';
$j = '0';
foreach($threadlist as $list) {

	$i++;
	$j++;
	

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i.'', ''.$j.'')
				->setCellValue('B'.$i.'', ''.date('Y-m-d',($list['runtimeline']+25200)).'')
				->setCellValue('C'.$i.'', ''.$list['typename'].'')
				->setCellValue('D'.$i.'', ''.$list['payer'].'')
				->setCellValue('E'.$i.'', ''.str_replace(array("\r\n", "\r", "\n"), "", $list['runname']).'')
				->setCellValue('F'.$i.'', ''.$list['income'].'')
				->setCellValue('G'.$i.'', ''.$list['payout'].'');


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
		//$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
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





}



$count_hang = $i;
//加边框	  
$objPHPExcel->getActiveSheet()->getStyle('A3:G'.$count_hang.'')->applyFromArray(

           array(

               'borders' => array(

                   'allborders' => array(

                       'style' => PHPExcel_Style_Border::BORDER_THIN

                   )

               )

           )

);




//合计

$yuangongqianzi_hang = $i+1;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$yuangongqianzi_hang.'', '合计：');



//设置文字字号
$objPHPExcel->getActiveSheet()->getStyle('A'.$yuangongqianzi_hang.'')->getFont()->setSize(9);


//文字左右居中
$objPHPExcel->getActiveSheet()->getStyle('A'.$yuangongqianzi_hang.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//文字垂直方向上中间居中  
$objPHPExcel->getActiveSheet()->getStyle('A'.$yuangongqianzi_hang.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	










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




//加边框	  
$objPHPExcel->getActiveSheet()->getStyle('A'.$yuangongqianzi_hang.':G'.$yuangongqianzi_hang.'')->applyFromArray(

           array(

               'borders' => array(

                   'allborders' => array(

                       'style' => PHPExcel_Style_Border::BORDER_THIN

                   )

               )

           )

);


$objPHPExcel->getActiveSheet()->setCellValue('F'.$yuangongqianzi_hang.'', $work_financial_running_account_income_count);


//设置文字字号
$objPHPExcel->getActiveSheet()->getStyle('F'.$yuangongqianzi_hang.'')->getFont()->setSize(9);


//文字左右居中
$objPHPExcel->getActiveSheet()->getStyle('F'.$yuangongqianzi_hang.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//文字垂直方向上中间居中  
$objPHPExcel->getActiveSheet()->getStyle('F'.$yuangongqianzi_hang.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	


$objPHPExcel->getActiveSheet()->setCellValue('G'.$yuangongqianzi_hang.'', $work_financial_running_account_payout_count);





//设置文字字号
$objPHPExcel->getActiveSheet()->getStyle('G'.$yuangongqianzi_hang.'')->getFont()->setSize(9);


//文字左右居中
$objPHPExcel->getActiveSheet()->getStyle('G'.$yuangongqianzi_hang.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//文字垂直方向上中间居中  
$objPHPExcel->getActiveSheet()->getStyle('G'.$yuangongqianzi_hang.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);							




// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');




header('Content-Disposition: attachment;filename="'.$editor.'的「'.$star_checktime.'~'.$end_checktime.'」流水明细_work_financial_runningaccount_uid_'.$editorid.'_dateline_'.$excelcode.'.xlsx"');
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