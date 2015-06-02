<?php

namespace Controller\Admin\Site;

class Delete extends \Controller\Admin\Site
{
    public $data;
    public $path = array('site', 'site.list');
    public function get($id)
    {
        try
        {

            $user = $this->user;
            if($user->admin!=1){
                echo "cannot delete  site";exit;
            }
            $result = new \Model\Site();
            $result->delete($id);

            redirect('/admin/site');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}