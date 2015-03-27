<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>更新推荐</fieldset>

        <div class="control-group">
            <label class="control-label">标题</label>
            <div class="controls">
                <input type="text" name="title"  class="span4" value="<?php echo $result->title; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">标签图片</label>
            <div class="controls">
                <input type="text"   id="tag_icon"  name="coverPic" class="span4" value="<?php echo $result->coverPic;?>"/>
                <input id="img1" type="file" size="45" name="img" class="input">
                <button class="button" id="buttonUpload1" onclick="return ajaxFileUpload('img1','tag_icon');">上传</button>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">活动ID(暂时这么搞)</label>
            <div class="controls">
                <input type="text" name="activityId"  class="span4" value="<?php echo $result->activityId->objectId; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">状态</label>
            <div class="controls">
                <select id="status" name="status" class="span2">
                    <option value="0" <?php if(empty($result->status)):?>  selected="true" <?php endif;?> >上线(默认)</option>
                    <option value="1" <?php if($result->status==1):?>  selected="true" <?php endif;?>>下线</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>



<script type="text/javascript">
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