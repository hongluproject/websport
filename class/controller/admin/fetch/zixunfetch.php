<?php
namespace Controller\Admin\Fetch;
//todo
use Utils\Acurl;

include(SP."class/utils/simplehtml.php");
class Zixunfetch extends \Controller\Admin\Fetch
{
    public $path = array('fetch', 'fetch.zixunfetch');
    protected $_tpl = 'admin/fetch/create';

    public function get(){

    }

    public function post()
    {
        //1点资讯抓取
      /*  $acurl = new \Utils\Acurl();
        $tag_level2  = $acurl->setOption(array('method'=>'get','class'=>'Tag','limit'=>1000,'where'=>'{"level":2}'))->getCurlResult();
        $tag_level2_decode = json_decode($tag_level2);*/

        $tag = $this->getTag();
        $temp1 = $tag_level2_decode = array();
        foreach($tag['level1']->results as $key=> $item){
            $temp1[$item->objectId] = $item->alias_name?$item->alias_name:$item->tag_name;
        }

        //return 2级标签objectId,tag_name  1级标签objectId,tag_name
        foreach($tag['level2']->results as $key => $item){
            $tag_level2_decode[] = array('fetch_rule'=>$item->fetch_rule,'s_title'=>$item->alias_name?$item->alias_name:$item->tag_name,'s_objectId'=>$item->objectId,'f_title'=>$temp1[$item->pid],'f_objectId'=>$item->pid) ;
        }
        //step1 获取sessionId;step2 注入头部
        $sessionUrl = 'http://api.hipu.com/Website/user/login?appid=outdoor&platform=1&username=HG_14f65a8d10e44814&password=0aac2a267f5f67e70e7786381ea721f91d587a6c&version=010804';
        $contents = json_decode(file_get_contents($sessionUrl));
        $header = array();
        $this->curl_hander = curl_init();
        curl_setopt($this->curl_hander,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->curl_hander,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl_hander, CURLOPT_HEADER, 0);
        $header[] ='Cookie: '.$contents->cookie;
        curl_setopt($this->curl_hander,CURLOPT_HTTPHEADER,$header);
        curl_setopt($this->curl_hander, CURLOPT_CONNECTTIMEOUT, 53);
        curl_setopt($this->curl_hander, CURLOPT_CUSTOMREQUEST, "GET");
        //遍历
        foreach($tag_level2_decode as $item){
        $tag_name = $item['s_title'];
        $tag_id = $item['s_objectId'];
        $f_tag_id = $item['f_objectId'];
        $f_tag_name = $item['f_title'];
        $fetch_rule =  $item['fetch_rule'];
        if($fetch_rule == 2){
            $url = 'http://www.yidianzixun.com/api/q/?path=channel|news-list-for-keyword&display='.urlencode($tag_name." ".$f_tag_name).'&word_type=token&fields=docid&fields=image&fields=title&fields=url&cstart=1&cend=50&version=999999&infinite=true';
        } else{
            $url = 'http://www.yidianzixun.com/api/q/?path=channel|news-list-for-keyword&display='.urlencode($tag_name).'&word_type=token&fields=docid&fields=image&fields=title&fields=url&cstart=1&cend=50&version=999999&infinite=true';
        }
        curl_setopt($this->curl_hander, CURLOPT_URL,$url);
        $list_result = curl_exec($this->curl_hander);
        //step 3 列表
        //image url http://i1.go2yd.com/image.php?url=07fc9Q00&type=thumbnail_200x140;
        //step4 循环抓详情  GO
        $decode_list_result = json_decode($list_result);
        if($decode_list_result->status=='success'){
            $insert_result = array();
            foreach($decode_list_result->result as $item){
                $news_list = array();
                $url = 'http://a1.go2yd.com/Website/contents/content?appid=yidian&docid='.$item->docid;
                curl_setopt($this->curl_hander, CURLOPT_URL,$url);
                $view_result =   json_decode(curl_exec($this->curl_hander));
                if($view_result->status == 'success'){
                    $view_result_document = $view_result->documents[0];
                    if(strpos($view_result_document->title,$tag_name)===false&&$fetch_rule == 1){
                        continue;
                    }
                    $news_list['link'] =  $view_result_document->url ;
                    if($view_result_document->image){
                        $news_list['cover_pic'] =  'http://i1.go2yd.com/image.php?url='.$view_result_document->image.'&type=thumbnail_200x140';
                    }
                    $news_list['before_content'] = '一点资讯';
                    $contents =  preg_replace("/<a[^>]*>(.*)<\/a>/isU",'${1}',$view_result_document->content);
                    $news_list['after_content'] = str_replace(array('<body>','</body>'),'',$contents);
                    $news_list['tags'] =$f_tag_id.','. $tag_id;
                    $news_list['title'] = $view_result_document->title;
                    $news_list['title_md5'] = md5($view_result_document->title);
                    $news_list['post_user'] = $view_result_document->source;
                    $news_list['post_date'] = date('Y-m-d',strtotime($view_result_document->date));
                    $insert_result[]= $news_list ;
                }
            }
        }
        foreach ($insert_result as $value) {
            try {
                $fetch = new \Model\Fetch();
                $fetch->set($value);
                $fetch->save();
            } catch (\Exception  $e) {
                continue;
            }
        }
        //http://www.yidianzixun.com/mp_sign_in?password=xxs20416007&username=43046435%40qq.com
        }
        redirect('/admin/fetch');

    }
    public function getTag(){
        $acurl = new \Utils\Acurl();
        $tag_level1  = $acurl->setOption(array('method'=>'get','class'=>'Tag','limit'=>1000,'where'=>'{"level":1}'))->getCurlResult();
        $tag_level2  = $acurl->setOption(array('method'=>'get','class'=>'Tag','limit'=>1000,'where'=>'{"level":2}'))->getCurlResult();
        return array('level1'=>json_decode($tag_level1),'level2'=>json_decode($tag_level2));
    }
}