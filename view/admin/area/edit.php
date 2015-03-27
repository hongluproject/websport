<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>更新地区</fieldset>
        <div class="control-group">
            <label class="control-label">标题</label>
            <div class="controls">
                <input type="text" name="title"  class="span4" value="<?php echo $result->title; ?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">层级</label>
            <div class="controls">
                <select   name="level" id="level" class="span2" >
                    <option value="1"  <?php if ($result->level==1) :?>selected="true"<?php endif ;?>  >一级</option>
                    <option value="2"  <?php if ($result->level==2) :?>selected="true"<?php endif ;?> >二级</option>
                </select>
                <span>1,2 父标签1，子标签2</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">父标签</label>
            <div class="controls">
                <select   name="pid" class="span2">
                    <option value=""></option>
                    <?php foreach($pids->results as $value) {?>
                        <option value="<?php echo $value->objectId.','.$value->title;?>" <?php if($result->pid == $value->objectId):?>selected="true"<?php endif;?>><?php echo $value->title;?> </option>
                    <?php }?>
                </select>
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