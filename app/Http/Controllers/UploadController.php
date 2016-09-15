<?php
/**
 * Created by PhpStorm.
 * User: TAO YU
 * Date: 9/11/2016
 * Time: 12:43 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {}

    //no using anymore
    public function imgupload2()
    {
        $sFileName = $_FILES['image_file']['name'];
        $sFileType = $_FILES['image_file']['type'];
        $sFileSize = bytesToSize1024($_FILES['image_file']['size'], 1);
        echo <<<EOF
<p>Your file: {$sFileName} has been successfully received.</p>
<p>Type: {$sFileType}</p>
<p>Size: {$sFileSize}</p>
EOF;
    }
    function bytesToSize1024($bytes, $precision = 2) {
        $unit = array('B','KB','MB');
        return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
    }

    //currently use
    public function imgupload()
    {
        $file = Input::file('image_file');
        //$id = Input::get('id');
        $allowed_extensions = ["png", "jpg", "gif", "bmp"];
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            return ['error' => 'You may only upload png, jpg or gif.'];
        }

        $destinationPath = 'uploads/images/';
        $extension = $file->getClientOriginalExtension();
        //$fileName = str_random(10).'.'.$extension;
        $fileName = date('Ymd').".".date('His').".".$extension;
        $file->move($destinationPath, $fileName);
        //return $fileName;
        return [
            'success' => true,
            //'pic' => asset($destinationPath.$fileName) //path is HTTP://... cannot be delete by unlink
            'pic' => $destinationPath.$fileName
        ];
    }

    //delete Pic
    public function imgDelete()
    {
        $filename = Input::get('deleteImgId');

        fopen(public_path($filename),'r');
        if(!unlink($filename))
        {
            return [
                'success' => false,
                'message' => '删除失败'
            ];
        }
        else
        {
            return [
                'success' => true,
                'message' => '删除成功'
            ];
        }
    }

    //other way to save file
    public function postFileupload(Request $request){
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $savePath = 'test/'.$newFileName;
        $bytes = Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );
        if(!Storage::exists($savePath)){
            exit('保存文件失败！');
        }
        header("Content-Type: ".Storage::mimeType($savePath));
        echo Storage::get($savePath);
    }
}