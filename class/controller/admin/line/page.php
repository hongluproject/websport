<?php
namespace Controller\Admin\Line;
class Page extends \Controller\Admin\Line
{
    public $data;
    public $path = array('line', 'line.list');
    protected $_tpl = 'admin/line/list';

    public function get()
    {
        $lines = new \Model\Line();
        $where = array();
        $path = $this->getPath();
        $order = array('lineId' => 'asc');
        $this->result = $lines->fetchAsPage($where, $_GET['page'], 10, $order, $path);
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