<?php

namespace App\Http\Controllers;

use App\InsuranceField;
use App\InsuranceFieldDetail;
use App\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InsuranceFieldDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('insurance-field-detail.index');
    }

    public function anyData()
    {
        $inuranceField = InsuranceFieldDetail::select(
            'id',
            'insurance_field_id',
            'fieldname',
            'description',
            'status'
        );
        $inuranceField = $inuranceField->orderBy(InsuranceFieldDetail::$tablename . '.id', 'desc');

        return DataTables::of($inuranceField)
            ->addColumn('action', function ($field) {
                $view = ' <a href="' . route('field-detail.show', $field->id) . '" class="btn btn-sm btn-success">View</a>';
                $edit = ' <a href="' . route('field-detail.edit', $field->id) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('field-detail.destroy', $field->id);
                $delete = Utils::deleteBtn($delete_link);

                return $view . $edit . $delete;
            })
            ->addColumn('_insurance_field_id', function ($field) {
                $status = InsuranceField::getInsuranceField($field->insurance_field_id);
                return $status;
            })
            ->filterColumn('_insurance_field_id', function ($query, $search) {
                $query->where('insurance_field_id', $search);
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
    public function fieldData(Request $request)
    {
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
        $inuranceField = $inuranceField->where('insurance_field_id', $request->field_id)->orderBy(InsuranceFieldDetail::$tablename . '.id', 'desc');

        return DataTables::of($inuranceField)
            ->addColumn('action', function ($field) use ($request) {
                $edit = ' <a href="' . route('field.field-detail.edit', ['field' => $request->field_id, 'field_detail' => $field->id]) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('field.field-detail.destroy', ['field' => $request->field_id, 'field_detail' => $field->id]);
                $delete = Utils::deleteBtn($delete_link);

                return $edit . $delete;
            })
            ->filterColumn('insurance_field_id', function ($query, $field_id) {
                $query->where('insurance_field_id', $field_id);
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
    public function create($field)
    {
        $field = InsuranceField::findOrFail($field);
        return view('insurance-field-detail.create', ['field' => $field]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $field)
    {
        $field = InsuranceField::findOrFail($field);
        $request->validate([
            'fieldname' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'is_required' => 'nullable',
            'options' => 'required_if:type,select,yes_no',
            'status' => 'required',
        ]);

        $user = InsuranceFieldDetail::create([
            'insurance_field_id' => $field->id,
            'fieldname' => $request['fieldname'],
            'description' => $request['description'],
            'type' => $request['type'],
            'is_required' => !empty($request['is_required']) ? $request['is_required'] : null,
            'options' => $request['options'],
            'status' => $request['status'],
        ]);

        return redirect()->route('field.view', ['id' => $field->id])
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
        $insuranceFieldDetail = InsuranceFieldDetail::find($id);

        if (!empty($insuranceFieldDetail)) {
            return view('insurance-field-detail.view', ['fieldDetail' => $insuranceFieldDetail]);
        } else {
            return redirect()->route('field-detail.index')->with('fail', 'Field does not exist.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($field, $id)
    {
        $field = InsuranceField::findOrFail($field);
        $insuranceFieldDetail = InsuranceFieldDetail::find($id);
        $insuranceFieldDetail = json_decode(json_encode($insuranceFieldDetail), true);
        if (!empty($insuranceFieldDetail)) {
            return view('insurance-field-detail.edit', ['fieldDetail' => $insuranceFieldDetail, 'field' => $field]);
        } else {
            return redirect()->route('field-detail.index')->with('fail', 'Field does not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $field, $id)
    {
        $field = InsuranceField::findOrFail($field);
        $request->validate([
            'fieldname' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'is_required' => 'nullable',
            'options' => 'required_if:type,select,yes_no',
            'status' => 'required',
        ]);


        $insuranceFieldDetail = InsuranceFieldDetail::find($id);
        $insuranceFieldDetail->insurance_field_id = $field->id;
        $insuranceFieldDetail->fieldname = $request['fieldname'];
        $insuranceFieldDetail->description = $request['description'];
        $insuranceFieldDetail->type = $request['type'];
        $insuranceFieldDetail->is_required = !empty($request['is_required']) ? $request['is_required'] : null;
        $insuranceFieldDetail->options = $request['options'];
        $insuranceFieldDetail->status = $request['status'];
        $insuranceFieldDetail->save();

        return redirect()->route('field.view', ['id' => $insuranceFieldDetail->insurance_field_id])
            ->with('success', 'Field updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($field, $id)
    {
        $insuranceFieldDetail = InsuranceFieldDetail::findOrFail($id);
        if (!empty($insuranceFieldDetail)) {
            $insuranceFieldDetail->delete();
            return redirect()->route('field.view', ['id' => $field])
                ->with('fail', 'Field deleted successfully.');
        } else {
            return redirect()->route('field-detail.index')->with('fail', 'Field does not exist.');
        }
    }
}
