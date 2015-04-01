<?php

namespace Controller\Admin\Member;

class Delete extends \Controller\Admin\Site
{
    public $data;
    public $path = array('site', 'site.list');
    public function get($id)
    {
        try
        {
            $result = new \Model\Site();
            $result->delete($id);
            redirect('/admin/site');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}