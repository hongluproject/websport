<link href="/assets/css/datepicker.css" rel="stylesheet">
<script src="/assets/js/datepicker.js" type="text/javascript"></script>
<script src="/assets/js/lang/en.js" type="text/javascript"></script>
<script src="/assets/js/lang/en-us.js" type="text/javascript"></script>
<div class="container-fluid">
    <form  name="editform" id="editform" action="" method="post">
        <input type="hidden" name="pb_stat" id="pb_stat" value="">
        <table class="table table-bordered table-striped" >
            <thead>
            <tr>
                <th width="20">Id</th>
                <th width="100">线路号</th>
                <th width="100">线路名称</th>
                <th width="100">点标情况</th>
                 <th width="100">线长</th>
                <th width="100">联系方式</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($result->list as $item): ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->lineId; ?></td>
                        <td><?php echo $item->lineName; ?></td>
                        <td> <?php echo $countLine[$item->lineId];?> &nbsp;&nbsp;<a href="http://sport.hoopeng.cn/admin/site/<?php echo $item->lineId?>" target="_blank">点击查看</a></td>
                        <td><?php echo $item->lineManagerName; ?></td>
                        <td><?php echo $item->phone; ?></td>
                        <td>
                            <a href="/admin/line/edit/<?php echo $item->id; ?>" target="_blank"><i class="icon-ok" alt="更新" title="更新"></i></a>&nbsp;&nbsp;&nbsp;

                            <?php if($this->user->admin == 1):?>
                            <a href="/admin/line/delete/<?php echo $item->id; ?>"  onclick="if(confirm('注意：删除线路后，会同时删除本条线路里的点标和队伍，以及队伍的历史成绩，请确认是否要继续删除？')==false)return false;" >删除</a>&nbsp;&nbsp;&nbsp;
                            <?php endif?>


                        </td>
                    </tr>
                <?php endforeach; ?>
            <tr>
                <th width="20">Id</th>
                <th width="100">线路号</th>
                <th width="100">线路名称</th>
                <th width="100">点标情况</th>
                <th width="100">线长</th>
                <th width="100">联系方式</th>
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
