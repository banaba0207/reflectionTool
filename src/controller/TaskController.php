<?php

class TaskController
{
    public function index()
    {
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

                //  リダイレクト
                header("Location: " . "/task/index");
            }
            $stmt = $pdo->prepare("SELECT * FROM TaskData ORDER BY taskDataId DESC");
            $stmt->execute();
            $taskDataList = $stmt->fetchAll();
            $nowTask = array_shift($taskDataList);
        } catch (PDOException $e) {
            exit('データベース接続失敗。'.$e->getMessage());
        }

        include_once(__DIR__ . "/../view/index.html");
    }
}

function time_diff($timeFrom, $timeTo)
{
    // 日時差を秒数で取得
    $dif = $timeFrom - $timeTo;
    $min = intval($dif/60);
    $sec = intval($dif%60);
    return sprintf("%s分  %s秒", $min, $sec);
}
