<?php
/**
 * User: xiaogu
 * Date: 17/3/24
 * Time: 22:32
 */

namespace App\Services;


class AvatarService
{
    public static function getUserFullAvatar($avatar){
        if(!$avatar){
            return self::getDefaultAvatar();
        }
        if(strpos($avatar,'http') !== false){
            return $avatar;
        }
        $avatar = trim($avatar,'/');
        $acid = WechatService::getCurrentWechatId();
        $appUrl = WechatService::getWechatAppUrl($acid);
        $url = trim($appUrl,'/');
        return $url.'/'.$avatar;
    }
    public static function getDefaultAvatar(){
        $acid = WechatService::getCurrentWechatId();
        $appUrl = WechatService::getWechatAppUrl($acid);
        return trim($appUrl,'/').'/img/touxiang.gif';
    }

}