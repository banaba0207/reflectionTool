<?php
namespace controller;

class LoginController extends BaseController
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
}
