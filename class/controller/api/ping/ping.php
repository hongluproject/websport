<?php
namespace Controller\Api\Ping;

class Ping extends    \Controller\Api
{


    public function get()
    {
        require_once(SP."class/utils/ping/lib/Pingpp.php");
        $input_data = $_GET;
        if (empty($input_data['channel']) || empty($input_data['amount'])) {
            echo "no channel or amount";
            exit();
        };

        $input_data =  array(
            "order_no"  => $input_data['order_no'],//商户订单号，这里是你的系统中的订单号
            "app"       => array("id" => config('pingAppId')),//请填写你的应用 ID
            "channel"   => strtolower($input_data['channel']),//支付渠道
            "amount"    => $input_data['amount'],//订单金额，单位：分
            "client_ip" => $_SERVER["REMOTE_ADDR"],//客户端 IP
            "currency"  => "cny",//货币，目前只支持 cny
            "subject"   =>$input_data['subject'],//商品名称
            "body"      => $input_data['body']//商品描述
        );


        $extra = array();
        switch ($input_data['channel']) {
            case 'alipay_wap':
                $extra = array(
                    'success_url' => 'http://www.yourdomain.com/success',
                    'cancel_url' => 'http://www.yourdomain.com/cancel'
                );
                break;
            case 'upmp_wap':
                $extra = array(
                    'result_url' => 'http://www.yourdomain.com/result?code='
                );
                break;
        }

        \Pingpp::setApiKey(config('pingKey'));
        $ch = \Pingpp_Charge::create(
            array(
                "order_no"  => $input_data['order_no'],//商户订单号，这里是你的系统中的订单号
                "app"       => array("id" => config('pingAppId')),//请填写你的应用 ID
                "channel"   => strtolower($input_data['channel']),//支付渠道
                "amount"    => $input_data['amount'],//订单金额，单位：分
                "client_ip" => $_SERVER["REMOTE_ADDR"],//客户端 IP
                "currency"  => "cny",//货币，目前只支持 cny
                "subject"   => $this->utf8_substr($input_data['subject'],0,30),//商品名称
                "body"      => $input_data['body'],//商品描述
            )
        );


        //回写avos  写入seriousNO
        if ($ch) {
            $chDecode = json_decode($ch, true);
                $acurl = new \Utils\Acurl();
                $where = '{"bookNumber":"' . $chDecode['order_no'] . '"}';
                $result = json_decode($acurl->setOption(array('method' => 'get', 'limit' => 1, 'class' => 'StatementAccount', 'where' => $where))->getCurlResult(), true);
                if ($result['results'][0]['objectId']) {
                    $acurl = new \Utils\Acurl();
                    $param['serialNumber'] = $chDecode['id'];
                    $result = $acurl->setOption(array('method' => 'post', 'class' => 'StatementAccount', 'field' => $param, 'objectId' => $result['results'][0]['objectId']))->getCurlResult();
                }




            //不用保存
            $charge = array();
            $charge['order_no'] = $chDecode['order_no'];
            $charge['chargeId'] = $chDecode['id'];
            $charge['body'] = $chDecode['body'];
            $charge['subject'] = $chDecode['subject'];
            $charge['channel'] = $chDecode['channel'];
            $charge['amount'] = $chDecode['amount'];
            $charge['time_expire'] = $chDecode['time_expire'];
            $charge['info'] = json_encode($chDecode['credential']);
            $charge['mode'] = 1;
            $chargeClass = new \Model\Charge();
            $chargeClass->set($charge);
            $chargeClass->save();


        }


        echo $ch;
        exit;
    }



    function utf8_substr( $str , $start , $length=null ){
        $res = substr( $str , $start , $length );
        $strlen = strlen( $str );
        if ( $start >= 0 ){
            $next_start = $start + $length;
            $next_len = $next_start + 6 <= $strlen ? 6 : $strlen - $next_start;
            $next_segm = substr( $str , $next_start , $next_len );
            $prev_start = $start - 6 > 0 ? $start - 6 : 0;
            $prev_segm = substr( $str , $prev_start , $start - $prev_start );
        }
        else{
            $next_start = $strlen + $start + $length; // 初始位置
            $next_len = $next_start + 6 <= $strlen ? 6 : $strlen - $next_start;
            $next_segm = substr( $str , $next_start , $next_len );
            $start = $strlen + $start;
            $prev_start = $start - 6 > 0 ? $start - 6 : 0;
            $prev_segm = substr( $str , $prev_start , $start - $prev_start );
        }
        if ( preg_match( '@^([\x80-\xBF]{0,5})[\xC0-\xFD]?@' , $next_segm , $bytes ) ){
            if ( !empty( $bytes[1] ) ){
                $bytes = $bytes[1];
                $res .= $bytes;
            }
        }
        $ord0 = ord( $res[0] );
        if ( 128 <= $ord0 && 191 >= $ord0 ){
            if ( preg_match( '@[\xC0-\xFD][\x80-\xBF]{0,5}$@' , $prev_segm , $bytes ) ){
                if ( !empty( $bytes[0] ) ){
                    $bytes = $bytes[0];
                    $res = $bytes . $res;
                }
            }
        }
        return $res;
    }

    public function post()
    {



    }

}

