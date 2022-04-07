<?php

namespace App\Http\Controllers;

use App\AttributeFamilyGroup;
use App\Group;
use Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    public function show()
    {
        try {
            $group = Group::select(
                'id',
                'group_name',
                'group_based',
                'created_at',
                'updated_at'
            )->orderBy('id')
                ->paginate(10);
            return response()->json([
                'groups' => $group,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function delete($id)
    {
        try {
            $flag = Group::where('id', $id)->value('group_based');
            Group::when(($flag == 'User'), function ($q) use ($id) {
                // dd();
                Attribute::where('group_id', $id)
                    ->update(['group_id' => null]);
                $q->find($id)->delete();
                return $q;
            });
            if ($flag == 'User') {
                return response()->json([
                    'delete message' => 'Successfully Deleted !',
                ]);
            } else {
                return response()->json([
                    'delete message' => 'System cannot be delete !',
                ]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function insert(Request $request, $id)
    {
        try {
            $credentials = $request->only([
                'group_name',
            ]);

            $group = new Group();
            $group->group_name = $request->group_name;
            $group->group_based = 'User';
            $group->save();

            $attribite_family_group = new AttributeFamilyGroup();
            $group_id = $group->where('group_name', $request->group_name)->first()->id;
            $attribite_family_group->group_id = $group_id;
            $attribite_family_group->attribute_family_id = $id;

            $attribite_family_group->save();

            return response()->json([
                'insert data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function insertAttribute(Request $request, $id)
    {
        try {
            // request
            $group_id = $request->input('group_id');
            $attribute_family_id = $request->input('attribute_family_id');

            // data load from database
            $family = new AttributeFamilyGroup();

            // fetch ids and data
            $flag_attribute = count($family->where('attribute_family_id', $attribute_family_id)->where('attribute_id', $id)->get());

            // dd($flag_attribute);
            if ($flag_attribute) {
                $family->where('attribute_id', $id)
                    ->update([
                        'group_id' => $group_id,
                        'attribute_family_id' => $attribute_family_id,
                    ]);
                $family->save();
            }

            // dd($flag_attribute);
            if (!$flag_attribute) {
                $family->attribute_family_id = $attribute_family_id;
                $family->group_id = $group_id;
                $family->attribute_id = $id;
                $family->save();
            }

            return response()->json([
                'insert data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    
    public function attribute_group_show()
    {
        try {

            // data load from database

            $attribute_family_group = AttributeFamilyGroup::join('attribute', 'attribute.id', '=', 'attribute_family_group.attribute_id')
                ->select(
                    'attribute_family_group.attribute_id',
                    'attribute_family_group.group_id',
                    'attribute_family_group.attribute_family_id',
                    'attribute.attribute_based',
                    'attribute.attribute_code',
                    'attribute.name',
                    'attribute.type',
                )
                ->orderBy('attribute_family_id', 'ASC')
                ->get();

            return response()->json([
                'insert data' => $attribute_family_group,
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
            Group::where('id', $query)
            ->orWhere('attribute_code', 'like', '%' . $query . '%')
            ->orWhere('name', 'like', '%' . $query . '%')
            ->orWhere('type', 'like', '%' . $query . '%')
            ->paginate(10);

        return response()->json([
            'groups' => $data,
        ]);
    }
}
