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

        $smarty = new Smarty();
        $smarty->template_dir = dirname(__DIR__) . '/view/templates';
        $smarty->compile_dir = dirname(__DIR__) . '/tmp/templates_c';
        $smarty->cache_dir    = dirname(__DIR__) . '/tmp/cache';

        // tplに渡す変数
        $nowTask       = $res['nowTask'];
        $nowTaskDataId = $nowTask['taskDataId'];
        $taskDataList  = $res['taskDataList'];

        $smarty->assign('nowTask', $nowTask);
        $smarty->assign('nowTaskDataId', $nowTaskDataId);
        $smarty->assign('taskDataList', $taskDataList);

        $smarty->display('index.tpl');
    }

    public function addTask()
    {
        $postData = $this->_request->getPost();

        if (!empty($postData['task'])) {
            $taskLogic = new TaskLogic();
            $taskLogic->addTask($postData['task'], $postData['isCutInTask'], $postData['nowTaskDataId']);
        }

        //  リダイレクト
        $this->redirect("/task/index");
    }

    public function redirect($url)
    {
        header("Location: " . $url);
    }
}
