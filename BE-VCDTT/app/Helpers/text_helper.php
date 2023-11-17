<?php
function string_truncate($string, $length = 30) {
    //length = number of charater
    //suffix
    if (mb_strlen($string) > $length) {
        return mb_substr($string, 0, $length) . '...';
    }
    return $string;
}

function time_format($time){
    return \Carbon\Carbon::parse($time)->format('Y-m-d H:i:s');
}

function money_format($number)
{
    $formattedNumber = number_format($number, 0, ',', '.');
    return $formattedNumber . 'VNĐ';
}

function config_pusher(){
    $options = array(
        'cluster' => 'ap1',
        'encrypted' => true
    );

    $pusher = new Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        $options
    );

    return $pusher;
}
