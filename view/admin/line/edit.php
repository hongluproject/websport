<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>新建线路</fieldset>



        <div class="control-group">
            <label class="control-label">线路号</label>
            <div class="controls">
                <input type="text" name="lineId"  class="span2" value="<?php echo $result->lineId; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>




        <div class="control-group">
            <label class="control-label">线路名称</label>
            <div class="controls">
                <input type="text" name="lineName"  class="span2" value="<?php echo $result->lineName; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


<!--

        <div class="control-group">
            <label class="control-label">点标情况</label>
            <div class="controls">
                <input type="text" name="siteInfo"  class="span2" value="<?php /*echo $result->siteInfo; */?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>
-->



        <div class="control-group">
            <label class="control-label">线长</label>
            <div class="controls">
                <input type="text" name="lineManager"  class="span2" value="<?php echo $result->lineManager; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>




        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
            <button type="button" class="btn back">取消</button>
        </div>
    </form>
</div>

