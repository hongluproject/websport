<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui" />
    <script src="/assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="    http://api.imsahala.com/js/common.js?2015040101" type="text/javascript"></script>
    <title>投票</title>
    <style>
        @charset "utf-8";body,h1,h2,h3,h4,h5,h6,hr,p,blockquote,dl,dt,dd,ul,ol,li,pre,form,fieldset,legend,button,input,textarea,th,td{margin:0;padding:0}
        body,button,input,select,textarea{font:12px/1.5 'Microsoft Yahei','Lucida Grande',Arial,'\5b8b\4f53'}
        h1,h2,h3,h4,h5,h6{font-size:100%}
        ul,ol{list-style:none}
        iframe,img{border:0;vertical-align:middle}
        table{border-collapse:collapse;border-spacing:0}
        i,b,s,em{font-style:normal}
        del{font-family:'\5b8b\4f53'}.clear{*zoom:1}
        .cf:after {
            clear: both;
        }
        .cf:before, .cf:after {
            content: "";
            display: table;
        }

        .chart-list{
            width: 100%;
            padding-top: 10px;
            border-collapse: collapse;
            border-spacing: 0px;
        }

        .chart-list li {
            position: relative;
            height: 114px;
            border-bottom: 1px solid #E2E2E2;
        }

        .chart-list li .num{
            width: 50px;
            line-height: 114px;
            color: #888;
            font-size: 25px;
            font-family: "Microsoft YaHei";
            text-align: center;
            float: left;

        }
        .chart-list li .img{
            line-height: 114px;
            text-align: center;
            display: block;
            float: left;
            overflow: hidden;

        }

        .chart-list li .img img{
            width: 60px;
            height: 60px;
            border-radius: 7px;

        }


        .chart-list li .intro{
            margin-left: 10px;
            text-align: center;
            display: block;
            float: left;
            overflow: hidden;
        }



        .chart-list li .intro .title{
            color: #333;
            text-align: left;
            width: 100px;
            line-height: 67px;
            font-size: 13px;
            word-break:keep-all;/* 不换行 */
            white-space:nowrap;/* 不换行 */
        }

        .chart-list li .intro .note{
            color: #333;
            text-align: left;
        }


        .chart-list li  .toupiao{
            line-height: 114px;
            float: right;
            margin-right: 20px;
            text-align:center;
        }




        .chart-list li  .btn:hover {
            color: #FFF;
            background: none repeat scroll 0% 0% #cccccc;
        }


        .chart-list li  .btn {
            display: inline-block;
            width: 70px;
            height: 30px;
            line-height: 30px;
            margin: 0px;
            padding: 0px;
            color: #FFF;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border: 0px none;
            vertical-align: middle;
            cursor: pointer;
            border-radius: 7px;
        }


       .has_note{
            color: #FFF;
            background: none repeat scroll 0% 0% #cccccc;

        }

        .no_note{
            background: none repeat scroll 0% 0% #36cad8;

        }



        .share {max-width: 640px;margin:0 auto}


    </style>
</head>
<body >

<div class="share">
    <div class="ui-resp-pics2 ui-100x56 cf top" >
        <ul class="chart-list">

            <?php if($isSubmit == 1){
                $hover = 'has_note';

            } else {
                $hover = 'no_note';
            }

            ?>

            <?php foreach($noteResult as $key=>$item):?>
            <li>
                <div class="num"><?php echo $key+1;?></div>
                <div class="img"> <img src="<?php echo $item->imageUrl?>"  ></div>
                <div class="intro"><p class="title"><?php echo $item->title?></p><p class="note" >票数　<em id="<?php echo $item->objectId;?>_count"><?php echo $item->count?></em></p></div>
                <div class="toupiao"  ><a href="javaScript:void(0)" class="btn <?php echo $hover;?>" id="<?php echo $item->objectId;?>_addnote" rel="<?php echo $item->objectId;?>">投票</a></div>
            </li>
            <?php endforeach;?>

        </ul>
    </div>
</div>

</body>


<script language="javascript">


    //document.cookie  = 'submitNote=1';
    $(function(){
        var strcookie=document.cookie;
        var arrcookie=strcookie.split("; ");
        var submitNote;
        for(var i=0;i<arrcookie.length;i++){
            var arr=arrcookie[i].split("=");
            if("submitNote"==arr[0]){
                submitNote=arr[1];
                break;
            }
        }

        if(submitNote == 1){
            $(function(){
                $("ul li").each(function(){
                    $(this).find('.btn').attr('class','btn has_note');
                })
            })
        }

        $(".btn").click(function(){

            if (!isInHoopeng()) {
                alert("请下载撒哈拉在APP内打开");return;
            }

            if(submitNote == 1){
                alert("不能重复投票");return;
            }
            var love = $(this);
            var id = love.attr("rel"); //对应id
            $.ajax({
                type:"POST",
                url:"note.php",
                data:"id="+id,
                cache:false, //不缓存此页面
                success:function(data){
                    if(data.status==2){
                        var count =   1+parseInt($("#"+id+"_count").html());
                        $("#"+id+"_count").html(count);
                        $(function(){
                            $("ul li").each(function(){
                                $(this).find('.btn').attr('class','btn has_note');
                            })
                        })
                        document.cookie  = 'submitNote=1';
                        alert(data.message);
                    }else{
                        alert(data.message);
                    }
                }
            });
            return false;
        });
    });
</script>


</html>






