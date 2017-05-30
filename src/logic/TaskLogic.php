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

    /*
     * タスク取得
     * @return array
     */
    public function getTaskList($userId)
    {
        $taskDataModel = $this->getTaskDataModel();

        $taskDataList = $taskDataModel->getTaskList($userId);

        // 現在取り組んでいるタスクを取得
        $nowTask = array_shift($taskDataList);
        if ($nowTask["isClosed"] == TaskDataModel::IS_CLOSED) {
            array_unshift($taskDataList, $nowTask);
            $nowTask = null;
        }

        // タスク毎に、要した時間を計算
        foreach ($taskDataList as &$task) {
            $task["diffTime"] = $this->_timeDiffString($task['startTime'], $task['endTime']);
        }

        return array(
            'nowTask'      => $nowTask,
            'taskDataList' => $taskDataList
        );
    }

    /*
     * タスク取得
     * @return array
     */
    public function getTaskListAll($userId)
    {
        $taskDataModel = $this->getTaskDataModel();

        $taskDataList = $taskDataModel->getTaskListAll($userId);

        // タスク毎に、要した時間を計算
        foreach ($taskDataList as &$task) {
            $task["diffTime"] = $this->_timeDiffString($task['startTime'], $task['endTime']);
        }

        return array(
            'taskDataList' => $taskDataList
        );
    }

    /*
     * 取得日もしくは取得期間を指定してタスク取得
     * @param int $userId
     * @param string $startDate
     * @param string $endDate nullだった場合は$startDateを取得日とする
     * @return array
     */
    public function getTaskListByDate($userId, $startDate, $endDate = null)
    {
        $taskDataModel = $this->getTaskDataModel();

        $startDate = date("Y-m-d 00:00:00", strtotime($startDate));

        // $endDateが指定されていない場合はDaily取得とし、1日後を設定
        if($endDate) {
            $endDate   = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($endDate)));
        } else {
            $endDate   = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($startDate)));
        }

        $taskDataList = $taskDataModel->getTaskLisBetweenDate($userId, $startDate, $endDate);

        // タスク毎に、要した時間を計算
        $normalTaskTime = 0;
        $cutInTaskTime  = 0;
        foreach ($taskDataList as &$task) {
            $time = $this->_timeDiff($task['startTime'], $task['endTime']);
            $task["diffTime"] = $this->_formatTime($time);

            if($task["isCutInTask"]) {
                $cutInTaskTime += $time;
            } else {
                $normalTaskTime += $time;
            }
        }

        $allTime = $normalTaskTime + $cutInTaskTime;

        $reportData = array(
            "normalTaskTime"     => $this->_formatTime($normalTaskTime),
            "cutInTaskTime"      => $this->_formatTime($cutInTaskTime),
            "normalTaskTimeRate" => round($normalTaskTime / $allTime * 100, 1),
            "cutInTaskTimeRate"  => round($cutInTaskTime /  $allTime * 100, 1),
            "allTime"            => $this->_formatTime($allTime),
        );

        return array(
            'taskDataList' => $taskDataList,
            'reportData'   => $reportData,
        );
    }

     /*
      * タスクを挿入する。既存タスクが存在する場合、それを終了する
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

    /*
     * タスクを更新
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

   /*
    * タスクを更新
    * @param int    $taskDataId
    * @param string $task
    * @param int    $isCutInTask
    * @param string $startTime
    * @param string $endTime
    * @return bool
    */
  public function finishTask($taskDataId)
  {
      $taskDataModel = $this->getTaskDataModel();
      return $taskDataModel->endTask($nowTaskDataId);
  }

    /*
     * 英文形式の日付を受け取り、日付の差分を返す
     * @param string $startTime
     * @param string $endTime
     * @return string
     */
    private function _timeDiffString($startTime, $endTime)
    {
        // 日時差を秒数で取得
        $diff = $this->_timeDiff($startTime, $endTime);

        return $this->_formatTime($diff);
    }

    /*
     * 英文形式の日付を受け取り、日付の差分を秒数で返す
     * @param string $startTime
     * @param string $endTime
     * @return string
     */
    private function _timeDiff($startTime, $endTime)
    {
        $timeTo   = strtotime($startTime);
        $timeFrom = strtotime($endTime);

        // 日時差を秒数で取得
        $diff = $timeFrom - $timeTo;

        return $diff;
    }

    /*
     * 秒数を受け取り、分秒の形式にして返す
     * @param string $startTime
     * @param string $endTime
     * @return string
     */
    private function _formatTime($time)
    {
        $min = intval($time / 60);
        $sec = intval($time % 60);
        return sprintf("%s分  %s秒", $min, $sec);
    }
}
