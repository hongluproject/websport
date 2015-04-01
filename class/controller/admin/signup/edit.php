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
            $sign = \Model\Signup::find($id);
            $sign->set($data);
            $sign->save();
        } else {
            $sign = new \Model\Signup();
            $sign->set($data);
            $sign->save();
        }
        redirect('/admin/signup');
    }
}