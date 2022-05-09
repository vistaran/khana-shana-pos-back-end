<?php

namespace App\Http\Controllers;

use App\ItemGroup as AppItemGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class ItemGroup extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $limit = request('limit');
            $query = request('query');
            $pitems = AppItemGroup::when(($query == null), function ($q) {
                return $q;
            })
                ->when(($query !== null), function ($q) use ($query) {
                    return $q->where('id', '=', $query)
                        ->orWhere('group_name', 'like', '%' . $query . '%');

                })
            ->select('item_groups.*');


            // default
            if (($limit == null)) {
                return $pitems->orderBy('id', 'desc')->paginate(10);
            }

            // for dynamic pagination
            if (($limit !== null && $limit <= 500)) {
                return $pitems->orderBy('id', 'desc')->paginate($limit);
            }

            if (($limit !== null && $limit > 500)) {
                return $pitems->orderBy('id', 'desc')->paginate(500);
            };

            return response()->json([
                'item_groups' => $pitems
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $vendor = new AppItemGroup();
            $vendor->group_name = $request->group_name;
            $vendor->save();
            return response()->json($vendor);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
         try {
            $vendor = AppItemGroup::where('id', $id)->first();
            return response()->json($vendor);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        try {
            AppItemGroup::where('id', $id)->update([
                'group_name' => $request->group_name
            ]);
            $vendor = AppItemGroup::where('id', $id)->first();
            return response()->json($vendor);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            AppItemGroup::find($id)->delete();
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
