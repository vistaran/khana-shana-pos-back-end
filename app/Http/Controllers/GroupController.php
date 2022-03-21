<?php

namespace App\Http\Controllers;

use App\AttributeFamilyGroup;
use App\Group;
use Attribute;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    //Show Group Datas
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
    //Insert Group
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
    //Insert Attributes in Group
    public function insertAttribute(Request $request, $id)
    {
        try {
            // request
            $group_id = $request->input('group_id');
            $attribute_family_id = $request->input('attribute_family_id');

            // data load from database
            $attribute_family_group = new AttributeFamilyGroup();

            // fetch ids and data
            $flag_attribute = count($attribute_family_group->where('attribute_family_id', $attribute_family_id)->where('attribute_id', $id)->get());

            // dd($flag_attribute);
            if ($flag_attribute) {
                $attribute_family_group->where('attribute_id', $id)
                ->update([
                    'group_id' => $group_id,
                    'attribute_family_id' => $attribute_family_id,
                ]);
                $attribute_family_group->save();
            }

            // dd($flag_attribute);
            if (!$flag_attribute) {
                $attribute_family_group->attribute_family_id = $attribute_family_id;
                $attribute_family_group->group_id = $group_id;
                $attribute_family_group->attribute_id = $id;
                $attribute_family_group->save();
            }

            return response()->json([
                'insert data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Show Attribute which is in Group
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
    //Delete Group
    public function delete($id)
    {
        try {
            $group_based = Group::where('id', $id)->value('group_based');
            Group::when(($group_based == 'User'), function ($q) use ($id) {
                // dd();
                Attribute::where('group_id', $id)
                    ->update(['group_id' => null]);
                $q->find($id)->delete();
                return $q;
            });
            if ($group_based == 'User') {
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
    //Search Group
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
