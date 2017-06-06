<?php
namespace controller;

class BaseController
{
    protected $_request;

    protected $_smarty;

    protected $_tplFilePath;

    // コンストラクタ
    function __construct()
    {
        // リクエスト
        $this->_request = new \plugin\Request();
    }

    public function prefilter()
    {
    }

    public function postfilter()
    {
        $this->_smarty->display($this->_tplFilePath);
    }

    public function getUserId()
    {
        return $this->_request->getQuery('userId');
    }

    public function getResponse()
    {
        if (!$this->_smarty) {
            $this->_smarty = new \Smarty();
            $this->_smarty->template_dir = dirname(__DIR__) . '/view/templates';
            $this->_smarty->compile_dir  = dirname(__DIR__) . '/tmp/templates_c';
            $this->_smarty->cache_dir    = dirname(__DIR__) . '/tmp/cache';
            $this->withValues(['userId' => $this->getUserId()]);
        }

        return $this;
    }

    public function withTemplate($tplFilePath)
    {
        $this->_tplFilePath = $tplFilePath;

        return $this;
    }

    public function withValues($valueArray)
    {
        $this->_smarty->assign($valueArray);

        return $this;
    }

    public function redirect($url)
    {
        header("Location: " . $url);
    }
}
