<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/9/2017
 * Time: 1:24 PM
 */

function setActive($path)
{
    return Request::is($path . '*') ? 'active open' : '';
}


/**
 * @param $string
 * @param string $action
 * @return bool|string
 */
function my_crypt($string, $action = 'e')
{
    // you may change these values to your own
    $secret_key = env('APP_KEY');
    $secret_iv = env('APP_KEY');

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}


function myDate($time)
{
    if (\App::getLocale() == 'en') {
        //16 Nov 2017 | 02:10 pm ‏
        //١٦ نوفمبر ٢٠١٧ | ٠٢:١٠ مساءاً
        return date('d M Y | h:i A', strtotime($time));
    }

    $months = ["Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر"];
    $days = ["Sat" => "السبت", "Sun" => "الأحد", "Mon" => "الإثنين", "Tue" => "الثلاثاء", "Wed" => "الأربعاء", "Thu" => "الخميس", "Fri" => "الجمعة"];
    $am_pm = ['AM' => 'صباحاً', 'PM' => 'مساءً'];

    $day = '';//$days[date('D', $time)];
    $month = $months[date('M', strtotime($time))];
    $am_pm = $am_pm[date('A', strtotime($time))];
    $date = /*$day . '' . date('d', strtotime($time)) . ' ' . $month . ' ' . date('Y', strtotime($time)) . ' | ' .*/ date('h:i', strtotime($time)) . ' ' . $am_pm;
    $numbers_ar = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
    $numbers_en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    return $date;
}