<?php

namespace Controller\Admin\Site;

class Delete extends \Controller\Admin\Site
{
    public $data;
    public $path = array('site', 'site.list');
    public function get($id)
    {
        try
        {


            $site = \Model\Site::find($id);
            $before_line = \Model\Line::find(array('lineId'=>$site->lineId));
            $before_line->set(array('siteNum'=>$before_line->siteNum-1));
            $before_line->save();

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