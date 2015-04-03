<?php

namespace Controller\Admin\Site;
class Edit extends \Controller\Admin\Site
{
    public $data;
    public $path = array('site', 'site.edit');

    protected $_tpl = 'admin/site/edit';

    public function get($id)
    {
        $db = \Model\Line::db();
        $table = 'ma_line';
        $this->lineList= $db->fetch('select * from  `ma_line` ');

        if ($id) {
            $this->result = \Model\Site::find($id);
        } else {
            $this->result = array();
        }
    }

    public function post($id)
    {
        try
        {
            $data = $_POST;
            $mission =array();
            if($data['passInfo']==2){
                $mission = array_combine($_POST['missionTitle'],$_POST['missionUrl']);
            }

            $data['mission']  = json_encode($mission);
            unset($data['missionTitle']);
            unset($data['missionUrl']);
            if ($id) {
                $site = \Model\Site::find($id);
                $before_line = \Model\Line::find(array('lineId'=>$site->lineId));
                $before_line->set(array('siteNum'=>$before_line->siteNum-1));
                $before_line->save();

                $after_line = \Model\Line::find(array('lineId'=>$data['lineId']));
                $after_line->set(array('siteNum'=>$after_line->siteNum+1));
                $after_line->save();
                $site->set($data);
                $site->save();
            }else{
                $site = new \Model\Site();
                $site->set($data);
                $site->save();
                $line = \Model\Line::find(array('lineId'=>$data['lineId']));
                $line->set(array('siteNum'=>$line->siteNum+1));
                $line->save();

            }
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
            echo '</br>';
            echo '没有这个站点';
            exit;
        }
        redirect('/admin/site');
    }
}