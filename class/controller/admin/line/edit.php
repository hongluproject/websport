<?php

namespace Controller\Admin\Line;
class Edit extends \Controller\Admin\Line
{
    public $data;
    public $path = array('line', 'line.edit');
    protected $_tpl = 'admin/line/edit';
    public function get($id)
    {
        if ($id) {
            $this->result = \Model\Line::find($id);
        } else {
            $this->result = array();
        }
    }

    public function post($id)
    {
        $data = $_POST;
        if ($id) {
            $member = \Model\Line::find($id);
            $member->set($data);
            $member->save();
        } else {
            $member = new \Model\Line();
            $member->set($data);
            $member->save();
        }
        redirect('/admin/line');
    }
}