<?php

use App\Utils;
use App\MutualFundCompany;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update : {{$company['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('company.index') }}">Mutual Fund Companies</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('company.show', $company['id']) }}">{{$company['name']}}</a></li>
                    <li class="breadcrumb-item active">Update</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('company.update', $company['id']) }}">
                    {{method_field('PUT')}}
                    {{ csrf_field() }}

                    <?php
                    $fields = [
                        [
                            ['name' => 'name', 'type' => 'text', 'label' => MutualFundCompany::attributes('name'), 'value' => $company['name']],
                            ['name' => 'image', 'type' => 'file', 'label' => MutualFundCompany::attributes('image'), 'value' => ''],
                            ['name' => 'status', 'type' => 'select', 'label' => MutualFundCompany::attributes('status'), 'value' => $company['status'], 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
                        ]
                    ];
                    ?>

                    @include('layouts.form', ['form' => $fields])

                    <div class="form-group">
                        <div class="d-flax pl-2">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                            <a class="btn btn-secondary" href="{{ route('company.show', $company['id']) }}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection