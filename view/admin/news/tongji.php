<link href="/assets/css/datepicker.css" rel="stylesheet">
<script src="/assets/js/datepicker.js" type="text/javascript"></script>
<script src="/assets/js/lang/en.js" type="text/javascript"></script>
<script src="/assets/js/lang/en-us.js" type="text/javascript"></script>
<script src="/assets/layer/layer.min.js" type="text/javascript"></script>
<link href="/assets/layer/skin/layer.css" rel="stylesheet">

<form class="well form-search" name="searchform" id="searchform" action="/admin/news/tongji" method="post">
    开始日期<input type="text" placeholder="发布日期…"
               class=" span2 w16em w16em dateformat-m-sl-d-sl-Y show-weeks statusformat-l-cc-sp-d-sp-F-sp-Y fill-grid"
               name="start_date" id="start_date"
               value="<?php if (isset($searchParam['start_date']) && !empty($searchParam['start_date'])) echo $searchParam['start_date']; ?>">
    &nbsp;&nbsp;---------------------
    结束日期<input type="text" placeholder="发布日期…"
               class=" span2 w16em w16em dateformat-m-sl-d-sl-Y show-weeks statusformat-l-cc-sp-d-sp-F-sp-Y fill-grid"
               name="end_date" id="end_date"
               value="<?php if (isset($searchParam['end_date']) && !empty($searchParam['end_date'])) echo $searchParam['end_date']; ?>">
    &nbsp;&nbsp;
    <button class="btn" type="submit">Search</button>
</form>
<?php foreach ($p_tags as $item): ?>
    <?php $total = 0; ?>
    <?php foreach ($item->subTree as $item1) {
        $total += $item1->count;
    }?>
    <?php echo $item->tag_name ?>    已完成(<?php echo $total; ?>)条
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
             style="width: 100%;"></div>
    </div>
    <?php foreach ($item->subTree as $item1): ?>

        <span style="margin-left: 50px;"><input type="button" value="点击查看"  onclick="showBox(<?php echo "'".$item1->objectId."'";?>);">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $item1->tag_name ?></span>    已完成(<?php echo $item1->count ?>)条
        <div class="progress" style="margin-left: 50px;">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"style="width: <?php echo ($item1->count / $total) * 100 ?>%;"></div>
        </div>
    <?php endforeach; ?>

<?php endforeach; ?>


<script>
function showBox(objectId){
    $(function(){
        $.layer({
            type: 2,
            shadeClose: true,
            title: [
                '统计结果',
                'background:#428BCA; height:40px; color:#FFF; border:none;' //自定义标题样式
            ],
            border:[0],
            area: ['800px', 500],
            iframe: {src: 'http://admin.hoopeng.cn/admin/news/tongjinews?objectId='+objectId+'&start_date=<?php echo $searchParam['start_date'] ?>&end_date=<?php echo $searchParam['end_date'] ?>'}
        })

    });



}







</script>

