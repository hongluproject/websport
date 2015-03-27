<?php

namespace Controller\Admin\Area;

class Delete extends \Controller\Admin\Area
{
    public $data;
    public $path = array('area', 'area.list');
    public function get($id)
    {
        try
        {
            $acurl = new \Utils\Acurl();
            $result  = $acurl->setOption(array('method'=>'delete','class'=>'Area','objectId'=>$id))->getCurlResult();
            redirect('/admin/area/list');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}