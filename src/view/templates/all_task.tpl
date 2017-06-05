{extends file="layout.tpl"}

{block name="contents"}
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
                <th>アクション</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$taskDataList item=v}
            <form id="updateTask" action="/task/updateTask/?userId={$userId|default:0}" method="post" class="ui form">
            <tr {if $v.isCutInTask == '1'}style="background: #fef263;"{/if}>
                <input type="hidden" name="taskDataId" value="{$v.taskDataId}" />
                <td>{$v.taskDataId|default:0}</td>
                <td><input name="task" value="{$v.task}" /></td>
                <td><input name="startTime" value="{$v.startTime}" /></td>
                <td><input name="endTime" value="{$v.endTime}" /></td>
                <td>{$v.diffTime}</td>
                <td><input name="isCutInTask" value="{$v.isCutInTask}" /></td>
                <td><button type="submit">更新</button></td>
            </tr>
            </form>
            {/foreach}
        </tbody>
    </table>
{/block}
