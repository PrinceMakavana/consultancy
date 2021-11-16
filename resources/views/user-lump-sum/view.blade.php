<?php

use App\UserLampSumInvestment;
use App\MutualFundInvestmentHist;
use App\UserSipInvestement;
use App\Utils;
use App\User;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Client Lump Sum : {{$lumpsum['folio_no']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-lump-sum.index') }}">Client Lump Sums</a></li>
                    <li class="breadcrumb-item active">{{$lumpsum['folio_no']}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                {{Utils::successAndFailMessage()}}
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table mt-2">
                            <tr>
                                <th>{{ UserLampSumInvestment::attributes('folio_no') }}</th>
                                <td>{{ $lumpsum['folio_no'] }}</td>
                            </tr>
                            <tr>
                                <th>{{ UserLampSumInvestment::attributes('user_id') }}</th>
                                <td>{{ $lumpsum['user']['name'] }}</td>
                            </tr>
                            <tr>
                                <th>{{ UserLampSumInvestment::attributes('matual_fund_id') }}</th>
                                <td>{{ $lumpsum['mutual_fund']['name'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table mt-2">
                            <tr>
                                <th>{{ UserLampSumInvestment::attributes('invested_amount') }}</th>
                                <td>{{ $lumpsum['invested_amount'] }}</td>
                            </tr>
                            <tr>
                                <th>{{ UserLampSumInvestment::attributes('invested_at') }}</th>
                                <td>{{ Utils::getFormatedDate($lumpsum['invested_at']) }}</td>
                            </tr>
                            <tr>
                                <th>{{ UserLampSumInvestment::attributes('nav_on_date') }}</th>
                                <td>{{ $lumpsum['nav_on_date'] }}</td>
                            </tr>
                            <tr>
                                <th>{{ UserLampSumInvestment::attributes('units') }}</th>
                                <td>{{ $lumpsum['units'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection