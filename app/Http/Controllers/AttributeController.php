<?php

namespace App\Http\Controllers;

use App\Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttributeController extends Controller
{
    public function show()
    {
        try {
            $attribute = Attribute::select(
                'id',
                'group_id',
                'attribute_based',
                'attribute_code',
                'name',
                'type',
                'validation_required',
                'validation_unique',
                'input_validation',
                'value_per_local',
                'value_per_channel',
                'use_in_layered',
                'use_to_create_configuration_product',
                'visible_on_productview_page_front_end',
                'create_in_product_flat_table',
                'attribute_comparable',
                'created_at',
                'updated_at'
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
    public function insert(Request $request)
    {
        try {
            $user = "User";
            $credentials = $request->only([
                'attribute_code',
                'name',
                'type',
                'validation_required',
                'validation_unique',
                'input_validation',
                'value_per_local',
                'value_per_channel',
                'use_in_layered',
                'use_to_create_configuration_product',
                'visible_on_productview_page_front_end',
                'create_in_product_flat_table',
                'attribute_comparable',
            ]);
            $att = new Attribute();
            $att->attribute_code = $request->attribute_code;
            $att->type = $request->type;
            $att->name = $request->name;
            $att->attribute_based = $user;
            $att->validation_required = $request->validation_required;
            $att->validation_unique = $request->validation_unique;
            $att->input_validation = $request->input_validation;
            $att->value_per_local = $request->value_per_local;
            $att->value_per_channel = $request->value_per_channel;
            $att->use_in_layered = $request->use_in_layered;
            $att->use_to_create_configuration_product = $request->use_to_create_configuration_product;
            $att->visible_on_productview_page_front_end = $request->visible_on_productview_page_front_end;
            $att->create_in_product_flat_table = $request->create_in_product_flat_table;
            $att->attribute_comparable = $request->attribute_comparable;

            $att->save();
            return response()->json([
                'Insert Data' => 'Successfully Inserted !',
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
                'attribute_code',
                'name',
                'type',
                'validation_required',
                'validation_unique',
                'input_validation',
                'value_per_local',
                'value_per_channel',
                'use_in_layered',
                'use_to_create_configuration_product',
                'visible_on_productview_page_front_end',
                'create_in_product_flat_table',
                'attribute_comparable',
            ]);
            $outlet = Attribute::where('id', $id)
                ->update([
                    'attribute_code' => $request->attribute_code,
                    'type' => $request->type,
                    'name' => $request->name,
                    'validation_required' => $request->validation_required,
                    'validation_unique' => $request->validation_unique,
                    'input_validation' => $request->input_validation,
                    'value_per_local' => $request->value_per_local,
                    'value_per_channel' => $request->value_per_channel,
                    'use_in_layered' => $request->use_in_layered,
                    'use_to_create_configuration_product' => $request->use_to_create_configuration_product,
                    'visible_on_productview_page_front_end' => $request->visible_on_productview_page_front_end,
                    'create_in_product_flat_table' => $request->create_in_product_flat_table,
                    'attribute_comparable' => $request->attribute_comparable,
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
            Attribute::find($id)
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
        $data =
            Attribute::where('id', $query)
            ->orWhere('attribute_code', 'like', '%' . $query . '%')
            ->orWhere('name', 'like', '%' . $query . '%')
            ->orWhere('type', 'like', '%' . $query . '%')
            ->paginate(10);

        return response()->json([
            'Attributes' => $data,
        ]);
    }
    public function show_data($id)
    {
        $attr = Attribute::where('id', $id)->first();

        return response()->json([
            'Show_Data' => $attr,
        ]);
    }
}