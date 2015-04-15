<?php
namespace Controller\Front\Sport;

class Userinfo extends \Controller\Front
{

    protected $_tpl = 'front/sport/userinfo';

    public function get()
    {


        $this->result  = $_GET['phone'];

    }

    public function post()
    {

    }
}

