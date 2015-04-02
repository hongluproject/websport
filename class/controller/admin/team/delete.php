<?php

namespace Controller\Admin\Member;

class Delete extends \Controller\Admin\Team
{
    public $data;
    public $path = array('team', 'team.list');
    public function get($id)
    {
        try
        {
            $result = new \Model\Team();
            $result->delete($id);
            redirect('/admin/team');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}