<?php

namespace Controller\Admin\Site;
class Edit extends \Controller\Admin\Site
{
    public $data;
    public $path = array('site', 'site.edit');

    protected $_tpl = 'admin/site/edit';

    public function get($id)
    {
        if ($id) {
            $this->result = \Model\Site::find($id);
        } else {
            $this->result = array();

        }
    }

    public function post($id)
    {
        $data = $_POST;
        if ($id) {
            $site = \Model\Site::find($id);
            $site->set($data);
            $site->save();
        }else{
            $site = new \Model\Site();
            $site->set($data);
            $site->save();
        }
        redirect('/admin/site');

    }
}