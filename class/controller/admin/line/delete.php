<?php

namespace Controller\Admin\Line;

class Delete extends \Controller\Admin\Line
{
    public $data;
    public $path = array('line', 'line.list');
    public function get($id)
    {
        try
        {
            $result = new \Model\Line();
            $result->delete($id);
            redirect('/admin/line');
        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}