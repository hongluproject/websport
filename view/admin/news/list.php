<link href="/assets/css/datepicker.css" rel="stylesheet">
<script src="/assets/js/datepicker.js" type="text/javascript"></script>
<script src="/assets/js/lang/en.js" type="text/javascript"></script>
<script src="/assets/js/lang/en-us.js" type="text/javascript"></script>

<div class="container-fluid">
    <form class="well form-search" name="searchform" id="searchform" action="/admin/news" method="post">
        <input type="text" placeholder="资讯标题" class="span2" id="txt" name="title" value="<?php if (isset($searchParam['title']) && !empty($searchParam['title'])) echo $searchParam['title'];?>">
        &nbsp;&nbsp;
        开始日期<input type="text" placeholder="发布日期…"
                   class=" span2 w16em w16em dateformat-m-sl-d-sl-Y show-weeks statusformat-l-cc-sp-d-sp-F-sp-Y fill-grid"
                   name="start_date" id="start_date"
                   value="<?php if (isset($searchParam['start_date']) && !empty($searchParam['start_date'])) echo $searchParam['start_date']; ?>">
        &nbsp;&nbsp;
        结束日期<input type="text" placeholder="发布日期…"
                   class=" span2 w16em w16em dateformat-m-sl-d-sl-Y show-weeks statusformat-l-cc-sp-d-sp-F-sp-Y fill-grid"
                   name="end_date" id="end_date"
                   value="<?php if (isset($searchParam['end_date']) && !empty($searchParam['end_date'])) echo $searchParam['end_date']; ?>">
        &nbsp;&nbsp;
        <button class="btn" type="submit">Search</button>
    </form>

    <form  name="editform" id="editform" action="/admin/horn/update" method="post">
        <input type="hidden" name="pb_stat" id="pb_stat" value="">
        <table class="table table-bordered table-striped" >
            <thead>
            <tr>
                <th width="20">ObjectId</th>
                <th width="100">标题</th>
                <th width="100">资讯URL</th>
                <th width="100">上传时间</th>
                <th width="100">评论数</th>
                <th width="100">顶</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($result) && !empty($result->results)) {?>
                 <?php foreach ($result->results as $item): ?>
                    <tr>

                         <td><?php echo $item->objectId; ?></td>
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo $item->contents_url; ?></td>
                        <td><?php echo $item->createdAt; ?></td>
                        <td><?php echo $item->comment_count; ?></td>
                        <td><?php echo $item->up_count; ?></td>
                        <td>
                            <a href="/admin/news/update/<?php echo $item->objectId; ?>" target="_blank"><i class="icon-ok" alt="更新" title="更新"></i></a>&nbsp;&nbsp;&nbsp;
                            <a href="/admin/news/delete/<?php echo $item->objectId; ?>?type=avos" class="delete"><i class="icon-remove" alt="删除" title="删除"></i></a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php }?>
            <tr>
                <th width="20">ObjectId</th>
                <th width="100">标题</th>
                <th width="100">资讯URL</th>
                <th width="100">上传时间</th>
                <th width="100">评论数</th>
                <th width="100">顶</th>
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
