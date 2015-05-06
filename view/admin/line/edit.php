<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>新建线路</fieldset>



        <div class="control-group">
            <label class="control-label">线路号</label>
            <div class="controls">
                <input type="text" name="lineId"  class="span2" value="<?php echo $result->lineId; ?>"/>
                <span class="help-inline">必填</span>
                <span class="help-inline" style="color: #ff0000">线路号格式为两位数字，例如1号线路为01，14号线路为14</span>

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
                <input type="text" name="lineManager"   readonly="true" class="span2" value="<?php echo $result->lineManager; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label"> 线长姓名</label>
            <div class="controls">
                <input type="text"  name="lineManagerName"     class="span4" value="<?php echo $result->lineManagerName;?>"/>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label">手机号</label>
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


