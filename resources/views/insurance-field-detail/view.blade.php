<?php

use App\InsuranceField;
use App\InsuranceFieldDetail;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Insurance Field : {{$fieldDetail['fieldname']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('field-detail.index') }}">Insurance Fields</a></li>
                    <li class="breadcrumb-item active">Insurance Field : {{$fieldDetail['fieldname']}}</li>
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
                        <div class="card-body">
                            {{Utils::successAndFailMessage()}}
                            <a href="{{route('field-detail.edit', $fieldDetail['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            {!! Utils::deleteBtn(route('field-detail.destroy', $fieldDetail['id'])) !!}

                            <div class="row">
                                <table class="col-lg-6 table mt-2">
                                    <tr>
                                        <th>{{ InsuranceFieldDetail::attributes('fieldname') }}</th>
                                        <td>{{ $fieldDetail['fieldname'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceFieldDetail::attributes('created_at') }}</th>
                                        <td>{{ $fieldDetail['created_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceFieldDetail::attributes('updated_at') }}</th>
                                        <td>{{ $fieldDetail['updated_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceFieldDetail::attributes('status') }}</th>
                                        <td>{{ Utils::setStatus($fieldDetail['status']) }}</td>
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

