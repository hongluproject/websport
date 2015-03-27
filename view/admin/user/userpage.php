<table class="table table-striped">
    <thead>
    <tr>
        <th width="50">#ID</th>
        <th>用户名</th>
        <th width="200">邮箱</th>
        <th width="100">域账号</th>
        <th width="150">创建时间</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $item): ?>
    <tr>
        <td><?php echo $item->id; ?></td>
        <td><?php echo $item->user_name; ?></td>
        <td><?php echo $item->email; ?></td>
        <td><?php echo $item->syna_name; ?></td>
        <td><?php echo $item->create_time; ?></td>
        <td>
           	   <a href="/admin/user/add?type=edit&id=<?php echo $item->id;?>" title="编辑"><i class="icon-ok"></i></a>
               <a href="/admin/user/add?type=delete&id=<?php echo $item->id;?>" title="删除"><i class="icon-remove"></i></a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>