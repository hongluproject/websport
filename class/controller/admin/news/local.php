<?php

namespace Controller\Admin\News;
include(SP . "class/utils/qiniu/io.php");
include(SP . "class/utils/qiniu/rs.php");

class Local extends \Controller\Admin\News
{
    public $data;
    public $path = array('news', 'news.local');
    protected $_tpl = 'admin/news/local';
    public $status = array(
        1 => '预选',
        2 => '达到推送',
        3 => '已推送到AVOS'
    );

    public function get()
    {
        $acurl = new \Utils\Acurl();
        $where = '{"level":2}';
        $option = array('method' => 'get', 'limit' => 1000, 'class' => 'Tag', 'where' => $where, 'extend' => '1');
        $key = "newsLocalGet:" . md5(json_encode($option));
    /*    $redisconf = \Core\Config::get('redis');
        $redis = new \Core\Redis($redisconf['default']['host'], $redisconf['default']['port']);
        if ($redis_result = $redis->Get($key)) {
            $this->sub_tags = json_decode($redis_result);
        } else {
            $result = $acurl->setOption($option)->getCurlResult();
            $redis->SetEx($key, 36000, $result);
            $this->sub_tags = json_decode($result);
        }*/

        $result = $acurl->setOption($option)->getCurlResult();
        $this->sub_tags = json_decode($result);
        $result = $acurl->setOption($option)->getCurlResult();

        if ($_GET['search'] == 1) {
            //Array ( [status] => [txt] => [post_user] => [post_date] => )
            $where = array();
            $this->params = array();
            if (isset($_POST['status']) && !empty($_POST['status'])) {
                $where[] = '`status` = "' . $_POST['status'] . '"';
                $this->params['status'] = $_POST['status'];
            }
            if (isset($_POST['title']) && !empty($_POST['title'])) {
                $where[] = '`title` LIKE "%' . $_POST['title'] . '%"';
                $this->params['title'] = $_POST['title'];

            }
            if (isset($_POST['tags']) && !empty($_POST['tags'])) {
                $where[] = '`tags` LIKE "%' . $_POST['tags'] . '%"';
                $this->params['tags'] = $_POST['tags'];
            }

            if (isset($_POST['post_user']) && !empty($_POST['post_user'])) {
                $where[] = '`post_user` LIKE "%' . $_POST['post_user'] . '%"';
                $this->params['post_user'] = $_POST['post_user'];
            }
            if (isset($_POST['post_date']) && !empty($_POST['post_date'])) {
                $where[] = '`post_date` = "' . date('Y-m-d', strtotime($_POST["post_date"])) . '"';
                $this->params['post_date'] = $_POST['post_date'];
            }

            $path = $this->getPath();
            $news = new \Model\Fetch();
            if (isset($_POST['order_pic']) && !empty($_POST['order_pic'])) {
                $this->params['order_pic'] = $_POST['order_pic'];
                $order = array('post_date' => 'desc','cover_pic'=>'desc');
            }else{
                $order = array('post_date' => 'desc');
            }

            $this->result = $news->fetchAsPage($where, $_GET['page'], 20, $order, $path);
        } else {
            $this->params = $_GET;
            $date = date('Y-m-d H:i:s');

            if (isset($_GET['order_pic']) && !empty($_GET['order_pic'])) {
                $order = array('post_date' => 'desc','cover_pic'=>'desc');
            }else{
                $order = array('post_date' => 'desc');
            }

            // $where = array("`create_time`<='$date' and  `status` = 1");
            $where = array();
            if (isset($_GET['status']) && !empty($_GET['status'])) {
                $where[] = '`status` = "' . $_GET['status'] . '"';
                $this->params['status'] = $_GET['status'];
            } 
            if (isset($_GET['title']) && !empty($_GET['title'])) {
                $where[] = '`title` LIKE "%' . $_GET['title'] . '%"';
                $this->params['title'] = $_GET['title'];

            }
            if (isset($_GET['post_user']) && !empty($_GET['post_user'])) {
                $where[] = '`post_user` LIKE "%' . $_GET['post_user'] . '%"';
                $this->params['post_user'] = $_GET['post_user'];
            }
            if (isset($_GET['post_date']) && !empty($_GET['post_date'])) {
                $where[] = '`post_date` = "' . date('Y-m-d', strtotime($_GET["post_date"])) . '"';
                $this->params['post_date'] = $_GET['post_date'];
            }

            if (isset($_GET['tags']) && !empty($_GET['tags'])) {
                $where[] = '`tags` LIKE "%' . $_GET['tags'] . '%"';
                $this->params['tags'] = $_GET['tags'];
            }
            $news = new \Model\Fetch();
            $this->result = $news->fetchAsPageByQuery($where, 20, $order);
        }
    }

    public function post()
    {
        if ($_GET['search'] == 1) {
            $this->get();
            return;
        }
        try {
            $ids = $post = null;
            if (isset($_POST['ids']) && !empty($_POST['ids'])) {
                //step1 select status = 1 in ids
                $db = \Model\Fetch::db();
                $ids = join(',', $_POST['ids']);
                $query = 'select * from news where id In (' . $ids . ')';
                $data = $db->fetch($query);
                //step2 insert into  avos
                //todo batch
                foreach ($data as $item) {
                    $cover_pic_url = parse_url($item->cover_pic);
                    if ($cover_pic_url['host'] != 'hoopeng.qiniudn.com' && $item->cover_pic) {
                        $key = "tags/" . date('YmdHis') . rand(1, 10000) . '.jpg';
                        $client = new \Qiniu_MacHttpClient(null);
                        $ret = Qiniu_RS_Fetch($client, $item->cover_pic, 'hoopeng', $key);
                        $cover_pic = 'http://hoopeng.qiniudn.com/' . $key;
                    } elseif ($item->cover_pic) {
                        $cover_pic = $item->cover_pic;
                    } else {
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

                }
                //step3 update status
                foreach ($_POST['ids'] as $id) {
                    $match = \Model\Fetch::find($id);
                    $match->set(array('status' => 3));
                    $match->save();
                }

            }
            redirect('/admin/news/local');
        } catch (\Exception $e) {
            $this->showError($e->getMessage());
        }
    }


    public function getPath()
    {
        $page = (int)isset($_POST['page']) ? $_POST['page'] : 1;
        if ($page < 1) $page = 1;
        $query = $_POST;
        if (!empty($query)) {
            foreach ($query as $k => $v) {
                if (!$v) {
                    unset($query[$k]);
                    continue;
                }
                $query[$k] = urlencode($k) . "=" . urlencode($v);
            }
            $path = PATH . '?' . join('&', $query) . '&page=:page';
        } else {
            $path = PATH . '?' . 'page=:page';
        }
        return $path;
    }
}