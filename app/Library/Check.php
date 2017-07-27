<?php
/**
 * User: xiaogu
 * Date: 17/3/11
 * Time: 18:06
 */

namespace App\Library;


class Check
{

    /**
     * 是否是 合法的 valueList
     * @param $str string 格式为 1,2,3,4
     * @return bool
     */
    public static function isLegalValueList($str){
        if(!$str){
            return false;
        }
        $arr = explode(',',$str);
        foreach ($arr as $v){
            if(!self::isInt($v)){
                return false;
            }
        }
        return true;
    }

    /**
     * 是否是整数
     */
    public static function isInt($num){
        return filter_var($num,FILTER_VALIDATE_INT);
    }

    /**
     * 是否是大于0的整数
     */
    public static function isPositiveInt($num){
        if(self::isInt($num) && $num > 0){
            return true;
        }
        return false;
    }
    /**
     * 是否是邮箱
     * @param $email
     * @return bool
     */
    public static function isEmail($email){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 是否是url
     * @param $url
     * @return bool
     */
    public static function isUrl($url){
        if(filter_var($url,FILTER_VALIDATE_URL)){
            return true;
        }else{
            return false;
        }
    }

    public static function isIp($ip){
        if(self::isIpV4($ip) || self::isIpv6($ip)){
            return true;
        }
    }

    public static function isIpV4($ip){
        return filter_var($ip,FILTER_FLAG_IPV4) ? true : false;
    }

    public static function isIpv6($ip){
        return filter_var($ip,FILTER_FLAG_IPV6) ? true : false;
    }

    /**
     * 是否是正确的手机号
     */
    public static function isPhone($phone){
        $pat = "/^1[3587][0-9]{9}$/";
        if(preg_match($pat,$phone)){
            return true;
        }
        return false;
    }

    /**
     * 是否是正确的电话号码
     */
    public static function isTel($tel){
        $pat = "/^([0-9]{3,4}-)?[0-9]{7,8}$/";
        if(preg_match($pat,$tel)){
            return true;
        }
        return false;
    }

}