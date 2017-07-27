<?php
/**
 * User: xiaogu
 * Date: 17/4/2
 * Time: 12:03
 */

namespace App\Library;


class Date
{

    public static function getToday(){
        return date("Y-m-d H:i:s");
    }

    public static function prettyDateInterval($date){
        if(strlen($date) != 10){
            $date = strtotime($date);
        }
        $now = time();
        $interval = $now - $date;
        if($interval <= 60){
            return '刚刚';
        }
        if($interval <= 3600){
            return intval($interval/60).'分钟前';
        }
        if($interval <= 86400){
            return intval($interval/3600).'小时前';
        }
        return date("Y-m-d H:i:s",$date);
    }
    public static function getWeekDay($time = ''){
        $week = [
            0 => '星期日',
            1 => '星期一',
            2 => '星期二',
            3 => '星期三',
            4 => '星期四',
            5 => '星期五',
            6 => '星期六',
            7 => '星期日',
        ];
        if($time == ''){
            $time = time();
        }
        if(!is_integer($time)){
            $time = strtotime($time);
        }
        return $week[date("w",$time)];
    }

    /**
     * 周一到周日是几号
     */
    public static function getWeekDate(){
        //本周开始的时间
        //$time =  strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"))));
        $w = date("w");
        if($w == 0){
            $t = 7;
        }else{
            $t = $w;
        }
//        $t = abs(date("w") - 7);
        $now = time();
        $oneDay = 86400;
        $time = $now - ($t - 1) * $oneDay;

        $oneDay = 86400;
        $day1 = date("d",$time);
        $day2 = date("d" ,$time + $oneDay);
        $day3 = date("d" ,$time + 2 * $oneDay);
        $day4 = date("d" ,$time + 3 * $oneDay);
        $day5 = date("d" ,$time + 4 * $oneDay);
        $day6 = date("d" ,$time + 5 * $oneDay);
        $day7 = date("d" ,$time + 6 * $oneDay);
        return [
            $day1,
            $day2,
            $day3,
            $day4,
            $day5,
            $day6,
            $day7,
        ];
    }
}