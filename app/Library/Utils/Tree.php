<?php

/**
 * User: xiaogu
 * Date: 17/6/3
 * Time: 19:07
 */
namespace App\Library\Utils;

class Tree
{

    //组合一维数组
    public static function unlimitedForLevel ($cate, $html = '&nbsp;&nbsp', $pid = 0, $level = 0) {
        $arr = array();
        foreach ($cate as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['level'] = $level + 1;
                $v['html']  = str_repeat($html, $level);
                $arr[] = $v;
                $arr = array_merge($arr, self::unlimitedForLevel($cate, $html, $v['id'], $level + 1));
            }
        }
        return $arr;
    }
    //组合多维数组
     public static function unlimitedForLayer ($cate, $name = 'child', $pid = 0) {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $v[$name] = self::unlimitedForLayer($cate, $name, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }
    //传递一个子分类ID返回所有的父级分类
    public static function getParents ($cate, $id) {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['id'] == $id) {
                $arr[] = $v;
                $arr = array_merge(self::getParents($cate, $v['pid']), $arr);
            }
        }
        return $arr;
    }

    //传递一个父级分类ID返回所有子分类ID
    public static function getChildsId ($cate, $pid) {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $arr[] = $v['id'];
                $arr = array_merge($arr, self::getChildsId($cate, $v['id']));
            }
        }
        return $arr;
    }
    //传递一个父级分类ID返回所有子分类
    public static function getChilds ($cate, $pid) {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $arr[] = $v;
                $arr = array_merge($arr, self::getChilds($cate, $v['id']));
            }
        }
        return $arr;
    }


}