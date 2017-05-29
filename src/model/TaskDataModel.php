<?php
namespace model;

class TaskDataModel extends \model\DataModel
{
    private $_tableName = 'TaskData';

    const CLOSED = 1;

    public function getTableName()
    {
        return $this->_tableName;
    }

    /*
     * 本日中のタスクを取得
     * @return array
     */
    public function getTaskList($userId)
    {
        $date = date("Y-m-d");

        $result = $this
            ->where('userId', '=', $userId)
            ->where('startTime', '>', $date)
            ->desc("taskDataId")
            ->toArray();

        return $result;
    }

    /*
     * 指定された日付のタスクを取得
     * @return array
     */
    public function getTaskListByDate($userId, $date)
    {
        $startDate = date("Y-m-d 00:00:00", strtotime($date));
        $endDate   = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($startTime)));

        return $this->getTaskLisBetweenDate($userId, $startDate, $endDate);
    }

    /*
     * 指定された日付間のタスクを取得
     * @return array
     */
    public function getTaskLisBetweenDate($userId, $startDate, $endDate)
    {
        $result = $this
            ->where('userId',    '=',  $userId)
            ->where('startTime', '>=', $startDate)
            ->where('startTime', '<=', $endDate)
            ->desc("taskDataId")
            ->toArray();

        return $result;
    }

     /*
      * タスクを挿入する
      * @param int    $userId
      * @param string $task
      * @param int    $isCutInTask 割り込みタスクであるか否か
      * @return bool
      */
    public function addTask($userId, $task, $isCutInTask)
    {
        // タスクの挿入
        $result = $this
            ->set('userId', $userId)
            ->set('task', $task)
            ->set('isCutInTask', $isCutInTask)
            ->save('task', $task);

        return $result;
    }

    /*
     * タスクを終了する
     * @param int    $nowTaskDataId
     * @return bool
     */
   public function endTask($nowTaskDataId)
   {
       $result = $this
           ->where('taskDataId', '=', $nowTaskDataId)
           ->update('isClosed', self::CLOSED);

       return $result;
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
      $result = $this
          ->set('task', $task)
          ->set('isCutInTask', $isCutInTask)
          ->set('startTime', $startTime)
          ->set('endTime', $endTime)
          ->where('taskDataId', '=', $taskDataId)
          ->update();

      return $result;
  }
}
