<?php

namespace Utils;

class Local
{

    public function getTagsTree()
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
       return  $cate_tree;
    }

}
