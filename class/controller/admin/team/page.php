<?php

namespace Controller\Admin\Team;

class Page extends \Controller\Admin\Team
{
    public $data;
    public $path = array('team', 'team.list');
    protected $_tpl = 'admin/team/list';

    public function get($searchParam)
    {
        if($searchParam){
            $db = \Model\Team::db();
            $table = 'ma_team';
            $this->result->list= $db->fetch('select * from `'.$table.'` where `teamId` = "'.$searchParam.'"  or `teamName`="'.$searchParam.'" ');
            $this->searchParam = $searchParam;
        }else{
            $team = new \Model\Team();
            $where = array();
            $path = $this->getPath();
            $order = array('create_time' => 'desc');
            $this->result = $team->fetchAsPage($where, $_GET['page'], 10, $order, $path);
        }

    }




    public function  post(){
        $searchParam = $_POST['searchParam'];
         $this->get($searchParam);

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