<?php

namespace Controller\Admin\User;

class Message extends \Controller\Admin\User
{
    public $data;
    public $path = array('user', 'message');
    protected $_tpl = 'admin/user/message';

    public function get()
    {



    }


    public function post(){
        //URL


//http://localhost/sp/DemoSrc/DealPage.php?type=0&port=*&self=0&flownum=0&method=2&phones=15955159604&msg=员工您好，感谢您对此次测试的配合。&r=0.6739688859511926

        include(SP . "class/utils/sp/config.php");
        include(SP . "class/utils/sp/function.php");
        include(SP . "class/utils/sp/Client.php");

        //array ( 'type' => '0', 'port' => '*', 'self' => '0', 'flownum' => '0', 'method' => '2', 'phones' => '15955159604', 'msg' => '员工您好，感谢您对此次测试的配合。', 'r' => '0.19251617023744183', )
        //array ( 'type' => '0', 'port' => '*', 'self' => '0', 'flownum' => '0', 'method' => 2, 'phones' => '15955159604', 'msg' => '员工您好，感谢您对此次测试的配合。', 'r' => '0.9542653846064739', )

        $db = \Model\Line::db();
        $dbUser  = $db->fetch('select `phone`   from  `ma_member` where `phone` <> "" group by `phone`');
        foreach($dbUser as $item){
            $newArr[] = trim($item->phone);
        }
        //100个1组
        $chunArr = array_chunk($newArr,100);
        foreach ($chunArr as $item){
            $phones = implode(',',$item);
            $V['type'] = '0';
            $V['port'] ='*';
            $V['self']='0';
            $V['flownum'] ='0';
            $V['method']= '2';
            $V['phones'] =$phones;
            $V['msg'] ='员工您好，感谢您对此次测试的配合。';
            $V['r']= mt_rand(10000000000,999999999999);
            if (!isset($V['type']) || !isset($V['method']))
            {
                echo "参数有误！！";
                return;
            }
            $smsInfo['userId'] = $username;
            $smsInfo['password'] = $password;
            //$smsInfo['pszSubPort'] = $V['port'];
            //$smsInfo['flownum'] = $V['flownum'];
            $action = $pageurl;
            $defhandle = $V['type']; //设置请求接口
            if ($V['self'] == 4)
            {
                $smsInfo['multixmt'] = ' ';
                $defhandle = 5;	//个性化发送  2014-09-11
            }
            if ($V['method'] > 0)
            {
                $action.="/".$pginface[$defhandle];
            }

            $sms = new \Client($action, $V['method']);
            $strRet = '';
            switch($V['type'])
            {
                //发送信息
                case 0:
                    $smsInfo['pszSubPort'] = $V['port'];
                    $smsInfo['flownum'] = $V['flownum'];

                    $smsInfo['pszMsg'] = $V['msg'];
                    if ($V['phones'] == '')
                        $mobiles = array();
                    else
                        $mobiles = explode(',', $V['phones']);

                    $smsInfo['pszMsg'] = str_replace("\\\\","\\",$smsInfo['pszMsg']);

                    $PhonsInfo = $V['phones'];
                    $Conts = substr_count($PhonsInfo, ',')+1;  //手机号码个数
                    if($Conts > 100)
                    {
                        $result = "号码个数超过100";	//
                        echo($result);
                        break;
                    }

                    $lenTest = strLength($V['msg']);// + $signlens;  //短信字符个数
                    if($lenTest > 350)
                    {
                        $result = "短信字符个数超过350";	//
                        echo($result);
                        break;
                    }

                    $result = $sms->sendSMS($smsInfo, $mobiles);

                    //错误
                    if (($strRet = GetCodeMsg($result, $statuscode)) != '')
                        break;

                    $len = strLength($V['msg']) + $signlens;
                    $strsigns = '';

                    if ($len <= 70)
                    {
                        //单条短信，生成消息ID
                        if (0 == $V['method'])
                            $strsigns = singleMsgId($result, $mobiles, ';');
                        else
                            $strsigns = singleMsgId($result[0], $mobiles, ';');
                    }
                    else
                    {
                        //长短信，生成消息ID
                        $nlen = ceil($len/67);

                        if (0 == $V['method'])
                            $strsigns = longMsgId($result, $mobiles, $nlen, ';');
                        else
                            $strsigns = longMsgId($result[0], $mobiles, $nlen, ';');
                    }
                    $strRet = $strsigns;
                    break;

               /* //获取上行或状态报告
                case 1:
                    $result = $sms->GetMoSMS($smsInfo);
                    if (!$result)
                    {
                        $strRet = '无任何上行信息';
                        break;
                    }
                    //错误
                    if (($strRet = GetCodeMsg($result, $statuscode)) != '')
                        break;

                    //返回上行信息
                    //日期,时间,上行源号码,上行目标通道号,*,信息内容
                    //$strRet = implode(';', $result);
                    if (is_array($result))
                        $strRet = implode(';', $result);
                    else
                        $strRet = $result;

                    break;

                //获取状态报告*/
             /*   case 2:
                    $result = $sms->GetRpt($smsInfo);
                    if (!$result)
                    {
                        $strRet = '无任何状态报告';
                        break;
                    }
                    //错误
                    if (($strRet = GetCodeMsg($result, $statuscode)) != '')
                        break;

                    //返回状态报告
                    //日期,时间,信息编号,*,状态值,详细错误原因  状态值（0 接收成功，1 发送暂缓，2 发送失败）
                    if (is_array($result))
                        $strRet = implode(';', $result);
                    else
                        $strRet = $result;
                    break;

                //获取余额*/
               /* case 3:
                    $result = $sms->GetMoney($smsInfo);
                    //错误
                    if (($strRet = GetCodeMsg($result, $statuscode)) != '')
                        break;
                    //返回余额
                    if (0 == $V['method'])
                        $strRet = $result;
                    else
                        $strRet = $result[0];
                    break;
                case 4:
                    $result = $sms->GetMoAndRpt($smsInfo);

                    if (!$result)
                    {
                        $strRet = '无任何上行信息和状态报告';
                        break;
                    }
                    //错误
                    if (($strRet = GetCodeMsg($result, $statuscode)) != '')
                        break;

                    //返回上行信息
                    //日期,时间,上行源号码,上行目标通道号,*,信息内容
                    $strRet = implode(';', $result);
                    break;*/
             /*   case 5:
                    $smsInfo['multixmt'] = $V['sefmsg'];
                    $smsInfo['multixmt'] = str_replace("\\\\","\\",$smsInfo['multixmt']);

                    $result = $sms->SefsendSMS($smsInfo);

                    if (0 == $V['method'])
                    {
                        $strRet = str_replace("\n","",$result);
                    }
                    else
                    {
                        $strRet = $result[0];
                    }
                    break;*/

                default:
                    $strRet = "没有匹配的业务类型";
                    break;
            }
            echo($strRet);
        }
    }
}