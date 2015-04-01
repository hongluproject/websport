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
            $member = \Model\Site::find($id);
            $member->set($data);
            $member->save();
        }else{
            $member = new \Model\Site();
            $member->set($data);
            $member->save();
        }
        redirect('/admin/site');

    }
}