<?php
// Front Controller

define("MYSite", true);

// شروع سشن
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// بارگذاری فایل‌های اصلی
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/models/Model.php";
require_once __DIR__ . "/../app/views/View.php";
require_once __DIR__ . "/../app/controllers/Controller.php";
require_once __DIR__ . "/../core/Router.php";
require_once __DIR__ . "/../core/App.php";
require_once __DIR__ . "/../helpers/Jalali.php";

// اجرای برنامه
$app = new App();
$app->run();