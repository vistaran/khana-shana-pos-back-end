<?php

namespace App\Http\Controllers;

use App\AttributeFamily;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AttributeFamilyController extends Controller
{
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
                'Attributes' => $attribute,

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
                'attribute_family_code',
                'attribute_family_name',
            ]);
            $outlet = AttributeFamily::where('id', $id)
                ->update([
                    'attribute_family_code' => $request->attribute_family_code,
                    'attribute_family_name' => $request->attribute_family_name,
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
            AttributeFamily::find($id)
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
                'attribute_family_code',
                'attribute_family_name',
            ]);
            $attf = new AttributeFamily();
            $attf->attribute_family_code = $request->attribute_family_code;
            $attf->attribute_family_name = $request->attribute_family_name;

            $attf->save();
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
            AttributeFamily::where('id', $query)
            ->orWhere('attribute_family_code', 'like', '%' . $query . '%')
            ->orWhere('attribute_family_name', 'like', '%' . $query . '%')
            ->paginate(10);

        return response()->json([
            'Attributes_Family' => $data,
        ]);
    }
}
