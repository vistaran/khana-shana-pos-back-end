<?php

namespace App\Http\Controllers;

use App\AttributeFamily;
use App\AttributeFamilyGroup;
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

class ProductsController extends Controller
{
    public function show()
    {
        try {
            $product = Product::join('attribute', 'attribute.id', '=', 'product.attribute_id')
                ->join('attribute_family', 'attribute_family.id', '=', 'product.attribute_family_id', 'left')
                ->join('group', 'group.id', '=', 'product.group_id', 'left')
                ->select(
                    'product.*',
                    'attribute.name',
                    'group.name',
                    'group.group_based'
                )->orderBy('id', "DESC")
                ->paginate(10);
            return response()->json([
                'Products' => $product,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function edit(Request $request)
    {
        $attribute_id = $request->attribute_id;
        $group_id = $request->group_id;
        $attribute_family_id = $request->attribute_family_id;
        foreach ($request->update_product_data as $iData) {
            // dd($uData);
            foreach ($iData['group_data'] as $gData) {
                foreach ($gData['items'] as $item) {
                    $group = Product::where('attribute_family_id', '=', $attribute_family_id)
                        ->where('attribute_id', '=', $attribute_id)
                        ->where('group_id', '=', $group_id)
                        ->update([
                            'attribute_data' => $item['data'],
                            // 'attribute_id' => $item['attribute_id'],
                            // 'group_id' => $item['group_id'],
                            // 'attribute_family_id' => $item['attribute_family_id'],
                        ]);
                }
            }
        }
        return response(['data' => $group]);
    }
    /**public function edit($id, Request $request)
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

            $flag = CategoryProduct::where('product_id', $id)->get();
            CategoryProduct::when($flag->isEmpty(), function () use ($category_id, $id) {
                $p = new CategoryProduct();
                $p->category_id = $category_id;
                $p->product_id = $id;
                $p->save();
            })
                ->when($flag->isNotEmpty(), function ($q) use ($category_id, $id) {
                    $q->update([
                        'category_id' => $category_id,
                        'product_id' => $id
                    ]);
                });
            return response()->json([
                'Update Message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }**/

    public function delete($id)
    {
        try {
            DB::table('category_product')
                ->where('product_id', $id)
                ->delete();

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
        $attribute_id = $request->attribute_id;
        $group_id = $request->group_id;
        $attribute_family_id = $request->attribute_family_id;
        foreach ($request->insert_product_data as $uData) {
            // dd($uData);
            foreach ($uData['group_data'] as $gData) {
                foreach ($gData['items'] as $item) {
                    $group = Product::where('attribute_family_id', $attribute_family_id)
                        ->where('attribute_id', $attribute_id)
                        ->where('group_id', $group_id)
                        ->insert([
                            'attribute_data' => $item['data'],
                            'attribute_id' => $item['attribute_id'],
                            'group_id' => $item['group_id'],
                            'attribute_family_id' => $item['attribute_family_id'],
                        ]);
                }
            }
        }
    }
    /**public function insert(Request $request)
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
            $p = new Product();
            $paf = new ProductAttributeFamily();

            $p->sku = $request->sku;
            $p->name = $request->name;
            $p->product_type = $request->product_type;
            $p->status = $request->status;
            $p->price = $request->price;
            $p->quantity = $request->quantity;

            $p->save();

            $ProductAttributeID = AttributeFamily::where('attribute_family_name', $request->attribute_family_name)->first()->id;

            $id = Product::where('name', $request->name)->first()->id;

            $paf->attribute_family_id = $ProductAttributeID;
            $paf->product_id = $id;
            $paf->save();
            return response()->json([
                'Insert Data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }**/

    public function search(Request $request)
    {
        $query = $request->input('query');
        $data =
            $product = Product::join('product_attribute_family', 'product.id', '=', 'product_attribute_family.product_id')
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
            'Products' => $data,
        ]);
    }
    public function show_data($id)
    {
        $product = Product::where('id', $id)->first();

        return response()->json([
            'Show_Data' => $product,
        ]);
    }
}
