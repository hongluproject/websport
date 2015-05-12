<?php

namespace Controller\Admin\Line;

class Delete extends \Controller\Admin\Line
{
    public $data;
    public $path = array('line', 'line.list');
    public function get($id)
    {
        try
        {
            $result = \Model\Line::find($id);
            $lineId= $result->lineId;
            $db = \Model\Line::db();
            $db->delete('delete  from  `ma_site` where `lineId`='.$lineId);
            $db->delete('delete  from  `ma_team` where `lineId`='.$lineId);
            $db->delete('delete  from  `ma_record` where `lineId`='.$lineId);

            $modelLine = new \Model\Line();
            $modelLine->delete($id);
            redirect('/admin/line');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}