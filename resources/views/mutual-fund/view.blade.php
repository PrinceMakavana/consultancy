<?php

use App\MutualFund;
use App\MutualFundType;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$funds['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('funds.index') }}">Mutual Funds</a></li>
                    <li class="breadcrumb-item active">{{$funds['name']}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-header">
                            <a href="{{route('funds.edit', $funds['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="<?= route('funds.nav', $funds['id']) ?>" class="btn btn-sm btn-primary">
                                NAV Edit
                            </a>
                            {!! Utils::deleteBtn(route('funds.destroy', $funds['id'])) !!}
                        </div>
                        <div class="card-body p-0">
                            {{Utils::successAndFailMessage()}}

                            <div>
                                <table class="table">
                                    <tr>
                                        <th>{{ MutualFund::attributes('main_type') }}</th>
                                        <td>{{ Utils::setMainTypes($funds['main_type']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('company_id') }}</th>
                                        <td>{{ MutualFund::getCompany($funds['company_id']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('direct_or_regular') }}</th>
                                        <td>{{ Utils::setDirectOrRegular($funds['direct_or_regular']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('type_id') }}</th>
                                        <td>{{ MutualFundType::getFundType($funds['type_id']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('name') }}</th>
                                        <td>{{ $funds['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('nav') }}</th>
                                        <td>{{ $funds['nav'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('min_sip_amount') }}</th>
                                        <td>{{ $funds['min_sip_amount'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('fund_size') }}</th>
                                        <td>{{ $funds['fund_size'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('created_at') }}</th>
                                        <td>{{ $funds['created_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFund::attributes('status') }}</th>
                                        <td>{{ Utils::setStatus($funds['status']) }}</td>
                                    </tr>
                                </table>
                                <table class="col-lg-6 table mt-2">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection