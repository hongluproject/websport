<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>新建任务</fieldset>


        <div class="control-group">
            <label class="control-label">任务标题</label>
            <div class="controls">
                <input type="text" name="title"  class="span4" value="<?php echo $result->title; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">任务H5链接</label>
            <div class="controls">
                <input type="text" name="missionLink"  class="span4" value="<?php echo $result->missionLink; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">任务描述</label>
            <div class="controls">
                <input type="text" name="description"  class="span4" value="<?php echo $result->description; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>


