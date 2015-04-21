<div class="bs-docs-example">

    <h3>路线<?php echo $lineInfo->lineId?>(<?php echo $lineInfo->lineName?>)</h3>
    <ul class="inline">
        <li>团队总数：<?php echo $countNum = $teamNumber[0]->countNum?></li>
        <li>取消成绩：<?php echo $CancelTeamNumber = $teamNumber[0]->CancelTeamNumber? $teamNumber[0]->CancelTeamNumber:0?></li>
        <li>应到：<?php echo $countNum-$CancelTeamNumber;?></li>
        <li>已完成本线路比赛：2</li>
     </ul>
    <h4>每个站点签到情况：</h4>
    <div style="padding-bottom: 20px;border-top: 1px solid #DDD;">
    </div>

    <table class="table table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>应到</th>
            <th>当前已到</th>
            <th>未到</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($lineSignUp as $item):?>
        <tr>
            <td><?php echo "站点".$item->siteId;?></td>
            <td><?php echo $countNum-$CancelTeamNumber;?></td>
            <td><?php echo $item->signUpNum;?></td>
            <td><?php echo $countNum-$CancelTeamNumber-$item->signUpNum;?></td>
        </tr>
        <?php endforeach;?>

        </tbody>
    </table>

    <h4>本线路完成情况：</h4>
    <div style="padding-bottom: 20px;border-top: 1px solid #DDD;">
    </div>

    <table class="table table-condensed">
        <thead>
        <tr>
            <th>团队编号</th>
            <th>名称</th>
            <th>完成站点数</th>
            <th>累计用时</th>
            <th>本路线排名</th>
            <th>状态</th>
        </tr>
        </thead>
        <tbody>

        <?php $page = $_GET['page']?$_GET['page']-1:0?>

        <?php foreach($result->list as $key=> $item): ?>
        <tr>
            <td><?php echo $item->teamId;?></td>
            <td><?php echo $item->teamName;?></td>
            <td><?php echo $item->passSiteNum?$item->passSiteNum:0;?></td>
            <td><?php echo $item->useTime;?></td>
            <td><?php echo $key+1+($page*10);?></td>
            <td><?php echo $item->status ;?></td>
        </tr>
        <?php endforeach;?>
        <tr>
            <td colspan="20"><?php echo $result->page; ?></td>
        </tr>
        </tbody>
    </table>


</div>