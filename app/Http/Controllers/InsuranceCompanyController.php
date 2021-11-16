<?php

namespace App\Http\Controllers;
use App\InsuranceCompany;
use App\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class InsuranceCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('insurance-company.index');
    }

    public function anyData()
    {
        $insuranceCompanies = InsuranceCompany::select(
            'id',
            'name',
            'image',
            'created_at',
            'updated_at',
            'status'
        );
        $insuranceCompanies = $insuranceCompanies->orderBy(InsuranceCompany::$tablename . '.id', 'desc');
        
        return DataTables::of($insuranceCompanies)
            ->addColumn('action', function ($company) {
                $view = ' <a href="' . route('insurance-company.show', $company->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('insurance-company.edit', $company->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('insurance-company.destroy', $company->id);
                $delete = Utils::deleteBtn($delete_link);

                return $view . $edit . $delete;
            })
            ->addColumn('_image', function ($company) {
                $imageurl = InsuranceCompany::getCompanyImg($company->image);
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
        return view('insurance-company.create');
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
            'name' => 'required|unique:insurance_company,name,NULL,id,is_trashed,NULL',
        ]);

        $company = InsuranceCompany::create([
            'name' => $request['name'],
            'status' => 1,
        ]);
        InsuranceCompany::uploadImage($request, $company->id);
        return redirect()->route('insurance-company.index')
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
        $insuranceCompany = InsuranceCompany::find($id);

        if (!empty($insuranceCompany)) {
            return view('insurance-company.view', ['company' => $insuranceCompany]);
        } else {
            return redirect()->route('insurance-company.index')->with('fail', 'Company does not exist.');
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
        $insuranceCompany = InsuranceCompany::find($id);
        $insuranceCompany = json_decode(json_encode($insuranceCompany), true);
        // echo "<pre>";print_r($insuranceCompany);exit;
        if (!empty($insuranceCompany)) {
            return view('insurance-company.edit', ['company' => $insuranceCompany]);
        } else {
            return redirect()->route('insurance-company.index')->with('fail', 'Company does not exist.');
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
            'name' => 'required|unique:' . InsuranceCompany::$tablename . ',name,' . $id . ',id,is_trashed,NULL',
        ]);


        $insuranceCompany = InsuranceCompany::find($id);
        $insuranceCompany->name = $request['name'];
        $insuranceCompany->status = $request['status'];

        InsuranceCompany::uploadImage($request, $insuranceCompany->id);
        $insuranceCompany->save();

        return redirect()->route('insurance-company.index')
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
        
        $insuranceCompany = InsuranceCompany::find($id);
        $insuranceCompany = json_decode(json_encode($insuranceCompany), true);
        if (!empty($insuranceCompany)) {
            $insuranceCompany = InsuranceCompany::findOrFail($id);
            $insuranceCompany->delete();
            return redirect()->route('insurance-company.index')->with('fail', 'Company deleted successfully.');
        } else {
            return redirect()->route('insurance-company.index')->with('fail', 'Company does not exist.');
        }
    }
}
