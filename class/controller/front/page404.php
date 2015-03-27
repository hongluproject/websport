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
namespace Controller\Front;

class Page404 extends \Controller\Front
{
    public function run()
    {
        $this->show404();
    }
}
