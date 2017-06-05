<!DOCTYPE html>
<html lang=“ ja”>

<head>
    <link rel="stylesheet" href="/public_html/css/common.css" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.css"
          type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.js"></script>
    <meta charset=“ UFT-8”>
    <title>reflection</title>
    <script src="/public_html/js/common.js">

    </script>
</head>

<!-- 日付計算 -->
{$nowDate        = $smarty.now|date_format:"%Y-%m-%d"}
{$oneWeekAgoDate = ($smarty.now-24*60*60*7)|date_format:"%Y-%m-%d"}

<div class="ui menu">
  <div class="header item">
    Let's Reflection!
  </div>
  <a class="item">
      <form class="ui form" id="updateUserId" action="/task/index/?userId={$userId|default:0}" method="get">
          <div class="ui labeled action input">
              <div class="ui label">UserID</div>
              <input name="userId" value="{$userId|default:0}" style="width:100px;"/>
              <button class="ui button" type="submit">更新</button>
          </div>
      </form>
  </a>
  <a href="/task/index/?userId={$userId}" class="active item">Home</a>
  <a href="/task/allTask/?userId={$userId}" class="item">All Task</a>
  <a href="/task/dailyReport/?userId={$userId}&date={$nowDate}" class="item">Daily Report</a>
  <a href="/task/report/?userId={$userId}&startDate={$oneWeekAgoDate}&endDate={$nowDate}" class="item">Weekly Report</a>
</div>

{if !empty($userId)}
    <h1>Let's Reflection</h1>
    <!-- タスク入力フォーム -->
    <form id="addTask" action="/task/addTask/?userId={$userId|default:0}" method="post">
        <input name="task" style="width:300px;height:50px" autofocus/>
        <input type="hidden" name="isCutInTask" value="0"/>
        <input type="hidden" name="nowTaskDataId" value="{$nowTaskDataId}"/>
        <button type="submit">更新</button>
    </form>

    {if !empty($nowTask)}
        <h3>取組中タスク</h3>
        <table class="type09">
            <thead>
            <tr>
                <th>taskID</th>
                <th>タスク</th>
                <th>開始時刻</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{$nowTask['taskDataId']}</td>
                <td>{$nowTask['task']}</td>
                <td>{$nowTask['startTime']}</td>
                <td>
                    <form action="/task/finishTask/?userId={$userId|default:0}" method="post">
                        <input type="hidden" name="taskDataId" value="{$nowTask['taskDataId']}"/>
                        <button type="submit">終了</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    {/if}

    <h3>終了タスク</h3>
    <table class="type09">
        <thead>
        <tr>
            <th>taskID</th>
            <th>タスク</th>
            <th>開始時刻</th>
            <th>終了時刻</th>
            <th>かかった時間（分）</th>
            <th>割り込み</th>
            <th>アクション</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$taskDataList item=v}
            <form id="updateTask" action="/task/updateTask/?userId={$userId|default:0}" method="post" class="ui form">
                <tr {if $v.isCutInTask == '1'}style="background: #fef263;"{/if}>
                    <input type="hidden" name="taskDataId" value="{$v.taskDataId}"/>
                    <td>{$v.taskDataId|default:0}</td>
                    <td><input name="task" value="{$v.task}"/></td>
                    <td><input name="startTime" value="{$v.startTime}"/></td>
                    <td><input name="endTime" value="{$v.endTime}"/></td>
                    <td>{$v.diffTime}</td>
                    <td><input name="isCutInTask" value="{$v.isCutInTask}"/></td>
                    <td>
                        <button type="submit">更新</button>
                    </td>
                </tr>
            </form>
        {/foreach}
        </tbody>
    </table>
{/if}
</body>

</html>
