<?php

namespace Controller\Admin\News;
include(SP."class/utils/qiniu/io.php");
include(SP."class/utils/qiniu/rs.php");
class Update extends \Controller\Admin\News
{
    public $data;
    public $path = array('news', 'news.list');

    protected $_tpl = 'admin/news/edit';

    public function get($id)
    {
        $acurl = new \Utils\Acurl();

        $result  = $acurl->setOption(array('method'=>'get','class'=>'Tag','limit'=>1000))->getCurlResult();
        $avos_tags = json_decode($result)->results;

        $tag_tree = $sub_tree = $tags =   array();
        //整理tag,树型结构
        foreach($avos_tags as $item){
            $tags[$item->objectId] = $item;
            if(!$item->pid){
                $cate_tree[$item->objectId] = $item;
                continue;
            }
            $sub_tree[$item->pid][] = $item;
        }
        $this->tags = $tags;

        //树型结构
        foreach($cate_tree as $key=> &$item){
            $item->subtree = $sub_tree[$item->objectId];
        }
        $this->cate_tree = $cate_tree;


        //地区
        $area_result =  $acurl->setOption(array('method'=>'get','class'=>'Area','limit'=>1000))->getCurlResult();
        $avos_area = json_decode($area_result)->results;
        $area_tree = $sub_area_tree = $areas =   array();
        //整理area,树型结构
        foreach($avos_area as $item1){
            $areas[$item1->objectId] = $item1;
            if(!$item1->pid){
                $area_tree[$item1->objectId] = $item1;
                continue;
            }
            $sub_area_tree[$item1->pid][] = $item1;
        }
        $this->areas = $areas;

        //树型结构
        foreach($area_tree as $key=> &$item1){
            $item1->subtree = $sub_area_tree[$item1->objectId];
        }
        $this->area_tree = $area_tree;

        //分类


        $avos_cate =  json_decode($acurl->setOption(array('method'=>'get','class'=>'Cate','limit'=>1000))->getCurlResult())->results;
        $cate_result =  array();
        foreach($avos_cate as &$item2){
            $cate_result[$item2->objectId] = $item2;
        }
        $this->cate_result = $cate_result;




        $result  = $acurl->setOption(array('method'=>'get','class'=>'News','objectId'=>$id))->getCurlResult();
        $this->result = json_decode($result);
    }

    public function post($id){

        $acurl = new \Utils\Acurl();

        if(isset($_POST['rank'])){
            $_POST['rank'] = (int)$_POST['rank'];
        }
        if(!empty($_POST['tags'])){
            $_POST['tags'] = explode(',',$_POST['tags']);
        }else{
            unset($_POST['tags']);
        }
        if(!empty($_POST['areas'])){
            $_POST['areas'] = explode(',',$_POST['areas']);
        }else{
            unset($_POST['areas']);
        }
        if(!empty($_POST['cateids'])){
            $_POST['cateids'] = explode(',',$_POST['cateids']);
        }else{
            unset($_POST['cateids']);
        }

        if(isset($_POST['allow_comment'])){
            $_POST['allow_comment'] = (bool)$_POST['allow_comment'];
        }
        if(isset($_POST['allow_forward'])){
            $_POST['allow_forward'] = (bool)$_POST['allow_forward'];
        }
        if(isset($_POST['status'])){
            $_POST['status'] = (int)$_POST['status'];
        }
        if(isset($_POST['comment_count'])){
            $_POST['comment_count'] = (int)$_POST['comment_count'];
        }
        if(isset($_POST['up_count'])){
            $_POST['up_count'] = (int)$_POST['up_count'];
        }
        if(!$_POST['list_pic']){
            $_POST['list_pic']='http://hoopeng.qiniudn.com/list.png';
        }

        unset($_POST['img']);
        //$_POST['publicAt'] =  array('iso'=>date('Y-m-d\TH:i:s.000\Z'),'__type'=>'Date');
        $result  = $acurl->setOption(array('method'=>'post','class'=>'News','objectId'=>$id,'field'=>$_POST))->getCurlResult();

        redirect('/admin/news/update/'.$id.'?op=ok');

    }
}