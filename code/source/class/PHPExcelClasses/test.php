<?php



//ͨ��PHPExcel_IOFactory::load����������һ���ļ���load���Զ��ж��ļ��ĺ�׺����������Ӧ�Ĵ����࣬��ȡ��ʽ����xlsx/xls/xlsm/ods/slk/csv/xml/gnumeric
require_once 'PHPExcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load('test2.xlsx');
//��������ļ�Ĭ�ϱ�һ�㶼�ǵ�һ����ͨ��toArray����������һ����ά����
$dataArray = $objPHPExcel->getActiveSheet()->toArray();
//����ֱ��д��һ��xlsx�ļ���
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); //$objPHPExcel�������ж�����Դ
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

miduo($dataArray);




function miduo($varmiduo) {
	global $_G;


		if(is_array($varmiduo) || $showmessage == "2") {
			$dateline = $_G['timestamp'];
			file_put_contents("./debug/var_$dateline.txt", var_export($varmiduo, true)); 
			//showmessage("�ñ���Ϊ���飬�Ѱ�����ӡ����./debug/var_$dateline.txt���ļ���!<br /><a href=./debug/var_$dateline.txt target=_blank>����ǰ���鿴>></a>");
		} elseif($showmessage == "1") {
			//showmessage($varmiduo);
		} elseif($showmessage == "3"){
			file_put_contents("./debug/var_$dateline.txt", var_export($varmiduo, true)); 	
		} elseif($showmessage == "noexit") {
			echo "<br />";
			echo "Debug���������ݣ�";
			echo "<br />";
			echo "<pre>";
			print_r($varmiduo);
			echo "<br />";
		} else {
			echo "<br />";
			echo "Debug���������ݣ�";
			echo "<br />";
			echo "<pre>";
			print_r($varmiduo);
			echo "<br />";
			exit;
		}
	

}
