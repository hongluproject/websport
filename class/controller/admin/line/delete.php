<?php

namespace Controller\Admin\Member;

class Delete extends \Controller\Admin\Member
{
    public $data;
    public $path = array('member', 'member.list');
    public function get($id)
    {
        try
        {

            $result = new \Model\Member();
            $result->delete($id);
            redirect('/admin/member');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}