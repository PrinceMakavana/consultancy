<?php

namespace App\Http\Controllers;

use App\MutualFundType;
use App\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MutualFundTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mutual-fund-type.index');
    }

    public function anyData()
    {
        $mftypes = MutualFundType::select(
            'id',
            'main_type',
            'name',
            'status'
        );
        $mftypes = $mftypes->orderBy(MutualFundType::$tablename . '.id', 'desc');

        return DataTables::of($mftypes)
            ->addColumn('action', function ($type) {
                $view = ' <a href="' . route('type.show', $type->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('type.edit', $type->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('type.destroy', $type->id);
                $delete = Utils::deleteBtn($delete_link);

                return $view . $edit . $delete;
            })
            ->addColumn('_main_type', function ($type) {
                $status = Utils::setMainTypes($type->main_type);
                return $status;
            })
            ->addColumn('_status', function ($type) {
                $status = Utils::setStatus($type->status);
                return $status;
            })
            ->filterColumn('_status', function ($query, $search) {
                $query->where('status', $search);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mutual-fund-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fundTypes = Utils::getMainTypes();
        $request->validate([
            'name' => 'required|unique:mutual_fund_type,name,NULL,id,is_trashed,NULL',
            'main_type' => 'required|max:255|in:' . implode(',', array_keys($fundTypes)),
        ]);

        $user = MutualFundType::create([
            'name' => $request['name'],
            'main_type' => $request['main_type'],
            'description' => $request['description'],
            'status' => 1,
        ]);

        return redirect()->route('type.show', $user->id)
            ->with('success', 'Type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mftype = MutualFundType::find($id);

        if (!empty($mftype)) {
            return view('mutual-fund-type.view', ['type' => $mftype]);
        } else {
            return redirect()->route('type.index')->with('fail', 'Type does not exist.');
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
        $mftype = MutualFundType::find($id);
        $mftype = json_decode(json_encode($mftype), true);
        // echo "<pre>";print_r($mftype);exit;
        if (!empty($mftype)) {
            return view('mutual-fund-type.edit', ['type' => $mftype]);
        } else {
            return redirect()->route('type.index')->with('fail', 'Type does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fundTypes = Utils::getMainTypes();
        $request->validate([
            'name' => 'required|unique:' . MutualFundType::$tablename . ',name,' . $id . ',id,is_trashed,NULL',
            'main_type' => 'required|max:255|in:' . implode(',', array_keys($fundTypes)),
        ]);

        $mftype = MutualFundType::find($id);
        $mftype->main_type = $request['main_type'];
        $mftype->name = $request['name'];
        $mftype->description = $request['description'];
        $mftype->status = $request['status'];
        $mftype->save();

        return redirect()->route('type.show', $mftype->id)
            ->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mftype = MutualFundType::find($id);
        $mftype = json_decode(json_encode($mftype), true);
        if (!empty($mftype)) {
            $mftype = MutualFundType::findOrFail($id);
            $mftype->delete();
            return redirect()->route('type.index')->with('fail', 'Type deleted successfully.');
        } else {
            return redirect()->route('type.index')->with('fail', 'Type does not exist.');
        }
    }
}
