<?php

namespace Controller\Admin\News;
include(SP . "class/utils/qiniu/io.php");
include(SP . "class/utils/qiniu/rs.php");

class Localupdate extends \Controller\Admin\News
{
    public $data;
    public $path = array('news', 'news.local');
    protected $_tpl = 'admin/news/localupdate';


    public function get($id)
    {
        $acurl = new \Utils\Acurl();
        $result = $acurl->setOption(array('method' => 'get', 'class' => 'Tag', 'limit' => 1000))->getCurlResult();
        $avos_tags = json_decode($result)->results;

        $tag_tree = $sub_tree = $tags = array();
        //整理tag,树型结构
        foreach ($avos_tags as $item) {
            $tags[$item->objectId] = $item;
            if (!$item->pid) {
                $cate_tree[$item->objectId] = $item;
                continue;
            }
            $sub_tree[$item->pid][] = $item;
        }
        $this->tags = $tags;

        //树型结构
        foreach ($cate_tree as $key => &$item) {
            $item->subtree = $sub_tree[$item->objectId];
        }
        $this->cate_tree = $cate_tree;


        //地区
        $area_result = $acurl->setOption(array('method' => 'get', 'class' => 'Area', 'limit' => 1000))->getCurlResult();
        $avos_area = json_decode($area_result)->results;
        $area_tree = $sub_area_tree = $areas = array();
        //整理area,树型结构
        foreach ($avos_area as $item1) {
            $areas[$item1->objectId] = $item1;
            if (!$item1->pid) {
                $area_tree[$item1->objectId] = $item1;
                continue;
            }
            $sub_area_tree[$item1->pid][] = $item1;
        }
        $this->areas = $areas;

        //树型结构
        foreach ($area_tree as $key => &$item1) {
            $item1->subtree = $sub_area_tree[$item1->objectId];
        }
        $this->area_tree = $area_tree;

        //分类


        $avos_cate = json_decode($acurl->setOption(array('method' => 'get', 'class' => 'Cate', 'limit' => 1000))->getCurlResult())->results;
        $cate_result = array();
        foreach ($avos_cate as &$item2) {
            $cate_result[$item2->objectId] = $item2;
        }
        $this->cate_result = $cate_result;


        try {
            $this->result = \Model\Fetch::find($id);
        } catch (\Exception $e) {
            $this->showError($e->getMessage());
        }
    }


    public function post($id)
    {
        if ($_POST['status'] == 4) {
            $this->postToAvos($id);
        } else {
            try {
                $match = \Model\Fetch::find($id);
                $data = $_POST;
                unset($data['img']);
                $match->set($data);
                $match->save();
                redirect('/admin/news/localupdate/' . $id . '?op=ok');
            } catch (\Exception $e) {
                $this->showError($e->getMessage());
            }
        }
    }

    public function postToAvos($postid)
    {
        $item = (object)$_POST;
        $cover_pic_url = parse_url($item->cover_pic);
        if ($cover_pic_url['host'] != 'hoopeng.qiniudn.com'&&$item->cover_pic) {
            $key = "tags/" . date('YmdHis') . rand(1, 10000) . '.jpg';
            $client = new \Qiniu_MacHttpClient(null);
            $ret = Qiniu_RS_Fetch($client, $item->cover_pic, 'hoopeng', $key);
            $cover_pic = 'http://hoopeng.qiniudn.com/' . $key;
        } elseif($item->cover_pic) {
            $cover_pic = $item->cover_pic;
        }else{
            $cover_pic = 'http://hoopeng.qiniudn.com/list.png';
        }
        $param = array(
            'title' => $item->title,
            'contents' => $item->after_content,
            'contents_url' => $item->link,
            'publicAt' => array('iso' => date('Y-m-d\TH:i:s.000\Z'), '__type' => 'Date'),
            'source' => $item->post_user,
            'list_pic' => $cover_pic,
        );
        if ($item->tags) {
            $param['tags'] = explode(',', $item->tags);
        }
        if ($item->areas) {
            $param['areas'] = explode(',', $item->areas);
        }
        if ($item->cateids) {
            $param['cateids'] = explode(',', $item->cateids);
        }
        $acurl = new \Utils\Acurl();
        $result = $acurl->setOption(array('method' => 'post', 'class' => 'News', 'field' => $param))->getCurlResult();
        //step3 update status
        $match = \Model\Fetch::find($postid);
        $data = $_POST;
        unset($data['img']);
        $data['status'] = 3;
        $data['cover_pic'] = $cover_pic;
        $match->set($data);
        $match->save();
        redirect('/admin/news/localupdate/' . $postid . '?op=ok');
    }
}