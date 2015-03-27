<?php

namespace Controller\Admin\Cate;

class Delete extends \Controller\Admin\Cate
{
    public $data;
    public $path = array('cate', 'cate.list');
    public function get($id)
    {
        try
        {
            $acurl = new \Utils\Acurl();
            $result  = $acurl->setOption(array('method'=>'delete','class'=>'Cate','objectId'=>$id))->getCurlResult();
            redirect('/admin/cate/list');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}