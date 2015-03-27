<?php

namespace Controller\Admin\Tag;

class Delete extends \Controller\Admin\Tag
{
    public $data;
    public $path = array('tag', 'tag.list');
    public function get($id)
    {
        try
        {
            $acurl = new \Utils\Acurl();
            $result  = $acurl->setOption(array('method'=>'post','class'=>'Tag','objectId'=>$id,'field'=>array('status'=>2)))->getCurlResult();
            redirect('/admin/tag/list');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}