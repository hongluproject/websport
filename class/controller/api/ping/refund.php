<?php
namespace Controller\Api\Ping;

class Refund extends \Controller\Api
{
    public function get()
    {
        $retrieveChId = $_GET['ch_id'];
        $amount = $_GET['amount'];
        $desc = $_GET['description']? $_GET['description']:'任性退钱';
        require_once(SP . "class/utils/ping/lib/Pingpp.php");
        \Pingpp::setApiKey(config('pingKey'));
        $ch = \Pingpp_Charge::retrieve($retrieveChId);
        $ch->refunds->create(
            array(
                "amount" => $amount,
                "description" => $desc
            )
        );

        $refund = array();
        $refund['amount'] = $amount;
        $refund['description'] = $desc;
        $refund['chargeId'] = $retrieveChId;
        $chargeClass = new \Model\Refund();
        $chargeClass->set($refund);
        $chargeClass->save();
    }

    public function post()
    {

    }
}
