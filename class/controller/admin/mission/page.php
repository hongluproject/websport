<?php

namespace Controller\Admin\Mission;

class Page extends \Controller\Admin\Mission
{
    public $data;
    public $path = array('mission', 'mission.list');
    protected $_tpl = 'admin/mission/list';

    public function get()
    {
        $mission = new \Model\Mission();
        $where = array();
        $path = $this->getPath();
        $order = array('create_time' => 'desc');
        $this->result = $mission->fetchAsPage($where, $_GET['page'], 1, $order, $path);
    }

    public function getPath()
    {
        $page = (int)isset($_POST['page']) ? $_POST['page'] : 1;
        if ($page < 1) $page = 1;
        $query = $_POST;
        if (!empty($query)) {
            foreach ($query as $k => $v) {
                if (!$v) {
                    unset($query[$k]);
                    continue;
                }
                $query[$k] = urlencode($k) . "=" . urlencode($v);
            }
            $path = PATH . '?' . join('&', $query) . '&page=:page';
        } else {
            $path = PATH . '?' . 'page=:page';
        }
        return $path;
    }
}