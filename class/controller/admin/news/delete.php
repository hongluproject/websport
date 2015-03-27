<?php

namespace Controller\Admin\News;

class Delete extends \Controller\Admin\News
{
    public $path = array('news', 'news.local');
    public function get($id)
    {
        $type = $_GET['type'] ? $_GET['type'] : 'local';
        try {
            if ($type == 'avos') {
                $acurl = new \Utils\Acurl();
                $result = $acurl->setOption(array('method' => 'delete', 'class' => 'News', 'objectId' => $id))->getCurlResult();
                redirect('/admin/news');
            } else {
                $fetch = new \Model\Fetch();
                $fetch->delete($id);
                redirect('/admin/news/local');
            }
        } catch (\Exception $e) {
            $this->showError($e->getMessage());
        }
    }

}