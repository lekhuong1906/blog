<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Services;
use App\Http\Requests\SliderRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    protected $data;

    public function __construct(Services\ProcessService $processService)
    {
        return $this->data = $processService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return false|\Illuminate\Http\Response|string
     */
    public function index()
    {
        $files = Storage::allFiles('public/sliders');

        $imageUrls = [];

        foreach ($files as $file) {
            $imageUrls[] = asset('storage/'.str_replace('public/', '', $file));
        }
        return $this->data->formatJson($imageUrls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SliderRequest $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

    }
}
