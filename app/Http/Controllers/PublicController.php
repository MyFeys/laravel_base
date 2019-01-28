<?php
namespace App\Http\Controllers;

use App\Traits\Msg;
use Illuminate\Http\Request;
use zgldh\QiniuStorage\QiniuStorage;

class PublicController extends Controller
{
    use Msg;
    //图片上传处理
    public function uploadImg(Request $request)
    {

        //上传文件最大大小,单位M
        $maxSize = 10;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif"];
        //返回信息json
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()){
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的图片";
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getClientSize() > $maxSize*1024*1024){
                $data['msg'] = "图片大小限制".$maxSize."M";
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }
        $newFile = date('Y-m-d')."_".time()."_".uniqid().".".$file->getClientOriginalExtension();
        $disk = QiniuStorage::disk('qiniu');
        $res = $disk->put($newFile,file_get_contents($file->getRealPath()));
        if($res){
            $data = [
                'code'  => 0,
                'msg'   => '上传成功',
                'data'  => $newFile,
                'url'   => $disk->downloadUrl($newFile).'?imageMogr2/auto-orient/interlace/1/blur/1x0/quality/75|watermark/1/image/aHR0cDovL3BsbDk1NGlkNy5ia3QuY2xvdWRkbi5jb20vMTEucG5n/dissolve/70/gravity/SouthEast/dx/10/dy/10'
            ];
        }else{
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);
    }

    /**
     * 生成图片水印
     * Date: 2018\9\6 0006
     * Time: 17:52
     */
    public function WaterMask($path){
        $watermark = $this->sysconfig('watermark');
        $watermarkText = $this->sysconfig('watermarkText');
        if($watermark == 0){
            return true;
        }
        $imgFileName = $path;//需要加水印图片路径
        $obj = new WaterMarkController($imgFileName); //实例化对象
        $imgInfo = $obj->srcImgInfo();
        $fontSize = ceil(($imgInfo[0])/27);

        $obj->waterTypeStr = true;     //开启文字水印
        $obj->waterTypeImage = false;    //开启图片水印
    // $obj->pos = 10;         //定义水印图片位置
    // $obj->waterImg = './water.png';      //水印图片
        $obj->transparent = 30;          //水印透明度
        $obj->waterStr = empty($watermarkText) ? '金牌大管家' : $watermarkText;       //水印文字
        $obj->fontSize = $fontSize;            //文字字体大小
        $obj->fontColor = array(240,235,213);        //水印文字颜色（RGB）
        $font = ROOT_PATH.'hb/yahei.ttf';//字体路径
        $obj->fontFile = $font;    //字体文件，这里是微软雅黑
//      $obj->is_draw_rectangle = TRUE;      //开启绘制矩形区域
        $obj ->output_img = $path;//输出的图片路径
        $obj->output();
    }

}