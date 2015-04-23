<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>新建点标</fieldset>

        <div class="control-group">
            <label class="control-label">点标号</label>
            <div class="controls">
                <input type="text" name="siteId"  <?php if($user->level ==2){ echo 'readonly="true"';}?> class="span2" id="ilove" value="<?php echo $result->siteId; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">线路点位</label>
            <div class="controls">
                <input type="radio" name="section"   value="1"  <?php if($result->section == 1){ echo 'checked="true"';}?> id="startSite">起点
                <input type="radio" name="section"   value="2"  <?php if($result->section == 2){ echo 'checked="true"';}?>>中间线路
                <input type="radio" name="section"   value="3"  <?php if($result->section == 3){ echo 'checked="true"';}?>>终点
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

                <textarea name="position" placeholder="【点标地址】"><?php echo $result->position; ?></textarea>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group" >
            <label class="control-label"> 任务书</label>
            <div class="controls">
            <textarea name="mission" placeholder="【任务书】"><?php echo $result->mission; ?></textarea>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label"> 任务书答案</label>
            <div class="controls">
            <textarea name="missionResult" ><?php echo $result->missionResult; ?></textarea>
            </div>
        </div>





        <div class="control-group">
            <label class="control-label"> 点长</label>
            <div class="controls">
                <input type="text"  name="siteManager"   readonly="true" class="span2" value="<?php echo $result->siteManager ?>"/>
             </div>
        </div>

        <div class="control-group">
            <label class="control-label"> 点长姓名</label>
            <div class="controls">
                <input type="text"  name="siteManagerName"    class="span4" value="<?php echo $result->siteManagerName;?>"/>
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



        <div class="control-group">
            <label class="control-label">站点二维码URL</label>
            <div class="controls">
                <input type="text"  class="span8"   value="http://sport.hoopeng.cn/api/sport/scan?type=2&lineId=<?php echo $result->lineId?>&siteId=<?php echo $result->siteId?>&section=<?php echo $result->section;?>&md=<?php echo md5($result->lineId.'-'.$result->siteId)?>"/>
                <span class="help-inline" style="color: #ff0000">系统,不可修改</span>
            </div>

        </div>


    </form>
</div>


<script language="javascript">




    $("#startSite").click(function(){
        $("#ilove").val(0);

    })



</script>
