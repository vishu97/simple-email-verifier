<?php
	
	
	session_start();
	
	$file_name="";
	
	function varify($email,$index)
	{
		$url="https://trumail.io/json/";
		
		global $file_name;
		$url.=$email;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$output = curl_exec($ch);

		curl_close($ch);
		
		$data=json_decode($output);
		
	$objPHPExcel = PHPExcel_IOFactory::load($file_name);
	$objPHPExcel->setActiveSheetIndex(0);
	$row = $objPHPExcel->getActiveSheet()->getHighestRow();
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$index,$data->address);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$index,$data->username);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$index,$data->domain);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$index,$data->hostExists);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$index,$data->deliverable);
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$index,$data->fullInbox);
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$index,$data->catchAll);
	$objPHPExcel->getActiveSheet()->SetCellValue('H'.$index,$data->disposable);
	$objPHPExcel->getActiveSheet()->SetCellValue('I'.$index,$data->gravatar);
	
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
	$objWriter->save($file_name);
	
	
	
	}
	
	
	function create_file()
	{
		global $file_name;
		
		$handle=fopen($file_name, 'w');
		
		fclose($handle);
		
	}
	
	
	
	require_once('PHPExcel/Classes/PhpExcel.php');
	
	
	$objPHPExcel = PHPExcel_IOFactory::load($_FILES["emails"]["tmp_name"]);
	$objPHPExcel->setActiveSheetIndex(0);
	$row = $objPHPExcel->getActiveSheet()->getHighestRow();
	
    
	for($a=0;$a<$row;$a++)
	{
		
		if($a==0)
		{
		
		$file_name=time().'.csv';
		create_file();
		
		
		}
		$b=$a+1;
		$email=$objPHPExcel->getActiveSheet()->getCell('A'.$b)->getValue();
		
		
		varify(trim($email),$a+1);
		sleep(2);
		
		$_SESSION['file']=$file_name;
		
		header('Location:download.php');
	}
	
	 



?>