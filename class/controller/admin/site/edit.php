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
        $this->lineList = $db->fetch('select * from  `ma_line` ');

        if ($id) {
            $this->result = \Model\Site::find($id);
        } else {
            $this->result = array();
        }
    }

    public function post($id)
    {
        try {
            $data = $_POST;
            $mission = array();
            if ($data['passInfo'] == 2) {
                $mission = array_combine($_POST['missionTitle'], $_POST['missionUrl']);
            }


            /*$siteModel = new \Model\Site();
            $where = array('lineId' => $_POST['lineId']);
            $sites = $siteModel->fetch($where, 1000);
            $selfLine = array();
            foreach ($sites as $item) {
                $selfLine[$item->siteId] = $item->siteId;
            }
            if (array_key_exists($_POST['siteId'], $selfLine)) {
                echo "error line input";exit;
            }*/

            $data['mission'] = json_encode($mission);
            unset($data['missionTitle']);
            unset($data['missionUrl']);

            if ($data['passInfo'] == 2 && (empty($mission) || !$data['missionResult'])) {
                echo "mission and mission result must be input";
                exit;
            }

            if (!$data['position']) {
                echo "address  must be input";
                exit;
            }


            if ($data['section'] == 1 && $data['siteId'] != 0) {
                echo "select start position must start input be 0";
                exit;
            }

            if ($id) {
                $site = \Model\Site::find($id);
                $before_line = \Model\Line::find(array('lineId' => $site->lineId));
                $before_line->set(array('siteNum' => $before_line->siteNum - 1));
                $before_line->save();

                $after_line = \Model\Line::find(array('lineId' => $data['lineId']));
                $after_line->set(array('siteNum' => $after_line->siteNum + 1));
                $after_line->save();
                $site->set($data);
                $site->save();
            } else {
                $site = new \Model\Site();
                $site->set($data);
                $site->save();
                $line = \Model\Line::find(array('lineId' => $data['lineId']));
                $line->set(array('siteNum' => $line->siteNum + 1));
                $line->save();

            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo '</br>';
            echo '没有这个点标';
            exit;
        }
        redirect('/admin/site');
    }
}