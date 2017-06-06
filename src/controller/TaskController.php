<?php
namespace controller;

use logic\TaskLogic;

class TaskController extends BaseController
{

    public function index()
    {
        $userId    = $this->getUserId();
        $taskLogic = new TaskLogic();
        $res       = $taskLogic->getTaskList($userId);

        $this->getResponse()
            ->withTemplate('index.tpl')
            ->withValues([
                'nowTask'      => $res['nowTask'],
                'taskDataList' => $res['taskDataList'],
            ]);
    }

    public function allTask()
    {
        $userId = $this->getUserId();
        $taskLogic = new TaskLogic();
        $res = $taskLogic->getTaskListAll($userId);

        $this->getResponse()
            ->withTemplate('all_task.tpl')
            ->withValues([
                'taskDataList' => $res['taskDataList'],
            ]);
    }

    public function dailyReport()
    {
        $userId = $this->getUserId();
        $date = $this->_request->getQuery('date', 0);
        if(empty($date)) {
            $date = date("Y-m-d");
        }

        $taskLogic = new TaskLogic();
        $res = $taskLogic->getTaskListByDate($userId, $date);

        $this->getResponse()
            ->withTemplate('report.tpl')
            ->withValues([
                'taskDataList'     => $res['taskDataList'],
                'reportByDateList' => $res['reportByDateList'],
                'reportData'       => $res['reportData'],
                'date'             => $date,
            ]);
    }

    public function report()
    {
        $userId = $this->getUserId();
        $startDate = $this->_request->getQuery('startDate');
        $endDate = $this->_request->getQuery('endDate');

        $taskLogic = new TaskLogic();
        $res = $taskLogic->getTaskListByDate($userId, $startDate, $endDate);

        $this->getResponse()
            ->withTemplate('report.tpl')
            ->withValues([
                'taskDataList'     => $res['taskDataList'],
                'reportByDateList' => $res['reportByDateList'],
                'reportData'       => $res['reportData'],
                'startDate'        => $startDate,
                'endDate'          => $endDate,
            ]);
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
        $this->redirect( $_SERVER['HTTP_REFERER']);
    }

    public function updateTask()
    {
        $postData = $this->_request->getPost();
        $userId = $this->getUserId();

        if (isset($postData['taskDataId']) && isset($postData['task']) && isset($postData['isCutInTask']) && isset($postData['startTime']) && isset($postData['endTime'])) {
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
        $this->redirect( $_SERVER['HTTP_REFERER']);
    }

    public function finishTask()
    {
        $postData = $this->_request->getPost();
        $userId = $this->getUserId();

        if (isset($postData['taskDataId'])) {
            $taskLogic = new TaskLogic();
            $taskLogic->finishTask($postData['taskDataId']);
        }

        //  リダイレクト
        $this->redirect( $_SERVER['HTTP_REFERER']);
    }
}
