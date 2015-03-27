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
                <th width="20">ObjectId</th>
                <th width="100">标题</th>
                <th width="100">图片</th>
                <th width="100">上下线</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($result) && !empty($result->results)) {?>
                 <?php foreach ($result->results as $item): ?>
                    <tr>

                         <td><?php echo $item->objectId; ?></td>
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo $item->coverPic; ?></td>
                        <td><?php echo $item->status; ?></td>
                        <td>
                            <a href="/admin/recommend/edit/<?php echo $item->objectId; ?>" target="_blank"><i class="icon-ok" alt="更新" title="更新"></i></a>&nbsp;&nbsp;&nbsp;
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php }?>
            <tr>
                <th width="20">ObjectId</th>
                <th width="100">标题</th>
                <th width="100">图片</th>
                <th width="100">上下线</th>
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
