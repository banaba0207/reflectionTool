<?php

use logic\TaskLogic;

class TaskController
{
    public function index()
    {
        $taskLogic = new TaskLogic();
        $res = $taskLogic->getTaskList();
        $nowTask = $res['nowTask'];
        $taskDataList = $res['taskDataList'];

        // 残り時間を計算
        foreach ($taskDataList as &$task) {
            // かかった時間を求める
            $task["diffTime"] = $this->time_diff($task['startTime'], $task['endTime']);
        }

        include_once(__DIR__ . "/../view/index.html");
    }

    public function addTask()
    {
        if (!empty($_POST)) {
            $taskLogic = new TaskLogic();
            $taskLogic->addTask($_POST["task"], $_POST['nowTaskDataId']);
        }
        //  リダイレクト
        header("Location: " . "/task/index");
    }

    function time_diff($startTime, $endTime)
    {
        $timeFrom = strtotime($startTime);
        $timeTo = strtotime($endTime);

        // 日時差を秒数で取得
        $dif = $timeFrom - $timeTo;
        $min = intval($dif/60);
        $sec = intval($dif%60);
        return sprintf("%s分  %s秒", $min, $sec);
    }
}
