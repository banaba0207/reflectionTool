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

        return array(
            'nowTask' => $nowTask,
            'taskDataList' => $taskDataList
        );
    }

    /* タスクを挿入する。既存タスクが存在する場合、それを終了する
     *
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
}
