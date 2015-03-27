<?php
namespace Controller\Admin\Fetch;
include(SP."class/utils/simplehtml.php");
class Create extends \Controller\Admin\Fetch
{
    public $path = array('fetch', 'fetch.create');
    protected $_tpl = 'admin/fetch/create';

    public static  $black_word = array('会员','视频','wifi','例行','团购','通知','公益','名额','聚会','朋友圈','特惠','社团','报道','一日游','二日游','三日游','门票','招募','花絮','开幕','揭晓','征稿','工作室','协会','旗舰店');

    public function get()
    {
    }
    public function post()
    {
        $tag = $this->getTag();
        $temp1 = $temp2 = array();

        // return 1级标签[objectId]=>'tag_name';
        foreach($tag['level1']->results as $key=> $item){
            $temp1[$item->objectId] = $item->alias_name?$item->alias_name:$item->tag_name;
        }

        //return 2级标签objectId,tag_name  1级标签objectId,tag_name
        foreach($tag['level2']->results as $key => $item){
            $temp2[] = array('s_title'=>$item->alias_name?$item->alias_name:$item->tag_name,'s_objectId'=>$item->objectId,'f_title'=>$temp1[$item->pid],'f_objectId'=>$item->pid) ;
        }
        foreach ($temp2 as $item){
            $query = $item['f_title']." ".$item['s_title'];
            $query = urlencode($query);
            for($i=1;$i<2;$i++){
                //只限于微信规则。。哥哥们别乱搞
                $fetch_url = "http://weixin.sogou.com/weixin?query=".$query."&type=2&page=".$i."&ie=utf8";
                $html = file_get_html($fetch_url);
                //step1  fetch  dom about url and new img
                $news_list = array();
                foreach($html->find('div.results .img_box2') as $key => $result) {
                    $k = 0;
                    $news_list[$key]['link'] =  $result->find('a',0)->href ;
                    $news_list[$key]['cover_pic'] =  $this->parseUrl($result->find('img ',0)->src);
                    $content = $this->getContent($news_list[$key]['link']);
                    $news_list[$key]['before_content'] = "微信";
                    $news_list[$key]['after_content'] = $content['after_content'];
                    $news_list[$key]['tags'] =$item['f_objectId'].','. $item['s_objectId'];
                    $news_list[$key]['title'] = $content['title'];
                    foreach (self::$black_word as $bw){
                        if(strpos($content['title'],$bw)!==false){
                            $k++;
                            break;
                        }
                    }
                    $news_list[$key]['title_md5'] = md5($content['title']);
                    $news_list[$key]['post_user'] = $content['post_user'];
                    $news_list[$key]['post_date'] = $content['post_date'];
                    if ($k!=0){
                        unset($news_list[$key]);
                    }
                }//step2把列表添加到数据库
                //Array ( [0] => title [1] => link [2] => cover_pic [3] => before_content [4] => after_content )
                foreach ($news_list as $value) {
                    try {
                        $fetch = new \Model\Fetch();
                        $fetch->set($value);
                        $fetch->save();
                    } catch (\Exception  $e) {
                        continue;
                    }
                }
            }
            $html->clear();
        }
        redirect('/admin/fetch');
    }

    public function parseUrl($url){
        //拿出query里的URL  比较蛋疼。。TODO
        $img_url = '';
        $url_query = parse_url( $url , PHP_URL_QUERY );
        $url_query =  htmlspecialchars_decode($url_query);
        $url_param  = explode('&',$url_query);
        foreach ($url_param as $item){
            $temp = explode('=',$item);
            if($temp[0]=='url'){
                $img_url = $temp[1];
            }
        }
        return $img_url;
    }
    public function getContent($url){
        //拿出文章内容  title用于md5比较
        $remove = array('/style=.+?[*|\"]/i','/data-s=.+?[*|\"]/i','/data-ratio=.+?[*|\"]/i','/data-w=.+?[*|\"]/i','/height=.+?[*|\"]/i','/width=.+?[*|\"]/i','/class=.+?[*|\"]/i','/id=.+?[*|\"]/i');
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

    public function getTag(){
        $acurl = new \Utils\Acurl();
        $tag_level1  = $acurl->setOption(array('method'=>'get','class'=>'Tag','limit'=>1000,'where'=>'{"level":1}'))->getCurlResult();
        $tag_level2  = $acurl->setOption(array('method'=>'get','class'=>'Tag','limit'=>1000,'where'=>'{"level":2}'))->getCurlResult();
        return array('level1'=>json_decode($tag_level1),'level2'=>json_decode($tag_level2));
    }
}