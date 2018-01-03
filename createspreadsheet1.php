<?php 
    $data = $_POST['data1'];    
    $data = json_decode($data, true);
    
    include '../PHPExcel/Classes/PHPExcel.php';
    $file_name = 'export_table.xlsx';        

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()
        ->setCreator("Aplikasi Scan Pajak BJTIPORT")
        ->setLastModifiedBy("Aplikasi Scan Pajak BJTIPORT")
        ->setTitle("CSV Generate auto by Scan Pajak BJTIPORT")
        ->setSubject("CSV Generate auto by Scan Pajak BJTIPORT")
        ->setDescription(
            "CSV Generate auto by Scan Pajak BJTIPORT"
        )
        ->setKeywords("Scan Pajak BJTIPORT")
        ->setCategory("BJTIPORT");    
   
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'NO');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'NPWP');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'PENJUAL');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'ALAMAT PENJUAL');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'FAKTUR');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'TANGGAL FAKTUR');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'JUMLAH DPP');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'JUMLAH PPN');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'STATUS');
    
    $counter = 2;
    foreach($data as $detail){
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, ($counter - 1));
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $counter, $detail['npwpPenjual'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $detail['namaPenjual']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $detail['alamatPenjual']);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $counter, $detail['kdJenisTransaksi'] . $detail['fgPengganti']. $detail['nomorFaktur'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $detail['tanggalFaktur']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $detail['jumlahDpp']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $detail['jumlahPpn']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $detail['statusApproval']);
        $counter++;
    }        

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Disposition: attachment; filename="' . $file_name. '"');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);        
    $objWriter->save('php://output');
    $objPHPExcel->disconnectWorksheets();                     
    unset($objPHPExcel);
?>