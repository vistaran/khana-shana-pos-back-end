<?php

namespace App\Http\Controllers;

use App\Customers;
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
    public function searchOrder()
    {
        $query = request('query');

        $data = Customers::where('phone_number', $query)
            ->orWhere('first_name', 'like', $query . '%')
            ->orWhere('last_name', 'like', $query . '%')
            ->paginate(10);

        return response()->json([
            'customers' => $data,
        ]);
    }
}
