<?php

namespace Controller\Admin\Session;

class Login extends \Controller\Admin\Session
{
    protected $_tpl = 'admin/session/login';
    protected $_login = false;

    public function get()
    {
        if ($this->user)
        {
            redirect('/admin');
        }
    }

    public function post(){
        $user = \Model\User::find(array('username' => $_POST['username'],'password'=>md5($_POST['password'])));
        if($user){
            if (in_array($user->username, config('cas.admin')))
            {
                $user->admin = 1;
                $user->status = 1;
            }
            $_SESSION['user_id'] = $user->id;
        }
        redirect('/admin');

    }

}