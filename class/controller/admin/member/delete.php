<?php

namespace Controller\Admin\Member;

class Delete extends \Controller\Admin\Member
{
    public $data;
    public $path = array('member', 'member.list');
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