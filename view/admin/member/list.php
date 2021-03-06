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
                <th width="100">队员编号</th>
                <th width="100">姓名</th>
                <th width="100">队伍序号</th>
                <th width="100">队伍名</th>
                <th width="100">手机号</th>
                <th width="100">状态</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($result->list as $item): ?>
                    <tr>

                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->userId; ?></td>
                        <td><?php echo $item->username; ?></td>
                        <td><?php echo $item->teamId; ?></td>
                        <td><?php echo $item->teamName; ?></td>
                        <td><?php echo $item->phone; ?></td>
                        <td><?php echo $item->status; ?></td>
                        <td>
                            <a href="/admin/member/edit/<?php echo $item->id; ?>" target="_blank"><i class="icon-ok" alt="更新" title="更新"></i></a>&nbsp;&nbsp;&nbsp;
                            <a href="/admin/member/delete/<?php echo $item->id; ?>" class="delete"><i class="icon-remove" alt="删除" title="删除"></i></a>&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                <?php endforeach; ?>
            <tr>
                <th width="20">Id</th>
                <th width="100">队员编号</th>
                <th width="100">姓名</th>
                <th width="100">队伍序号</th>
                <th width="100">队伍名</th>
                <th width="100">手机号</th>
                <th width="100">状态</th>
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
