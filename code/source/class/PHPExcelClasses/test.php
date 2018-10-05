<?php



//通过PHPExcel_IOFactory::load方法来载入一个文件，load会自动判断文件的后缀名来导入相应的处理类，读取格式保含xlsx/xls/xlsm/ods/slk/csv/xml/gnumeric
require_once 'PHPExcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load('test2.xlsx');
//吧载入的文件默认表（一般都是第一个）通过toArray方法来返回一个多维数组
$dataArray = $objPHPExcel->getActiveSheet()->toArray();
//读完直接写到一个xlsx文件里
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); //$objPHPExcel是上文中读的资源
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

miduo($dataArray);




function miduo($varmiduo) {
	global $_G;


		if(is_array($varmiduo) || $showmessage == "2") {
			$dateline = $_G['timestamp'];
			file_put_contents("./debug/var_$dateline.txt", var_export($varmiduo, true)); 
			//showmessage("该变量为数组，已帮您打印到【./debug/var_$dateline.txt】文件中!<br /><a href=./debug/var_$dateline.txt target=_blank>请点击前往查看>></a>");
		} elseif($showmessage == "1") {
			//showmessage($varmiduo);
		} elseif($showmessage == "3"){
			file_put_contents("./debug/var_$dateline.txt", var_export($varmiduo, true)); 	
		} elseif($showmessage == "noexit") {
			echo "<br />";
			echo "Debug出以下数据：";
			echo "<br />";
			echo "<pre>";
			print_r($varmiduo);
			echo "<br />";
		} else {
			echo "<br />";
			echo "Debug出以下数据：";
			echo "<br />";
			echo "<pre>";
			print_r($varmiduo);
			echo "<br />";
			exit;
		}
	

}
