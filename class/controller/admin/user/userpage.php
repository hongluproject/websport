<?php

namespace Controller\Admin\User;

class Userpage extends \Controller\Admin\User
{
	public $data;
	public $path = array('user', 'userpage');

	protected $_tpl = 'admin/user/userpage';
	public static $belongs_to = array(
			'user' => '\Model\User',
	);
    public function get()
    {
    	$this->data = \Model\Useradd::fetch();

    }


}