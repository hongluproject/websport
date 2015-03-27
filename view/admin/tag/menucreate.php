<link href="/assets/css/bootstrap-tagsinput.css" rel="stylesheet">
<script src="/assets/js/bootstrap-tagsinput.js" type="text/javascript"></script>
<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>添加目录</fieldset>

        <div class="control-group">
            <label class="control-label">目录名</label>
            <div class="controls">
                <input type="text" name="title"  class="span4" value="<?php echo $result['title'];?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">权重</label>
            <div class="controls">
                <input type="text" name="tagSort"  class="span4" value="<?php echo $result['tagSort']?$result['tagSort']:1;?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">目录状态</label>
            <div class="controls">
                <select   name="status"   class="span2" >
                    <option value="1"    <?php if ($result['status']==1) :?>selected="true"<?php endif ;?> >上线</option>
                    <option value="2"    <?php if ($result['status']==2) :?>selected="true"<?php endif ;?> >下线</option>
                </select>

            </div>
        </div>


        <div class="control-group">
            <label class="control-label">背景色</label>
            <div class="controls">
                <select   name="cover"   class="span2" >
                    <option value="yule"  <?php if ($result['cover']=="yule") :?>selected="true"<?php endif ;?>  >娱乐</option>
                    <option value="huwai"  <?php if ($result['cover']=="huwai") :?>selected="true"<?php endif ;?>  >户外</option>
                    <option value="caijing"  <?php if ($result['cover']=="caijing") :?>selected="true"<?php endif ;?>  >财经</option>
                    <option value="shenghuo"  <?php if ($result['cover']=="shenghuo") :?>selected="true"<?php endif ;?>  >生活</option>
                </select>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">兴趣标签</label>
            <div class="controls">
                <input type="text" id="tags" name="tags"  value=""/>
            </div>
            <div class="controls">
                <select    id="pid"  class="span2" >
                    <option value=""></option>
                    <?php foreach($tags['results'] as $item) {?>
                        <option value="<?php echo $item['objectId'];?>"  ><?php echo $item['tag_name'];?></option>
                    <?php }?>
                </select>
                <span id="tag_tree">
                </span>
                <button onclick="return addTagInput('tags','pid','tag_sub_select');"><span>添加新标签</span></button>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>




<?php


if($result['tagIds']){
    $temp = $result['tagIds'];
}else {
    $temp = array();
}
$tags_k_y = array();
foreach($temp as $item){

    $tags_k_y[] = array('value'=>$tags['results'][$item]['objectId'],'text'=>$tags['results'][$item]['tag_name']);
}
$tags_json = json_encode($tags_k_y);

 ?>

<script>
    var tags_json = <?php echo $tags_json;?>;
    var tag_tree =  <?php echo json_encode($tags['results']);?>;

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


