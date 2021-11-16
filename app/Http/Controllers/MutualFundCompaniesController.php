<?php

namespace App\Http\Controllers;

use App\MutualFundCompany;
use App\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MutualFundCompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mutual-fund-company.index');
    }

    public function anyData()
    {
        $mfcompanies = MutualFundCompany::select(
            'id',
            'name',
            'image',
            'created_at',
            'status'
        );
        $mfcompanies = $mfcompanies->orderBy(MutualFundCompany::$tablename . '.id', 'desc');

        return DataTables::of($mfcompanies)
            ->addColumn('action', function ($company) {
                $view = ' <a href="' . route('company.show', $company->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('company.edit', $company->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('company.destroy', $company->id);
                $delete = Utils::deleteBtn($delete_link);

                return $view . $edit . $delete;
            })
            ->addColumn('_image', function ($company) {
                $imageurl = MutualFundCompany::getCompanyImg($company->image);
                // $image = ' <img src="'. $imageurl .'" style="width: 200px"> ';
                return $imageurl;
            })
            ->addColumn('_status', function ($company) {
                $status = Utils::setStatus($company->status);
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
        return view('mutual-fund-company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:mutual_fund_company,name,NULL,id,is_trashed,NULL',
        ]);

        $company = MutualFundCompany::create([
            'name' => $request['name'],
            'status' => 1,
        ]);
        MutualFundCompany::uploadImage($request, $company->id);
        return redirect()->route('company.show', $company->id)
            ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mfcompany = MutualFundCompany::find($id);

        if (!empty($mfcompany)) {
            return view('mutual-fund-company.view', ['company' => $mfcompany]);
        } else {
            return redirect()->route('company.index')->with('fail', 'Company does not exist.');
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
        $mfcompany = MutualFundCompany::find($id);
        $mfcompany = json_decode(json_encode($mfcompany), true);
        // echo "<pre>";print_r($mfcompany);exit;
        if (!empty($mfcompany)) {
            return view('mutual-fund-company.edit', ['company' => $mfcompany]);
        } else {
            return redirect()->route('company.index')->with('fail', 'Company does not exist.');
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
        $request->validate([
            'name' => 'required|unique:' . MutualFundCompany::$tablename . ',name,' . $id . ',id,is_trashed,NULL',
        ]);


        $mfcompany = MutualFundCompany::find($id);
        $mfcompany->name = $request['name'];
        $mfcompany->status = $request['status'];

        MutualFundCompany::uploadImage($request, $mfcompany->id);
        $mfcompany->save();

        return redirect()->route('company.show', $mfcompany->id)
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mfcompany = MutualFundCompany::find($id);
        $mfcompany = json_decode(json_encode($mfcompany), true);
        if (!empty($mfcompany)) {
            $mfcompany = MutualFundCompany::findOrFail($id);
            $mfcompany->delete();
            return redirect()->route('company.index')->with('fail', 'Company deleted successfully.');
        } else {
            return redirect()->route('company.index')->with('fail', 'Company does not exist.');
        }
    }
}
