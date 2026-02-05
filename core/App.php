<?php

if (!defined("MYSite")) {
    die("شما مجوز دسترسی به این فایل را ندارید");
}

class App
{
    protected $router;

    public function __construct()
    {
        // ساخت کنترلر اصلی
        $controller = new Controller();

        // ساخت Router
        $this->router = new Router($controller);
    }

    public function run()
    {
        // گرفتن صفحه از URL
        $page = isset($_GET["page"]) && !empty($_GET["page"]) ? $_GET["page"] : "login";

        // اجرای مسیر
        $this->router->dispatch($page);
    }
}