<div class="bs-docs-example">

    <h3>路线<?php echo $siteInfo->lineId?>—<?php echo $siteInfo->siteName?></h3>
    <ul class="inline">
        <li>团队总数：<?php echo $countNum = $teamNumber[0]->countNum?></li>
        <li>取消成绩：<?php echo $CancelTeamNumber = $teamNumber[0]->CancelTeamNumber? $teamNumber[0]->CancelTeamNumber:0?></li>
        <li>应到：<?php echo $countNum-$CancelTeamNumber;?></li>
        <li style="color: #008800">当前已签到：<?php echo $receiveTeamNumber[0]->receiveTeamNumber?></li>

         <button class="btn btn-success" type="button" id="MissionBt">任务书答案(再次点击收起)</button>

        <div id="showMission" style="display: none;">
         <?php  echo $siteInfo->missionResult;?>
        </div>
      </ul>


    <?php  if($siteInfo->siteId==0 ){?>
    <h4>上一站签到情况： 本站点是起点</h4>
    <?php } else{ ?>
    <h4>上一站签到情况： 签到<?php echo $PreReceiveTeamNumber[0]->PreReceiveTeamNumber?>/应到<?php echo $countNum-$CancelTeamNumber;?></h4>
    <?php };?>


    <div style="padding-bottom: 20px;border-top: 1px solid #DDD;">
    </div>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th>编号</th>
            <th>团队名称</th>
            <th>签到时间</th>
            <th>状态</th>
        </tr>
        </thead>
        <tbody>


        <?php foreach ($result->list as $item):?>
        <tr>
            <td><?php echo $item->teamId?></td>
            <td><?php echo $item->teamName?></td>
            <td><?php echo $item->SignUpTime?></td>
            <td><?php  if($item->status==1){echo "正常";}elseif($item->status==3){echo "取消成绩";}?></td>
        </tr>
        <?php endforeach;?>
        <tr>
            <td colspan="20"><?php echo $result->page; ?></td>
        </tr>
        </tbody>
    </table>
</div>

<script language="javascript">
    $("#MissionBt").click(function(){
         if($("#showMission").is(":hidden")){
            $("#showMission").show('slow');
        }else{
            $("#showMission").hide('slow');
        }


    })

 </script>