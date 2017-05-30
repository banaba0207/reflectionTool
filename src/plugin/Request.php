<?php
namespace plugin;

class Request
{
    // POSTパラメータ
    private $post;
    // GETパラメータ
    private $query;

    // コンストラクタ@
    public function __construct()
    {
        $this->post = new Post();
        $this->query = new QueryString();
    }

    // POST変数取得
    public function getPost($key = null)
    {
        if (!$key) {
            return $this->post->get();
        }
        if (!$this->post->has($key)) {
            return null;
        }

        return $this->post->get($key);
    }

    // GET変数取得
    public function getQuery($key = null)
    {
        if (!$key) {
            return $this->query->get();
        }
        if (!$this->query->has($key)) {
            return null;
        }
        return $this->query->get($key);
    }
}
