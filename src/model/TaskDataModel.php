<?php
namespace model;

class TaskDataModel
{
    private $_pdo;

    function __construct()
    {
        $this->_pdo = new \PDO(
            'mysql:host=localhost;dbname=euler_test;charset=utf8',
            'root',
            '',
            array(\PDO::ATTR_EMULATE_PREPARES => false)
         );
    }

    /* タスクを取得
     * @param string $task
     * @param int    $nowTaskDataId
     */
    public function getTaskList()
    {
        $sql = "SELECT * FROM TaskData WHERE startTime > :startTime ORDER BY taskDataId DESC";
        $stmt = $this->_pdo->prepare($sql);

        $date = date("Y-m-d H:i:s", strtotime('-24 hour', time()));
        $stmt->bindParam(':startTime', $date, \PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll();
    }

     /* タスクを挿入する。既存タスクが存在する場合、それを終了する
      * @param string $task
      * @param int    $nowTaskDataId
      */
    public function addTask($task, $nowTaskDataId = null)
    {
        // タスクの挿入
        $stmt = $this->_pdo->prepare("INSERT INTO TaskData (task) VALUES (:task)");
        $stmt->bindParam(':task', $task, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    /* タスクを終了する
     * @param int    $nowTaskDataId
     */
   public function endTask($nowTaskDataId)
   {
       // 既存タスクの終了
       $stmt = $this->_pdo->prepare('update TaskData set isClosed =1 where taskDataId = :taskDataId');
       $stmt->bindValue(':taskDataId', $nowTaskDataId, \PDO::PARAM_INT);

       return $stmt->execute();
   }
}
