<?php

namespace Controller\Admin\Signup;

class Delete extends \Controller\Admin\Signup
{
    public $data;
    public $path = array('signup', 'signup.list');
    public function get($id)
    {
        try
        {
            $result = new \Model\Signup();
            $result->delete($id);
            redirect('/admin/signup');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}