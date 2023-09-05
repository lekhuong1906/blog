<?php


namespace App\Http\Services;


use App\Models\ImageProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageProductService
{
    public function createImage($request,$product_id)
    {
        try {
            $images = $this->dataImage($request); // Get image files

            $this->importStorage($images);  // Import to Storage

            $dataImport = $this->dataImport($images,$product_id); // Get Data to import into DB

            $this->importImage($dataImport);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function dataImport($images,$product_id)  // Create Data to Import into DB
    {
        $arrName = array();
        $arrLink = array();
        foreach ($images as $image) {
            array_push($arrName, $image['name']);
            array_push($arrLink, $image['link']);
        }
        return [
            'product_id' => $product_id,
            'image_name' => implode(',', $arrName),
            'image_link' => implode(',', $arrLink),
        ];
    }


    public function dataImage($request) // Merge images
    {
        $images = [];
        $images[] = $this->thumbnails($request->thumbnails);
        $imageList = $this->images($request->images);
        foreach ($imageList as $value)
            $images[] = $value;
        return $images;
    }

    public function thumbnails($imageFile)
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

    public function setImageName($imageFile)  // Set image name
    {
        return Str::random(32).'_'. $imageFile->getClientOriginalName();
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
        return ('http://blog.test:8080/storage/products/' . $imageName);
    }
}
