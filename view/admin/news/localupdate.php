<?php if ($_GET['op']=='ok'){?>
    <div class="alert alert-info"><?php echo '更新成功';?></div>
<?php }?>
<link href="/assets/css/bootstrap-tagsinput.css" rel="stylesheet">
<script src="/assets/js/bootstrap-tagsinput.js" type="text/javascript"></script>


<link rel="stylesheet" href="/assets/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/assets/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/assets/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/assets/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/assets/kindeditor/plugins/code/prettify.js"></script>


<script>
    KindEditor.ready(function(K) {
        var editor1 = K.create('textarea[name="after_content"]', {
            cssPath : '/assets/kindeditor/plugins/code/prettify.css',
             allowFileManager : true,
            afterCreate : function() {
                var self = this;
                K.ctrl(document, 13, function() {
                    self.sync();
                    K('form[name=news]')[0].submit();
                });
                K.ctrl(self.edit.doc, 13, function() {
                    self.sync();
                    K('form[name=news]')[0].submit();
                });
            }
        });
        prettyPrint();
    });
</script>


<div class="well">
    <form class="form-horizontal validate"  name="news" action="" method="post">
        <fieldset>更新本地资讯</fieldset>

        <div class="control-group">
            <label class="control-label">标题</label>
            <div class="controls">
                <input type="text" name="title"  class="span4" value="<?php echo $result->title; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">新闻地址</label>
            <div class="controls">
                <input type="text" name="link" class="span4" value="<?php echo $result->link; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">文章来源</label>
            <div class="controls">
                <input type="text" name="post_user" class="span4" value="<?php echo $result->post_user; ?>"/>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">新闻内容</label>
            <textarea class="input-xlarge" id="textarea"  name="after_content" rows="20" style="width:700px;"><?php echo htmlspecialchars($result->after_content); ?></textarea>
        </div>



        <div class="control-group">
            <label class="control-label">列表图片</label>
            <div class="controls">
                <input type="text"   id="cover_pic"  name="cover_pic" class="span4" value="<?php echo  $result->cover_pic; ?>"/>
                <input id="img1" type="file" size="45" name="img" class="input">
                <button class="button" id="buttonUpload1" onclick="return ajaxFileUpload('img1','cover_pic');">上传</button>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">兴趣标签</label>
            <div class="controls">
            <input type="text" id="tags" name="tags"  value=""/>
            </div>
            <div class="controls">
                <select    id="pid"  class="span2"  onchange="appendSelect('pid','tag_tree',1,'tag_sub_select');">
                    <option value=""></option>
                    <?php foreach($cate_tree as $item) {?>
                        <option value="<?php echo $item->objectId;?>"  ><?php echo $item->tag_name;?></option>
                    <?php }?>
                </select>
                <span id="tag_tree">
                </span>
                 <button onclick="return addTagInput('tags','pid','tag_sub_select');"><span>添加新标签</span></button>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">地区</label>
            <div class="controls">
                <input type="text" id="areas" name="areas"  value=""/>
            </div>
            <div class="controls">
                <select    id="p_area_ids"  class="span2"  onchange="appendSelect('p_area_ids','area_tree',2,'area_sub_select');">
                    <option value=""></option>
                    <?php foreach($area_tree as $item) {?>
                        <option value="<?php echo $item->objectId;?>"  ><?php echo $item->title;?></option>
                    <?php }?>
                </select>
                <span id="area_tree">
                </span>
                <button onclick="return addTagInput('areas','p_area_ids','area_sub_select');"><span>添加新标签</span></button>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">分类</label>
            <div class="controls">
                <input type="text" id="cates" name="cateids"  value=""/>
            </div>
            <div class="controls">
                <select    id="p_cate_ids"  class="span2" >
                    <option value=""></option>
                     <?php foreach($cate_result as $item) {?>
                        <option value="<?php echo $item->objectId;?>"  ><?php echo $item->cate_name;?></option>
                    <?php }?>
                </select>
                <span id="area_tree">
                </span>
                <button onclick="return addTagInput('cates','p_cate_ids');"><span>添加新标签</span></button>
            </div>
        </div>




        <div class="control-group">
            <label class="control-label">文章状态</label>
            <div class="controls">
                <select id="status" name="status" class="span2">
                    <option value="1" <?php if($result->status==1):?>  selected="true" <?php endif;?> >数据原始状态</option>
                    <option value="2" <?php if($result->status==2):?>  selected="true" <?php endif;?>>达到推送</option>
                    <option value="3" <?php if($result->status==3):?>  selected="true" <?php endif;?>>已推送到AVOS</option>
                    <option value="4">直接推送到AVOS</option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>



