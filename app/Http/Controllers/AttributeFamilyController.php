<?php

namespace App\Http\Controllers;

use App\AttributeFamily;
use App\AttributeFamilyGroup;
use Attribute;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AttributeFamilyController extends Controller
{

    //Show AttributeFamily Data
    public function show()
    {
        try {
            $attribute = AttributeFamily::select(
                'id',
                'attribute_family_code',
                'attribute_family_name',
                'created_at',
                'updated_at',
            )->orderBy('id')
                ->paginate(10);
            return response()->json([
                'attributes' => $attribute,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Insert AttributeFamily
    public function insert(Request $request)
    {
        try {
            $credentials = $request->only([
                'attribute_family_code',
                'attribute_family_name',
            ]);
            $attribute_family = new AttributeFamily();
            $attribute_family->attribute_family_code = $request->attribute_family_code;
            $attribute_family->attribute_family_name = $request->attribute_family_name;

            $attribute_family->save();
            return response()->json([
                'insert data' => 'successfully inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    // Edit AttributeFamily
    public function edit($id, Request $request)
    {

        try {
            $credential = $request->only([
                'attribute_family_code',
                'attribute_family_name',
            ]);
            AttributeFamily::where('id', $id)
                ->update([
                    'attribute_family_code' => $request->attribute_family_code,
                    'attribute_family_name' => $request->attribute_family_name,
                ]);
            return response()->json([
                'update message' => 'successfully updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Delete AtrributeFamily
    public function delete($id)
    {
        try {
            AttributeFamily::find($id)
                ->delete();
            AttributeFamilyGroup::where('attribute_family_id', $id)
                ->delete();
            return response()->json([
                'delete message' => 'successfully deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Search AttributeFamily Datas
    public function search(Request $request)
    {
        $query = $request->input('query');
        $data =
            AttributeFamily::where('id', $query)
            ->orWhere('attribute_family_code', 'like', '%' . $query . '%')
            ->orWhere('attribute_family_name', 'like', '%' . $query . '%')
            ->paginate(10);

        return response()->json([
            'attributes_family' => $data,
        ]);
    }
    //Show AttributeFamily Datas using ID
    public function show_data($id)
    {
        $attribute_family = AttributeFamily::where('id', $id)->first();

        return response()->json([
            'show_data' => $attribute_family,
        ]);
    }
}
