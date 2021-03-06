<?php

namespace Controller\Admin\Member;

class Page extends \Controller\Admin\Member
{
    public $data;
    public $path = array('member', 'member.list');
    protected $_tpl = 'admin/member/list';

    public function get()
    {
        $members = new \Model\Member();
        $where = array();
        $path = $this->getPath();
        $order = array('create_time' => 'desc');
        $this->result = $members->fetchAsPage($where, $_GET['page'], 20, $order, $path);
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