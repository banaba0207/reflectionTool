<!DOCTYPE html>
<html lang=“ ja”>

<head>
    <link rel="stylesheet" href="/public_html/css/common.css" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <meta charset=“ UFT-8”>
    <title>reflection</title>
    <script src="/public_html/js/common.js">

    </script>
</head>

<body>
    <!-- UserId入力フォーム -->
    UserId:
    <form id="updateUserId" action="/task/index/?userId={$userId|default:0}" method="get">
        <input name="userId" value="{$userId|default:0}" style="width:100px;height:30px" />
        <button type="submit">更新</button>
    </form>

    {if !empty($userId)}
        <h1>Let's Reflection</h1>
        <!-- タスク入力フォーム -->
        <form id="addTask" action="/task/addTask/?userId={$userId|default:0}" method="post">
            <input name="task" style="width:300px;height:50px" autofocus />
            <input type="hidden" name="isCutInTask"   value="0" />
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
                <tr {if $v.isCutInTask == '1'}style="background: #fef263;"{/if}>
                    <td>{$v.taskDataId}</td>
                    <td>{$v.task}</td>
                    <td>{$v.startTime}</td>
                    <td>{$v.endTime}</td>
                    <td>{$v.diffTime}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    {/if}
</body>

</html>
