<?php
namespace Controller\Api\Ping;

class Notify extends \Controller\Api
{
    public function get()
    {
    }

    public function post()
    {
        $input_data = json_decode(file_get_contents("php://input"), true);
        if($input_data['object'] == 'charge') {
                $chDecode = $input_data;
                if ($chDecode['paid'] == 1) {
                    $acurl = new \Utils\Acurl();
                    $param['bookNo'] = $chDecode['order_no'];
                    $param['timePaid'] = $chDecode['time_paid'];
                    $param['transactionNo'] = $chDecode['transaction_no'];
                    $result = $this->postCloudFunction($param,'paymentComplete');

                    $charge = array();
                    $charge['order_no'] = $chDecode['order_no'];
                    $charge['chargeId'] = $chDecode['id'];
                    $charge['body'] = $chDecode['body'];
                    $charge['subject'] = $chDecode['subject'];
                    $charge['channel'] = $chDecode['channel'];
                    $charge['amount'] = $chDecode['amount'];
                    $charge['transaction_no'] = $chDecode['transaction_no'];
                    $charge['time_expire'] = $chDecode['time_expire'];
                    $charge['info'] = json_encode($chDecode['credential']);
                    //付款成功
                    $charge['mode'] = 2;
                    $chargeClass = new \Model\Charge();
                    $chargeClass->set($charge);
                    $chargeClass->save();
                }

            echo 'success';
        } elseif($input_data['object'] == 'refund') {
            $chDecode = $input_data;

            $charge = array();
            $charge['order_no'] = $chDecode['order_no'];
            $charge['chargeId'] = $chDecode['charge'];
            $charge['amount'] = $chDecode['amount'];
            $charge['mode'] = 3;
            $charge['body'] = $chDecode['description'];
            $charge['time_expire'] = $chDecode['time_succeed'];
            $charge['info'] = json_encode($chDecode);
            //退款成功
            $chargeClass = new \Model\Charge();
            $chargeClass->set($charge);
            $chargeClass->save();
            $param  = array();
            $param['chargeId'] =  $chDecode['charge'];
            $param['refundId'] =  $chDecode['id'];
            $result = $this->postCloudFunction($param,'refundComplete');

            echo 'success';
        }else{
            echo 'fail';
        }
        exit;

    }




    public function  postCloudFunction($param,$function){
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
        curl_setopt($curl_hander, CURLOPT_URL, 'https://leancloud.cn:443/1.1/functions/'.$function);
        curl_setopt($curl_hander, CURLOPT_POSTFIELDS, json_encode($param)); //设置提交的字符串
        $result = curl_exec($curl_hander);
        return $result;
    }
}

