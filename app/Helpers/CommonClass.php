<?php

namespace App\Helpers;

use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer;

class CommonClass
{
    public static function dateTimeFormat($datetime, $type='datetime')
    {
        if($type == 'datetime'){
            return date("Y-m-d h:i A", strtotime($datetime));

        }elseif($type == 'date'){
            return date("Y-m-d", strtotime($datetime));

        }elseif($type == 'time'){
            return date("h:i A", strtotime($datetime));

        }else{
            return 'Invalid format';
        }
    }

    public static function jsonValidation($data=NULL){

        if (!empty($data)) {
            @json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }

    public static function uploadImage($fileObj, $folder=''){
        try{
            //make thumbnail function
            $createThumbnail = function($sourcePath,$thumbnailPath, $width, $height, $resizeWithRatio = true){

                if($resizeWithRatio){ //ration based
                    $img = Image::make($sourcePath)->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailPath);

                }else{ //fixed size based
                    $img = Image::make($sourcePath)->resize($width, $height);
                    $img->save($thumbnailPath);
                }
            };

            //image info
            $filenamewithextension = $fileObj->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $fileObj->getClientOriginalExtension();

            //filename to store
//            $baseImgName = $filename.'_'.time().'.'.$extension;
            $baseImgName = date('Ymdhis').'_'.rand(111111,999999999).'.'.$extension;
            $originalImg = 'original_'.$baseImgName;
            $smallImg = 'small_'.$baseImgName;
            $mediumImg = 'medium_'.$baseImgName;
            $largeImg = 'large_'.$baseImgName;

            //Upload File
            $fileObj->move(public_path('upload/'.$folder.'/'), $originalImg);
            $createThumbnail('upload/'.$folder.'/'.$originalImg, 'upload/'.$folder.'/'.$smallImg,150, 93);
            $createThumbnail('upload/'.$folder.'/'.$originalImg, 'upload/'.$folder.'/'.$mediumImg,300, 185);
            $createThumbnail('upload/'.$folder.'/'.$originalImg, 'upload/'.$folder.'/'.$largeImg,550, 340);

            $file = [
                'base_name' => $baseImgName,
                'original' => 'upload/'.$folder.'/'.$originalImg,
                'large' => 'upload/'.$folder.'/'.$largeImg,
                'medium' => 'upload/'.$folder.'/'.$mediumImg,
                'small' => 'upload/'.$folder.'/'.$smallImg,
            ];

        }catch (\Exception $e){
            return $file = false;
        }
        return $file;
    }

    public static function getImagePath($folder='', $size='small', $baseName='', $returnPath = false){
                   return  'https://via.placeholder.com/100?text=Preview';

        if($returnPath){
            return asset('upload/'.$folder.'/'.$size.'_');
        }else{
            $path = 'upload/'.$folder.'/'.$size.'_'.$baseName;
            if($baseName && file_exists($path)){
                return  asset($path);
            }else{
                return asset('img/preview.png');
//           return  'https://via.placeholder.com/100?text=Preview';
            }
        }

    }

    public static function uploadFile($fileObj, $folder=''){
        try{
            //image info
            $filenamewithextension = $fileObj->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $fileObj->getClientOriginalExtension();

            //filename to store
            $originalImg = $filename.'_'.time().'.'.$extension;

            //Upload File
            $fileObj->move(public_path('upload/'.$folder.'/'), $originalImg);

            $file = [
                'name' => $originalImg,
                'path' => 'upload/'.$folder.'/'.$originalImg
            ];

        }catch (\Exception $e){
            return $file = false;
        }
        return $file;
    }

    public static function invoiceNo($prefix='T'){
        return self::user()->company_id.date('ymdh').self::user()->id.rand(10, 999);
        return date('my').strtoupper(uniqid());
        return date('my').strtoupper(uniqid()).rand(11, 999);
        return $prefix.'-'.date('Ymdhis').rand(100, 9999);
    }

    public static function getProductAttributeMatrix($input =[]) {
        /*$input=[
           'size'=>[
               ['id'=>11, 'name'=>'XL'],
               ['id'=>23, 'name'=>'M'],
           ],
           'unit'=>[
               ['id'=>1, 'name'=>'kg'],
               ['id'=>2, 'name'=>'g'],
           ],
           'brand'=>[
               ['id'=>1, 'name'=>'metro'],
               ['id'=>2, 'name'=>'mahedi'],
               ['id'=>'', 'name'=>'test'],
           ],
       ];*/

        $result = [[]];
        foreach ($input as $key => $values) {
            $append = [];
            foreach ($values as $id=>$name) {
                foreach ($result as $data) {
                    $append[] = $data + [$key => $name];
                }
            }
            $result = $append;
        }
        return $result;
    }

    public static function getStockByProductAttribute($params, $variant_display){
        $product_id = isset($params['product_id'])?$params['product_id']:null;
        return Stock::where('product_id',$product_id)->where('variant_display',$variant_display)->first();
    }

    public static function generateBarcode($prefix = ''){
//        $unique = strtoupper(uniqid($prefix));
        $ran =  str_pad(strtoupper(mt_rand( 100, date('Y'))),4,"0",STR_PAD_LEFT);
        $stockMax =Stock::max('id')+1;
        $unique = $prefix.str_pad($stockMax.$ran,12,"0",STR_PAD_LEFT);
        $check = Stock::where('sku', $unique)->first();
        if ($check) {
            return self::generateBarcode($prefix);
        }
        return $unique;
    }

    public static function getBarcodeImgUri($code){
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128, 1,50));
        return "data:image/png;base64,".$barcode;
//        echo  "<img  src='data:image/png;base64,".$barcode."' /><br>".$code.'<br>';
    }

    public static function getQRCodeImg($content=''){
        return QrCode::size(100)->generate($content);
    }

    public static function user(){
        return Auth::user();
    }

    public static function currencySymbol($symbol=true){
        return ($symbol)? '৳':'BDT';
    }
}
