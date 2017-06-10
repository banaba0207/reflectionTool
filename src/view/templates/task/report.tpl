{extends file="common/layout.tpl"}

{block name="contents"}
    <h1>
        {if !empty($date)}
            {$date}
        {else}
            {$startDate} ~ {$endDate}
        {/if}
        Report
    </h1>

    <h3>ALL</h3>
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
            <td>{$reportData.normalTaskTime|default:0}<br>{$reportData.normalTaskTimeRate|default:0} %</td>
            <td>{$reportData.cutInTaskTime|default:0}<br>{$reportData.cutInTaskTimeRate|default:0} %</td>
            <td>{$reportData.allTime|default:0}</td>
        </tr>
        </tbody>
    </table>
    <hr>

    <h3>日毎</h3>
    <table class="type09">
        <thead>
        <tr>
            <th>日時</th>
            <th>定常タスク時間</th>
            <th>割り込みタスク時間</th>
            <th>全体タスク時間</th>
        </tr>
        </thead>
        <tbody>
            {foreach from=$reportByDateList key=date item=v}
                <tr>
                    <td>{$date} {call dayOfWeekJP date=$date}</td>
                    <td>{$v.normalTaskTime}<br>{$v.normalTaskTimeRate} %</td>
                    <td>{$v.cutInTaskTime}<br>{$v.cutInTaskTimeRate} %</td>
                    <td>{$v.allTime}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
    <hr>

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
{/block}
