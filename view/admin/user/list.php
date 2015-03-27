<table class="table table-striped">
    <thead>
    <tr>
        <th width="50">#ID</th>
        <th>用户名</th>
        <th width="200">邮箱</th>
        <th width="150">创建时间</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $item): ?>
    <tr>
        <td><?php echo $item->id; ?></td>
        <td><?php echo $item->username; ?></td>
        <td><?php echo $item->email; ?></td>
        <td><?php echo $item->create_time; ?></td>
        <td>
            <?php if ($user->admin && (!$item->admin || $user->isSuperAdmin()) && !$item->isSuperAdmin()):?>
            <a href="/admin/user/quick/<?php echo $item->id; ?>?type=delete" title="删除"><i class="icon-remove"></i></a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>