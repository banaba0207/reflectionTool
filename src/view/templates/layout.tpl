<!DOCTYPE html>
<html lang=“ ja”>

<head>
    <link rel="stylesheet" href="/public_html/css/common.css" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.css" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.js"></script>
    <meta charset=“ UFT-8”>
    <title>reflection_tool</title>
    <script src="/public_html/js/common.js">

    </script>
</head>

<body>
    <!-- 日付計算 -->
    {$nowDate        = $smarty.now|date_format:"%Y-%m-%d"}
    {$oneWeekAgoDate = ($smarty.now-24*60*60*7)|date_format:"%Y-%m-%d"}

    <!-- 曜日出力用用関数 -->
    {function name=dayOfWeekJP date=$smarty.now}
        (
        {$date|date_format:"%a"|replace:"Sun":"日"|replace:"Mon":"月"|replace:"Tue":"火"|replace:"Wed":"水"|replace:"Thu":"木"|replace:"Fri":"金"|replace:"Sat":"土"}
        )
    {/function}

    <!-- ヘッダーメニュー -->
    <div class="ui menu">
      <div class="header item">
        Let's Reflection!
      </div>
      <a class="item">
          <form class="ui form" id="updateUserId" action="/task/index/?userId={$userId|default:0}" method="get">
              <div class="ui labeled action input">
                  <div class="ui label">UserID</div>
                  <input name="userId" value="{$userId|default:0}" style="width:70px;"/>
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
        <div style="padding:0 50px;">
            {block name="contents"}{/block}
        </div>
    {else}
        UserID is empty.
    {/if}
</body>

</html>
