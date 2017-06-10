<?php
namespace controller;

class LoginController extends BaseController
{

    public function index()
    {
        $this->getResponse()
            ->withTemplate('login/index.tpl')
            ->withValues([
            ]);
    }
}
