<?php

namespace App\Http\Controllers;

use App\Models\FoodItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class FoodItemCategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $category = FoodItemCategory::get();
        // $category->makeHidden(['created_at', 'updated_at']);
        return response()->json($category, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $name  = $request->name;
        $image = $request->image;
        $icon  = $request->icon;

        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=640,min_height=360',
            'icon'  => 'image|mimes:jpeg,png,jpg|dimensions:min_width=260,min_height=260',

        ]);
        if ($validator->passes()) {
            if ($image) {
                $image_name = hexdec(uniqid());
                $ext        = strtolower($image->getClientOriginalExtension());

                $image_full_name = $image_name . '.' . $ext;
                $upload_path     = 'category/';
                $upload_path1    = 'images/category/category/';
                $image_url       = $upload_path . $image_full_name;
                // $success         = $image->move($upload_path1, $image_full_name);
                $img = Image::make($image)->resize(644, 583);
                $img->save($upload_path1 . $image_full_name, 60);

            }

            if ($icon) {

                $icon_name         = hexdec(uniqid());
                $icon_ext          = strtolower($icon->getClientOriginalExtension());
                $icon_full_name    = $icon_name . '.' . $icon_ext;
                $icon_upload_path  = 'icons/';
                $icon_upload_path1 = 'images/category/icons/';
                $icon_url          = $icon_upload_path . $icon_full_name;
                // $success           = $icon->move($icon_upload_path1, $icon_full_name);
                $img = Image::make($icon)->resize(260, 260);
                $img->save($icon_upload_path1 . $icon_full_name, 60);

            }

            $category = FoodItemCategory::create([
                'name'  => $request->name,
                'image' => $image_url,
                'icon'  => $icon_url,
            ]);

            return response()->json(['message' => 'category created successfully'], 201);
        } else {
            return response()->json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodItemCategory  $foodItemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FoodItemCategory $foodItemCategory) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodItemCategory  $foodItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        // return $foodItemCategory;
        $category = FoodItemCategory::find($id);

        if ($category) {
            $category->makeHidden(['created_at', 'updated_at']);
            return response()->json($category, 200);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodItemCategory  $foodItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $category = FoodItemCategory::find($id);
        if ($category) {
            $image     = $request->image;
            $icon      = $request->icon;
            $validator = Validator::make($request->all(), [
                'name'  => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=640,min_height=360',
                'icon'  => 'image|mimes:jpeg,png,jpg|dimensions:min_width=260,min_height=260',

            ]);
            if ($validator->passes()) {
                if ($image) {
                    File::delete(public_path('images/category/' . $category->image));
                    $image_name      = hexdec(uniqid());
                    $ext             = strtolower($image->getClientOriginalExtension());
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path     = 'category/';
                    $upload_path1    = 'images/category/category/';
                    $image_url       = $upload_path . $image_full_name;
                    // $success         = $image->move($upload_path1, $image_full_name);
                    $img = Image::make($image)->resize(644, 583);
                    $img->save($upload_path1 . $image_full_name, 60);

                } else {
                    $image_url = $category->image;
                }

                if ($icon) {
                    File::delete(public_path('images/category/' . $category->icon));
                    $icon_name         = hexdec(uniqid());
                    $icon_ext          = strtolower($icon->getClientOriginalExtension());
                    $icon_full_name    = $icon_name . '.' . $icon_ext;
                    $icon_upload_path  = 'icons/';
                    $icon_upload_path1 = 'images/category/icons/';
                    $icon_url          = $icon_upload_path . $icon_full_name;
                    // $success           = $icon->move($icon_upload_path1, $icon_full_name);
                    $img = Image::make($icon)->resize(260, 260);
                    $img->save($icon_upload_path1 . $icon_full_name, 60);

                } else {
                    $icon_url = $category->icon;
                }

                $category->update([
                    'name'  => $request->name,
                    'image' => $image_url,
                    'icon'  => $icon_url,

                ]);
                return response()->json(['message' => 'category updated successfully'], 200);
            } else {
                return response()->json(['errors' => $validator->errors()]);
            }
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodItemCategory  $foodItemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $category = FoodItemCategory::find($id);

        if ($category) {
            $category->delete();
            File::delete(public_path('images/category/' . $category->icon));
            File::delete(public_path('images/category/' . $category->image));

            return response()->json(['message' => 'Category deleted successfully']);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }
}
