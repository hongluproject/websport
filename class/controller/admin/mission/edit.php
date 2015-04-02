<?php

namespace Controller\Admin\Mission;
class Edit extends \Controller\Admin\Mission
{
    public $data;
    public $path = array('mission', 'mission.edit');

    protected $_tpl = 'admin/mission/edit';

    public function get($id)
    {
        if ($id) {
            $this->result = \Model\Mission::find($id);
        } else {
            $this->result = array();

        }

    }

    public function post($id)
    {
        $data = $_POST;
        if ($id) {
            $mission = \Model\Mission::find($id);
            $mission->set($data);
            $mission->save();
        }else{
            $mission = new \Model\Mission();
            $mission->set($data);
            $mission->save();
        }
        redirect('/admin/mission');

    }
}