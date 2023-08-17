<?php


namespace App\Http\Services;


use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SliderService
{
    public function getSlider()
    {
        $image_links = Slider::orderby('id','desc')->take(3)->get();
        foreach ($image_links as $image_link)
            $data[] = $image_link->slider_image_link;
        return $data;
    }

    public function createSlider($request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'image' => 'required|image',
            ]);

            if ($validate->fails())
                return $validate->errors();

            $image_name = Str::random(32) . $request->image->getClientOriginalName();

            Storage::putFileAs('public/sliders', $request->file('image'), $image_name);

            $image_link = 'http://blog.test:8080/storage/sliders/' . $image_name;

            Slider::create([
                'slider_name' => $image_name,
                'slider_image_link' => $image_link,
                'slider_description' => $request->description
            ]);

            return 'Add Slider Successfully';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
