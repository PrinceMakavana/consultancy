<?php

namespace App\Http\Controllers;
use App\InsuranceCategory;
use App\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class InsuranceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('insurance-category.index');
    }

    public function anyData()
    {
        $inuranceCategory = InsuranceCategory::select(
            'id',
            'name',
            'status'
        );
        $inuranceCategory = $inuranceCategory->orderBy(InsuranceCategory::$tablename . '.id', 'desc');

        return DataTables::of($inuranceCategory)
            ->addColumn('action', function ($category) {
                $view = ' <a href="' . route('category.show', $category->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('category.edit', $category->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('category.destroy', $category->id);
                $delete = Utils::deleteBtn($delete_link);

                return $view . $edit . $delete;
            })
            ->addColumn('_status', function ($category) {
                $status = Utils::setStatus($category->status);
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
        return view('insurance-category.create');
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

        $user = InsuranceCategory::create([
            'name' => $request['name'],
            'status' => 1,
        ]);

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $insuranceCategory = InsuranceCategory::find($id);

        if (!empty($insuranceCategory)) {
            return view('insurance-category.view', ['category' => $insuranceCategory]);
        } else {
            return redirect()->route('category.index')->with('fail', 'Category does not exist.');
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
        $insuranceCategory = InsuranceCategory::find($id);
        $insuranceCategory = json_decode(json_encode($insuranceCategory), true);
        // echo "<pre>";print_r($insuranceCategory);exit;
        if (!empty($insuranceCategory)) {
            return view('insurance-category.edit', ['category' => $insuranceCategory]);
        } else {
            return redirect()->route('category.index')->with('fail', 'Category does not exist.');
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
            'name' => 'required|unique:' . InsuranceCategory::$tablename . ',name,' . $id . ',id,is_trashed,NULL',            
        ]);

        $insuranceCategory = InsuranceCategory::find($id);        
        $insuranceCategory->name = $request['name'];
        $insuranceCategory->status = $request['status'];
        $insuranceCategory->save();

        return redirect()->route('category.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $insuranceCategory = InsuranceCategory::find($id);
        $insuranceCategory = json_decode(json_encode($insuranceCategory), true);
        if (!empty($insuranceCategory)) {
            $insuranceCategory = InsuranceCategory::findOrFail($id);
            $insuranceCategory->delete();
            return redirect()->route('category.index')->with('fail', 'Category deleted successfully.');
        } else {
            return redirect()->route('category.index')->with('fail', 'Category does not exist.');
        }
    }
}
