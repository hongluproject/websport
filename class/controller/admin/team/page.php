<?php

namespace Controller\Admin\Team;

class Page extends \Controller\Admin\Team
{
    public $data;
    public $path = array('team', 'team.list');
    protected $_tpl = 'admin/team/list';

    public function get()
    {
        $team = new \Model\Team();
        $where = array();
        $path = $this->getPath();
        $order = array('create_time' => 'desc');
        $this->result = $team->fetchAsPage($where, $_GET['page'], 1, $order, $path);
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