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

<body style="margin:10px 50px">
<!-- UserId入力フォーム -->
UserId:
<form id="updateUserId" action="/task/index/?userId={$userId|default:0}" method="get">
    <input name="userId" value="{$userId|default:0}" style="width:100px;height:30px"/>
    <button type="submit">更新</button>
</form>

{if !empty($userId)}
    <h1>Let's Reflection
        {if !empty($date)}
            {$date}
        {else}
            {$startDate} ~ {$endDate}
        {/if}
        Report
    </h1>
    <table class="type09">
        <thead>
        <tr>
            <th>定常タスク時間</th>
            <th>割り込みタスク時間</th>
            <th>全体タスク時間</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{$reportData.normalTaskTime}<br>{$reportData.normalTaskTimeRate} %</td>
            <td>{$reportData.cutInTaskTime}<br>{$reportData.cutInTaskTimeRate} %</td>
            <td>{$reportData.allTime}</td>
        </tr>
        </tbody>
    </table>
    <h3>タスク一覧</h3>
    <table class="type09">
        <thead>
        <tr>
            <th>taskID</th>
            <th>タスク</th>
            <th>開始時刻</th>
            <th>終了時刻</th>
            <th>かかった時間（分）</th>
            <th>割り込み</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$taskDataList item=v}
            <tr {if $v.isCutInTask == '1'}style="background: #fef263;"{/if}>
                <td>{$v.taskDataId}</td>
                <td>{$v.task}</td>
                <td>{$v.startTime}</td>
                <td>{$v.endTime}</td>
                <td>{$v.diffTime}</td>
                <td>{$v.isCutInTask}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{/if}
</body>

</html>
