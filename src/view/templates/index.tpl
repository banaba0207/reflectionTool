{extends file="layout.tpl"}

{block name="contents"}
    <div class="ui info message">
        <div class="header">Enter:通常タスク Shift + Enter:割り込みタスク</div>
    </div>
    <!-- タスク入力フォーム -->
    <form id="addTask" action="/task/addTask/?userId={$userId|default:0}" method="post">
        <input name="task" style="width:300px;height:50px" autofocus/>
        <input type="hidden" name="isCutInTask" value="0"/>
        <input type="hidden" name="nowTaskDataId" value="{$nowTaskData.taskDataId}"/>
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
            <tr {if $nowTask.isCutInTask == '1'}style="background: #fef263;"{/if}>
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
{/block}
