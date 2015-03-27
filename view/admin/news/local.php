<link href="/assets/css/datepicker.css" rel="stylesheet">
<script src="/assets/js/datepicker.js" type="text/javascript"></script>
<script src="/assets/js/lang/en.js" type="text/javascript"></script>
<script src="/assets/js/lang/en-us.js" type="text/javascript"></script>


<div class="container-fluid">
    <form class="well form-search" name="searchform" id="searchform" action="/admin/news/local?search=1" method="post">
        <select id="status"  name="status" class="span2">
            <option value="">资讯状态</option>
            <?php foreach($status as $key=>$value) {?>
                <option value="<?php echo $key;?>" <?php if (isset($params['status']) && ''!=$params['status'] && $key==$params['status']) {?> selected="selected" <?php }?>><?php echo $value;?></option>
            <?php }?>
        </select>
        <select id="tags"  name="tags" class="span2">
            <option value="">标签</option>
            <?php foreach($sub_tags->results as $key=>$value) {?>
                <option value="<?php echo $value->objectId;?>" <?php if (isset($params['tags']) && ''!=$params['tags'] && $value->objectId==$params['tags']) {?> selected="selected" <?php }?> ><?php echo $value->tag_name;?></option>
            <?php }?>
        </select>


        <select id="order_pic"  name="order_pic" class="span2">
                <option value="1" <?php if (isset($params['order_pic']) && ''!=$params['order_pic'] && 1==$params['order_pic']) {?> selected="selected" <?php }?> >按照图片排序</option>
                <option value="0" <?php if ($params['order_pic']==null) {?> selected="selected" <?php }?> >按照时间排序</option>
        </select>
        &nbsp;&nbsp;
        <input type="text" placeholder="资讯标题" class="span2" id="txt" name="title" value="<?php if (isset($params['title']) && !empty($params['title'])) echo $params['title'];?>">
        &nbsp;&nbsp;

        <input type="text" placeholder="上传者" class="span2" id="txt" name="post_user" value="<?php if (isset($params['post_user']) && !empty($params['post_user'])) echo $params['post_user'];?>">
        &nbsp;&nbsp;

        <input type="text" placeholder="发布日期…" class=" span2 w16em w16em dateformat-m-sl-d-sl-Y show-weeks statusformat-l-cc-sp-d-sp-F-sp-Y fill-grid" name="post_date" id="post_date" value = "<?php if (isset($params['post_date']) && !empty($params['post_date'])) echo $params['start_time'];?>">
        &nbsp;&nbsp;
        <button class="btn" type="submit" >Search</button>

    </form>
    <form  name="editform" id="editform" action="/admin/news/local" method="post">
        <table class="table table-bordered table-striped" >
            <thead>
            <tr>
                <th width="80">
                    <input type="checkbox" value="" name="checkall" id="checkall" onclick="checkIds()"> 全选|反选
                </th>
                <th width="20">ID</th>
                <th width="100">标题</th>
                <th width="100">资讯URL</th>
                <th width="100">图片</th>
                <th width="100">上传者</th>
                <th width="50">时间</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($result) && !empty($result->list)) {?>
                <?php foreach ($result->list as $item): ?>
                    <tr>
                        <th>
                            <input type="checkbox" value="<?php echo $item->id; ?>" name="ids[]" id="ids[]">
                        </th>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo $item->link; ?></td>
                        <td ><?php echo $item->cover_pic; ?></td>
                        <td><?php echo $item->post_user; ?></td>
                        <td><?php echo $item->post_date; ?></td>
                        <td>
                            <a href="/admin/news/localupdate/<?php echo $item->id; ?>" target="_blank"><i class="icon-ok" alt="更新" title="更新"></i></a>&nbsp;&nbsp;&nbsp;
                            <a href="/admin/news/delete/<?php echo $item->id; ?>" class="delete"><i class="icon-remove" alt="删除" title="删除"></i></a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php }?>
            <tr>
                <th width="80">
                    <div class="btn-group dropup">
                        <span class="btn">
                            批量
                        </span>
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu pull-right" style="width: 50px;">
                            <li>
                                <a href="javascript:void(0);" title="发布到线上" onclick="multiUpdate('1')"><i class="icon-play"></i> 发布到线上</a>
                            </li>

                        </ul>
                    </div>
                    <!--<button class="btn btn-mini">批量审核</button>-->
                </th>
                <th width="20">ID</th>
                <th width="100">标题</th>
                <th width="100">资讯URL</th>
                <th width="100">图片</th>
                <th width="100">上传者</th>
                <th width="50">时间</th>
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

<script type="text/javascript">
    function checkIds(){
        if ( typeof($("#checkall").attr('checked')) == "undefined") {
            $("input[name='ids[]']").attr("checked",false);
        } else {
            $("input[name='ids[]']").attr("checked",true);
        }
    }
    function multiUpdate(pb_status){
        $("#editform").submit();
    }

</script>