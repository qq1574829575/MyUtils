<?php
namespace MyUtils\upload;

class UploadUtils
{
    /**
     * @param $save_upload_path @文件保存的路径
     * @param bool $is_return_url @是否返回url
     * @param int $limit_file_size @限制上传文件大小
     * @param string[] $limit_file_ext @限制上传文件类型
     * @param bool $use_https_url @返回的url是否使用https
     */
    public function uploadFiles(
        $save_upload_path,
        $is_return_url = true,
        $limit_file_size = 20,
        $limit_file_ext = array("jpg","jpeg","png","gif"),
        $use_https_url = false
    ){
        $files = $_FILES;
        $arr_urls = array();

        if (!is_dir($save_upload_path)){
            return array("code"=>0,"message"=>"无效的上传文件夹！");
        }

        if (count($files)<=0){
            return array("code"=>0,"message"=>"未上传文件！");
        }

        foreach ($files as $file){
            $file_name = $file[ 'name' ]; // 文件名称
            $file_size = $file[ 'size' ]; // 文件大小
            $file_ext  = strtolower(substr($file_name, strrpos($file_name, '.') + 1)); // 文件后缀名
            $file_tmp  = $file['tmp_name']; // 临时文件地址

            if ($file_size > 1024 * 1024 * $limit_file_size){
                return array("code"=>0,"message"=>"上传文件大小超过限制");
            }

            if (!$this->checkFileExt($file_ext, $limit_file_ext)){
                return array("code"=>0,"message"=>"不允许上传.".$file_ext."类型的文件");
            }

            $this->checkPictureFile($file_ext,$file_tmp);

            if(!rename($file_tmp,$save_upload_path ."/". $file_name)) {
                return array("code"=>0,"message"=>"保存文件失败");
            }

            if ($is_return_url){
                $httpHeader = "http";
                if ($use_https_url){
                    $httpHeader = "https";
                }
                $url = dirname($httpHeader.'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"])."/".$save_upload_path ."/". $file_name;
                $arr_urls[] = array("name"=>$file_name,"url"=>$url);
            }
        }

        if ($is_return_url){
            return array("code"=>1,"message"=>"上传成功","fileList"=>$arr_urls);
        }else{
            return array("code"=>1,"message"=>"上传成功");
        }
    }

    public function checkFileExt($ext, $limit_ext){
        $flag = false;
        foreach ($limit_ext as $_ext){
            if ($ext == $_ext){
                $flag = true;
            }
        }
        return $flag;
    }

    public function checkPictureFile($file_ext,$file_tmp){
        if ($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "png" || $file_ext == "gif"){
            /*if(!getimagesize($file_tmp)){
                exit(json_encode(array("code"=>0,"message"=>"上传的图片已损坏！")));
            }*/
            if($file_ext == 'jpg' || $file_ext == 'jpeg' ) {
                $img = imagecreatefromjpeg($file_tmp);
                imagejpeg($img, $file_tmp, 100);
                imagedestroy($img);
            }
            if($file_ext == 'png') {
                $img = imagecreatefrompng($file_tmp);
                imagepng($img, $file_tmp);
                imagedestroy($img);
            }
            if ($file_ext == 'gif'){
                $img = imagecreatefromgif($file_tmp);
                imagepng($img, $file_tmp);
                imagedestroy($img);
            }
        }
    }
}