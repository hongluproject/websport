<link href="/assets/css/datepicker.css" rel="stylesheet">
<script src="/assets/js/datepicker.js" type="text/javascript"></script>
<script src="/assets/js/lang/en.js" type="text/javascript"></script>
<script src="/assets/js/lang/en-us.js" type="text/javascript"></script>
<script src="/assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="/assets/js/jquery.treeview.js" type="text/javascript"></script>

<link href="/assets/css/jquery.treeview.css" rel="stylesheet">

<script type="text/javascript">
    $(function() {
        $("#tree").treeview({
            collapsed: true,
            animated: "fast",
            control:"#sidetreecontrol",
            prerendered: true,
            persist: "location"
        });
    })

</script>
<div class="container-fluid" style="font-size: 15px;">
    <div id="main">
        <div id="sidetree">
            <div class="treeheader">&nbsp;</div>
            <div id="sidetreecontrol"> <a href="?#">全部折起|&nbsp;</a> <a href="?#">全部展开|&nbsp;</a><a href="?#">上次操作反操作</a> </div>
            <ul class="treeview" id="tree">

              <?php foreach($tagdirectory['results'] as $tagsTree):?>
                  <li class="expandable"><div class="hitarea expandable-hitarea"></div><span class=""><?php echo $tagsTree['title']?><?php if($tagsTree['status']==2){ echo "<span style='color: red;'>(已下线)</span>";}?> <a  target="_blank" href="/admin/tag/menucreate/<?php echo $tagsTree['objectId']?>"><i class="icon-ok" alt="更新" title="更新"></i></a></span>
                      <ul style="display: none;">

                          <?php foreach($tagsTree['subTagTree'] as $item):?>

                        <li class="expandable"><div class="hitarea expandable-hitarea"></div><span class=""><?php echo $item->tag_name?><?php if($item->status==2){ echo "<span style='color: red;'>(已下线)</span>";}?> <a  target="_blank" href="/admin/tag/update/<?php echo $item->objectId; ?>"><i class="icon-ok" alt="更新" title="更新"></i></a></span>
                            <ul style="display: none;">
                                <?php foreach ($item->subtree as $subTagTree):?>
                                <li class="last"><div class="expandable-hitarea"></div><a href="/admin/tag/update/<?php echo $subTagTree->objectId; ?>"  <?php if($subTagTree->status ==2){echo 'style="color:red"';} ?> ><?php echo $subTagTree->tag_name;?><?php if($subTagTree->status==2){ echo "<span style='color: red;'>(已下线)</span>";}?> <a  target="_blank" href="/admin/tag/update/<?php echo $subTagTree->objectId; ?>"><i class="icon-ok" alt="更新" title="更新"></i></a> &nbsp;&nbsp; <a href="/admin/tag/delete/<?php echo $subTagTree->objectId; ?>" class="delete"><i class="icon-remove" alt="删除" title="删除"></i></a></a>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                    <?php endforeach;?>
                      </ul>
                  </li>
                <?php endforeach;?>

                <li class="last">下面没有太监了</li>



            </ul>
        </div>

    </div>

</div>
