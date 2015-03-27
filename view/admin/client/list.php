<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data->list as $key => $item): ?>
    <tr>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10"><?php echo $data->page; ?></td>
    </tr>
    </tfoot>
</table>