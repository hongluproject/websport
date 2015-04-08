<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>新建点标</fieldset>

        <div class="control-group">
            <label class="control-label">点标号</label>
            <div class="controls">
                <input type="text" name="siteId"  class="span2" value="<?php echo $result->siteId; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">点标名称</label>
            <div class="controls">
                <input type="text" name="siteName"  class="span4" value="<?php echo $result->siteName; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">分配线路</label>
            <div class="controls">
                <select class="span3" id="status" name="lineId">

                    <?php foreach($lineList as $item):?>
                        <option value="<?php echo $item->lineId?>" <?php if($result->lineId == $item->lineId){ echo 'selected="selected"';}?> ><?php echo $item->lineName?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">位置信息</label>
            <div class="controls">
                <input type="text" name="position"  class="span4" value="<?php echo $result->position; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">通关方式</label>
            <div class="controls">
                <select class="span3" id="passInfo" name="passInfo">
                    <option value="1" <?php if($result->passInfo == 1){ echo 'selected="selected"';}?> >一般性-直接通过</option>
                    <option value="2" <?php if($result->passInfo == 2){ echo 'selected="selected"';}?>>特殊性-任务书</option>
                </select>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group"  id="missionShow" <?php if($result->passInfo!=2): ?>style="display: none;" <?php endif;?>>
            <label class="control-label">任务书</label>
            <div class="controls">
                <button class="btn btn-primary" type="button" id="addMission">新增任务书</button>
            </div>
        </div>


        <div class="control-group" id="missionList">
            <?php  $mission = json_decode($result->mission,true);foreach($mission as $key=>$item):?>
             <div class="controls controls-row"><input  placeholder="任务标题" class="span2"  type="text" name="missionTitle[]" value="<?php echo $key?>"><input class="span4"  placeholder="任务H5链接" type="text" name="missionUrl[]" value="<?php echo $item;?>"><button class="btn btn-danger delete" type="button">删除</button></div>
           <?php endforeach;?>
        </div>

        <div class="control-group">
            <label class="control-label"> 点长</label>
            <div class="controls">
                <input type="text"  name="siteManager"   disabled class="span2" value="<?php echo $result->siteManager; ?>"/>
             </div>
        </div>

        <div class="control-group">
            <label class="control-label">联系电话</label>
            <div class="controls">
                <input type="text" name="phone"  class="span2" value="<?php echo $result->phone; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>


<script language="javascript">


    //添加任务书
    $("#addMission").click(function(){
        var html = '<div class="controls controls-row"><input class="span2"  placeholder="任务标题"  type="text" name="missionTitle[]"><input class="span4"  placeholder="任务H5链接"  type="text" name="missionUrl[]"><button class="btn btn-danger delete" type="button">删除<\/button><\/div>';
        $("#missionList").append(html);
    });
    $(".delete").live("click",function(){
         $(this).parent().html("");
　　})


    //删除任务书
    $("#passInfo").change(function(){
        if($(this).val()==1){
            $("#missionList").html('');
            $("#missionShow").hide();
        }else if ($(this).val()==2){
            $("#missionShow").show();
        }
    })


</script>
