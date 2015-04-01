<?php
namespace Controller\Admin\Signup;
class Page extends \Controller\Admin\Signup
{
    public $data;
    public $path = array('signup', 'signup.list');
    protected $_tpl = 'admin/signup/list';

    public function get()
    {
        $sign = new \Model\Signup();
        $where = array();
        $path = $this->getPath();

        $order = array('create_time' => 'desc');
        $this->result = $sign->fetchAsPage($where, $_GET['page'], 1, $order, $path);
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