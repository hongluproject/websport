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
        .conbox{ width:320px;  height:303px; background:url(../../assets/img/xxs3.png) repeat; background-size:cover; margin:0 auto}
        .input1{ padding:110px 32px 0 100px;  }
        .input1 input{ width:100%; background:#fff; height:25px; border:0 none; background:none;  color:#333; }
        li{list-style:none}
        input{resize:none;outline:0}
        input{font-family:inherit;font-size:inherit;font-weight:inherit;font-size:100%}
        .conbox ul{ padding-top:76px; padding-left:40px; overflow:hidden}
        .conbox li{ height:28px; float:left; width:80px; margin-left:60px; overflow:hidden; margin-bottom:4px;}
        .conbox li input{ background:none; border:0 none; float:left; line-height:28px; color:#333; }
        .body_bg{background:url(../../assets/img/bg.png)}
    </style>
</head>
<body  class="body_bg">
<div class="img_box">
    <img src="../../assets/img/xxs1.png">
</div>
<!--类容 s-->
<div class="conbox">
    <div class="input1">
        <input type="text"  readonly="true" value="<?php echo $result[0]->teamName?>">
    </div>
    <ul>
        <?php foreach($result as $item):?>
            <li><input type="text" readonly="true"  value="<?php echo $item->username?>"></li>
        <?php endforeach?>
    </ul>
</div>
<!--类容 e-->
<div class="img_box">
    <img src="../../assets/img/xxs2.png">
    <a href="javascript:doClient();"> <img src="../../assets/img/zhengshu.png"></a>

</div>
</body>


<script language="javascript">
    function doClient() {
        if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
            var loadDateTime = new Date();
            window.setTimeout(function() {
                var timeOutDateTime = new Date();
                if (timeOutDateTime - loadDateTime < 2000) {
                    window.location = "http://a.app.qq.com/o/simple.jsp?pkgname=com.honglu.sahala";
                } else {
                    window.close();
                }
            }, 25);
        } else if (navigator.userAgent.match(/android/i)) {
            var state = null;
            try {
                window.location = "http://a.app.qq.com/o/simple.jsp?pkgname=com.honglu.sahala";
            } catch (e) {}
            if (state) {
                window.close();
            } else {
                window.location = "http://a.app.qq.com/o/simple.jsp?pkgname=com.honglu.sahala";
            }
        }
    }
</script>
</html>






