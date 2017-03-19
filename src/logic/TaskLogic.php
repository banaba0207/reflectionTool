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

    public function getTaskList()
    {
        $taskDataModel = $this->getTaskDataModel();

        $taskDataList = $taskDataModel->getTaskList();

        // 現在取り組んでいるタスクを取得
        $nowTask = array_shift($taskDataList);

        // タスク毎に、要した時間を計算
        foreach ($taskDataList as &$task) {
            $task["diffTime"] = $this->_timeDiff($task['startTime'], $task['endTime']);
        }

        return array(
            'nowTask' => $nowTask,
            'taskDataList' => $taskDataList
        );
    }

     /* タスクを挿入する。既存タスクが存在する場合、それを終了する
      * @param string $task
      * @param int    $nowTaskDataId
      */
    public function addTask($task, $nowTaskDataId = null)
    {
        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=euler_test;charset=utf8', 'root', '',
        array(\PDO::ATTR_EMULATE_PREPARES => false));
                // 既存タスクの終了
        $stmt = $pdo->prepare('update TaskData set isClosed =1 where taskDataId = :taskDataId');
            $stmt->bindValue(':taskDataId', $nowTaskDataId, \PDO::PARAM_INT);
            $stmt->execute();

        // タスクの挿入
        $stmt = $pdo -> prepare("INSERT INTO TaskData (task) VALUES (:task)");
            $stmt->bindParam(':task', $task, \PDO::PARAM_STR);
            $stmt->execute();
        } catch (\PDOException $e) {
            exit('データベース接続失敗。'.$e->getMessage());
        }

        return true;
    }

    /* 英文形式の日付を受け取り、日付の差分を返す
     * @param string $startTime
     * @param string $endTime
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
