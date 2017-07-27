<?php
/**
 * User: xiaogu
 * Date: 17/3/24
 * Time: 22:32
 */

namespace App\Services;


use EasyWeChat\Core\Exception;
use Illuminate\Http\Request;
use Image;

class UploadService
{
    public static function uploadOne(Request $request,$dir = 'student',$input = 'file',$ext = ['gif','bmp','jpeg','jpg','png']){
        $ym = date("Y-m");
        $path = $dir.'/'.$ym;
        if(!$request->hasFile($input)){
            throw new \Exception('请上传文件');
        }
        $files = $request->file($input);
        $extension = $files->extension();
        $extension = strtolower($extension);
        if(!in_array($extension,$ext)){
            throw new \Exception('不允许的文件类型');
        }
        $name = uniqid().'.'.$extension;
        try {
            $path = $files->storeAs($path,$name,'public');
            $path = '/upload/'.$path;
            $success = true;
            $message = '上传成功';
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        if($success){
            return $path;
        }else{
            throw new Exception($message);
        }
    }

    public static function uploadAvatar(Request $request,$dir = 'student',$input = 'file',$ext = ['gif','bmp','jpeg','jpg','png']){
        try{
            $path = self::uploadOne($request,$dir,$input,$ext);
//            $filePath = ltrim($path,'/upload');
//            $realPath = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR).$filePath;
//            $img = Image::make($realPath)->resize(100, 100);
//            $img->save($realPath);
            return $path;
        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
    }

}