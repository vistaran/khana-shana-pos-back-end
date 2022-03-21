<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeFamilyGroup;
use App\Group;
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
                // 'group_id',
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
            $attribute = new Attribute();

            $attribute->attribute_code = $request->attribute_code;
            $attribute->type = $request->type;
            $attribute->name = $request->name;
            $attribute->attribute_based = $user;
            $attribute->validation_required = $request->validation_required;
            $attribute->validation_unique = $request->validation_unique;
            $attribute->input_validation = $request->input_validation;
            $attribute->value_per_local = $request->value_per_local;
            $attribute->value_per_channel = $request->value_per_channel;
            $attribute->use_in_layered = $request->use_in_layered;
            $attribute->use_to_create_configuration_product = $request->use_to_create_configuration_product;
            $attribute->visible_on_productview_page_front_end = $request->visible_on_productview_page_front_end;
            $attribute->create_in_product_flat_table = $request->create_in_product_flat_table;
            $attribute->attribute_comparable = $request->attribute_comparable;

            $attribute->save();
            $attribute_family = new AttributeFamilyGroup();
            $attribute_id = $attribute->where('attribute_code', $request->attribute_code)->first()->id;
            // dd($attribute_id);
            $attribute_family->attribute_id = $attribute_id;
            $attribute_family->save();
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
            AttributeFamilyGroup::where('attribute_id', $id)
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

    public function group_id()
    {

        $group_name_input = $request->input('group_name');
        $group_name = Group::where('group_name', $group_name_input)->first()->id;
        $att_group_id = $group_name->where('group_id', $group_id)->first()->id;
        $group = Group::where('id', $id)->first()->id;
        $group_id = AttributeFamilyGroup::where('attribute_id', $id)->where('group_id', $att_group_id)->first()->get();

        dd($group);
        return response()->json([
            'group_id' => $group_id,
        ]);

    }
}
