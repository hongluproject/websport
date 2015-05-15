<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui" />
    <title></title>
    <style>
        *{ margin:0px; padding:0px;}
        .img_box{ width:100%;}
        .img_box img{ width:100%; vertical-align:top}
        .conbox{ width:320px;  height:303px; background:url(../../assets/img/bg1.jpg) no-repeat; background-size:cover; margin:0 auto}
        .input1{ padding:80px 32px 0 100px;  }
        .input1 input{ width:100%; background:#fff; height:25px; border:0 none; background:none;  color:#333; }
        li{list-style:none}
        input{resize:none;outline:0}
        input{font-family:inherit;font-size:inherit;font-weight:inherit;font-size:100%}
        .conbox ul{ padding-top:96px; padding-left:40px; overflow:hidden}
        .conbox li{ height:28px; float:left; width:80px; margin-left:40px; overflow:hidden; margin-bottom:4px;}
        .conbox li input{ background:none; border:0 none; float:left; line-height:28px; color:#333; }
    </style>
</head>
<body>
<div class="img_box">
    <img src="../../assets/img/bg2.jpg">
</div>
<!--类容 s-->
<div class="conbox">
    <div class="input1">
        <input type="text" value="<?php echo $result[0]->teamName?>">
    </div>
    <ul>
        <?php foreach($result as $item):?>
        <li><input type="text" value="<?php echo $item->username?>"></li>
        <?php endforeach?>
    </ul>
</div>
<!--类容 e-->
<div class="img_box">
    <img src="../../assets/img/bg3.jpg">
</div>
</body>
</html>






