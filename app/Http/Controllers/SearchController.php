<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        $data =
            $product = Product::join('category',)
            ->where('product_name', 'like', '%' . $query . '%')
            ->orWhere('price', 'like', '%' . $query . '%')
            ->select('product.*')
            ->orderBy('id')
            ->paginate(10);

        return response()->json([
            'Products' => $data,
        ]);
    }
}
