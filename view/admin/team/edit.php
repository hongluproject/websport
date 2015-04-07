<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>新建队伍</fieldset>

        <div class="control-group">
            <label class="control-label">团队编号</label>
            <div class="controls">
                <input type="text" name="teamId"  class="span4" value="<?php echo $result->teamId; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">团队名称</label>
            <div class="controls">
                <input type="text" name="teamName"  class="span2" value="<?php echo $result->teamName; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

<!--        <div class="control-group">
            <label class="control-label">最后一次签到时间</label>
            <div class="controls">
                <input type="text" name="lastSignUp"  class="span4" value="<?php /*echo $result->lastSignUp; */?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>-->



        <div class="control-group">
            <label class="control-label">队长</label>
            <div class="controls">
                <input type="text" name="teamLeader"  class="span2" value="<?php echo $result->teamLeader; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">联系方式</label>
            <div class="controls">
                <input type="text" name="phone"  class="span2" value="<?php echo $result->phone; ?>"/>
            </div>
        </div>




        <div class="control-group">
            <label class="control-label">状态</label>
            <div class="controls">

                <select class="span3" id="status" name="status">
                    <option value="1" <?php if($result->status == 1){ echo 'selected="selected"';}?> >正常</option>
                    <option value="2" <?php if($result->status == 2){ echo 'selected="selected"';}?> >弃权</option>
                    <option value="3" <?php if($result->status == 3){ echo 'selected="selected"';}?> >取消成绩</option>
                </select>
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





        <!-- <div class="control-group">
             <label class="control-label">比赛开始时间</label>
             <div class="controls">
                 <input type="text" name="startSignUp"  class="span2" value="<?php /*echo $result->startSignUp; */?>"/>
             </div>
         </div>
 -->
<!--
        <div class="control-group">
            <label class="control-label">已完成点标个数</label>
            <div class="controls">
                <input type="text" name="passSiteNum"  class="span2" value="<?php /*echo $result->passSiteNum; */?>"/>
            </div>
        </div>-->

      <!--  <div class="control-group">
            <label class="control-label">当前点标</label>
            <div class="controls">
                <input type="text" name="nowSite"  class="span2" value="<?php /*echo $result->nowSite; */?>"/>
            </div>
        </div>
-->


        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>


