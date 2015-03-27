<?php

namespace Controller\Admin\Clan;

class Delete extends \Controller\Admin\Clan
{
    public $data;
    public $path = array('clan', 'clan.list');
    public function get($id)
    {
        try
        {
            $acurl = new \Utils\Acurl();
            $result  = $acurl->setOption(array('method'=>'delete','class'=>'Tag','objectId'=>$id))->getCurlResult();
            redirect('/admin/tag/list');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}