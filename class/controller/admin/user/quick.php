<?php

namespace Controller\Admin\User;

class Quick extends \Controller\Admin\User
{
    public $data;

    public function get($id)
    {
        try
        {
            switch ($_GET['type'])
            {
                case 'active':
                    \Logic\User::active($id);
                    redirect('/admin/user');
                    break;
                case 'deactive':
                    \Logic\User::deActive($id);
                    redirect('/admin/user');
                    break;
                case 'delete':
                    \Logic\User::delete($id);
                    redirect('/admin/user');
                    break;
                default:
                    throw new \Exception('没有这个操作');
            }

        }
        catch (\Exception $e)
        {
            $this->showError($e->getMessage());
        }
    }
}