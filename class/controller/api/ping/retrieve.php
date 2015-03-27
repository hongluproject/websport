<?php
namespace Controller\Api\Ping;

class Retrieve extends \Controller\Api
{
    public function get()
    {

        //返回订单的详细信息
        $retrieveChId = $_GET['ch_id'];
        require_once(SP . "class/utils/ping/lib/Pingpp.php");
        \Pingpp::setApiKey(config('pingKey'));
        $ch = \Pingpp_Charge::retrieve($retrieveChId);
        //不要入库
        if ($ch) {
            $chDecode = json_decode($ch, true);
            if ($ch['paid'] == 1) {
                $acurl = new \Utils\Acurl();
                $param['bookNo'] = $chDecode['order_no'];
                $param['timePaid'] = $chDecode['time_paid'];
                $param['transactionNo'] = $chDecode['transaction_no'];
                $result = $this->postCloudFunction($param);
            }
        }
        echo $ch;
        exit;
    }

    public function post()
    {

    }


    public function  postCloudFunction($param){
        $curl_hander = curl_init();
        curl_setopt($curl_hander, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_hander, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_hander, CURLOPT_HEADER, 0);
        $header[] = APP_ID;
        $header[] = App_KEY;
        $header[] = 'Content-Type: application/json';
        curl_setopt($curl_hander, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl_hander, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl_hander, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_hander, CURLOPT_URL, 'https://leancloud.cn:443/1.1/functions/paymentComplete');
        curl_setopt($curl_hander, CURLOPT_POSTFIELDS, json_encode($param)); //设置提交的字符串
        $result = curl_exec($curl_hander);
        return $result;
    }
}

