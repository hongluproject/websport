<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>新建报名</fieldset>

        <div class="control-group">
            <label class="control-label">团队名称</label>
            <div class="controls">
                <input type="text" name="teamName"  class="span4" value="<?php echo $result->teamName; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">队伍号</label>
            <div class="controls">
                <input type="text" name="teamId"  class="span2" value="<?php echo $result->teamId; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">所属线路</label>
            <div class="controls">
                <input type="text" name="lineName"  class="span4" value="<?php echo $result->lineName; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">线路号</label>
            <div class="controls">
                <input type="text" name="lineId"  class="span2" value="<?php echo $result->lineId; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">队长</label>
            <div class="controls">
                <input type="text" name="teamLeader"  class="span2" value="<?php echo $result->teamLeader; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">联系方式</label>
            <div class="controls">
                <input type="text" name="phone"  class="span2" value="<?php echo $result->phone; ?>"/>
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

        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>


