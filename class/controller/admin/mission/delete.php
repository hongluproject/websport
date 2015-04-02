<?php

namespace Controller\Admin\Member;

class Delete extends \Controller\Admin\Mission
{
    public $data;
    public $path = array('mission', 'mission.list');
    public function get($id)
    {
        try
        {
            $result = new \Model\Mission();
            $result->delete($id);
            redirect('/admin/mission');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}