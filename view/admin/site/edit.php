<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>新建站点</fieldset>

        <div class="control-group">
            <label class="control-label">站点号</label>
            <div class="controls">
                <input type="text" name="siteId"  class="span2" value="<?php echo $result->siteId; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">站点名称</label>
            <div class="controls">
                <input type="text" name="siteName"  class="span4" value="<?php echo $result->siteName; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">分配到线路</label>
            <div class="controls">
                <input type="text" name="lineId"  class="span4" value="<?php echo $result->lineId; ?>"/>
                <span class="help-inline">必填</span>
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
                <input type="text" name="passInfo"  class="span3" value="<?php echo $result->passInfo; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">任务书</label>
            <div class="controls">
                <input type="text" name="mission"  class="span3" value="<?php echo $result->mission; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label"> 点长</label>
            <div class="controls">
                <input type="text" name="siteManager"  class="span2" value="<?php echo $result->siteManager; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>


