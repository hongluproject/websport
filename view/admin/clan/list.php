<link href="/assets/css/datepicker.css" rel="stylesheet">
<script src="/assets/js/datepicker.js" type="text/javascript"></script>
<script src="/assets/js/lang/en.js" type="text/javascript"></script>
<script src="/assets/js/lang/en-us.js" type="text/javascript"></script>

<div class="container-fluid">
    <form  name="editform" id="editform" action="/admin/horn/update" method="post">
        <input type="hidden" name="pb_stat" id="pb_stat" value="">
        <table class="table table-bordered table-striped" >
            <thead>
            <tr>
                <th width="20">ObjectId</th>
                <th width="100">标签名</th>
                <th width="20">权重</th>
                <th width="20">ICON</th>
                <th width="20">状态</th>
                <th width="20">层级</th>
                <th width="20">父标签</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>

            <?php if (isset($result) && !empty($result->results)) {?>

                 <?php foreach ($result->results as $item): ?>
                    <tr>
                         <td><?php echo $item->objectId; ?></td>
                        <td><?php echo $item->tag_name; ?></td>
                        <td><?php echo $item->rank; ?></td>
                        <td><?php echo $item->icon; ?></td>
                        <td><?php echo $item->status; ?></td>
                        <td><?php echo $item->level; ?></td>
                        <td><?php echo $item->pid; ?></td>
                        <td>
                            <a href="/admin/tag/update/<?php echo $item->objectId; ?>"><i class="icon-ok" alt="更新" title="更新"></i></a>&nbsp;&nbsp;&nbsp;
                            <a href="/admin/tag/delete/<?php echo $item->objectId; ?>" class="delete"><i class="icon-remove" alt="删除" title="删除"></i></a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php }?>
            <tr>
                <th width="20">ObjectId</th>
                <th width="100">标签名</th>
                <th width="20">权重</th>
                <th width="20">ICON</th>
                <th width="20">状态</th>
                <th width="20">层级</th>
                <th width="20">父标签</th>
                <th width="50">操作</th>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="20"><?php echo $page->page; ?></td>
            </tr>
            </tfoot>
        </table>

    </form>

</div>
