<?php

namespace Controller\Admin\Tag;
class Update extends \Controller\Admin\Tag
{
    public $data;
    public $path = array('tag', 'tag.create');

    protected $_tpl = 'admin/tag/edit';

    public function get($id)
    {
        $acurl = new \Utils\Acurl();
        $this->tagdirectory = json_decode($acurl->setOption(array('method' => 'get', 'class' => 'TagDirectory', 'limit' => '1000'))->getCurlResult(), true);
        $where = '{"level":1}';
        $acurl = new \Utils\Acurl();
        $pids = $acurl->setOption(array('method' => 'get', 'class' => 'Tag', 'where' => $where))->getCurlResult();
        $this->pids = json_decode($pids);
        $result = $acurl->setOption(array('method' => 'get', 'class' => 'Tag', 'objectId' => $id))->getCurlResult();
        $this->result = json_decode($result);

    }

    public function post($id)
    {
        unset($_POST['img']);
        $acurl = new \Utils\Acurl();
        $getTagDirectoryIdResult = json_decode($acurl->setOption(array('method' => 'get', 'class' => 'TagDirectory', 'objectId' => $_POST['tagDirectoryId']))->getCurlResult(), true);
        if($_POST['level'] ==1){
            $getTagDirectoryIdResultTagIds = $getTagDirectoryIdResult['tagIds'];
            if(!$getTagDirectoryIdResultTagIds){
                $getTagDirectoryIdResultTagIds = array();
            }
            if(!in_array($id,$getTagDirectoryIdResultTagIds)){
                array_push($getTagDirectoryIdResultTagIds,$id);
            }
             $acurl->setOption(array('method' => 'post', 'class' => 'TagDirectory', 'objectId' => $_POST['tagDirectoryId'], 'field' => array('tagIds'=>$getTagDirectoryIdResultTagIds)))->getCurlResult();
        }

        if (isset($_POST['rank'])) {
            $_POST['rank'] = (int)$_POST['rank'];
        }
        if (isset($_POST['status'])) {
            $_POST['status'] = (int)$_POST['status'];
        }
        if (isset($_POST['level'])) {
            $_POST['level'] = (int)$_POST['level'];
        }
        if (isset($_POST['fetch_rule'])) {
            $_POST['fetch_rule'] = (int)$_POST['fetch_rule'];
        }

        if (isset($_POST['tagDirectoryId'])) {
            $_POST['tagDirectoryId'] = array('__type' => 'Pointer', 'className' => 'TagDirectory', 'objectId' => $_POST['tagDirectoryId']);
        }

        $result = $acurl->setOption(array('method' => 'post', 'class' => 'Tag', 'objectId' => $id, 'field' => $_POST))->getCurlResult();


        redirect('/admin/tag/update/' . $id);

    }
}