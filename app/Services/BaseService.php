<?php

/**
 * User: xiaogu
 * Date: 17/2/19
 * Time: 21:44
 */
namespace App\Services;

abstract class BaseService
{
    protected static $model = [];
    protected static $modelName = '';
    protected static function getModel($atterbutes = []){
        return static::getInstance($atterbutes);
    }

    protected static function getInstance($attr = []){
        $name = static::$modelName;
        if($attr){
            $key = md5($name.json_encode($attr));
        }else{
            $key = md5($name);
        }
        if(isset(self::$model[$key])){
            return self::$model[$key];
        }else{
            //
            $class = "App\\Models\\".$name;
            $model = new $class;
            $key = $attr ? $name.json_encode($attr) : $name;
            $key = md5($key);
            self::registerModel($key,$model);
            return $model;
        }
    }

    protected static function registerModel($key,$instance){
        self::$model[$key] = $instance;
    }

    /**
     * @param $data
     * @return bool|int
     */
    public static function insert($data){
        $data = static::buildData($data);
        return static::getModel()->insert($data);
    }

    public static function insertGetId($data){
        $data = static::buildData($data);
        return static::getModel()->insertGetId($data);
    }
    /**
     * 更新
     * @param $data
     * @param $id
     * @return bool|int
     */
    public static function update($data,$id){
        return static::getModel()->where("id",'=',$id)->update($data,['id' => $id]);
    }

    /**
     * 删除
     * @param $id
     * @return bool|int
     */
    public static function delete($id){
        $model = static::getModel()->find($id);
        return $model->delete();
    }

    /**
     * 获取一条数据
     * @param $id
     * @return bool|mixed
     */
    public static function get($id,$fileds = []){
        if(!empty($fileds)){
            $data = static::getModel()->select($fileds)->where('id','=',$id)->first();
        }else{
            $data = static::getModel()->where('id','=',$id)->first();
        }
        if($data){
            return $data->toArray();
        }
        return [];
    }

    public static function getRow($where,$filed = [],$order = []){
        $select = self::getSelect($where,$filed);
        if(!empty($order)){
            foreach ($order as $key => $o){
                $select->orderBy($key,$o);
            }
        }
        $data = $select->first();
        if($data){
            return $data->toArray();
        }
        return [];
    }

    /**
     * 组装数据
     * @param $data
     * @return mixed
     */
    public static function buildData($data){
        return $data;
    }

    /**
     * @param $where
     * @param int $pageSize
     * @param array $order
     * @return array
     */
    public static function getList($where,$pageSize = 20,$order = []){
        $select = self::getSelect($where);
        if(!empty($order)){
            foreach ($order as $key => $op){
                $select->orderBy($key,$op);
            }
        }
        $data = $select->paginate($pageSize);
        return $data;
    }

    /**
     * 通过where条件更新
     * @param $where
     * @param $data
     * @return mixed
     */
    public static function updateByWhere($where,$data){

        $select = self::getSelect($where);
        $data = $select->update($data);
        return $data;
    }

    /**
     * 通过where条件删除数据
     * @param $where
     * @return mixed
     */
    public static function deleteByWhere($where){
        if(empty($where)){
            throw new \LogicException('不允许不传where条件删除数据');
        }
        $select = self::getSelect($where);
        return $select->delete();
    }

    /**
     * 获取总数
     * @param $where
     * @return mixed
     */
    public static function count($where){
        $select = self::getSelect($where);
        return $select->count();

    }

    /**
     * 获取数据，不分页
     * @param $where
     * @param $order
     * @return array
     */
    public static function getsBy($where = [],$order = [],$field = []){
        $select = self::getSelect($where,$field);
        $select =self::order($select,$order);
        return $select->get()->toArray();
    }

    /**
     * 排序
     * @param $select
     * @param array $order  ['id' =>'desc']
     * @return mixed
     */
    private static function order($select , $order = []){
        if(!empty($order)){
            foreach ($order as $key => $op){
                $select->orderBy($key,$op);
            }
        }
        return $select;
    }

    private static function getSelect($where,$filed = []){
        $model = static::getModel();
        if(!empty($filed)){
            $select = $model->select($filed);
        }else{
            $select = $model->select();
        }
        if(empty($where)){
            return $select;
        }

        foreach ($where as $key => $map){
            if(!is_array($map)){
                $select->where($key,$map);
                continue;
            }
            if(count($where[$key]) >= 2){
                foreach ($map as $m){
                    if(is_array($m)) {
                        $select = self::getWhere($select, $key, $m[0], $m[1]);
                    }else{
                        $select = self::getWhere($select,$key,$map[0],$map[1]);
                        break;
                    }
                }
            }else{
                $select = self::getWhere($select,$key,$map[0],$map[1]);
            }
        }
        return $select;
    }

    /**
     * 获取where
     * @param $select
     * @param $field
     * @param $operate
     * @param $data
     * @return mixed
     */
    private static function getWhere($select ,$field, $operate,$data){
        $operate = strtoupper($operate);
        switch ($operate){
            case "IN":
                $select->whereIn($field,$data);
                return $select;
            case 'NOTIN' :
                $select->whereNotIn($field,$data);
                return $select;
            case "BETWEEN" :
                $select->whereBetween($field,$data);
                return $select;
            case 'NOTBETWEEN' :
                $select->whereNotBetween($field,$data);
                return $select;
            case 'OR' :
                $select->orWhere($field,$data);
                return $select;
            case 'LIKE' :
                $select->where($field,'like',$data);
                return $select;
            case 'FIND_IN_SET' :
                $select->whereRaw("find_in_set($data,{$field})");
                return $select;
            default :
                return $select->where($field,$operate,$data);
        }
    }

}