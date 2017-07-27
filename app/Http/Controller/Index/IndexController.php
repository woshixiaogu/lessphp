<?php
/**
 * User: xiaogu
 * Date: 2017/7/27
 * Time: 21:36
 */

namespace App\Http\Controller\Index;

use App\Services\UsersService;

class IndexController
{
    public function index(){
        echo 'index';
        $user = UsersService::getsBy();
        print_r($user);
    }
}