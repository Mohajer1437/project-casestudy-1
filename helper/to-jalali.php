<?php
// ۱) الگوریتم تبدیل میلادی به شمسی
function gregorianToJalali($gy, $gm, $gd) {
    $g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];
    $jy = ($gy > 1600) ? 979 : 0;
    $gy -= ($gy > 1600) ? 1600 : 0;
    $gy2 = ($gm > 2) ? $gy + 1 : $gy;
    $days = 365*$gy + intval(($gy2+3)/4) - intval(($gy2+99)/100)
          + intval(($gy2+399)/400) - 80 + $gd + $g_d_m[$gm-1];
    $jy += 33 * intval($days/12053);
    $days %= 12053;
    $jy += 4 * intval($days/1461);
    $days %= 1461;
    if ($days > 365) {
        $jy += intval(($days-1)/365);
        $days = ($days-1)%365;
    }
    $jm = ($days < 186)
        ? 1 + intval($days/31)
        : 7 + intval(($days-186)/30);
    $jd = 1 + (($days < 186) ? ($days%31) : (($days-186)%30));
    return [$jy, $jm, $jd];
}

// ۲) تبدیل ارقام لاتین به فارسی
function toPersianDigits($number) {
    $map = [
        '0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴',
        '5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹'
    ];
    return strtr($number, $map);
}

// ۳) تابع اصلی: گرفتن ورودی و برگرداندن رشته‌ی شمسی
function convertToJalali($dateString) {
    $dateString = trim($dateString);

    // الف) نگاشت نام ماه‌های فارسی (ترانویسی) به عدد
    $monthMap = [
        'ژانویه'=>1,'فوریه'=>2,'مارس'=>3,'آوریل'=>4,
        'مه'=>5,'ژوئن'=>6,'ژوئیه'=>7,'جولای'=>7,
        'اوت'=>8,'آگوست'=>8,'سپتامبر'=>9,
        'اکتبر'=>10,'نوامبر'=>11,'دسامبر'=>12
    ];

    // ب) اعداد فارسی/عربی → لاتین
    $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    $ar = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
    $en = ['0','1','2','3','4','5','6','7','8','9'];
    $dateString = str_replace(array_merge($fa,$ar), array_merge($en,$en), $dateString);

    // ج) حذف whitespace‌های اضافه
    $dateString = preg_replace('/\s+/u', ' ', $dateString);

    // د) تلاش برای تطبیق "روز نام‌ماه سال"
    if (preg_match('/^(\d{1,2})\s+([^\d\s]+)\s+(\d{4})$/u', $dateString, $m)) {
        $d = intval($m[1]);
        $monthName = $m[2];
        $y = intval($m[3]);
        $gm = $monthMap[$monthName] ?? 0;
    }
    // هـ) تطبیق "روز-ماه-سال" یا "روز/ماه/سال" یا با space
    elseif (preg_match('/^(\d{1,2})[\/\-\s](\d{1,2})[\/\-\s](\d{4})$/', $dateString, $m)) {
        $d = intval($m[1]);
        $gm = intval($m[2]);
        $y = intval($m[3]);
    }
    // و) ISO "YYYY-MM-DD"
    elseif (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $dateString, $m)) {
        $y = intval($m[1]);
        $gm = intval($m[2]);
        $d = intval($m[3]);
    }
    else {
        // فرمت نشناخته
        return false;
    }

    // تبدیل و فرمت خروجی
    list($jy, $jm, $jd) = gregorianToJalali($y, $gm, $d);
    $jm = str_pad($jm, 2, '0', STR_PAD_LEFT);
    $jd = str_pad($jd, 2, '0', STR_PAD_LEFT);
    $out = "{$jy}/{$jm}/{$jd}";
    return toPersianDigits($out);
}

// نمونهٔ استفاده:
// echo convertToJalali('8 ژوئن 2025');   // خروجی: ۱۴۰۴/۰۳/۱۸
// echo "\n";
// echo convertToJalali('8 4 2025');      // خروجی: ۱۴۰۳/۰۱/۱۹
// echo "\n";
// echo convertToJalali('2025-12-31');    // خروجی: ۱۴۰۴/۱۰/۱۰



// فیلتر کردن get_comment_date بدون recursion
add_filter('get_comment_date', function($date, $format, $comment) {
    // تاریخ ذخیره‌شده در دیتابیس: "YYYY-MM-DD HH:MM:SS"
    $raw_dt = $comment->comment_date;                  
    // فقط بخش Y-m-d
    $raw_date = substr($raw_dt, 0, 10);                 
    // تبدیل به شمسی
    $jalali = convertToJalali($raw_date);              
    return $jalali !== false ? $jalali : $date;
}, 10, 3);

// فیلتر کردن زمانِ کامنت (اختیاری)
add_filter('get_comment_time', function($time, $format, $comment) {
    // مستقیم از property آبجکت بخوانیم، بدون اینکه خود get_comment_time را صدا بزنیم
    $raw_tm = substr($comment->comment_date, 11, 5);     // "HH:MM"
    return toPersianDigits($raw_tm);
}, 10, 3);