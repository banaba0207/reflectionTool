<?php

class Dispatcher
{
    private $sysRoot;

    public function setSystemRoot($path)
    {
        // $pathの最後から、/を取り除く
        $this->sysRoot = rtrim($path, '/');
    }

    public function dispatch()
    {
        // URLの最後のスラッシュを取り除く
        $param = preg_replace('/\/?$/', '', $_SERVER['REQUEST_URI']);
        // URLをスラッシュで分割
        $params = array();
        if (!empty($param)) {
            $params = explode('/', $param);
            if ($params[0] == "") {
                array_shift($params);
            }
        }

        $controller = "Index";
        if (count($params) > 0) {
            // URLが空の場合、デフォルトコントローラー名を設定
            $controller = $params[0];
        }

        // コントローラー名作成
        $className = ucfirst(strtolower($controller)). "Controller";
        // コントローラーのパスを作成
        $classPath = $this->sysRoot. '/controller/'. $className. '.php';
        require_once $classPath;

        // インスタンス生成
        $controllerInstance = new $className();

        // アクション名取得
        $action = "index";
        if (count($params) > 1) {
            $action = $params[1];
        }
        
        // アクション実行
        $controllerInstance->$action();
    }
}
