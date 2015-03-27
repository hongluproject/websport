<?php

namespace Utils;

class Acurl
{
    private $skip;
    private $count = 1;
    private $order = '-updatedAt';
    private $method = 'get';
    private $limit = 10;
    private $objectId = null;
    private $curl_hander;
    private $param = array();
    private $class;

    public function  __construct()
    {
        $this->curl_hander = curl_init();
        curl_setopt($this->curl_hander, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->curl_hander, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl_hander, CURLOPT_HEADER, 0);
        $header[] = APP_ID;
        $header[] = App_KEY;
        $header[] = 'Content-Type: application/json';
        curl_setopt($this->curl_hander, CURLOPT_HTTPHEADER, $header);
        curl_setopt($this->curl_hander, CURLOPT_CONNECTTIMEOUT, 3);
        return $this->curl_hander;
    }

    public function getCurlResult()
    {
        $methodFun = 'Curl' . $this->param['method'];
        return $this->$methodFun();
    }

    public function  Curlget()
    {
        curl_setopt($this->curl_hander, CURLOPT_CUSTOMREQUEST, "GET");
        $class = $this->param['class'];
        unset($this->param['class']);
        unset($this->param['method']);
        //TODO becasuse unsupprt cql;
        if ($this->param['objectId']) {
            //sign
            curl_setopt($this->curl_hander, CURLOPT_URL, AVOS_PATH . $class . '/' . $this->param['objectId']);
        } else {
            //list
            curl_setopt($this->curl_hander, CURLOPT_URL, AVOS_PATH . $class . '?' . http_build_query($this->param));
        }
        $result = curl_exec($this->curl_hander);
        return $result;
    }

    public function Curlcsql()
    {
        curl_setopt($this->curl_hander, CURLOPT_CUSTOMREQUEST, "GET");
        //$cql_url = 'https://leancloud.cn/1.1/cloudQuery?'.urlencode($this->param['csql']);
        $cql_url = 'https://leancloud.cn/1.1/cloudQuery?cql="select * from News"';
        curl_setopt($this->curl_hander, CURLOPT_URL, $cql_url);
        $result = curl_exec($this->curl_hander);
        print_r($result);exit;

        return $result;
    }


    public function Curlpost()
    {
        $class = $this->param['class'];
        unset($this->param['class']);
        unset($this->param['method']);
        if ($this->param['objectId']) {
            curl_setopt($this->curl_hander, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($this->curl_hander, CURLOPT_URL, AVOS_PATH . $class . '/' . $this->param['objectId']);
        } else {
            curl_setopt($this->curl_hander, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($this->curl_hander, CURLOPT_URL, AVOS_PATH . $class);
        }
        curl_setopt($this->curl_hander, CURLOPT_POSTFIELDS, json_encode($this->param['field'])); //设置提交的字符串
        $result = curl_exec($this->curl_hander);

        return $result;
    }


    public function Curldelete()
    {
        curl_setopt($this->curl_hander, CURLOPT_CUSTOMREQUEST, "DELETE");
        $class = $this->param['class'];
        curl_setopt($this->curl_hander, CURLOPT_URL, AVOS_PATH . $class . '/' . $this->param['objectId']);
        $result = curl_exec($this->curl_hander);
        return $result;
    }




    public function setOption(array $options)
    {
        if ($options['method'] == 'get') {
            $param = array(
                'limit' => $this->limit,
                'count' => $this->count,
                'order' => $this->order,
            );
            $this->param = array_merge($param, $options);
            //$extend 1,2,3,4  1的时候放弃page 因为是本地
            $extend = $this->param['extend'];
            unset($this->param['extend']);
            if ($_GET['page'] && $extend != 1) {
                $this->param ['skip'] = ($_GET['page'] - 1) * $this->param ['limit'];
            }
        } elseif ($options['method'] == 'post') {
            //todo merge
            $this->param = $options;
        } elseif ($options['method'] == 'delete') {
            $this->param = $options;
        } elseif ($options['method'] == 'csql') {
            $this->param = $options;
        }
        return $this;
    }
}


