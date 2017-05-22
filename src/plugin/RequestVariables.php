<?php
namespace plugin;

// リクエスト変数抽象クラス
abstract class RequestVariables
{
    protected $_values;

    public function __construct()
    {
        $this->setValues();
    }

    abstract protected function setValues();

    // 指定キーのパラメータを取得
    public function get($key = null)
    {
        $ret = null;
        if (!$key) {
            $ret = $this->_values;
        } else {
            if ($this->has($key)) {
                $ret = $this->_values[$key];
            }
        }

        return $ret;
    }

    // 指定キーの存在確認
    public function has($key)
    {
        if (empty($this->_values)) {
            return false;
        }

        if (!array_key_exists($key, $this->_values)) {
            return false;
        }

        return true;
    }
}
