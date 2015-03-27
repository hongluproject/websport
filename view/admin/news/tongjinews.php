<div class="well sidebar-nav">
    <ul class="nav nav-list">
      <?php foreach($result->results as $key=> $item):?>
     <li> <?php echo $key+1;?>:  <?php echo $item->title?><span style="float: right"><a href="http://admin.hoopeng.cn/admin/news/update/<?php echo $item->objectId?>" target="_blank">编辑</a> &nbsp;&nbsp;<a href="https://hoopeng.avosapps.com/news/<?php echo $item->objectId?>" target="_blank">预览</a><span></li>
     <?php endforeach;?>

    </ul>
</div>