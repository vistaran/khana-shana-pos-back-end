<?php

namespace App\Http\Controllers;

use App\AttributeFamily;
use App\Category;
use App\CategoryProduct;
use App\Product;
use App\ProductAttributeFamily;
use Attribute;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProductAttributeFamilySeeder;

class ProductController extends Controller
{
    public function show()
    {
        try {
            $product = Product::join('product_attribute_family', 'product.id', '=', 'product_attribute_family.product_id')
                ->join('attribute_family', 'product_attribute_family.attribute_family_id', '=', 'attribute_family.id')
                ->select(
                    'product.id',
                    'product.sku',
                    'product.name',
                    'product.product_type',
                    'product.status',
                    'product.price',
                    'product.quantity',
                    'product.created_at',
                    'product.updated_at',
                    'attribute_family.attribute_family_name',
                )->orderBy('id', "DESC")
                ->paginate(10);
            return response()->json([
                'products' => $product,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function edit($id, Request $request)
    {

        try {
            $credential = $request->only([
                'sku',
                'name',
                'product_type',
                'status',
                'price',
                'quantity',
            ]);
            Product::where('id', $id)
                ->update([
                    'sku' => $request->sku,
                    'name' => $request->name,
                    'product_type' => $request->product_type,
                    'status' => $request->status,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                ]);

            $category_id = Category::where('name', $request->category_name)->first()->id;

            $flag_category_product = CategoryProduct::where('product_id', $id)->get();
            CategoryProduct::when($flag_category_product->isEmpty(), function () use ($category_id, $id) {
                $category_product = new CategoryProduct();
                $category_product->category_id = $category_id;
                $category_product->product_id = $id;
                $category_product->save();
            })
                ->when($flag_category_product->isNotEmpty(), function ($q) use ($category_id, $id) {
                    $q->update([
                        'category_id' => $category_id,
                        'product_id' => $id
                    ]);
                });
            return response()->json([
                'ipdate message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function delete($id)
    {
        try {
            DB::table('category_product')
                ->where('product_id', $id)
                ->delete();

            Product::find($id)
                ->delete();
            return response()->json([
                'delete message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function insert(Request $request)
    {
        try {
            $credentials = $request->only([
                'sku',
                'name',
                'product_type',
                'status',
                'price',
                'quantity',
                'attribute_family_name',
            ]);
            $product = new Product();
            $product_attribute_family = new ProductAttributeFamily();

            $product->sku = $request->sku;
            $product->name = $request->name;
            $product->product_type = $request->product_type;
            $product->status = $request->status;
            $product->price = $request->price;
            $product->quantity = $request->quantity;

            $product->save();

            $product_attribute_id = AttributeFamily::where('attribute_family_name', $request->attribute_family_name)->first()->id;

            $product_id = Product::where('name', $request->name)->first()->id;

            $product_attribute_family->attribute_family_id = $ProductAttributeID;
            $product_attribute_family->product_id = $id;
            $product_attribute_family->save();
            return response()->json([
                'insert data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $data =
            Product::join('product_attribute_family', 'product.id', '=', 'product_attribute_family.product_id')
            ->join('attribute_family', 'product_attribute_family.attribute_family_id', '=', 'attribute_family.id')
            ->where('product_attribute_family.product_id', $query)
            ->orWhere('product.price', $query)
            ->orWhere('product.quantity', $query)
            ->orWhere('product.sku', 'like', '%' . $query . '%')
            ->orWhere('product.name', 'like', '%' . $query . '%')
            ->orWhere('product.product_type', 'like', '%' . $query . '%')
            ->select(
                'product.id',
                'product.sku',
                'product.name',
                'product.product_type',
                'product.status',
                'product.price',
                'product.quantity',
                'product.created_at',
                'product.updated_at',
                'attribute_family.attribute_family_name',
            )
            ->orderBy('id')
            ->paginate(10);

        return response()->json([
            'products' => $data,
        ]);
    }
    public function show_data($id)
    {
        $product = Product::where('id', $id)->first();

        return response()->json([
            'show_data' => $product,
        ]);
    }
}
