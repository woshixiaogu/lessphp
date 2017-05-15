<?php
/**
 * User: xiaogu
 * Date: 17/5/15
 * Time: 21:45
 */
$dir =  __DIR__;
require $dir.'/xiaogu/lessphp/vendor/autoload.php';
$container = new \Lessphp\Container\Container();
class A{
    public function aa(){
        echo 'this is aa';
    }
}
$container->bind("yqbaa",function (){
   return new A();
});
$a = $container->make("yqbaa");
$a->aa();