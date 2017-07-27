<?php
/**
 * User: xiaogu
 * Date: 17/3/11
 * Time: 18:06
 */

namespace App\Library;


class Comm
{
    /**
     * 取二级数组的下某个key作为key
     */
    public static function resetArr($array,$key = 'id'){
        if(empty($array)){
            return [];
        }
        $temp = [];
        foreach ($array as $item){
            if(!isset($item[$key])){
                continue;
            }
            $temp[$item[$key]] = $item;
        }
        return $temp;
    }

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

    }

    /**
     * 是否是整数
     */
    public static function isInt(){

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
     * 获取中文首字母
     * @param $str string 中文
     * @return string
     */
    public static function getFirstChar($s0)
    {
        $firstchar_ord=ord(strtoupper($s0{0}));
        if (($firstchar_ord>=65 and $firstchar_ord<=91)or($firstchar_ord>=48 and $firstchar_ord<=57)) return $s0{0};
        try {
            $s = iconv("UTF-8", "gb2312", $s0);
        }catch (\Exception $e){
            return 'A';
        }
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319 and $asc<=-20284)return "A";
        if($asc>=-20283 and $asc<=-19776)return "B";
        if($asc>=-19775 and $asc<=-19219)return "C";
        if($asc>=-19218 and $asc<=-18711)return "D";
        if($asc>=-18710 and $asc<=-18527)return "E";
        if($asc>=-18526 and $asc<=-18240)return "F";
        if($asc>=-18239 and $asc<=-17923)return "G";
        if($asc>=-17922 and $asc<=-17418)return "H";
        if($asc>=-17417 and $asc<=-16475)return "J";
        if($asc>=-16474 and $asc<=-16213)return "K";
        if($asc>=-16212 and $asc<=-15641)return "L";
        if($asc>=-15640 and $asc<=-15166)return "M";
        if($asc>=-15165 and $asc<=-14923)return "N";
        if($asc>=-14922 and $asc<=-14915)return "O";
        if($asc>=-14914 and $asc<=-14631)return "P";
        if($asc>=-14630 and $asc<=-14150)return "Q";
        if($asc>=-14149 and $asc<=-14091)return "R";
        if($asc>=-14090 and $asc<=-13319)return "S";
        if($asc>=-13318 and $asc<=-12839)return "T";
        if($asc>=-12838 and $asc<=-12557)return "W";
        if($asc>=-12556 and $asc<=-11848)return "X";
        if($asc>=-11847 and $asc<=-11056)return "Y";
        if($asc>=-11055 and $asc<=-10247)return "Z";
        return null;
    }

    public static function isMobileRequest(){
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
        $mobile_browser = '0';
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $mobile_browser++;
        if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false))
            $mobile_browser++;
        if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
            $mobile_browser++;
        if (isset($_SERVER['HTTP_PROFILE']))
            $mobile_browser++;
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
        );
        if (in_array($mobile_ua, $mobile_agents))
            $mobile_browser++;
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
            $mobile_browser++;
        // Pre-final check to reset everything if the user is on Windows
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
            $mobile_browser = 0;
        // But WP7 is also Windows, with a slightly different characteristic
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
            $mobile_browser++;
        if ($mobile_browser > 0)
            return true;
        else
            return false;
    }
}

