<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>更新分类</fieldset>

        <div class="control-group">
            <label class="control-label">分类标题</label>
            <div class="controls">
                <input type="text" name="cate_name"  class="span4" value="<?php echo $result->cate_name; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">权重</label>
            <div class="controls">
                <input type="text" name="rank" class="span1" value="<?php echo $result->rank; ?>"/>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">状态</label>
            <div class="controls">
                <input type="text" name="status" class="span1" value="<?php echo $result->status; ?>"/>
            </div>
        </div>


        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>