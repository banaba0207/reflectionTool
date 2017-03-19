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
}
