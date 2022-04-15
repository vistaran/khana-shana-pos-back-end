<?php

namespace App\Http\Controllers;

use App\CategoryProduct;
use App\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $product = Product::select(
                'product.*',
            )->orderBy('id', "DESC")
                ->paginate(10);
            return response()->json(['products' => $product]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $product = new Product();
            $product->product_name = $request->product_name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->category_name = $request->category_name;
            $product->save();

            // dd($product->id);
            CategoryProduct::insert([
                'category_id' => $request->category_id,
                'product_id' => $product->id,
            ]);

            return response()->json([
                'message' => "Product inserted",
            ]);
            // foreach ($request->insert_product_data as $uData) {
            // dd($uData);
            // foreach ($uData['group_data'] as $gData) {
            // foreach ($gData['items'] as $item) {
            //         }
            //     }
            // }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::where('id', $id)->first();
            return response()->json($product);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $product_name = $request->product_name;
            $description = $request->description;
            $price = $request->price;
            $category_id = $request->category_id;
            $attribute_id = $request->attribute_id;
            $group_id = $request->group_id;
            $attribute_family_id = $request->attribute_family_id;
            $attribute_data = $request->attribute_data;
            $category_name = $request->category_name;
            // dd(Product::where('id', $id)->get());
            Product::where('id', $id)
                ->update([
                    'attribute_data' => $attribute_data,
                    'product_name' => $product_name,
                    'description' => $description,
                    'price' => $price,
                    'category_id' => $category_id,
                    'category_name' => $category_name,
                ]);
            $group = Product::where('id', $id)->first();
            // foreach ($request->update_product_data as $iData) {
            // dd($uData);
            //     foreach ($iData['group_data'] as $gData) {
            //         foreach ($gData['items'] as $item) {
            // 'attribute_id' => $item['attribute_id'],
            // 'group_id' => $item['group_id'],
            // 'attribute_family_id' => $item['attribute_family_id'],
            //         }
            //     }
            // }
            return response(['products' => $group]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // DB::table('category_product')
            //     ->where('product_id', $id)
            //     ->delete();

            Product::where('id', $id)
                ->delete();
            return response()->json([
                'Delete Message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
