<?php

namespace Controller\Admin\Signup;
class Edit extends \Controller\Admin\Signup
{
    public $data;
    public $path = array('signup', 'signup.edit');
    protected $_tpl = 'admin/signup/edit';
    public function get($id)
    {
        if ($id) {
            $this->result = \Model\Signup::find($id);
        } else {
            $this->result = array();
        }
    }

    public function post($id)
    {
        $data = $_POST;
        if ($id) {
            $line = \Model\Signup::find($id);
            $line->set($data);
            $line->save();
        } else {
            $line = new \Model\Signup();
            $line->set($data);
            $line->save();
        }
        redirect('/admin/signup');
    }
}