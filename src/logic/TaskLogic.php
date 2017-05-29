<?php
namespace logic;

use model\TaskDataModel;

class TaskLogic
{
    private $_taskDataModel = null;

    private function getTaskDataModel()
    {
        if ($this->_taskDataModel) {
            return $this->_taskDataModel;
        }

        $this->_taskDataModel = new TaskDataModel();
        return $this->_taskDataModel;
    }

    /* タスク取得
     * @return array
     */
    public function getTaskList($userId)
    {
        $taskDataModel = $this->getTaskDataModel();

        $taskDataList = $taskDataModel->getTaskList($userId);

        // 現在取り組んでいるタスクを取得
        $nowTask = array_shift($taskDataList);

        // タスク毎に、要した時間を計算
        foreach ($taskDataList as &$task) {
            $task["diffTime"] = $this->_timeDiff($task['startTime'], $task['endTime']);
        }

        return array(
            'nowTask'      => $nowTask,
            'taskDataList' => $taskDataList
        );
    }

     /* タスクを挿入する。既存タスクが存在する場合、それを終了する
      * @param string $task
      * @param int    $nowTaskDataId
      * @return bool
      */
    public function addTask($userId, $task, $isCutInTask, $nowTaskDataId = null)
    {
        $taskDataModel = $this->getTaskDataModel();

        if ($nowTaskDataId) {
            // 既存タスクの更新
            $taskDataModel->endTask($nowTaskDataId);
        }

        // 新タスク挿入
        return $taskDataModel->addTask($userId, $task, $isCutInTask);
    }

    /* タスクを更新
     * @param int    $taskDataId
     * @param string $task
     * @param int    $isCutInTask
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
   public function updateTask($taskDataId, $task, $isCutInTask, $startTime, $endTime)
   {
       $taskDataModel = $this->getTaskDataModel();
       return $taskDataModel->updateTask($taskDataId, $task, $isCutInTask, $startTime, $endTime);
   }

    /* 英文形式の日付を受け取り、日付の差分を返す
     * @param string $startTime
     * @param string $endTime
     * @return string
     */
    private function _timeDiff($startTime, $endTime)
    {
        $timeTo   = strtotime($startTime);
        $timeFrom = strtotime($endTime);

        // 日時差を秒数で取得
        $dif = $timeFrom - $timeTo;

        $min = intval($dif/60);
        $sec = intval($dif%60);
        return sprintf("%s分  %s秒", $min, $sec);
    }
}
