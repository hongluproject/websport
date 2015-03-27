<?php

namespace Controller\Admin\Api;

class AutoComplete extends \Controller\Api
{
    public function get($method)
    {
        $this->data = array(
            'query'       => $_GET['query'],
            'suggestions' => array(),
            'data'        => array(),
        );

        $query = trim(trim($_GET['query']));
        if (empty($query) || empty($method))
        {
            $this->showError("接口类型或参数为空");
        }

        $this->{$method}($query);
    }

    public function zt($query)
    {
        $data = \Model\Match::fetch(array('`url` LIKE "%' . $query . '%"'));
        foreach ($data as $index => $item)
        {
            $this->data['suggestions'][$index] = $item->url;
            $this->data['data'][$index] = $item->id;
        }
    }

    public function initialize($method)
    {
        parent::initialize($method);
        $this->loadDatabase();
    }
}