<?php
if($result->tags){
    $temp = explode(',',$result->tags);
}else {
    $temp = array();
}
$tags_k_y = array();
foreach($temp as $item){
   $tags_k_y[] = array('value'=>$tags[$item]->objectId,'text'=>$tags[$item]->tag_name);
}
 $tags_json = json_encode($tags_k_y);



if($result->areas){
    $temp = explode(',',$result->areas);
}else {
    $temp = array();
}
$areas_k_y = array();
foreach($temp as $item){
    $areas_k_y[] = array('value'=>$areas[$item]->objectId,'text'=>$areas[$item]->title);
}
$areas_json = json_encode($areas_k_y);


//cate_result

if($result->cateids){
    $temp = explode(',',$result->cateids);
}else {
    $temp = array();
    foreach($cate_result as $item){
        if(strpos($result->title,$item->cate_name)!==false){
            array_push($temp,$item->objectId);
        }
    }
}

$cate_k_y = array();
foreach($temp as $item){
    $cate_k_y[] = array('value'=>$cate_result[$item]->objectId,'text'=>$cate_result[$item]->cate_name);
}
$cates_json = json_encode($cate_k_y);
?>

<script>
    var tags_json = <?php echo $tags_json;?>;
    var tag_tree =  <?php echo json_encode($cate_tree);?>;
    var area_json = <?php echo $areas_json;?>;
    var area_tree = <?php echo json_encode($area_tree);?>;
    var cate_json =<?php echo $cates_json;?>;
    var cate_tree = <?php echo json_encode($cate_result);?>;


    var sub_tree = null;
    var elt = $('#tags');
    elt.tagsinput({
        itemValue: 'value',
        itemText: 'text'
    });
    if(tags_json.length>0){
        for(var i = 0;i<tags_json.length;i++){
        elt.tagsinput('add', { "value": tags_json[i].value , "text": tags_json[i].text});
        }
    }

    elt = $('#areas');
    elt.tagsinput({
        itemValue: 'value',
        itemText: 'text'
    });
    if(area_json.length>0){
        for(var i = 0;i<area_json.length;i++){
            elt.tagsinput('add', { "value": area_json[i].value , "text": area_json[i].text});
        }
    }



    elt = $('#cates');
    elt.tagsinput({
        itemValue: 'value',
        itemText: 'text'
    });
    if(cate_json.length>0){
        for(var i = 0;i<cate_json.length;i++){
            elt.tagsinput('add', { "value": cate_json[i].value , "text": cate_json[i].text});
        }
    }


    function appendSelect(select_id,tag,type,sub_select){
        var objectId = $("#"+select_id).val();
        if(!objectId){
            $('#'+tag).html("");
        }else{
             if(type==1){
                var tag_name = 'tag_name';
                sub_tree =  tag_tree[objectId].subtree;
            }else if(type ==2){
                var tag_name = 'title';
                sub_tree =  area_tree[objectId].subtree;
            }
            sub_select =   '<select   id="'+sub_select+'"  class="span2" >';
            sub_select +='<option value=""></option>';
            $.each(sub_tree, function(i,val){
                sub_select +='<option value="'+val.objectId+'">'+val[tag_name]+'</option>';
            });
            sub_select +='<\/select>';
            $('#'+tag).html(sub_select);
        }
        sub_tree = null;
    }
    function addTagInput(input_tags,top_select,tag_select){
        var checkText = null;
        var checkValue = null;
        if($("#"+tag_select).find("option:selected").text()){
             checkText=$("#"+tag_select).find("option:selected").text();
             checkValue=$("#"+tag_select).val();
        }else if($("#"+top_select).find("option:selected").text()){
            checkText=$("#"+top_select).find("option:selected").text();
            checkValue=$("#"+top_select).val();
        }else{
            return false;
        }
       $('#'+input_tags).tagsinput('add', {  "value": checkValue , "text": checkText});
        return false;
    }


    function ajaxFileUpload(var1,var2){

        $.ajaxFileUpload({
            url:'/api/imageupload?format=json',//处理图片脚本
            secureuri :false,
            fileElementId :var1,//file控件id
            dataType : 'json',
            success : function (data, status){
                $("#"+var2).val(data.msg);
            },
            error: function(data, status, e){
            }
        })
        return false;
    }

</script>











