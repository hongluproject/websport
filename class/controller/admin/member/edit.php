<?php

namespace Controller\Admin\Member;
class Edit extends \Controller\Admin\Member
{
    public $data;
    public $path = array('member', 'member.edit');

    protected $_tpl = 'admin/member/edit';

    public function get($id)
    {
        if ($id) {
            $this->result = \Model\Member::find($id);
        } else {
            $this->result = array();

        }

    }

    public function post($id)
    {



        $file_dir = $_FILES['memberExcel']['tmp_name'];
        if($file_dir){
            $db = \Model\Line::db();
            $table = 'ma_team';
            $db->delete('delete  from  `ma_team` ');

            //上传
         //   $file_dir =  SP . "public/assets/test.xls";
            $result = $this->importExcel($file_dir);
            unset($result[0]);
            unset($result[1]);
            unset($result[2]);
            unset($result[3]);
            foreach($result as $item){
                $param = array();
                if(!$item[7]){
                    continue;
                }
                $team = new \Model\Team();
                $param['lineId']= $item[7];
                $param['status']=  1;
                $param['teamId']= $item[5];
                $param['teamName']= $item[3];
                $param['teamLeader']= $item[4];
                $param['phone']= $item[6];
                $team->set($param);
                $team->save();
            }
        }
        redirect('/admin/team');

        /*
            $data = $_POST;
            if ($id) {
                $member = \Model\Member::find($id);
                $member->set($data);
                $member->save();
            }else{
                $member = new \Model\Member();
                $member->set($data);
                $member->save();
            }*/
    }

    function importExcel($file)
    {

        include(SP . "class/utils/phpexcel/PHPExcel.php");
        include(SP . "class/utils/phpexcel/PHPExcel/IOFactory.php");
        include(SP . "class/utils/phpexcel/PHPExcel/Reader/Excel5.php");
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
        $objPHPExcel = $objReader->load($file);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }

//用法：
}