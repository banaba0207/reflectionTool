<?php
var_dump($_POST);

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=euler_test;charset=utf8', 'root', '',
array(PDO::ATTR_EMULATE_PREPARES => false));
        if (!empty($_POST)) {
            // 既存タスクの終了
$stmt = $pdo->prepare('update TaskData set isClosed =1 where taskDataId = :taskDataId');
            $stmt->bindValue(':taskDataId', $_POST['nowTaskDataId'], PDO::PARAM_INT);
            $stmt->execute();

// タスクの挿入
$stmt = $pdo -> prepare("INSERT INTO TaskData (task) VALUES (:task)");
            $stmt->bindParam(':task', $_POST['task'], PDO::PARAM_STR);
            $stmt->execute();
            header("Location: " . $_SERVER['PHP_SELF']);
        }

        $stmt = $pdo->prepare("SELECT * FROM TaskData ORDER BY taskDataId DESC");
        $stmt->execute();
        $taskDataList = $stmt->fetchAll();
        $nowTask = array_shift($taskDataList);

    } catch (PDOException $e) {
        exit('データベース接続失敗。'.$e->getMessage());
    }


function time_diff($timeFrom, $timeTo)
{
    // 日時差を秒数で取得
    $dif = $timeFrom - $timeTo;
    $min = intval($dif/60);
    $sec = intval($dif%60);
    return sprintf("%s分  %s秒", $min, $sec);
}
?>


<!DOCTYPE html>
<html lang = “ja”>
<head>
    <style type="text/css">
    table.type09 {
	border-collapse: collapse;
	text-align: left;
	line-height: 1.5;

}
table.type09 thead th {
	padding: 10px;
	font-weight: bold;
	vertical-align: top;
	color: #369;
	border-bottom: 3px solid #036;
}
table.type09 tbody th {
	width: 150px;
	padding: 10px;
	font-weight: bold;
	vertical-align: top;
	border-bottom: 1px solid #ccc;
	background: #f3f6f7;
}
table.type09 td {
	width: 350px;
	padding: 10px;
	vertical-align: top;
	border-bottom: 1px solid #ccc;
}
    </style>
<meta charset = “UFT-8”>
<title>reflection</title>
</head>
<body>
<h1>Let's Reflection</h1>

<!-- タスク入力フォーム -->
<form action="" method="post">
    <input name="task" style="width:300px;height:50px"/>
    <input type="hidden" name="nowTaskDataId" value='<?php echo $nowTask['taskDataId'] ?>' />
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
<?php
echo sprintf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $nowTask['taskDataId'], $nowTask['task'], $nowTask['startTime']);
?>
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
<?php
foreach ($taskDataList as $task) {
    // かかった時間を求める
    $startTime = strtotime($task['startTime']);
    $endTime = strtotime($task['endTime']);

    echo sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $task['taskDataId'], $task['task'], $task['startTime'], $task['endTime'], time_diff($endTime, $startTime));
}
?>
</table>
</body>
</html>
