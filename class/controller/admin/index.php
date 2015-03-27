<?php
/**
 * Index Page
 *
 * Example index page.
 *
 * @package        MicroMVC
 * @author         David Pennington
 * @copyright      (c) 2011 MicroMVC Framework
 * @license        http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
namespace Controller\Admin;

class Index extends \Controller\Admin
{
    public function get()
    {
        // Load the welcome view
         $this->content = new \Core\View('admin/index');
    }
}
