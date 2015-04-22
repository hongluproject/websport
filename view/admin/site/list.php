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
                <th width="100">点标号</th>
              <!--  <th width="100">二维码链接</th>
                <th width="100">任务二维码链接</th>-->
                <th width="100">点标位置</th>
                <th width="100">点标名称</th>
                <th width="100">分配到线路</th>
                <th width="100">位置信息</th>
                <th width="100">通关方式</th>
                <th width="100">任务书</th>
                <th width="100">点长</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($result->list as $item): ?>
                    <tr>

                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->siteId; ?></td>
                        <!--
                        <td>
                            <?php /*echo "http://sport.hoopeng.cn/api/sport/scan?type=2&lineId=".$item->lineId."&siteId=".$item->siteId.htmlspecialchars("&section=").$item->section."&md=".md5($item->lineId.'-'.$item->siteId);*/?>
                        </td>


                        <td>
                            <?php /*if ($item->passInfo == 2):*/?>
                            <?php /*echo "http://sport.hoopeng.cn/api/sport/scan?type=1&lineId=".$item->lineId."&siteId=".$item->siteId.htmlspecialchars("&section=").$item->section;*/?>
                            <?php /*endif ;*/?>
                        </td>-->


                        <td><?php  if($item->section ==1){echo '起点';}elseif($item->section == 3){echo '终点';}else{ echo '中间站点';}; ?></td>
                        <td><?php echo $item->siteName; ?></td>

                        <td><?php echo $item->lineId; ?></td>
                        <td><?php echo $item->position; ?></td>
                        <td><?php  if($item->passInfo ==2){echo '特殊性-任务书';}else{echo '一般性-直接通过';}; ?></td>
                        <td><?php  foreach(json_decode($item->mission,true) as $key => $temp){ echo $key."#";}; ?></td>
                        <td><?php echo $item->siteManager; ?></td>
                        <td>
                            <a href="/admin/site/edit/<?php echo $item->id; ?>" target="_blank"><i class="icon-ok" alt="更新" title="更新"></i></a>&nbsp;&nbsp;&nbsp;
<!--                            <a href="/admin/site/delete/<?php /*echo $item->id; */?>" class="delete"><i class="icon-remove" alt="删除" title="删除"></i></a>&nbsp;&nbsp;&nbsp;
-->                        </td>
                    </tr>

                <?php endforeach; ?>
            <tr>
                <th width="20">Id</th>
                <th width="100">点标号</th>
        <!--        <th width="100">二维码链接</th>
                <th width="100">任务二维码链接</th>-->
                <th width="100">点标位置</th>
                <th width="100">点标名称</th>
                <th width="100">分配到线路</th>
                <th width="100">位置信息</th>
                <th width="100">通关方式</th>
                <th width="100">任务书</th>
                <th width="100">点长</th>
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
