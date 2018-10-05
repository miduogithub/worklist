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































$query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE projectid='$projectid'");	
$projectinfo = DB::fetch($query);


$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE uid='$editorid'");	
$memberinfo = DB::fetch($query);

$organizationlist = get_organizationlist();
//获取任务类型
$typelist = get_typelist();










$wherearr[] = "projectid = ".$projectid."";


if($view == 'ing') {

	$viewtips = '（进行中）';
	$wherearr[] = "status = '0'";

} else {
	$viewtips = '';
}


$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';

if(empty($count)) {
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission')." $wheresql"), 0);
}

$myprojectlist = array();
$indexlist = array();
$missionlist = array();

$query = DB::query("SELECT * FROM ".DB::table('work_project_mission')." $wheresql ORDER BY status ASC,missionstarttimeline DESC $LIMIT");	
while ($value = DB::fetch($query)) {

	$tasklistcount = '';
	$tasklistcount = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('work_project_mission_tasklist')." WHERE missionid='$value[missionid]'"), 0);
	
	$tasklist = get_mission_tasklist_by_missionid($value['missionid']);
	





	$missionlist['tasklist'] = $tasklist; 
	$missionlist['tasklistcount'] = $tasklistcount; 

	
	if(!empty($memberlist[$value['editorid']]['headimgurl'])) {

		$value['avatar'] = $memberlist[$value['editorid']]['headimgurl'];	

	} else {

		$value['avatar'] = avatar($value['uid'], 'middle', true);
	}
	
	if($value['status'] == '1') {

		$missionlist['favicon'] = 'mui-badge mui-badge-danger';

	} else {

		$missionlist['favicon'] = 'mui-badge mui-badge-success';
	}


	if($value['status'] == '1') {
		$missionlist['status_excel'] = '完成';
	} else {
		$missionlist['status_excel'] = '';
	}


	$missionlist['id'] = $value['missionid'];
	$missionlist['post_id'] = $value['missionid'];
	$missionlist['title'] = $value['missionname'];
	$missionlist['author_name'] = $value['editor'];
	$missionlist['cover'] = $value['avatar'];
	$missionlist['published_at'] = date("Y-m-d H:i:s", $value['missionstarttimeline']); 
	$missionlist['typename'] = $typelist[$value['projecttypeid']]['typename'];
	$missionlist['missiontime'] = preg_replace("/\&nbsp;/", "", date("m-d", $value['missionstarttimeline']));
	$missionlist['missionstarttimeline'] = $value['missionstarttimeline'];


	//$missionlist[] = $value;
	$missionlist_json['missionlist'][] = $missionlist;

}
if(empty($missionlist_json['missionlist'])) {
	
	$missionlist_json['missionlist']['0']['author_name'] = $memberinfo['username'];
	$missionlist_json['missionlist']['0']['title'] = '请添加新任务…';
	$missionlist_json['missionlist']['0']['missiontime'] = '暂无任务';
	$missionlist_json['missionlist']['0']['typename'] = '暂无任务';
	$missionlist_json['missionlist']['0']['cover'] = avatar($editorid, 'middle', true);

}
$missionlist_json['porjectinfo'] = $projectinfo;




$missionlist = $missionlist_json['missionlist'];












//miduo($Projectcountstatus0_threadlist_favicon_1);
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
$objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); 


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

$objPHPExcel->getActiveSheet()->setCellValue('A1', ''.$editor.'的「'.$missionlist_json['porjectinfo']['projectname'].'」项目明细'.$viewtips);

$objPHPExcel->getActiveSheet()->setCellValue('A2', '');

//文字字号
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18); 
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

$objPHPExcel->getActiveSheet()->mergeCells('D'.$print_time_hang.':F'.$print_time_hang.''); 
$objPHPExcel->getActiveSheet()->setCellValue('D'.$print_time_hang.'', 'PrintTime：'.$thistimeHis.'');

		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('D'.$print_time_hang.'')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('D'.$print_time_hang.'')->getFont()->setBold(true);  

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('D'.$print_time_hang.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('D'.$print_time_hang.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);



//背景色
$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00b5f0');//设置第一行背景色为00b5f0
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', '序号')
			->setCellValue('B3', '类型')
			->setCellValue('C3', '名称')
			->setCellValue('D3', '负责人')
			->setCellValue('E3', '时间')
			->setCellValue('F3', '状态');


		//文字字号
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setSize(9);

		//文字加粗
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);  
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);

		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);










$i = '3';
$j = '0';
foreach($missionlist as $list) {

	$i++;
	$j++;
	

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i.'', ''.$j.'')
				->setCellValue('B'.$i.'', ''.$list['typename'].'')
				->setCellValue('C'.$i.'', ''.$list['title'].'')
				->setCellValue('D'.$i.'', ''.$list['author_name'].'')
				->setCellValue('E'.$i.'', ''.date('m月d日',($list['missionstarttimeline']+25200)).'')
				->setCellValue('F'.$i.'', ''.$list['status_excel'].'');




		


		//设置文字字号
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getFont()->setSize(9);


		//文字左右居中
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		//文字垂直方向上中间居中  
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


		

		if($list['status_excel'] == '完成') {
			$objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getFont()->setStrikethrough(true); // 删除线
		}

		









			
		if(!empty($list['tasklist'])) {
			
			$l = $i;
			$m = '0';
			foreach($list['tasklist'] as $tlist) {
				$l++;
				$m++;
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$l.'', '')
							->setCellValue('B'.$l.'', '')
							->setCellValue('C'.$l.'', ''.$m.'、'.$tlist['taskname_for_excel'].'')
							->setCellValue('D'.$l.'', '')
							//->setCellValue('E'.$l.'', ''.date('m月d日',($tlist['dateline']+25200)).'')
							->setCellValue('E'.$l.'', '')
							->setCellValue('F'.$l.'', ''.$tlist['status_excel'].'');	

							//设置文字字号
							$objPHPExcel->getActiveSheet()->getStyle('A'.$l.'')->getFont()->setSize(9);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$l.'')->getFont()->setSize(9);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$l.'')->getFont()->setSize(9);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$l.'')->getFont()->setSize(9);
							$objPHPExcel->getActiveSheet()->getStyle('E'.$l.'')->getFont()->setSize(9);
							$objPHPExcel->getActiveSheet()->getStyle('F'.$l.'')->getFont()->setSize(9);


							//文字左右居中
							$objPHPExcel->getActiveSheet()->getStyle('A'.$l.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$l.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$l.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$l.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('E'.$l.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('F'.$l.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


							//文字垂直方向上中间居中  
							$objPHPExcel->getActiveSheet()->getStyle('A'.$l.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$l.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$l.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$l.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('E'.$l.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('F'.$l.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);							


							if($tlist['status_excel'] == '完成') {
								$objPHPExcel->getActiveSheet()->getStyle('C'.$l.'')->getFont()->setStrikethrough(true); // 删除线
							}

			
			}

			$i = $i + $list['tasklistcount'];
		}
	
		



}




$count_hang = $i;
//加边框	  
$objPHPExcel->getActiveSheet()->getStyle('A3:F'.$count_hang.'')->applyFromArray(

           array(

               'borders' => array(

                   'allborders' => array(

                       'style' => PHPExcel_Style_Border::BORDER_THIN

                   )

               )

           )

);




/*

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










header('Content-Disposition: attachment;filename="'.$editor.'的「'.$missionlist_json['porjectinfo']['projectname'].'」项目明细_quickproject_username_'.$editor.'_uid_'.$editorid.'_dateline_'.$excelcode.'.xlsx"');
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