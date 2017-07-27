<?php
/**
 * User: xiaogu
 * Date: 17/6/4
 * Time: 19:43
 */

namespace App\Library\Utils;
use Illuminate\Pagination\LengthAwarePaginator;

class MihuaPage
{
        public static function getPaginator($total,$pageSize,$page,$path= '/')
        {
            $paginator = new LengthAwarePaginator([],$total,$pageSize,$page,[
                'path' => $path,  //注释2
                'pageName' => 'page',
            ]);
            return $paginator;
        }
}