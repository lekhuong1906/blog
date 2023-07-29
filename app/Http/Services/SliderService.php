<?php


namespace App\Http\Services;


use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderService
{
    public function getSlider(){
        $files = Storage::allFiles('public/sliders');
        $imageUrl = [];
        foreach ($files as $file){
            $imageUrl[] = asset('storage/'.str_replace('public/','',$file));
        }
        return $imageUrl;
    }

    public function createSlider($request){
        try {
            $image = Str::random(32) . "." . $request->image->getClientOriginalExtension();

            Slider::create([
                'image_name' => $request->image_name,
                'image' => $image,
                'image_description' => $request->image_description
            ]);

            Storage::putFileAs('public/sliders', $request->file('image'), $image);


            return response()->json([
                'message' => 'Success.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
