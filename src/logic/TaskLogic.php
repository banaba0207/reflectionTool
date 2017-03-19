<?php
namespace logic;

class TaskLogic
{
    public function getTaskList()
    {
        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=euler_test;charset=utf8', 'root', '',
        array(\PDO::ATTR_EMULATE_PREPARES => false));

            $stmt = $pdo->prepare("SELECT * FROM TaskData ORDER BY taskDataId DESC");
            $stmt->execute();
            $taskDataList = $stmt->fetchAll();
            $nowTask = array_shift($taskDataList);
        } catch (\PDOException $e) {
            exit('データベース接続失敗。'.$e->getMessage());
        }

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
        $timeFrom = strtotime($startTime);
        $timeTo = strtotime($endTime);

        // 日時差を秒数で取得
        $dif = $timeFrom - $timeTo;
        $min = intval($dif/60);
        $sec = intval($dif%60);
        return sprintf("%s分  %s秒", $min, $sec);
    }
}
