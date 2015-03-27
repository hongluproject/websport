<?php

namespace Controller\Admin\Tag;

class Page extends \Controller\Admin\Tag
{
    public $data;
    public $path = array('tag', 'tag.list');

    protected $_tpl = 'admin/tag/list';

    public function get($id)
    {
        $acurl = new \Utils\Acurl();
        $tagdirectory = json_decode($acurl->setOption(array('method' => 'get', 'class' => 'TagDirectory', 'limit' => '1000'))->getCurlResult(), true);
        $utilsLocal = new \Utils\Local();
        //所有的1级标签
        $tagsTree = $utilsLocal->getTagsTree();

        $menuTagTree = array();
        foreach ($tagdirectory['results'] as $key => $item) {
            foreach ($item['tagIds'] as $key1 => $itemTagIds) {
                //在目录中出现的1级标签
                $menuTagTree[$itemTagIds] = $itemTagIds;
                $tagdirectory['results'][$key]['subTagTree'][$itemTagIds] = $tagsTree[$itemTagIds];

            }
        }
        //求差集   $menuTagTree
        $diffTagTree = array_diff_key($tagsTree, $menuTagTree);
        $tagdirectory['results']['noadd'] = array('title' => '未加入的标签', 'subTagTree' => $diffTagTree);
        $this->tagdirectory = $tagdirectory;


    }

}

