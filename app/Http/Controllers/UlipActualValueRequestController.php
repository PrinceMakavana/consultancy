<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils;
use App\LifeInsuranceUlip;
use Illuminate\Http\Request;
use App\UlipActualValueRequest;
use App\Mail\ActualValueRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class UlipActualValueRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('life_insurance.ulip.request.index');
    }

    public function anyData()
    {

        $list = UlipActualValueRequest::select(
            UlipActualValueRequest::$tablename . '.id',
            User::$tablename . '.name as user_name',
            LifeInsuranceUlip::$tablename . '.plan_name',
            UlipActualValueRequest::$tablename . '.status',
            UlipActualValueRequest::$tablename . '.created_at'
        );

        $list = UlipActualValueRequest::joinToParent($list);
        // $list = UlipActualValueRequest::withUser($list);
        // $list = UlipActualValueRequest::withPolicy($list);
        $list = $list->orderBy(UlipActualValueRequest::$tablename . '.id', 'desc');
        return DataTables::of($list)
            ->addColumn('action', function ($model) {
                $view = ' <a href="' . route('life-insurance-ulip.actual-value-request.edit', $model->id) . '" class="btn btn-sm btn-success">Send Details</a>';
                return $view;
            })
            ->addColumn('created_at', function ($model) {
                return Utils::getFormatedDate($model->created_at);
            })
            ->filterColumn('user_name', function ($query, $search) {
                $query->where(User::$tablename . '.name', 'like', "%{$search}%");
            })
            ->filterColumn('life_ins_ulip', function ($query, $search) {
                $query->where(LIfeInsuranceUlip::$tablename . '.name', 'like', "%{$search}%");
            })
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = UlipActualValueRequest::findOrFail($id);

        $model->actual_units = Utils::numberFormatedValue(!empty($model->ulip->units) ? $model->ulip->units : 0);
        $model->actual_nav = Utils::numberFormatedValue(!empty($model->ulip->nav) ? $model->ulip->nav : 0);
        $model->actual_value = Utils::numberFormatedValue($model->actual_units * $model->actual_nav);
        return view('life_insurance.ulip.request.edit', ['model' => $model]);
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
        $model = UlipActualValueRequest::findOrFail($id);

        $this->validate($request, [
            'actual_value' => 'required',
            'actual_nav' => 'required',
            'actual_units' => 'required',
        ], [], UlipActualValueRequest::attributes());

        $model->status = 'done';
        $model->actual_units = $request['actual_units'];
        $model->actual_value = $request['actual_value'];
        $model->actual_nav = $request['actual_nav'];
        $model->save();


        // send mail
        if (!empty(env('SEND_MAIL'))) {
            Mail::to($model->client->email)->send(new ActualValueRequest($model));
            if (Mail::failures()) {
                return redirect()->route('life-insurance-ulip.actual-value-request.index')
                    ->with('fail', "Something went wrong");
            }
        }

        return redirect()->route('life-insurance-ulip.actual-value-request.index')
            ->with('success', UlipActualValueRequest::$responseMsg['send']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ulipRequest = UlipActualValueRequest::find($id);
        if (!empty($ulipRequest)) {
            $ulipRequest->status = 'cancelled';
            $ulipRequest->save();
            return redirect()->route('life-insurance-ulip.actual-value-request.index')->with('fail', UlipActualValueRequest::$responseMsg['cancelled']);
        } else {
            return redirect()->route('life-insurance-ulip.actual-value-request.index')->with('fail', UlipActualValueRequest::$responseMsg['notfound']);
        }
    }
}
