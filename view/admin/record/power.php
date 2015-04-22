<div class="bs-docs-example">
    <h3>总览</h3>
    <ul class="inline">
        <li>团队数：<?php echo $countNum = $teamNumber[0]->countNum?></li>
        <li>弃权：<?php echo $CancelTeamNumber = $CancelTeamNumber[0]->CancelTeamNumber? $CancelTeamNumber[0]->CancelTeamNumber:0?></li>
        <li>应到：<?php echo $countNum-$CancelTeamNumber;?></li>
    </ul>

    <div style="padding-bottom: 20px;border-top: 1px solid #DDD;">
    </div>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th>线路</th>
            <th>团队总数</th>
            <th>弃权</th>
            <th>应到</th>
            <th>已完成比赛</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $item):?>
            <tr>
                <td><?php echo $item['lineId']?></td>
                <td><?php echo $item['shouldReceiveGameTeamNum']?></td>
                <td><?php echo $item['dropGameTeamNum']?></td>
                <td><?php echo $item['shouldReceiveGameTeamNum']-$item['dropGameTeamNum']?></td>
                <td><?php echo $item['finishGameTeamNum']?></td>
            </tr>
        <?php endforeach;?>
        <tr>
            <td colspan="20"><?php echo $result->page; ?></td>
        </tr>
        </tbody>
    </table>
</div>






