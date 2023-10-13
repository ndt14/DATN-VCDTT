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