<?php

namespace App\Http\Controllers;
use App\InsuranceCategory;
use App\InsuranceSubCategory;
use App\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InsuranceSubCategoryController extends Controller
{
    public function index()
    {
        return view('insurance-sub-category.index');
    }

    public function anyData()
    {
        $inuranceSubCategory = InsuranceSubCategory::select(
            InsuranceSubCategory::$tablename . '.*',
            InsuranceCategory::$tablename . '.name as _category_id'
        );

        $inuranceSubCategory = InsuranceSubCategory::withCategory($inuranceSubCategory);
        $inuranceSubCategory = $inuranceSubCategory->orderBy(InsuranceSubCategory::$tablename . '.id', 'desc');

        return DataTables::of($inuranceSubCategory)
            ->addColumn('action', function ($subCategory) {
                $view = ' <a href="' . route('sub-category.show', $subCategory->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('sub-category.edit', $subCategory->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('sub-category.destroy', $subCategory->id);
                $delete = Utils::deleteBtn($delete_link);
                return $view . $edit . $delete;
            })
            ->filterColumn('_category_id', function ($query, $search) {
                $query->where('category_id', $search);
            })
            ->addColumn('_status', function ($subCategory) {
                $status = Utils::setStatus($subCategory->status);
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
        return view('insurance-sub-category.create');
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
            'name' => 'required|unique:insurance_category,name,NULL,id,is_trashed,NULL',
        ]);

        $user = InsuranceSubCategory::create([
            'name' => $request['name'],
            'category_id' => $request['category_id'],
            'status' => 1,
        ]);

        return redirect()->route('sub-category.index')
            ->with('success', 'Sub Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $insuranceSubCategory = InsuranceSubCategory::find($id);

        if (!empty($insuranceSubCategory)) {
            return view('insurance-sub-category.view', ['subCategory' => $insuranceSubCategory]);
        } else {
            return redirect()->route('sub-category.index')->with('fail', 'Sub Category does not exist.');
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
        $insuranceSubCategory = InsuranceSubCategory::find($id);
        $insuranceSubCategory = json_decode(json_encode($insuranceSubCategory), true);
        // echo "<pre>";print_r($insuranceSubCategory);exit;
        if (!empty($insuranceSubCategory)) {
            return view('insurance-sub-category.edit', ['subCategory' => $insuranceSubCategory]);
        } else {
            return redirect()->route('sub-category.index')->with('fail', 'Sub Category does not exist.');
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
            'name' => 'required|unique:' . InsuranceSubCategory::$tablename . ',name,' . $id . ',id,is_trashed,NULL',            
        ]);

        $insuranceSubCategory = InsuranceSubCategory::find($id);        
        $insuranceSubCategory->name = $request['name'];
        $insuranceSubCategory->category_id = $request['category_id'];
        $insuranceSubCategory->status = $request['status'];
        $insuranceSubCategory->save();

        return redirect()->route('sub-category.index')
            ->with('success', 'Sub Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $insuranceSubCategory = InsuranceSubCategory::find($id);
        $insuranceSubCategory = json_decode(json_encode($insuranceSubCategory), true);
        if (!empty($insuranceSubCategory)) {
            $insuranceSubCategory = InsuranceSubCategory::findOrFail($id);
            $insuranceSubCategory->delete();
            return redirect()->route('sub-category.index')->with('fail', 'Sub Category deleted successfully.');
        } else {
            return redirect()->route('sub-category.index')->with('fail', 'Sub Category does not exist.');
        }
    }
}
