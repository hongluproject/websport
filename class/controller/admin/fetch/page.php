<?php
namespace Controller\Admin\Fetch;
//todo
include(SP."class/utils/simplehtml.php");
class Page extends \Controller\Admin\Fetch
{
    public $data;
    public $path = array('fetch', 'fetch.list');
    protected $_tpl = 'admin/fetch/list';
    public function get()
    {
        //todo
        $html = file_get_html('http://weixin.sogou.com/weixin?type=2&query=%E5%BE%92%E6%AD%A5&ie=utf8');
        $result = $html->find('div.results',0)->innertext;
        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'get','class'=>'Area'))->getCurlResult();
        $this->result = json_decode($result);
        $page =  \Model\Core::fetchAsPageByAvos(10,$this->result->count);
        $this->page = $page;
        exit;
    }

}