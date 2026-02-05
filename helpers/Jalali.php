<?php
/**
 * Jalali ↔ Gregorian Date Helper
 * - تبدیل دقیق بدون آفست
 * - پشتیبانی از سال‌های کبیسه
 * - جلوگیری از تبدیل تاریخ‌های صفر دیتابیس
 * - خروجی نمایشی امن: —
 */

if (!function_exists('jalali_to_gregorian')) {
    function jalali_to_gregorian($jy, $jm, $jd)
    {
        $g_days_in_month = [31,28,31,30,31,30,31,31,30,31,30,31];
        $j_days_in_month = [31,31,31,31,31,31,30,30,30,30,30,29];

        $jy -= 979;
        $jm -= 1;
        $jd -= 1;

        // تعداد روزهای گذشته از مبدأ جلالی
        $j_day_no = 365 * $jy
            + intdiv($jy, 33) * 8
            + intdiv(($jy % 33 + 3), 4);

        // جمع روزهای ماه‌های قبل
        for ($i = 0; $i < $jm; $i++) {
            $j_day_no += $j_days_in_month[$i];
        }

        $j_day_no += $jd;

        // تبدیل به میلادی
        $g_day_no = $j_day_no + 79;

        $gy = 1600 + 400 * intdiv($g_day_no, 146097);
        $g_day_no %= 146097;

        $leap = true;
        if ($g_day_no >= 36525) {
            $g_day_no--;
            $gy += 100 * intdiv($g_day_no, 36524);
            $g_day_no %= 36524;

            if ($g_day_no >= 365)
                $g_day_no++;
            else
                $leap = false;
        }

        $gy += 4 * intdiv($g_day_no, 1461);
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = false;
            $g_day_no--;
            $gy += intdiv($g_day_no, 365);
            $g_day_no %= 365;
        }

        // محاسبه ماه و روز میلادی
        for ($i = 0; $i < 12; $i++) {
            $days = $g_days_in_month[$i];
            if ($i == 1 && $leap) $days++;

            if ($g_day_no < $days) break;
            $g_day_no -= $days;
        }

        return [$gy, $i + 1, $g_day_no + 1];
    }
}

if (!function_exists('convertJalaliToGregorian')) {
    function convertJalaliToGregorian($jalaliDateString)
    {
        $jalaliDateString = trim((string)$jalaliDateString);

        // تاریخ صفر یا خالی → خروجی نمایشی
        if (
            $jalaliDateString === '' ||
            $jalaliDateString === '0000-00-00' ||
            $jalaliDateString === '0000/00/00'
        ) {
            return '—';
        }

        $jalaliDateString = str_replace('-', '/', $jalaliDateString);
        $parts = explode('/', $jalaliDateString);
        if (count($parts) !== 3) return '—';

        [$y, $m, $d] = array_map('intval', $parts);

        if ($y === 0 && $m === 0 && $d === 0) {
            return '—';
        }

        [$gy, $gm, $gd] = jalali_to_gregorian($y, $m, $d);

        return sprintf('%04d-%02d-%02d', $gy, $gm, $gd);
    }
}
