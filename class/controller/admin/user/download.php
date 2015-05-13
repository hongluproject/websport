<?php

namespace Controller\Admin\User;

class Download extends \Controller\Admin\User
{
    public $data;
    public $path = array('user', 'download');
    protected $_tpl = 'admin/user/download';

    public function get()
    {


    }


    public function post()
    {
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        /** Include PHPExcel */
        include(SP . "class/utils/phpexcel/PHPExcel.php");

// Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();

// Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '用户名')
            ->setCellValue('B1', '密码');

        $db = \Model\Line::db();
        $userArray = $db->fetch('select * from `user` where `level` =1 OR `level` =2  ');
        foreach ($userArray as $key => $item) {
            $userName = 'A' . ($key + 2);
            $userPass = 'B' . ($key + 2);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($userPass, substr(md5($item->username),0,6));
            $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit($userName,$item->username,\PHPExcel_Cell_DataType::TYPE_STRING);

        }

// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('人员列表');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="点长线长用户名密码.xls"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;


    }


}