<?php

namespace Controller\Admin;

class System extends \Controller\Admin
{
    public $menu = array(
        '_h1'           => array('配置管理'),
        'option.create' => array('创建配置', '/admin/option/create'),
        'option.list'   => array('配置列表', '/admin/option'),
    );
    public $path = array('system', 'option');
    public $validate = array(
        'rules' => array(
            'key'   => array(
                'required' => true,
            ),
            'value' => array(
                'required' => true,
            )
        )
    );

    public function get()
    {

    }
}