<?php

use App\InsuranceCompany;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$company['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('insurance-company.index') }}"><?= Utils::titles('insurance_companies') ?></a></li>
                    <li class="breadcrumb-item active">{{$company['name']}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            {{Utils::successAndFailMessage()}}
                            <a href="{{route('insurance-company.edit', $company['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            {!! Utils::deleteBtn(route('insurance-company.destroy', $company['id'])) !!}

                            <div class="row">
                                <table class="col-lg-6 table mt-2">
                                    <tr>
                                        <th>{{ InsuranceCompany::attributes('name') }}</th>
                                        <td>{{ $company['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceCompany::attributes('created_at') }}</th>
                                        <td>{{ $company['created_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceCompany::attributes('status') }}</th>
                                        <td>{{ Utils::setStatus($company['status']) }}</td>
                                    </tr>
                                </table>
                                <table class="col-lg-6 table mt-2">
                                    <tr>
                                        <td>
                                            <p><b>{{ InsuranceCompany::attributes('image') }}</b></p>
                                        </td>
                                        <td>
                                            <a href="{{ InsuranceCompany::getCompanyImg($company['image']) }}" target="_blank">
                                                <img src="{{ InsuranceCompany::getCompanyImg($company['image']) }}" style="width: 100px">
                                            </a>
                                        </td>
                                    </tr>
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