
<div class="well">
    <form class="form-horizontal validate" action="" method="post">
    <input type="hidden" name='id' value="<?php echo $result->id?>">
        <div class="control-group">
            <label class="control-label">用户名</label>
            <div class="controls">
                <input type="text" name="username"  value="<?php echo $result->username;?>"/>
                <span class="help-inline">必填</span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">密码</label>
            <div class="controls">
                <input type="text" name="password" value=""/>
                <span class="help-inline">必填</span>
            </div>
        </div>



        <div class="form-actions">
            <button type="submit" class="btn btn-info btn-large">提交</button>
         </div>
    </form>
</div>
