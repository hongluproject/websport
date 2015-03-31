<?php

namespace Controller\Admin\Tag;

class Menucreate extends \Controller\Admin\Tag
{
    public $data;
    public $path = array('tag', 'tag.menucreate');
    protected $_tpl = 'admin/tag/menucreate';

    public function get($id)
    {
        $acurl = new \Utils\Acurl();
        $where = '{"level":1}';
        $result = $acurl->setOption(array('method' => 'get', 'class' => 'Tag', 'limit' => '1000', 'where' => $where))->getCurlResult();
        $tags = json_decode($result, true);

        $frmatTags = array();
        foreach($tags['results'] as $item){
             $frmatTags['results'][$item['objectId']] = $item;
        }
        $this->tags = $frmatTags;

        if ($id) {
            $result = $acurl->setOption(array('method' => 'get', 'class' => 'TagDirectory', 'objectId' => $id))->getCurlResult();
            $this->result = json_decode($result, true);
        }
    }


    public function post($id)
    {

        $savePost = array();
        $acurl = new \Utils\Acurl();
        $savePost['tagIds'] = explode(',', $_POST['tags']);
        $savePost['title'] = $_POST['title'];
        $savePost['tagSort'] = (int)$_POST['tagSort'];
        $savePost['status'] = (int)$_POST['status'];
        $savePost['color'] = $_POST['color'];

        if($id){
            $result = json_decode($acurl->setOption(array('method' => 'post', 'class' => 'TagDirectory', 'field' => $savePost,'objectId'=>$id))->getCurlResult(), true);
        }else{
            $result = json_decode($acurl->setOption(array('method' => 'post', 'class' => 'TagDirectory', 'field' => $savePost))->getCurlResult(), true);

        }

        if ($savePost['tagIds'] && $result['objectId']) {
            foreach ($savePost['tagIds'] as $item) {
                $tagDirectoryPoint = array('className' => 'TagDirectory', 'objectId' => $result['objectId'], '__type' => 'Pointer');
                $acurl->setOption(array('method' => 'post', 'class' => 'Tag', 'objectId' => $item, 'field' => array('tagDirectoryId' => $tagDirectoryPoint)))->getCurlResult();
            }
        }



        redirect('/admin/tag/list/');

    }

}

