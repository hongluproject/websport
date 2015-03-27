<?php
/**
 * 404 Page
 *
 * @package        MicroMVC
 * @author         David Pennington
 * @copyright      (c) 2011 MicroMVC Framework
 * @license        http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
namespace Controller\Admin;

class Page404 extends \Controller\Admin
{
    public function run()
    {
        $this->show404();
    }
}
