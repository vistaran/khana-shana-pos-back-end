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
    // Show Attribute Data
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
                'attributes' => $attribute,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    //Insert Attributes
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
            $attribute_family_group = new AttributeFamilyGroup();
            $attribute_id = $attribute->where('attribute_code', $request->attribute_code)->first()->id;
            // dd($attribute_id);
            $attribute_family_group->attribute_id = $attribute_id;
            $attribute_family_group->save();
            return response()->json([
                'insert data' => 'successfully inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    //Edit Attributes
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
            Attribute::where('id', $id)
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
                'update message' => 'successfully updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    //Delete Attributes
    public function delete($id)
    {
        try {
            Attribute::find($id)
                ->delete();
            AttributeFamilyGroup::where('attribute_id', $id)
                ->delete();
            return response()->json([
                'delete message' => 'successfully deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    //Search Attributes
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
            'attributes' => $data,
        ]);
    }

    //Show Attributes Data using ID
    public function show_data($id)
    {
        $attribute = Attribute::where('id', $id)->first();

        return response()->json([
            'show_data' => $attribute,
        ]);
    }

    // public function group_id()
    // {

    //     $group_name_input = $request->input('group_name');
    //     $group_name = Group::where('group_name', $group_name_input)->first()->id;
    //     $attribute_group_id = $group_name->where('group_id', $group_id)->first()->id;
    //     $group = Group::where('id', $id)->first()->id;
    //     $group_id = AttributeFamilyGroup::where('attribute_id', $id)->where('group_id', $attribute_group_id)->first()->get();

    //     // dd($group);
    //     return response()->json([
    //         'group_id' => $group_id,
    //     ]);
    // }
}
