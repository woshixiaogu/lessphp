<?php
/**
 * User: xiaogu
 * Date: 2017/7/27
 * Time: 21:45
 */
namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Bootstrap{
    public static function run(){
        self::loadDB();
        return self::route();
    }

    private static function route(){
        $s = isset($_GET['s']) ? $_GET['s'] : '';
        if(!$s){
            $s = "index/index/index";
        }
        $s = strtolower($s);
        $pathinfo = explode('/',$s);
        $module = ucfirst($pathinfo[0]);
        if(isset($pathinfo[1])){
            $controller = ucfirst($pathinfo[1]).'Controller';
        }else{
            $controller = 'IndexController';
        }
        $method = isset($pathinfo[2]) ? $pathinfo[2] : 'index';
        $class = "App\\Http\\Controller\\".$module."\\".$controller;
        if(!class_exists($class)){
            throw new Exception("控制器不存在");
        }
        $instance = new $class;
        if(!method_exists($class,$method)){
            throw new Exception("方法不存在");
        }
        return $instance->$method();
    }

    private static function loadDB(){
        $capsule = new Capsule;

        $capsule->addConnection(require APP_PATH.'/config/database.php');

        $capsule->bootEloquent();

    }
}