<?php
use logic\TaskLogic;

class TaskController
{
    private $_request;

    // コンストラクタ
    function __construct()
    {
        // リクエスト
        $this->_request = new \plugin\Request();
    }

    public function index()
    {
        $taskLogic = new TaskLogic();
        $res = $taskLogic->getTaskList();

        // tplに渡す変数
        $nowTask       = $res['nowTask'];
        $nowTaskDataId = $nowTask['taskDataId'];
        $taskDataList  = $res['taskDataList'];

        include_once(__DIR__ . "/../view/index.html");
    }

    public function addTask()
    {
        $postData = $this->_request->getPost();

        if (!empty($postData['task'])) {
            $taskLogic = new TaskLogic();
            $taskLogic->addTask($postData['task'], $postData['nowTaskDataId']);
        }

        //  リダイレクト
        $this->redirect("/task/index");
    }

    public function redirect($url)
    {
        header("Location: " . $url);
    }
}
