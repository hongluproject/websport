<?php
namespace Controller\Admin\Fetch;
//todo
include(SP."class/utils/simplehtml.php");
class Edit extends \Controller\Admin\Fetch
{
    public $path = array('fetch', 'fetch.edit');
    protected $_tpl = 'admin/fetch/edit';
    public function get()
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



    }

    public function post()
    {
        $url = $_POST['url'];
        $tags = $_POST['tags'];
        $areas = $_POST['areas'];
        $cateids = $_POST['cateids'];
        $result = $this->getContent($url);


        try{
            if($result['title']){
                $result['link']=$url;
                $result['title_md5']=md5($result['title']);
                $result['tags']= $tags;
                $result['areas']= $areas;
                $result['cateids']= $cateids;
                $result['status']= 2;
                $fetch = new \Model\Fetch();
                $fetch->set($result);
                $fetch->save();
            }
        }
        catch(\Exception $e){
            echo 1;

        }
        redirect('/admin/fetch/edit');

    }


    public function getContent($url){
        //拿出文章内容  title用于md5比较
        $remove = array('/style=.+?[*|\"]/i','/data-s=.+?[*|\"]/i','/data-ratio=.+?[*|\"]/i','/data-w=.+?[*|\"]/i');
        $html = file_get_html($url);
        $title = trim($html->find('#activity-name',0)->innertext);
        $date  = trim($html->find('#post-date',0)->innertext);
        $content = trim($html->find("#js_content",0)->innertext);
        $content = preg_replace($remove,array(""),$content);
        $content = str_replace("data-src","src",$content);
        $title   =    trim($html->find("#activity-name",0)->innertext);
        $post_user  =  trim($html->find("#post-user",0)->innertext);
        $post_date = trim($html->find("#post-date",0)->innertext);
        return array('before_content'=>$html->innertext,'after_content'=>$content,'title'=>$title,'post_user'=>$post_user,'post_date'=>$post_date);
    }


}