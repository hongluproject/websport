<link href="/assets/css/datepicker.css" rel="stylesheet">
<script src="/assets/js/datepicker.js" type="text/javascript"></script>
<script src="/assets/js/lang/en.js" type="text/javascript"></script>
<script src="/assets/js/lang/en-us.js" type="text/javascript"></script>
<div class="container-fluid">

    <form class="well form-search" name="searchform" id="searchform" action="/admin/avosuser" method="post">
        <input type="text" name="title"  class="span4" value=""/>
        <button class="btn" type="submit">Search</button>
    </form>

    <form  name="editform" id="editform" action="/admin/horn/update" method="post">
        <input type="hidden" name="pb_stat" id="pb_stat" value="">
        <table class="table table-bordered table-striped" >
            <thead>
            <tr>
                <th width="20">ObjectId</th>
                <th width="20">昵称</th>
                <th width="20">用户名</th>
                <th width="20">动态数</th>
                <th width="20">问答数</th>
                <th width="20">部落数</th>
                <th width="20">好友数</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($result) && !empty($result->results)) {?>
                 <?php foreach ($result->results as $item): ?>
                    <tr>
                        <td><?php echo $item->objectId; ?></td>
                        <td><?php echo $item->nickname; ?></td>
                        <td><?php echo $item->username; ?></td>
                        <td><?php echo $item->dynamicCount; ?></td>
                        <td><?php echo $item->questionCount; ?></td>
                        <td><?php echo $item->clanCount; ?></td>
                        <td><?php echo $item->friendCount; ?></td>
                        <td>
                            <a href="/admin/avosuser/edit/<?php echo $item->objectId; ?>"><i class="icon-ok" alt="查看所有资料" title="查看所有资料"></i></a>&nbsp;&nbsp;&nbsp;
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php }?>
            <tr>
                <th width="20">ObjectId</th>
                <th width="20">昵称</th>
                <th width="20">用户名</th>
                <th width="20">动态数</th>
                <th width="20">问答数</th>
                <th width="20">部落数</th>
                <th width="20">好友数</th>
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
