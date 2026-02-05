<?php

if (!defined("MYSite")) {
    die("شما مجوز دسترسی به این فایل را ندارید");
}

class Router
{
    protected $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function dispatch(string $page)
    {
        // اگر متد وجود داشته باشد اجرا کن
        if (method_exists($this->controller, $page)) {
            $this->controller->$page();
        } else {
            // اگر نبود، برو به login
            $this->controller->login();
        }
    }
}