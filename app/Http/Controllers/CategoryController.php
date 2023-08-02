<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    //Show Category Datas
    public function show()
    {
        try {
            $category = Category::select(DB::raw('COUNT(category_product.category_id) as number_of_products'))
                ->join('category_product', 'category_product.category_id', '=', 'category.id')
                ->groupBy('category.id')
                ->orderBy('id', 'desc')
                ->paginate(10);
            return response()->json([
                'category' => $category,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Insert Category
    public function add(Request $request)
    {

        try {
            $credential = $request->only([
                'parent_id', 'name', 'visible_in_menu', 'position', 'display_mode', 'description', 'image', 'category_logo', 'parent_category', 'attri', 'meta_title', 'slug', 'meta_description', 'meta_keyword', 'status',
            ]);
            $category_product = new CategoryProduct();
            $category = new Category();
            if ($request->parent_id == null) {
                $category->parent_category_id = null;
            } else {
                $category->parent_category_id = $request->parent_id;
            }
            $category->name = $request->name;
            $category->visible_in_menu = $request->visible_in_menu;
            $category->position = $request->position;
            $category->display_mode = $request->display_mode;
            $category->decription = $request->decription;
            $category->image = $request->image;
            $category->category_logo = $request->category_logo;
            $category->attributes = $request->attri;
            $category->meta_title = $request->meta_title;
            $category->slug = $request->slug;
            $category->meta_description = $request->meta_description;
            $category->meta_keyword = $request->meta_keyword;
            $category->status = $request->status;
            $category->save();
            $category_id = $category->where('name', $request->name)->first()->id;
            $category_product->category_id = $category_id;
            $category_product->save();


            return response()->json([
                'insert data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Edit Category
    public function edit($id, Request $request)
    {
        try {
            $credential = $request->only(['parent_category_id', 'name', 'visible_in_menu', 'position', 'display_mode', 'description', 'image', 'category_logo', 'attri', 'meta_title', 'slug', 'meta_description', 'meta_keyword', 'status']);
            // dd($id);
            Category::where('id', $id)
                ->update([
                    'parent_category_id' => $request->parent_category_id,
                    'name' => $request->name,
                    'visible_in_menu' => $request->visible_in_menu,
                    'position' => $request->position,
                    'display_mode' => $request->display_mode,
                    'decription' => $request->decription,
                    'image' => $request->image,
                    'category_logo' => $request->category_logo,
                    'attributes' => $request->attri,
                    'meta_title' => $request->meta_title,
                    'slug' => $request->slug,
                    'meta_description' => $request->meta_description,
                    'meta_keyword' => $request->meta_keyword,
                    'status' => $request->status,
                ]);
            return response()->json([
                'update message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Delete Category
    public function delete($id)
    {
        try {

            DB::table('category_product')
                ->where('category_id', $id)
                ->delete();

            Category::find($id)
                ->delete();

            return response()->json([
                'delete message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Search Category
    public function search(Request $request)
    {
        $query = $request->input('query');
        $data = Category::select('category.*', DB::raw('COUNT(category_product.category_id) as number_of_products'))
            ->join('category_product', 'category_product.category_id', '=', 'category.id')

            ->when(($query == null), function ($q) {
                return $q;
            })

            ->when(($query !== null), function ($q) use ($query) {
                return $q->where('category.id', $query)
                    ->orWhere('category.name', 'like', '%' . $query . '%')
                    ->orWhere('category.position', $query);
            })

            ->groupBy('category.id')
            // ->select('category.*', DB::raw('COUNT(category_product.category_id) as number_of_products'), "category.id as category_id")
            ->orderBy('category.id', 'desc')->paginate(10);
        return response()->json([
            'category' => $data,
        ]);
    }
    //Shoe Product Datas using ID
    public function show_data($id)
    {
        $category = Category::where('id', $id)->first();

        return response()->json([
            'show_data' => $category,
        ]);
    }
    //Show QR code data
    public function qrcode_data()
    {
        try {
            $all_product_data = Category::with('products')->get();
            $category_with_product = [];
            foreach ($all_product_data as $item) {
                $category_with_product[] = $item->toArray();
            }

            return response()->json([
                'qrcode_data' => $category_with_product
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
