<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MutualFund;
use App\MutualFundType;
use App\MutualFundCompany;
use App\MutualFundNavHist;
use App\Utils;
use Yajra\DataTables\Facades\DataTables;

class MutualFundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mutual-fund.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mutual-fund.create');
    }

    public function anyData()
    {
        $mfunds = MutualFund::select(
            MutualFund::$tablename. '.id',
            MutualFund::$tablename. '.name',
            MutualFund::$tablename. '.main_type',
            MutualFund::$tablename. '.company_id',
            // 'direct_or_regular',
            MutualFund::$tablename . '.type_id',
            // 'nav',
            // 'nav_updated_at',
            // 'min_sip_amount',
            // 'fund_size',
            // 'created_at',
            MutualFund::$tablename . '.status'
        );
        $mfunds = MutualFund::joinToParent($mfunds);
        $mfunds = $mfunds->orderBy(MutualFund::$tablename . '.id', 'desc');

        return DataTables::of($mfunds)
            ->addColumn('action', function ($funds) {
                $view = ' <a href="' . route('funds.show', $funds->id) . '" class="btn btn-xs btn-success">View</a>';
                $edit = ' <a href="' . route('funds.edit', $funds->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $delete_link = route('funds.destroy', $funds->id);
                $delete = Utils::deleteBtn($delete_link);
                $nav = ' <a href="' . route('funds.nav', $funds->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>NAV Edit</a>';

                return $view . $edit . $delete . $nav;
            })
            ->addColumn('_main_type', function ($funds) {
                $status = Utils::setMainTypes($funds->main_type);
                return $status;
            })
            ->addColumn('_company_id', function ($funds) {
                $company = MutualFund::getCompany($funds->company_id);
                return $company;
            })
            ->addColumn('_type_id', function ($funds) {
                $mftype = MutualFundType::getFundType($funds->type_id);
                return $mftype;
            })
            // ->addColumn('_direct_or_regular', function ($funds) {
            //     $dirReg = Utils::setDirectOrRegular($funds->direct_or_regular);
            //     return $dirReg;
            // })
            ->addColumn('_status', function ($funds) {
                $status = Utils::setStatus($funds->status);
                return $status;
            })
            ->filterColumn('_status', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.status', $search);
            })
            ->filterColumn('_type_id', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.type_id', $search);
            })
            ->filterColumn('_main_type', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.main_type', $search);
            })
            ->filterColumn('name', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.name', $search);
            })
            ->filterColumn('_company_id', function ($query, $search) {
                $query->where(MutualFund::$tablename . '.company_id', $search);
            })
            ->make(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company_ids = MutualFundCompany::all();
        $company_ids = json_decode(json_encode($company_ids), true);
        $company_ids = array_combine(array_column($company_ids, 'id'), array_column($company_ids, 'name'));
        $direct_or_regulars = Utils::getDirectOrRegular();
        $main_types = Utils::getMainTypes();
        $type_ids = MutualFundType::all();
        $type_ids = json_decode(json_encode($type_ids), true);
        $type_ids = array_combine(array_column($type_ids, 'id'), array_column($type_ids, 'name'));

        // echo "<pre>";print_r($type_ids);exit;
        $request->validate([
            'name' => 'required|unique:mutual_fund,name,NULL,id,is_trashed,NULL',
            'company_id' => 'required|max:255|in:' . implode(',', array_keys($company_ids)),
            'direct_or_regular' => 'required|max:255|in:' . implode(',', array_keys($direct_or_regulars)),
            'main_type' => 'required|max:255|in:' . implode(',', array_keys($main_types)),
            'type_id' => 'required|max:255|in:' . implode(',', array_keys($type_ids)),
        ]);

        $funds = MutualFund::create([
            'name' => $request['name'],
            'company_id' => $request['company_id'],
            'direct_or_regular' => $request['direct_or_regular'],
            'main_type' => $request['main_type'],
            'type_id' => $request['type_id'],
            'nav' => $request['nav'],
            // 'nav_updated_at' => $request['nav_updated_at'],
            'min_sip_amount' => $request['min_sip_amount'],
            // 'fund_size' => $request['fund_size'],
            'status' => 1,
        ]);

        return redirect()->route('funds.show', $funds->id)
            ->with('success', 'Fund created successfully.');
    }

    public function nav($id)

    {
        $mfunds = MutualFund::find($id);
        $mfunds = json_decode(json_encode($mfunds), true);
        // echo "<pre>";print_r($mfunds);exit;
        if (!empty($mfunds)) {
            return view('mutual-fund.nav_edit', ['funds' => $mfunds]);
        } else {
            return redirect()->route('funds.index')->with('fail', 'Fund does not exist.');
        }
    }

    public function nav_update(Request $request, $id)

    {
        // echo "<pre>";print_r($type_ids);exit;
        $request->validate([
            'nav' => 'required'
        ]);


        $mfunds = MutualFund::find($id);
        $mfunds->nav = $request['nav'];
        $mfunds->save();


        $hist = new  MutualFundNavHist;
        $hist->nav = $request['nav'];
        $hist->mutual_fund_id = $request->id;
        $hist->save();

        return redirect()->route('funds.show', $id)
            ->with('success', 'Fund updated successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mfunds = MutualFund::find($id);

        if (!empty($mfunds)) {
            return view('mutual-fund.view', ['funds' => $mfunds]);
        } else {
            return redirect()->route('funds.index')->with('fail', 'Fund does not exist.');
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
        $mfunds = MutualFund::find($id);
        $mfunds = json_decode(json_encode($mfunds), true);
        // echo "<pre>";print_r($mfunds);exit;
        if (!empty($mfunds)) {
            return view('mutual-fund.edit', ['funds' => $mfunds]);
        } else {
            return redirect()->route('funds.index')->with('fail', 'Fund does not exist.');
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
        $company_ids = MutualFundCompany::all();
        $company_ids = json_decode(json_encode($company_ids), true);
        $company_ids = array_combine(array_column($company_ids, 'id'), array_column($company_ids, 'name'));
        $direct_or_regulars = Utils::getDirectOrRegular();
        $main_types = Utils::getMainTypes();
        $type_ids = MutualFundType::all();
        $type_ids = json_decode(json_encode($type_ids), true);
        $type_ids = array_combine(array_column($type_ids, 'id'), array_column($type_ids, 'name'));

        // echo "<pre>";print_r($type_ids);exit;
        $request->validate([
            'name' => 'required|unique:' . MutualFund::$tablename . ',name,' . $id . ',id,is_trashed,NULL',
            'company_id' => 'required|max:255|in:' . implode(',', array_keys($company_ids)),
            'direct_or_regular' => 'required|max:255|in:' . implode(',', array_keys($direct_or_regulars)),
            'main_type' => 'required|max:255|in:' . implode(',', array_keys($main_types)),
            'type_id' => 'required|max:255|in:' . implode(',', array_keys($type_ids)),
        ]);


        $mfunds = MutualFund::find($id);
        $mfunds->name = $request['name'];
        $mfunds->company_id = $request['company_id'];
        $mfunds->direct_or_regular = $request['direct_or_regular'];
        $mfunds->main_type = $request['main_type'];
        $mfunds->type_id = $request['type_id'];
        $mfunds->nav = $request['nav'];
        $mfunds->nav_updated_at = $request['nav_updated_at'];
        $mfunds->min_sip_amount = $request['min_sip_amount'];
        $mfunds->fund_size = $request['fund_size'];
        $mfunds->status = $request['status'];
        $mfunds->save();

        return redirect()->route('funds.show', $mfunds->id)
            ->with('success', 'Fund updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mfunds = MutualFund::find($id);
        $mfunds = json_decode(json_encode($mfunds), true);
        if (!empty($mfunds)) {
            $mfunds = MutualFund::findOrFail($id);
            $mfunds->delete();
            return redirect()->route('funds.index')->with('fail', 'Fund deleted successfully.');
        } else {
            return redirect()->route('funds.index')->with('fail', 'Fund does not exist.');
        }
    }

    //api
    public function getFundsByCompany(Request $request)
    {
        $funds = MutualFund::getMutualFundsByCompany($request->company_id);
        // echo "<pre>";print_r($funds);exit;
        if (!empty($funds)) {
            $response['funds'] = $funds;
            $response['message'] = '';
            $response['result'] = 'success';
            return Utils::create_response(true, $response);
        } else {
            $response['message'] = 'No data.';
            $response['result'] = 'fail';
            return Utils::create_response(true, $response);
        }
    }
}
