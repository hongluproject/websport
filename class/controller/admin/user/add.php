<?php

namespace Controller\Admin\User;

class Add extends \Controller\Admin\User
{
    public $data;
    public $path = array('user', 'add');
    protected $_tpl = 'admin/user/add';

    public function get()
    {
    	$this->data = \Model\User::fetch();
    	$type = $_GET['type'];
    	$id = $_GET['id'];
    	$db = \Model\Useradd::db();
    	$table = 'user';
    	$row = $db->fetch('select * from `'.$table.'` where `id` = "'.$id.'"');
    	if ($type == 'edit'){
    		$this->result = $row[0];

    	}elseif ($type=='delete'){
    		if ($id){
    			$db->delete('delete  from `'.$table.'` where `id` = "'.$id.'"');
    		}
    		redirect('/admin/user/page');

    	}else{

    	}

    }


    public function post(){
    	$user_name  =  $id='';
    	$user_name = $_POST['username'];
    	$password = $_POST['password'];
    	$id = $_POST['id'];
    	$db = \Model\Useradd::db();
    	$table = 'user';
    	if ($id){
    		try
    		{
    			$match = \Model\Useradd::find($id);
    			$data = $_POST;
    			unset($data['id']);
    			$match->set($data);
    		    $match->save();
    		}
    		catch (\Exception $e)
    		{
    			$this->showError($e->getMessage());
    		}

    	}else{
    		$row = $db->fetch('select * from `'.$table.'` where `username` = "'.$user_name.'"');
    		if (empty($row)){
    			\Model\Useradd::create(array('username'=>$user_name,'password'=>md5($password),'status'=>1));
    			echo "添加成功";
    		}
    	}
    	redirect('/admin/user/page');


    }
}