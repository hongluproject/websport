<?php

namespace Controller\Admin\Team;
class Edit extends \Controller\Admin\Team
{
    public $data;
    public $path = array('team', 'team.edit');

    protected $_tpl = 'admin/team/edit';

    public function get($id)
    {


        $db = \Model\Line::db();
        $table = 'ma_line';
        $this->lineList= $db->fetch('select * from  `ma_line` ');
        if ($id) {
            $this->result = \Model\Team::find($id);
        } else {
            $this->result = array();

        }

    }

    public function post($id)
    {
        $data = $_POST;
        if ($id) {
            $team = \Model\Team::find($id);
            $team->set($data);
            $team->save();
        }else{
            $team = new \Model\Team();
            $team->set($data);
            $team->save();
        }
        redirect('/admin/team');

    }
}