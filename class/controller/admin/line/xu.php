<?php
namespace Controller\Admin\Line;
class Xu extends \Controller\Admin\Line
{
    public $data;
    public $path = array('line', 'line.xu');
    protected $_tpl = 'admin/line/xu';

    public function get()
    {

        //团队总数
        $db = \Model\Member::db();
        $this->result = $db->fetch('select *  from  `ma_site`  order by lineId asc ,siteId asc');

    }

}

