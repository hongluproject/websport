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

        <div class="control-group">
            <label class="control-label">最后一次签到时间</label>
            <div class="controls">
                <input type="text" name="lastSignUp"  class="span4" value="<?php echo $result->lastSignUp; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">状态</label>
            <div class="controls">
                <input type="text" name="status"  class="span2" value="<?php echo $result->status; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">分配线路</label>
            <div class="controls">
                <input type="text" name="nowLine"  class="span2" value="<?php echo $result->nowLine; ?>"/>
             </div>
        </div>


        <div class="control-group">
            <label class="control-label">比赛开始时间</label>
            <div class="controls">
                <input type="text" name="startSignUp"  class="span2" value="<?php echo $result->startSignUp; ?>"/>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">已完成站点个数</label>
            <div class="controls">
                <input type="text" name="passSiteNum"  class="span2" value="<?php echo $result->passSiteNum; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">当前站点</label>
            <div class="controls">
                <input type="text" name="nowSite"  class="span2" value="<?php echo $result->nowSite; ?>"/>
            </div>
        </div>



        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>


