<?php

namespace App\Http\Controllers;

use App\Utils;
use App\InsuranceField;
use Illuminate\Http\Request;
use App\InsuranceFieldDetail;
use Yajra\DataTables\Facades\DataTables;

class InsuranceFieldController extends Controller
{
    public function index()
    {
        return view('insurance-field.index');
    }

    public function anyData()
    {
        $inuranceField = InsuranceField::select(
            'id',
            'name',
            'status'
        );
        $inuranceField = $inuranceField->orderBy(InsuranceField::$tablename . '.id', 'desc');

        return DataTables::of($inuranceField)
            ->addColumn('action', function ($field) {
                $view = ' <a href="' . route('field.show', $field->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('field.edit', $field->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('field.destroy', $field->id);
                $delete = Utils::deleteBtn($delete_link);

                return $view . $edit . $delete;
            })
            ->addColumn('_status', function ($field) {
                $status = Utils::setStatus($field->status);
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
        return view('insurance-field.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = Utils::getStatus();
        $has_multiple_benefits = InsuranceField::optionForHasMultipleBenefits();
        $request->validate([
            'name' => 'required|unique:insurance_fields,name,NULL,id,is_trashed,NULL',
            'benefit_name' => 'required',
            'status' => 'required|in:' . implode(',', array_keys($status)),
            'image' => 'required|image',
            'has_multiple_benefits' => 'required|in:' . implode(',', array_keys($has_multiple_benefits)),
        ]);

        $user = InsuranceField::create([
            'benefit_name' => $request['benefit_name'],
            'name' => $request['name'],
            'has_multiple_benefits' => $request['has_multiple_benefits'],
            'status' => $request['status']
        ]);

        InsuranceField::uploadInsuranceFieldImage($request, $user->id);

        return redirect()->route('field.show', $user->id)
            ->with('success', 'Field created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $insuranceField = InsuranceField::findOrFail($id);

        // Get Insurance Fields
        $inuranceField = InsuranceFieldDetail::select(
            'id',
            'insurance_field_id',
            'is_required',
            'options',
            'type',
            'fieldname',
            'description',
            'status'
        );
        $inuranceField = $inuranceField->where('insurance_field_id', $id)->orderBy(InsuranceFieldDetail::$tablename . '.id', 'desc')->get();
        
        if (!empty($insuranceField)) {
            return view('insurance-field.view', ['field' => $insuranceField, 'field_details' => $inuranceField]);
        } else {
            return redirect()->route('field.index')->with('fail', 'Field does not exist.');
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
        $insuranceField = InsuranceField::find($id);
        $insuranceField = json_decode(json_encode($insuranceField), true);
        // echo "<pre>";print_r($insuranceField);exit;
        if (!empty($insuranceField)) {
            return view('insurance-field.edit', ['field' => $insuranceField]);
        } else {
            return redirect()->route('field.index')->with('fail', 'Field does not exist.');
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
        $status = Utils::getStatus();
        $has_multiple_benefits = InsuranceField::optionForHasMultipleBenefits();
        $request->validate([
            'name' => 'required|unique:' . InsuranceField::$tablename . ',name,' . $id . ',id,is_trashed,NULL',
            'benefit_name' => 'required',
            'status' => 'required|in:' . implode(',', array_keys($status)),
            'image' => 'nullable|image',
            'has_multiple_benefits' => 'required|in:' . implode(',', array_keys($has_multiple_benefits)),
        ]);

        $insuranceField = InsuranceField::find($id);
        $insuranceField->benefit_name = $request['benefit_name'];
        $insuranceField->name = $request['name'];
        $insuranceField->status = $request['status'];
        $insuranceField->has_multiple_benefits = $request['has_multiple_benefits'];
        $insuranceField->save();

        InsuranceField::uploadInsuranceFieldImage($request, $id);

        return redirect()->route('field.show', $insuranceField->id)
            ->with('success', 'Field updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $insuranceField = InsuranceField::findOrFail($id);
        if (!empty($insuranceField)) {
            $insuranceField->delete();
            return redirect()->route('field.index')->with('fail', 'Field deleted successfully.');
        } else {
            return redirect()->route('field.index')->with('fail', 'Field does not exist.');
        }
    }
}
