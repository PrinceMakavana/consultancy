<?php

namespace App\Http\Controllers;
use App\MutualFundType;
use Illuminate\Http\Request;

class MutualFundTypeController extends Controller
{
    public function index()
    {
        return view('mutual-fund-type.index');
    }

    public function anyData()
    {
        $MutualFundType = MutualFundType::all();
        $MutualFundType = $MutualFundType->orderBy(MutualFundType::$tablename . '.id', 'desc');

        return DataTables::of($MutualFundType)
            ->addColumn('action', function ($MutualFundType) {
                $view = ' <a href="' . route('type.show', $MutualFundType->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('type.edit', $MutualFundType->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('type.destroy', $MutualFundType->id);
                $delete = Utils::deleteBtn($delete_link);
                
                return $view . $edit . $delete;
            })
            ->addColumn('_status', function ($MutualFundType) {
                $status = Utils::setStatus($MutualFundType->status);
                return $status;
            })
            ->filterColumn('_status', function ($query, $search) {
                $query->where('status', $search);
            })
            ->make(true);
    }
}
