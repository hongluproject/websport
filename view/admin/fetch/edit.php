<link href="/assets/css/bootstrap-tagsinput.css" rel="stylesheet">
<script src="/assets/js/bootstrap-tagsinput.js" type="text/javascript"></script>

<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>抓取数据</fieldset>


        <div class="control-group">
            <label class="control-label">输入详情页URL</label>
            <div class="controls">
                <input type="text" name="url"  class="span4" value=""/>
                <span class="help-inline">必填</span>
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
</script>
