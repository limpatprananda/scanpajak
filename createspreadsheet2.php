<?php 
    $data = $_POST['data2'];        
    $data = json_decode($data, true);
        
    include '../PHPExcel/Classes/PHPExcel.php';
    $file_name = 'format_pm.xlsx';        

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
   
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'FM');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'KD_JENIS_TRANSAKSI');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'FG_PENGGANTI');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'NOMOR_FAKTUR');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'MASA_PAJAK');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'TAHUN_PAJAK');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'TANGGAL_FAKTUR');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'NPWP');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'NAMA');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'ALAMAT_LENGKAP');
    $objPHPExcel->getActiveSheet()->setCellValue('K1', 'JUMLAH_DPP');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'JUMLAH_PPN');
    $objPHPExcel->getActiveSheet()->setCellValue('M1', 'JUMLAH_PPNBM');
    $objPHPExcel->getActiveSheet()->setCellValue('N1', 'IS_CREDITABLE');    
    
    $masa_pajak = date('n') . '';
    $tahun_pajak = date('Y') . '';
    $is_creditable = 1;
    $counter = 2;
    
    foreach($data as $detail){
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'FM');
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $counter, $detail['kdJenisTransaksi'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $counter, $detail['fgPengganti'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . $counter, $detail['nomorFaktur'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $counter, $masa_pajak);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $counter, $tahun_pajak);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $counter, $detail['tanggalFaktur']);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $counter, $detail['npwpPenjual'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I' . $counter, $detail['namaPenjual'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('J' . $counter, $detail['alamatPenjual'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('K' . $counter, $detail['jumlahDpp'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('L' . $counter, $detail['jumlahPpn'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('M' . $counter, $detail['jumlahPpnBm'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('N' . $counter, $is_creditable);        
        $counter++;                
    }        

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Disposition: attachment; filename="' . $file_name. '"');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);        
    $objWriter->save('php://output');
    $objPHPExcel->disconnectWorksheets();                     
    unset($objPHPExcel);
?>