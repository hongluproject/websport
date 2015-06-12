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
        //todo   important  now siteNum = '55782dfae4b0f8165ff084fb';
        $objectId = '55782dfae4b0f8165ff084fb';
        $file_dir = $_FILES['memberExcel']['tmp_name'];
        if($file_dir){
            $db = \Model\Line::db();
            $db->delete('delete  from  `ma_team`  where `objectId` = "'.$objectId.'"');
            $db->delete('delete  from  `ma_member` where `objectId` = "'.$objectId.'"');
            $db->delete('delete  from  `ma_record` where `objectId` = "'.$objectId.'"');
            $result = $this->importExcel($file_dir);
            unset($result[0]);
            unset($result[1]);
            foreach($result as $item){
                $param = array();
                if(!$item[7]){
                    continue;
                }
                if(strlen($item[6])!=11&&$item[6]!=''){
                    $item[6] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$item[6]);
                }
                $item[7] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$item[7]);
                $item[2] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$item[2]);
                $param['lineId']= $item[7];
                $param['status']=  1;
                $param['teamId']= $item[2];
                $param['teamName']= $item[3];
                $param['teamLeader']= $item[4];
                $param['phone']= $item[6];
                $param['objectId']= $objectId;
                if(substr($item[5],-1) == 1){
                    //队长
                    $team = new \Model\Team();
                    $team->set($param);
                    $team->save();
                }
            }

            foreach($result as $key=>$item){
                $param = array();
                if(!$item[7]){
                    continue;
                }
                if(strlen($item[6])!=11&&$item[6]!=''){
                    $item[6] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$item[6]);
                }
                $item[7] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$item[7]);
                $item[2] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$item[2]);
                $param['lineId']= $item[7];
                $param['status']=  1;
                $param['userName']= $item[4];
                $param['userId']= $item[5];
                $param['teamId']= $item[2];
                $param['teamName']= $item[3];
                $param['phone']= $item[6];
                $param['objectId']= $objectId;
                //队员入库
                $member = new \Model\Member();
                $member->set($param);
                $member->save();
            }
        }
        redirect('/admin/team');
    }

    function importExcel($file)
    {
        //处理excel
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

}