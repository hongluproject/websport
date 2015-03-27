<?php
/**
 * Created by JetBrains PhpStorm.
 * User: frankfu
 * Date: 12-5-30
 * Time: 下午4:43
 * To change this template use File | Settings | File Templates.
 */

//-----------------------------------------------------------------------------------------//
/*
$where = array('pb_status'=>0);
$order_by = array('create_time'=>'ASC');
$horns = \Model\Horn::fetchByPage($where,1,1,$order_by);
print_r($horns);
*/
echo json_encode(array('status'=>"金额不足请充值"));

