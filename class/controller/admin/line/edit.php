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
            $line = \Model\Line::find($id);
            $line->set($data);
            $line->save();
        } else {
            $line = new \Model\Line();
            $line->set($data);
            $line->save();
        }
        redirect('/admin/line');
    }
}