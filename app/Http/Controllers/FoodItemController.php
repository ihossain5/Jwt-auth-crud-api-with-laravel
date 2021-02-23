<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\FoodItemCategory;
use App\Models\FoodItemPrice;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class FoodItemController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = FoodItem::with('foodItemCategory', 'price', 'stockItems')->get();
        return response()->json($products, 200);
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
        $image = $request->image;

        $category_id = $request->category;
        $category    = FoodItemCategory::find($category_id);

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'category' => 'required',
            'image'    => 'required|image|mimes:jpeg,png,jpg|dimensions:min_width=640,min_height=360',
        ]);

        // if ($request->has('image')) {
        //     $filename = $request->image->getClientOriginalName();
        //     $request->image->storeAs('items/food/', $filename, 'public');
        // }

        if ($validator->passes()) {
            if ($image) {
                $image_name      = hexdec(uniqid());
                $ext             = strtolower($image->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path     = 'foods/';
                $upload_path1    = 'images/foods/';
                $image_url       = $upload_path . $image_full_name;
                // $success         = $image->move($upload_path1, $image_full_name);
                $img = Image::make($image)->resize(640, 360);
                $img->save($upload_path1 . $image_full_name, 60);
            }

            // store into fooditem table
            $item = FoodItem::create([
                'name'  => $request->name,
                'image' => $image_url,
            ]);
            $item->foodItemCategory()->attach($category); // store into pivot table

            // store into item stock table
            $stock_item = ItemStock::create([
                'food_item_id' => $item['id'],
                'quantity'     => $request->quantity,
            ]);

            // store into  fooditem price table
            $product = FoodItemPrice::create([
                'food_item_id'     => $item['id'],
                'original_price'   => $request->original_price,
                'discounted_price' => $request->discounted_price,
                'discount_type'    => $request->discount_type,
                'fixed_value'      => $request->fixed_value,
                'percent_of'       => $request->percent_of,
            ]);
            return response()->json(['message' => 'Product stored successfully'], 201);
        } else {
            return response()->json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodItem  $foodItem
     * @return \Illuminate\Http\Response
     */
    public function show(FoodItem $foodItem) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodItem  $foodItem
     * @return \Illuminate\Http\Response
     */
    public function edit(FoodItem $foodItem) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodItem  $foodItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodItem $foodItem) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodItem  $foodItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodItem $foodItem) {
        //
    }
}
