<?php


namespace App\Http\Services;


use App\Models\ImageProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageProductService extends ProcessService
{
    public function showImage($productId){
        try {
            $images = ImageProduct::where('product_id',$productId)->first();
            $images_link = explode(',',$images->image_link);

            return $images_link;
        } catch (\Exception $exception){
            return response()->json([
                'message'=>$exception->getMessage(),
            ]);
        }

    }

    public function createImage($request)
    {
        try {
            $images = $this->dataImage($request);

            $this->importStorage($images);

            $dataImport = $this->dataImport($images);
            $this->importImage($dataImport);


            return response()->json([
                'message' => 'Success.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function dataImport($images)
    {
        $arrName = array();
        $arrLink = array();
        foreach ($images as $image) {
            array_push($arrName, $image['name']);
            array_push($arrLink, $image['link']);
        }
        return [
            'product_id' => request()->product_id,
            'image_name' => implode(',', $arrName),
            'image_link' => implode(',', $arrLink),
        ];
    }

    public function dataImage($request)
    {
        $images = [];
        $images[] = $this->thumbNail($request->thumb_nail);
        $imageList = $this->images($request->images);
        foreach ($imageList as $value)
            $images[] = $value;
        return $images;
    }

    public function thumbNail($imageFile)
    {
        $thumbNail['file'] = $imageFile;
        $thumbNail['name'] = $this->setImageName($imageFile);
        $thumbNail['link'] = $this->getUrlImage($thumbNail['name']);
        return $thumbNail;
    }

    public function images($imageFiles)
    {
        $data = [];
        foreach ($imageFiles as $image) {
            $value['file'] = $image;
            $value['name'] = $this->setImageName($image);
            $value['link'] = $this->getUrlImage($value['name']);
            $data[] = $value;
        }
        return $data;
    }

    public function setImageName($imageFile)
    {
        return Str::random(32) .'.'. $imageFile->getClientOriginalExtension();
    }


    public function importImage($data)
    {
        $image_product = new ImageProduct();
        $image_product->fill($data);
        $image_product->save();
    }

    public function importStorage($images)
    {
        foreach ($images as $image)
            Storage::putFileAs('public/products', $image['file'], $image['name']);
    }

    public function getUrlImage($imageName)
    {
        return asset('storage/products/' . $imageName);
    }
}
