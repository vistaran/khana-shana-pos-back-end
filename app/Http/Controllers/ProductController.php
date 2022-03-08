<?php

namespace App\Http\Controllers;

use App\Product;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show()
    {
        try {
            $product = Product::join('product_attribute_family', 'product.id', '=', 'product_attribute_family.product_id')
                ->join('attribute_family', 'product_attribute_family.attribute_family_id', '=', 'attribute_family.id')
                ->select(
                    'product_attribute_family.id',
                    'product.sku',
                    'product.name',
                    'product.product_type',
                    'product.status',
                    'product.price',
                    'product.quantity',
                    'product.created_at',
                    'product.updated_at',
                    'attribute_family.attribute_family_name',
                )->orderBy('id')
                ->paginate(10);
            return response()->json([
                'Products' => $product,

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
            return response()->json([
                'Update Message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function delete($id)
    {
        try {
            Product::find($id)
                ->delete();
            return response()->json([
                'Delete Message' => 'Successfully Deleted !',
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
            ]);
            $p = new Product();
            $p->sku = $request->sku;
            $p->name = $request->name;
            $p->product_type = $request->product_type;
            $p->status = $request->status;
            $p->price = $request->price;
            $p->quantity = $request->quantity;

            $p->save();
            return response()->json([
                'Insert Data' => 'Successfully Inserted !',
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
            $product = Product::join('product_attribute_family', 'product.id', '=', 'product_attribute_family.product_id')
            ->join('attribute_family', 'product_attribute_family.attribute_family_id', '=', 'attribute_family.id')
            ->where('product_attribute_family.id', $query)
            ->orWhere('product.price', $query)
            ->orWhere('product.quantity', $query)
            ->orWhere('product.sku', 'like', '%' . $query . '%')
            ->orWhere('product.name', 'like', '%' . $query . '%')
            ->orWhere('product.product_type', 'like', '%' . $query . '%')
            ->select(
                'product_attribute_family.id',
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
            'Products_Search' => $data,
        ]);
    }
}
