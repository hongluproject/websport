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
<!--                            <a href="/admin/line/delete/<?php /*echo $item->id; */?>" ><i class="icon-remove" alt="删除" title="删除"></i></a>&nbsp;&nbsp;&nbsp;
-->
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
