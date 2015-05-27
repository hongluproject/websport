


<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th width="100">站点名</th>
        <th width="100">本站特殊二维码</th>
        <th width="100">特殊二维码</th>

    </tr>
    </thead>
    <tbody>

    <?php foreach ($result as $item):?>
    <tr>
        <td><?php echo $item->lineId.'-'.$item->siteId?></td>
        <td><input class="span6" value="http://sport.hoopeng.cn/api/sport/scan?type=2&lineId=<?php echo $item->lineId?>&siteId=<?php echo $item->siteId?>&section=<?php echo $item->section;?>" type="text"/></td>
        <td> <?php if($item->passInfo==2):?><input type="text" class="span6" value="http://sport.hoopeng.cn/api/sport/scan?type=1&lineId=<?php echo $item->lineId?>&siteId=<?php echo $item->siteId?>&section=<?php echo $item->section;?>"/><?php endif;?></td>
    </tr>
    <?php endforeach;?>

    <tr>
        <th width="100">站点名</th>
        <th width="100">本站特殊二维码</th>
        <th width="100">特殊二维码</th>

    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="20">
        </td>
    </tr>
    </tfoot>
</table>



