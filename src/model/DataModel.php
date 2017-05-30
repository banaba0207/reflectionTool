<?php
namespace model;

abstract class DataModel
{
    private $_db = null;

    // SELECT句作成用
    private $_columns = array();
    private $_orders  = array();

    // INSERT, UPDATE句生成用
    private $_sets      = array();
    private $_set_binds = array();

    // WHERE句生成用
    private $_conditions      = array();
    private $_condition_binds = array();

    abstract public function getTableName();

    public function connect()
    {
        $this->_db = new \PDO(
            'mysql:host=localhost;dbname=euler_test;charset=utf8',
            'root',
            '',
            array(\PDO::ATTR_EMULATE_PREPARES => false)
        );
    }

    private function _init()
    {
        $this->_columns         = array();
        $this->_orders          = array();
        $this->_sets            = array();
        $this->_set_binds       = array();
        $this->_conditions      = array();
        $this->_condition_binds = array();
    }

    public function where($column, $separetor, $value)
    {
        $this->_where($column, $separetor, $value);
        return $this;
    }

    private function _where($column, $separetor, $value)
    {
        if (is_array($value)) {
            // condition作成
            $qs = implode(',', array_fill(0, count($value), '?'));
            $this->_conditions[] = sprintf("%s %s (%s)", $column, $separetor, $qs);
            // bind_values作成
            foreach ($value as $v) {
                $this->_condition_binds[] = $v;
            }
        } else {
            $this->_conditions[] = sprintf("%s %s ?", $column, $separetor);
            $this->_condition_binds[] = $value;
        }
    }

    /**
     * 配列で返す。
     *
     * @return array 複数のレコードデータ
     */
    public function toArray()
    {
        $st = $this->_build();
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * クエリ発行 内部使用
     *
     * @param string $sql SQL文
     *
     * @return PDOStatement PDOStatement
     */
    protected function _query($sql)
    {
        if (!$this->_db) {
            $this->connect();
        }

        $binds = array_merge($this->_set_binds, $this->_condition_binds);

        // SQL文の準備を行う
        $st = $this->_db->prepare($sql);

        // プリペアドステートメントを実行する
        $st->execute($binds);

        // 初期化
        $this->_init();

        $this->_last_sql = $sql;
        return $st;
    }

    /**
     * SQL組み立て 内部使用
     *
     * @param array $params オプション
     *
     * @return PDOStatement PDOStatement
     */
    protected function _build($params = [])
    {
        $sql = '';
        $sql_where = '';

        // 条件組み立て
        $conditions = implode(' AND ', $this->_conditions);
        if ($conditions) {
            $sql_where .= " WHERE $conditions";
        }

        if ($this->_sets) {
            $insert = true;
            // 条件がある場合、update
            if ($this->_conditions) {
                $insert = false;
                $columns = implode('=?,', array_keys($this->_sets)) . '=?';
                $this->_set_binds = array_values($this->_sets);

                // SQL文作成
                $sql = sprintf("UPDATE %s SET %s",
                    $this->getTableName(),
                    $columns
                );
                $sql .= $sql_where;

                // 実行
                $st = $this->_query($sql);

                // UPDATE失敗時は、INSERT
                if ($st->rowCount() === 0 && empty($params['only_update'])) {
                    $insert = true;
                }
            }

            // 条件がない場合、またはUPDATE出来なかったときはINSERT
            if ($insert) {
                $columns = implode(',', array_keys($this->_sets));
                $this->_set_binds = array_values($this->_sets);
                $qs = implode(',', array_fill(0, count($this->_sets), '?'));
                $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)",
                    $this->getTableName(),
                    $columns,
                    $qs
                );

                // WHERE句を空に
                $this->condition_binds = array();

                // 実行
                $st = $this->_query($sql);
            }
        } else {
            // SELECT

            // 取得カラム
            $columns = implode(',', $this->_columns);
            if (!$columns) {
                $columns = '*';
            }

            // ORDER句
            $order = '';
            if (count($this->_orders)) {
                $order = ' ORDER BY ' . implode(',', $this->_orders);
            }

            // SQL文組み立て
            $sql = sprintf("SELECT %s FROM %s %s %s",
                $columns,
                $this->getTableName(),
                $sql_where,
                $order
            );

            // SQL実行
            $st = $this->_query($sql);
        }

        return $st;
    }

    /**
     * 挿入・更新値セット
     *
     * @param string $column カラム名
     * @param mixed $value 値
     *
     * @return Qb 自分自身のインスタンス
     */
    public function set($column, $value = null)
    {
        if (is_array($column)) {
            $sets = $column;
        } else {
            $sets = [$column => $value];
        }
        $this->_sets += $sets;
        return $this;
    }

    /**
     * UPDATE or INSERT
     *
     * @param string $column カラム名
     * @param mixed $value 値
     *
     * @return string プライマリキーの値
     */
    public function save($column = null, $value = null)
    {
        if ($column) {
            $this->set($column, $value);
        }
        $st = $this->_build();
        return $this->_db->lastInsertId();
    }

    /**
     * UPDATE
     *
     * @param string $column カラム名
     * @param mixed $value 値
     *
     * @return string プライマリキーの値
     */
    public function update($column = null, $value = null)
    {
        if ($column) {
            $this->set($column, $value);
        }

        $st = $this->_build(['only_update' => true]);
        return $this->_db->lastInsertId();
    }

    /**
     * ORDER BY ASC
     *
     * @param string $column カラム名
     *
     * @return Qb 自分自身のインスタンス
     */
    public function asc($column)
    {
        $this->_orders[] = sprintf("%s ASC", $column);
        return $this;
    }

    /**
     * ORDER BY DESC
     *
     * @param string $column カラム名
     *
     * @return Qb 自分自身のインスタンス
     */
    public function desc($column)
    {
        $this->_orders[] = sprintf("%s DESC", $column);
        return $this;
    }
}
