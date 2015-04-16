<?php

namespace Controller\Admin\Site;

class Page extends \Controller\Admin\Site
{
    public $data;
    public $path = array('site', 'site.list');
    protected $_tpl = 'admin/site/list';

    public function get($id)
    {
        $site = new \Model\Site();
        if ($id) {
            $where = array('lineId' => $id);

        } else {
            $where = array();
        }
        $path = $this->getPath();
        $order = array('lineId' => 'asc','siteId'=>'asc');
        $this->result = $site->fetchAsPage($where, $_GET['page'], 10, $order, $path);
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