<?php
// هیچ فاصله یا BOM قبل از <?php نباشد
session_start();

// تولید کد امن
$code = substr(bin2hex(random_bytes(3)), 0, 6);
$_SESSION["security_code"] = strtolower($code);

// ایجاد تصویر
$width = 120; $height = 40;
$image = imagecreatetruecolor($width, $height);

// رنگ‌ها
$bgColor   = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);
$noiseColor = imagecolorallocate($image, 120, 140, 180);

// پس‌زمینه سفید
imagefill($image, 0, 0, $bgColor);

// نویز
for ($i = 0; $i < 50; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $noiseColor);
}

// مسیر فونت
$font = __DIR__ . "../assets/shabnam-font-v5.0.1/oldsans.ttf";

// اگر فونت موجود بود از TTF استفاده کن، وگرنه fallback
if (file_exists($font) && function_exists("imagettftext")) {
    imagettftext($image, 18, rand(-10, 10), 15, 30, $textColor, $font, $code);
} else {
    imagestring($image, 5, 20, 12, $code, $textColor);
}

// خروجی تصویر
header("Content-Type: image/png");

// پاک کردن بافر خروجی برای جلوگیری از خراب شدن تصویر
if (function_exists("ob_get_level")) {
    while (ob_get_level() > 0) { ob_end_clean(); }
}

imagepng($image);
imagedestroy($image);