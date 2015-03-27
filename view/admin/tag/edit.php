<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>更新标签</fieldset>

        <div class="control-group">
            <label class="control-label">标签名</label>
            <div class="controls">
                <input type="text" name="tag_name"  class="span4" value="<?php echo $result->tag_name; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">标签图片</label>
            <div class="controls">
                <input type="text"   id="tag_icon"  name="icon" class="span4" value="<?php echo  $result->icon; ?>"/>
                <input id="img1" type="file" size="45" name="img" class="input">
                <button class="button" id="buttonUpload1" onclick="return ajaxFileUpload('img1','tag_icon');">上传</button>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">Hover标签图片</label>
            <div class="controls">
                <input type="text"   id="hover_icon"  name="hover_icon" class="span4" value="<?php echo  $result->hover_icon; ?>"/>
                <input id="img2" type="file" size="45" name="img" class="input">
                <button class="button" id="buttonUpload2" onclick="return ajaxFileUpload('img2','hover_icon');">上传</button>
            </div>
        </div>




        <div class="control-group">
            <label class="control-label">APP穿衣标识</label>
            <div class="controls">
                <input type="text" name="clothesTag" class="span1" value="<?php echo  $result->clothesTag; ?>"/>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">别名</label>
            <div class="controls">
                <input type="text" name="alias_name" class="span4" value="<?php echo  $result->alias_name; ?>"/>
            </div>
        </div>





        <div class="control-group">
            <label class="control-label">标签状态</label>
            <div class="controls">
                <select   name="status"   class="span2" >
                    <option value="1"    <?php if ($result->status==1) :?>selected="true"<?php endif ;?> >上线</option>
                    <option value="2"    <?php if ($result->status==2) :?>selected="true"<?php endif ;?> >下线</option>
                </select>

            </div>
        </div>


        <div class="control-group">
            <label class="control-label">标签权重</label>
            <div class="controls">
                <input type="text" name="rank" class="span1" value="<?php echo $result->rank; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">抓取是否带父标题</label>
            <div class="controls">
                <select   name="fetch_rule"   class="span2" >
                    <option value="1"  <?php if ($result->fetch_rule==1) :?>selected="true"<?php endif ;?>  >不带</option>
                    <option value="2"  <?php if ($result->fetch_rule==2) :?>selected="true"<?php endif ;?> >带</option>
                </select>
            </div>
        </div>




        <div class="control-group" style="display: block">
            <label class="control-label">字典目录</label>
            <div class="controls">
                <select   name="tagDirectoryId"   class="span2" >
                    <option value=""></option>


                    <?php foreach ($tagdirectory['results'] as $item):?>
                        <option value="<?php echo $item['objectId'];?>"  <?php if ($result->tagDirectoryId->objectId==$item['objectId']) :?>selected="true"<?php endif ;?> ><?php echo $item['title']?></option>
                    <?php endforeach;?>

                </select>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">层级</label>
            <div class="controls">
                <select   name="level" id="level" class="span2" >
                    <option value="1"  <?php if ($result->level==1) :?>selected="true"<?php endif ;?>  >一级</option>
                    <option value="2"  <?php if ($result->level==2) :?>selected="true"<?php endif ;?> >二级</option>
                </select>
                <span>1,2 父标签1，子标签2</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">父标签</label>
            <div class="controls">
                <select   name="pid" class="span2">
                    <option value=""></option>
                    <?php foreach($pids->results as $value) {?>
                        <option value="<?php echo $value->objectId;?>" <?php if($result->pid == $value->objectId):?>selected="true"<?php endif;?>><?php echo $value->tag_name;?> </option>
                    <?php }?>
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

