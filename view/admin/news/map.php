<?php foreach ($avos_tags as $item):?>
    <?php echo $item->tag_name?>    已完成(<?php echo $news_tags_count[$item->objectId]?$news_tags_count[$item->objectId]:0 ?>)条 <div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="60"
         aria-valuemin="0" aria-valuemax="100" style="width:  <?php echo $news_tags_count[$item->objectId]/5*100;?>%;">
        <span class="sr-only"></span>
    </div>
</div>

<?php endforeach;?>

