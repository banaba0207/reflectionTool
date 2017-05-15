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

    /* 本日中のタスクを取得
     * @return array
     */
    public function getTaskList()
    {
        $date = date("Y-m-d");

        $result = $this
            ->where('startTime', '>', $date)
            ->desc("taskDataId")
            ->toArray();

        return $result;
    }

     /* タスクを挿入する
      * @param string $task
      * @param int    $isCutInTask 割り込みタスクであるか否か
      * @return bool
      */
    public function addTask($task, $isCutInTask)
    {
        // タスクの挿入
        $result = $this
            ->set('task', $task)
            ->set('isCutInTask', $isCutInTask)
            ->save('task', $task);

        return $result;
    }

    /* タスクを終了する
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
}
