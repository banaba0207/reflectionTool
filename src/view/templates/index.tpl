<!DOCTYPE html>
<html lang=“ ja”>

<head>
    <link rel="stylesheet" href="/public_html/css/common.css" type="text/css" />
    <meta charset=“ UFT-8”>
    <title>reflection</title>
</head>

<body>
    <h1>Let's Reflection</h1>

    <!-- タスク入力フォーム -->
    <form action="/task/addTask" method="post">
        <input name="task" style="width:300px;height:50px" autofocus />
        <input type="hidden" name="nowTaskDataId" value="{$nowTaskDataId}" />
        <button type="submit">更新</button>
    </form>

    <h3>取組中タスク</h3>
    <table class="type09">
        <thead>
            <tr>
                <th>taskID</th>
                <th>タスク</th>
                <th>開始時刻</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{$nowTask['taskDataId']}</td>
                <td>{$nowTask['task']}</td>
                <td>{$nowTask['startTime']}</td>
            </tr>
        </tbody>
    </table>

    <h3>終了タスク</h3>
    <table class="type09">
        <thead>
            <tr>
                <th>taskID</th>
                <th>タスク</th>
                <th>開始時刻</th>
                <th>終了時刻</th>
                <th>かかった時間（分）</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$taskDataList item=v}
            <tr>
                <td>{$v.taskDataId}</td>
                <td>{$v.task}</td>
                <td>{$v.startTime}</td>
                <td>{$v.endTime}</td>
                <td>{$v.diffTime}</td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</body>

</html>
