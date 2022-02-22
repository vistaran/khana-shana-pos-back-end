<?php

namespace App\Http\Controllers;

use App\Category;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CategoryController extends Controller
{
    public function show()
    {
        try {
            $category = Category::join('category_product', 'category.id', '=', 'category_product.category_id')
                ->join('product', 'category_product.product_id', '=', 'product.id')
                ->select(
                    'category_product.category_id',
                    'category.name',
                    'category.visible_in_menu',
                    'category.position',
                    'category.display_mode',
                    'category.decription',
                    'category.image',
                    'category.category_logo',
                    'category.parent_category',
                    'category.attributes',
                    'category.meta_title',
                    'category.slug',
                    'category.meta_description',
                    'category.meta_keyword',
                    'category.status',
                    'category.created_at',
                    'category.updated_at',
                    'category_product.product_id',
                    'product.quantity',
                    'product.created_at',
                    'product.updated_at',

                )->orderBy('category_product.category_id')
                ->paginate(10);
            return response()->json([
                'category' => $category,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function edit($id, Request $request)
    {
        try {
            $credential = $request->only(['name', 'visible_in_menu', 'position', 'display_mode', 'description', 'image', 'category_logo', 'parent_category', 'attri', 'meta_title', 'slug', 'meta_description', 'meta_keyword', 'status']);
            Category::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'visible_in_menu' => $request->visible_in_menu,
                    'position' => $request->position,
                    'display_mode' => $request->display_mode,
                    'decription' => $request->decription,
                    'image' => $request->image,
                    'category_logo' => $request->category_logo,
                    'parent_category' => $request->parent_category,
                    'attributes' => $request->attri,
                    'meta_title' => $request->meta_title,
                    'slug' => $request->slug,
                    'meta_description' => $request->meta_description,
                    'meta_keyword' => $request->meta_keyword,
                    'status' => $request->status,
                ]);
            return response()->json([
                'Update Message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function add(Request $request)
    {
        
        try {
            $credential = $request->only([
                'name', 'visible_in_menu', 'position', 'display_mode', 'description', 'image', 'category_logo', 'parent_category', 'attri', 'meta_title', 'slug', 'meta_description', 'meta_keyword', 'status'
            ]);
            $category = new Category();

            $category->name = $request->name;
            $category->visible_in_menu  = $request->visible_in_menu;
            $category->position = $request->position;
            $category->display_mode  = $request->display_mode;
            $category->decription = $request->decription;
            $category->image  = $request->image;
            $category->category_logo = $request->category_logo;
            $category->parent_category = $request->parent_category;
            $category->attributes  = $request->attri;
            $category->meta_title = $request->meta_title;
            $category->slug = $request->slug;
            $category->meta_description = $request->meta_description;
            $category->meta_keyword = $request->meta_keyword;
            $category->status = $request->status;
            $category->save();
            return response()->json([
                'Insert Data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function delete($id)
    {
        try {
            Category::find($id)
                ->delete();
            return response()->json([
                'Delete Message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $data = Category::where('name', 'like', '%' . $query . '%')
            ->orWhere('id', $query)
            ->orWhere('position', $query)
            ->paginate(10);

        return response()->json([
            'Category' => $data,
        ]);
    }
}
