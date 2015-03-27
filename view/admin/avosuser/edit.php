<div class="well">
    <form class="form-horizontal validate" action="" method="post">
        <fieldset>注册用户信息</fieldset>

        <div class="control-group">
            <label class="control-label">用户呼号</label>
            <div class="controls">
                <input type="text" name="invite_id" class="span1" value="<?php echo $result->invite_id; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户姓名</label>
            <div class="controls">
                <input type="text" name="username" class="span4" value="<?php echo $result->username; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户昵称</label>
            <div class="controls">
                <input type="text" name="nickname" class="span4" value="<?php echo $result->nickname; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户头像</label>
            <div class="controls">
                <img src="<?php echo  $result->icon?>"  style="width: 100px;height: 100px;" class="span4"  />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户标签</label>
            <div class="controls">
                <?php
                $tags = '';
                foreach($result->tags as $item){
                    $tags.= " ".$tags_arr[$item];
                }
                ?>
                <input type="text" name="tags" class="span4 uneditable-input" value="<?php echo $tags; ?>" />
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">用户部落</label>
            <div class="controls">
                <?php
                $tags = '';
                foreach($result->clanids as $item){
                    $clans.= " ".$clan_arr[$item];
                }
                ?>
                <input type="text" name="clanids" class="span4 uneditable-input" value="<?php echo $clans; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户常驻地区</label>
            <div class="controls">
                <input type="text" name="normal_area" class="span4" value="<?php echo $result->normal_area; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户实时地区</label>
            <div class="controls">
                <input type="text" name="actual_position" class="span4" value="<?php echo $result->actual_position; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户性别</label>
            <div class="controls">
                <?php if($result->sex == 1){$sex = '男';}elseif($result->sex == 2){$sex = '女';}else{$sex = '未知';} ?>
                <input type="text" name="sex" class="span4" value="<?php echo $sex; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">好友数</label>
            <div class="controls">
                <input type="text" name="sex" class="span4" value="<?php echo $result->friendCount; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">动态数</label>
            <div class="controls">
                <input type="text" name="sex" class="span4" value="<?php echo $result->dynamicCount; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">问答数</label>
            <div class="controls">
                <input type="text" name="sex" class="span4" value="<?php echo $result->questionCount; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">部落数</label>
            <div class="controls">
                <input type="text" name="sex" class="span4" value="<?php echo $result->clanCount; ?>"/>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">用户QQ</label>
            <div class="controls">
                 <input type="text" name="qq" class="span4" value="<?php echo $result->qq; ?>"/>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">用户blog</label>
            <div class="controls">
                <input type="text" name="blog" class="span4" value="<?php echo $result->blog; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户微信</label>
            <div class="controls">
                <input type="text" name="wechat" class="span4" value="<?php echo $result->wechat; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户状态</label>
            <div class="controls">
                <input type="text" name="status" class="span4" value="<?php echo $result->status; ?>"/>
            </div>
        </div>









        <div class="control-group">
            <label class="control-label">用户积分</label>
            <div class="controls">
                <input type="text" name="score" class="span4" value="<?php echo $result->score; ?>"/>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">用户权限</label>
            <div class="controls">
                <input type="text" name="power" class="span4" value="<?php echo $result->power; ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">用户等级</label>
            <div class="controls">
                <input type="text" name="level" class="span4" value="<?php echo $result->level; ?>"/>
            </div>
        </div>

    </form>
</div>