<?php
namespace Controller\Api;

class Config extends \Controller\Api
{
    public function get()
    {
        $key    = empty($_GET['key'])    ? null : (string)$_GET['key'];
        $prekey = empty($_GET['prekey']) ? null : (string)$_GET['prekey'];
        if ($key!==null)
        {
            $rs = \Model\Option::find(array('key'=>$key));
            $this->data = $rs->value;
        }
        elseif ($prekey!==null)
        {
            $rs = \Model\Option::fetch();
            $this->data = array();
            foreach ($rs as $item)
            {
                $arr = explode('.', $item->key);
                $pre = array_shift($arr);
                $kk = implode(',' ,$arr);
                if (count($arr)>0 && $pre==$prekey)
                {
                    $this->data[$kk] = $item->value;
                }
            }
        }
        else
        {
            $rs = \Model\Option::fetch();
            $this->data = array();
            foreach ($rs as $item)
                $this->data[$item->key] = $item->value;
        }
    }
}