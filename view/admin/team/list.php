<link href="/assets/css/datepicker.css" rel="stylesheet">
<script src="/assets/js/datepicker.js" type="text/javascript"></script>
<script src="/assets/js/lang/en.js" type="text/javascript"></script>
<script src="/assets/js/lang/en-us.js" type="text/javascript"></script>
<div class="container-fluid">
    <form class="well form-search" name="searchform" id="searchform" action="/admin/team" method="post">
        <input type="text" placeholder="按团队名称、队伍号搜索团队" class="span3"  name="searchParam" value="<?php if($searchParam){echo $searchParam;}?>">
        <button class="btn" type="submit">Search</button>
    </form>

    <form  name="editform" id="editform" action="" method="post">
        <input type="hidden" name="pb_stat" id="pb_stat" value="">
        <table class="table table-bordered table-striped" >
            <thead>
            <tr>
                <th width="20">Id</th>
                <th width="100">队伍号</th>
                <th width="100">队伍名称</th>
                <th width="100">状态</th>
                <th width="100">分配线路</th>
                <th width="100">当前点标</th>
                <th width="100">已完成点标个数</th>
                <th width="100">比赛开始时间</th>
                <th width="100">最后一次签到时间</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($result->list as $item): ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->teamId; ?></td>
                        <td><?php echo $item->teamName; ?></td>
                        <td><?php  if($item->status ==2){echo '弃权';}elseif($item->status==3){echo '取消成绩';}else{ echo "正常";} ?></td>
                        <td><?php echo $item->lineId; ?></td>
                        <td><?php echo $item->nowSite; ?></td>
                        <td><?php echo $item->passSiteNum; ?></td>
                        <td><?php echo $item->startSignUp; ?></td>
                        <td><?php echo $item->lastSignUp; ?></td>
                        <td>
                            <a href="/admin/team/edit/<?php echo $item->id; ?>" target="_blank"><i class="icon-ok" alt="更新" title="更新"></i></a>&nbsp;&nbsp;&nbsp;
                            <a href="/admin/team/delete/<?php echo $item->id; ?>" class="delete"><i class="icon-remove" alt="删除" title="删除"></i></a>&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                <?php endforeach; ?>
            <tr>
                <th width="20">Id</th>
                <th width="100">队伍号</th>
                <th width="100">队伍名称</th>
                <th width="100">状态</th>
                <th width="100">分配线路</th>
                <th width="100">当前点标</th>
                <th width="100">已完成点标个数</th>
                <th width="100">比赛开始时间</th>
                <th width="100">最后一次签到时间</th>
                <th width="50">操作</th>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="20"><?php echo $result->page; ?></td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
