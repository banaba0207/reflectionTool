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

    private function getUserId()
    {
        return $this->_request->getQuery('userId');
    }

    public function index()
    {
        $userId = $this->getUserId();
        $taskLogic = new TaskLogic();
        $res = $taskLogic->getTaskList($userId);

        $smarty = new Smarty();
        $smarty->template_dir = dirname(__DIR__) . '/view/templates';
        $smarty->compile_dir = dirname(__DIR__) . '/tmp/templates_c';
        $smarty->cache_dir    = dirname(__DIR__) . '/tmp/cache';

        // tplに渡す変数
        $nowTask       = $res['nowTask'];
        $nowTaskDataId = $nowTask['taskDataId'];
        $taskDataList  = $res['taskDataList'];

        $smarty->assign('userId', $userId);
        $smarty->assign('nowTask', $nowTask);
        $smarty->assign('nowTaskDataId', $nowTaskDataId);
        $smarty->assign('taskDataList', $taskDataList);

        $smarty->display('index.tpl');
    }

    public function addTask()
    {
        $postData = $this->_request->getPost();
        $userId = $this->getUserId();
        if (!empty($userId) && !empty($postData['task'])) {
            $taskLogic = new TaskLogic();
            $taskLogic->addTask($userId, $postData['task'], $postData['isCutInTask'], $postData['nowTaskDataId']);
        }

        //  リダイレクト
        $this->redirect("/task/index/?userId=" . $userId);
    }

    public function updateTask()
    {
        $postData = $this->_request->getPost();
        $userId = $this->getUserId();
        var_dump($postData);
        if (isset($postData['taskDataId']) && isset($postData['task']) && isset($postData['isCutInTask']) && isset($postData['startTime']) && isset($postData['endTime'])) {
            echo "INININ";
            $taskLogic = new TaskLogic();
            $taskLogic->updateTask(
                $postData['taskDataId'],
                $postData['task'],
                $postData['isCutInTask'],
                $postData['startTime'],
                $postData['endTime']
             );
        }

        //  リダイレクト
        $this->redirect("/task/index/?userId=" . $userId);
    }

    public function redirect($url)
    {
        header("Location: " . $url);
    }
}
